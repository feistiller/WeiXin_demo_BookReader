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
                    <a class="nav-link active" href="index">书籍上传<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manger">书籍管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userManger">用户管理</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row marketing" style="padding-top: 10%">
        <div class="col-lg-12">
            <form action="addBook" enctype="multipart/form-data" method="post">
                <fieldset class="form-group">
                    <div class="form-group row">
                        <label class="form-control-label">书名：</label>
                        <input class="form-control" type="text" name="name">
                    </div>
                    <div class="form-group row">
                        <label class="form-control-label">作者：</label>
                        <input class="form-control" type="text" name="writer">
                    </div>
                    <div class="form-group row">
                        <label class="form-control-label">描述：</label>
                        <textarea style="height: 80px" class="form-control" type="text" name="description"></textarea>
                    </div>
                    <div class="form-group row">
                        <label class="form-control-label">文件：</label>
                        <input class="form-control" type="file" name="file">
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token()?>"/>
                    <div class="form-group row">
                        <input class="btn btn-secondary" type="submit" value="提交" name="submit">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2016</p>
    </footer>

</div>
</body>
</html>