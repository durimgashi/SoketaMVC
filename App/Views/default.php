
<link rel="stylesheet" href="css/app.css">

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= APP_NAME ?></title>
    <!-- jQuery import -->
    <script src="..\Public\assets\jQuery\jquery-3.6.0.js"></script>
</head>
<body>

<h1>Default header</h1>

<?php

//include_once (new \App\Config\View($layout))->getView();
include_once $layout;

?>

<script>
    // $( document ).ready(function() {
    //     alert( "ready!" );
    // });
</script>

<h1>Default footer</h1>
</body>
</html>




