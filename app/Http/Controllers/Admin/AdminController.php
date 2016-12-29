<?php
/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/12/20
 * Time: 18:36
 */
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('Admin/login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if ($username != null && $password != null) {
            $user = DB::table('admin_user')->where('username', $username)->where('password', $password)->first();
            if ($user) {
                $request->session()->put('user', $user);
                return redirect('Admin/index');
            } else {
                return view('Public/error', ['title' => "密码错误", 'message' => "就是你输错密码了"]);
            }
        } else {
            return view('Public/error', ['title' => "输入为空", 'message' => "不要输空的用户名和密码"]);
        }
    }

    //主页显示
    public function aIndex(Request $request)
    {
        if($this->checkUserIsLogin($request)) {
            return view('Admin/index');
        }else{
            return redirect('../');
        }
    }

    //主页添加书籍
    public function addBook(Request $request)
    {
        if($this->checkUserIsLogin($request)) {
            //判断请求中是否包含name=file的上传文件
            if (!$request->hasFile('file')) {
                exit('上传文件为空！');
            }
            $file = $request->file('file');
            //判断文件上传过程中是否出错
            if (!$file->isValid()) {
                exit('文件上传出错！');
            }
            $destPath = realpath(public_path('books'));
            if (!file_exists($destPath))
                mkdir($destPath, 0755, true);
            //重新更新名称，md5()加密生成唯一名称
            $filename = md5(($file->getClientOriginalName()) . time()) . '.txt';
            if (!$file->move($destPath, $filename)) {
                exit('保存文件失败！');
            }
            //获取所有的数据
            $data = $request->all();
            $data_temp = array(
                'name' => $data['name'],
                'src' => '/books/' . $filename,
                'time' => 0,
                'number' => 0,
                'writer' => $data['writer'],
                'description' => $data['description']
            );
            //获取file，并调用putFile进行，写入src
            //构造data为符合DB要求的变量
            if (DB::table('books')->insert($data_temp)) {
                return redirect('Admin/index');
            } else {
                return view('Public/error', ['title' => "存储错误", 'message' => "可能输入或者是数据库错误"]);
            }
        }else{
            return redirect('../');
        }

    }

    //书籍管理主页显示
    public function bookIndex(Request $request)
    {
        if($this->checkUserIsLogin($request)) {
            $data = DB::table('books')->get();
            return view('Admin/bookIndex', ['books' => $data]);
        }else{
            return redirect('../');
        }
    }

    //书籍管理书籍删除
    public function bookDel(Request $request)
    {
        if($this->checkUserIsLogin($request)) {
            $id = $request->input('bookId');
            DB::table('books')->where('id', '=', $id)->delete();
            return redirect('Admin/manger');
        }else{
            return redirect('../');
        }
    }

    //用户管理主页显示
    public function userIndex(Request $request)
    {
        if($this->checkUserIsLogin($request)) {
            $data = DB::table('users')->get();
            return view('Admin/userIndex', ['users' => $data]);
        }else{
            return redirect('../');
        }
    }

    //用户管理主页显示
    public function userDel(Request $request)
    {
        if($this->checkUserIsLogin($request)){
            $id = $request->input('userId');
            DB::table('users')->where('id', '=', $id)->delete();
            return redirect('Admin/userManger');
        }else{
            return redirect('../');
        }
    }

    //检测是否登录
    public function checkUserIsLogin(Request $request)
    {
        //检测是否登录
        $value = $request->session()->get('user');
        if($value!=''){
            return true;
        }else{
            return false;
        }
    }
}