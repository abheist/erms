<?php
session_start();
if($reqlogin)
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_SESSION['user_right']))
    header('Location: .');
    switch($_SESSION['user_right'])
    {
        case 0: $width=100/8;
                break;
        case 1: $width=100/9;
                break;
        case 2: $width=100/6;
                break;
        default:$width=100/6;
                break;
    }

?>
<html>
<head>
    <title>Erasmith | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script
 type="text/javascript"
 src="tooltipsy-master/tooltipsy.min.js">
</script>
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
    <style type="text/css">
        .listitems  {
            width: <?php echo "$width%"; ?>;
        }
    </style>
</head>
<body>
    <div id="mainheader">
    <h1 id="header"><a href=".">Erasmith</a>
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
                    <li><a href="changepass">Change Password</a></li>
                    <li role="presentation"><a href="logout">Log Out</a></li>
                </ul>
            </li>
        </span>
    </h1>
    <div id="menu">
            <ul id="firstul">
                <a href="."><li class="listitems" id="firstli">Home</li></a>
                <a href="form"><li class="listitems">Add Jobs</li></a>
                <a href="cansearch"><li class="listitems">Search</li></a>
                <a href="viewrec"><li class="listitems">View Recruiters</li></a>
                <a href="viewcand"><li class="listitems">View candidate</li></a>
                <a href="add_candy"><li class="listitems">Add Candidate</li></a>
                <?php
                if($_SESSION['user_right']<2)
                {
                    echo '<a href="addfield_cand"><li class="listitems">Add Field</li></a>';
                ?>
           


                    <li class="dropdown listitems">
                         <button class=" dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Tutorials
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">HTML</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">About Us</a></li>
                        </ul>
                    </li>
           

                <?php /* 
                    echo '<a href="add_client"><li class="listitems" id="secondli">Add Client</li></a>';
                    echo '<a href="add_cp"><li class="listitems" id="secondli">Add Client Person</li></a>';
                    echo '<a href="viewclient"><li class="listitems" id="secondli">Clients Details</li></a>';
                    if($_SESSION['user_right']==0)
                    {
                        echo '<a href="add_recruit"><li class="listitems" id="secondli">Add Recruiter</li></a>';
                    }*/
                }
                ?>
            </ul>
    </div>   
    </div>     
