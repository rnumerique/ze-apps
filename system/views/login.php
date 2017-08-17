<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Zeapps</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/assets/css/login.css">

    <script>
        $(window).on('load', function () {

            var theWindow = $(window),
                $bg = $("#bg"),
                aspectRatio = $bg.width() / $bg.height();

            function resizeBg() {

                if ((theWindow.width() / theWindow.height()) < aspectRatio) {
                    $bg
                        .removeClass()
                        .addClass('bgheight');
                } else {
                    $bg
                        .removeClass()
                        .addClass('bgwidth');
                }

            }

            theWindow.resize(resizeBg).trigger("resize");

        });
    </script>

</head>
<body>

<img src="/assets/images/background-login-1600.jpg" id="bg" alt="">

<form action="/zeapps/auth" method="post">
    <div id="form-login">
        <img src="/assets/images/logo.png" alt="zeapps"/>
        <div class="form-group">
            <label for="exampleInputEmail1" i8n="Login"></label>
            <input type="text" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" i8n="Password"></label>
            <input type="password" class="form-control" name="password">
        </div>
        <a href="#">Mot de passe oublié</a>
        <button type="submit" class="btn btn-primary pull-right" i8n="Connexion">Connexion</button>
    </div>
</form>

</body>
</html>
