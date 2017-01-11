<?php
/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/12/15
 * Time: 16:18
 */
namespace App\Http\Controllers\Text;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TextController extends Controller
{
    //获得添加的所有图书列表
    public function index()
    {
        $books = DB::table('books')->get();
        if ($books) {
            return $this->formatData(1, null, $books);
        } else {
            return $this->formatData(0, '请联系管理员', null);
        }
    }

    //设置读取
    function getBook(Request $request)
    {
        //首先是测试
//        $data = file_get_contents(public_path() . '/books/84_cross_street_charing.txt', NULL, NULL, 0, 1000);
        //这里需要bookid,并且在每次请求的时候进行一次数据库的。
        //本身以为这个地方是有页码的，但是发现这个方法还是不要实现跳页的好，要不会乱掉，所以暂时去掉单独写一个方法
        $bookId = $request->input('bookId');
        $token = $request->input('token');
        $user = $this->checkUser($token);
        if ($user) {
            //读取数据库中的书本和其src
            $book = DB::table('books')->where('id', $bookId)->first();
            if ($book) {
                $books_my = DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->first();
                if ($books_my) {
                    //已经存在的书签和标记,更新页码
                    DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->update(['page' => $books_my->page + 1]);
                    $page = $books_my->page;
                } else {
                    //建立新的书签和标记
                    DB::table('bookmarks')->insert(['uid' => $user->id, 'bookid' => $bookId, 'page' => 1]);
                    $page = 0;
                }
                //读取TXT文件
                $data = file_get_contents(public_path() . $book->src, NULL, NULL, $page * 1000, 1000);
                if ($data == '') {
                    //当已经读完此书时,回滚一页
                    DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->update(['page' => $books_my->page]);
                    return $this->formatData(0, "您已读完此书", null);
                } else {
                    $data = mb_convert_encoding($data, 'utf-8');
                    return $this->formatData(1, null, $data);
                }
            } else {
                return $this->formatData(0, "您需要看的书不存在", null);
            }
        } else {
            return $this->formatData(0, "您的登录似乎存在问题，获取失败", null);
        }
    }

    //API跳页操作
    public function jumpPage(Request $request)
    {
        //跳转书的上一页的接口
        $bookId = $request->input('bookId');
        $token = $request->input('token');
        $user = $this->checkUser($token);
        $page=$this->input('page');
        if ($user) {
            //读取数据库中的书本和其src
            $book = DB::table('books')->where('id', $bookId)->first();
            if ($book) {
                $books_my = DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->first();
                if ($books_my) {
                    //记录之前的page，用于回滚page
                    $page_old=$books_my->page;
                    //已经存在的书签和标记,更新页码（减少一页）
                    DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->update(['page' => $page]);
                } else {
                    //不存在当前书签的情况下直接返回错误，因为不存在上一页
                    return $this->formatData(0, "发生了不可预知的错误，请过段时间再试", null);
                }
                //读取TXT文件
                $data = file_get_contents(public_path() . $book->src, NULL, NULL, $page * 1000, 1000);
                if ($data == '') {
                    //当已经读完此书时，或者跳到了一些奇怪的位置，回滚原来的页
                    DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->update(['page' =>$page_old]);
                    return $this->formatData(0, "您已读完此书", null);
                } else {
                    $data = mb_convert_encoding($data, 'utf-8');
                    return $this->formatData(1, null, $data);
                }
            } else {
                return $this->formatData(0, "您需要看的书不存在", null);
            }
        } else {
            return $this->formatData(0, "您的登录似乎存在问题，获取失败", null);
        }
    }

    //上一页
    public function beforePage(Request $request)
    {
        //跳转书的上一页的接口
        $bookId = $request->input('bookId');
        $token = $request->input('token');
        $user = $this->checkUser($token);
        if ($user) {
            //读取数据库中的书本和其src
            $book = DB::table('books')->where('id', $bookId)->first();
            if ($book) {
                $books_my = DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->first();
                if ($books_my) {
                    //已经存在的书签和标记,更新页码（减少一页）
                    DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->update(['page' => $books_my->page - 1]);
                    $page = $books_my->page - 1;
                } else {
                    //不存在当前书签的情况下直接返回错误，因为不存在上一页
                    return $this->formatData(0, "发生了不可预知的错误，请过段时间再试", null);
                }
                //读取TXT文件
                $data = file_get_contents(public_path() . $book->src, NULL, NULL, $page * 1000, 1000);
                if ($data == '') {
                    //当已经读完此书时,回滚一页（增加一页）
                    DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->update(['page' => $books_my->page + 1]);
                    return $this->formatData(0, "您已读完此书", null);
                } else {
                    $data = mb_convert_encoding($data, 'utf-8');
                    return $this->formatData(1, null, $data);
                }
            } else {
                return $this->formatData(0, "您需要看的书不存在", null);
            }
        } else {
            return $this->formatData(0, "您的登录似乎存在问题，获取失败", null);
        }
    }

    //注册
    public function register(Request $request)
    {
        //email中的username
        $username = $request->get('username');
        $password = $request->get('password');
        $nickname = $request->get('nickname');
        if (DB::tables('users')->where('username', $username)->first()) {
            return $this->formatData(0, "您似乎已经注册过了，请直接登录", null);
        } else {
            $data = array(
                'username' => $username,
                'password' => $password,
                'nickname' => $nickname,
            );
            if (DB::table('users')->insert($data)) {
                return $this->formatData(1, null, null);
            } else {
                return view('Public/error', ['title' => "存储错误", 'message' => "可能输入或者是数据库错误"]);
            }
        }
    }

    //用户登录获取Token
    function getToken(Request $request)
    {
        //此处Token使用时间戳和用户名之后使用Base64生成
        $username = $request->input('username');
        $password = $request->input('password');
        $token = $request->input('token');
        if ($token == '') {
            if ($username == '' || $password == '') {
                //做用户信息的完整验证
                return $this->formatData(0, '请输入合适的用户名和密码', null);
            } else {
                //验证用户名与密码
                $user = DB::table('users')->where('username', $username)->first();
                if ($user->password == $password) {
                    //生成新token
                    $token = base64_encode(time() . md5($username));
                    //存储新token
                    DB::table('users')->where('id', $user->id)->update(['token' => $token]);
                    return $this->formatData(1, null, array('token' => $token));
                } else {
                    return $this->formatData(0, "输入的密码或者用户名出错", null);
                }
            }
        } else {
            //验证token是否过期
            $token_decode = base64_decode($token);
            if ($token_decode) {
                $user = DB::table('users')->where('token', $token)->first();
                if ($user) {
                    //已经验证成功，验证是否过期,切分字符串，取到相关数字
                    $time = substr($token_decode, 0, (mb_strlen($token_decode) - mb_strlen(md5($user->username))));
                    //设置15天过期
                    if (((int)$time + 1296000) > time()) {
                        //写入相应的session供其他的接口检测而不用查数据库
                        return $this->formatData(1, '自动登录成功', null);
                    } else {
                        return $this->formatData(0, '您的登录已经过期，请输入使用用户名和密码', null);
                    }
                } else {
                    return $this->formatData(0, '您的自动登录不合法，请输入合适的用户名和密码', null);
                }
            } else {
                return $this->formatData(0, '您的登录出错，请输入合适的用户名和密码', null);
            }
        }
    }

    //获得用户之前阅读的书与阅读书的书签
    public function getUserBook(Request $request)
    {
        $token = $request->input('token');
        $user = $this->checkUser($token);
        if ($user) {
            //取得书和页数列表
            $books_my = DB::table('bookmarks')->where('uid', $user->id)->select('bookid')->get();
//            var_dump($books_my);die;
            //循环查找到的阅读历史，在books表中查找相关的知识点
            foreach ($books_my as $k => $v) {
                $books[$k] = DB::table('books')->where('id', $v->bookid)->get();
            }
//            var_dump($books);die;
            return $this->formatData(1, null, $books);
        } else {
            return $this->formatData(0, "您的登录似乎存在问题，获取失败", null);
        }
    }

    //用户对于之前阅读书的删除
    public function delUserBook(Request $request)
    {
        $token = $request->input('token');
        $user = $this->checkUser($token);
        if ($user) {
            //取得书和页数列表
            $bookId = $request->input('bookId');
            DB::table('bookmarks')->where('uid', $user->id)->where('bookid', $bookId)->delete();
            return $this->formatData(1, "删除成功", null);
        } else {
            return $this->formatData(0, "您的登录似乎存在问题，删除失败", null);
        }
    }


    //格式化返回值
    public function formatData($status, $message, $data)
    {
        $temp = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        return json_encode($temp);
    }

    //在每次调用API的时候进行一次session检测，确使每次登录后使用的API接口
    public function checkUser($token)
    {
        //检测Session但是不检测其是否过期等
        $user = DB::table('users')->where('token', $token)->first();
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
}