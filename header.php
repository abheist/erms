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
    <script type="text/javascript" src="tooltipsy-master/tooltipsy.min.js"></script>
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
                <a href="form"><li class="listitems">Add Job Opportunity</li></a>
                
<?php
                    echo '<li class="dropdown listitems">';
                         echo '<button class=" dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Clients';
                            echo'<span class="caret"></span>';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="add_client">Add Client</a></li>';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="add_cp">Add Contact Persons</a></li>';
                            echo '<li role="presentation" class="divider"></li>';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="viewclient">List of Contact Persons</a></li>';
                        echo '</ul>';
                    echo '</li>';
                    echo '<li class="dropdown listitems">';
                         echo '<button class=" dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Candidate';
                            echo '<span class="caret"></span>';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="add_candy">Add Candidate</a></li>';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="addfield_cand">Add Fields</a></li>';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="cansearch">Search Candidates</a></li>';
                            echo '<li role="presentation" class="divider"></li>';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="viewcand">List of Candidates</a></li>';
                        echo '</ul>';
                    echo '</li>';
                    echo '<li class="dropdown listitems">';
                         echo '<button class=" dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Recruiters';
                            echo '<span class="caret"></span>';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="add_recruit">Add Recruiter</a></li>';
                            echo '<li role="presentation" class="divider"></li>';
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="viewrec">Manage Recruiters</a></li>';
                        echo '</ul>';
                   echo '</li>';    
            echo '</ul>';
    echo '</div>';
    echo '</div>';
?>     