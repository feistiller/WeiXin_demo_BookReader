<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:23 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 登录</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico"> <link href="admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

    <link href="admin/css/animate.min.css" rel="stylesheet">
    <link href="admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">ST</h1>

            </div>
            <h3>欢迎使用管理上传功能</h3>

            <form class="m-t" role="form" METHOD="POST" action="Admin/alogin">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="用户名" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token()?>"/>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
                </p>
            </form>
        </div>
    </div>
    <script src="admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="admin/js/bootstrap.min.js?v=3.3.6"></script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:23 GMT -->
</html>
