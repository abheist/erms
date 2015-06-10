<?php
session_start();
if($reqlogin)
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_SESSION['user_right']))
    header('Location: .');
?>
<html>
<head>
    <title>Erasmith | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <style type="text/css">
    a:hover, a.hover
    {text-decoration: none;}
    </style>
     <?php 
        if(isset($css))
            echo '<link rel="stylesheet" type="text/css" href="css/'.$css.'.css">';
        if(isset($js))
            echo '<script src="js/'.$js.'.js"></script>';
    ?>
</head>
<body>
    <h1 id="heading"><a href=".">Erasmith</a>
        <span id="spanning">
            <li class="dropdown">
                <div>
                <div id="asd">
                <lala class="dropdown-toggle" href="#" data-toggle="dropdown">
                    <?php echo $_SESSION['user_name']?>
                </lala>
                <div>
                </div>
                <ul class="dropdown-menu">
                    <li><a href="#">Change Password</a></li>
                    <li role="presentation"><a href="logout">Log Out</a></li>
                </ul>
            </li>
        </span>
    </h1>        
