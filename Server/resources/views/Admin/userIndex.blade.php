<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>主页</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills float-xs-right">
                <li class="nav-item">
                    <a class="nav-link" href="index">书籍上传<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manger">书籍管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="userManger">用户管理</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row marketing" style="padding-top: 10%">
        <div class="col-lg-12">
            <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>最近登录时间</th>
                    <th>用户名</th>
                    <th>昵称</th>
                    <th>最近登录ip</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th>{{$user->id}}</th>
                        <th>{{$user->time}}</th>
                        <th>{{$user->username}}</th>
                        <th>{{$user->nickname}}</th>
                        <th>{{$user->ip}}</th>
                        <th>
                            <a href=""><button class="btn btn-warning">修改</button></a>
                            <a href="userDel?userId={{$user->id}}"><button class="btn btn-danger">删除</button></a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2016</p>
    </footer>

</div>
</body>
</html>