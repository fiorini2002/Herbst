<?php
require_once 'Functions/masterFunctions.php';
session_start();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "frontpage";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,300,700' rel='stylesheet' type='text/css'>
        <link href="code/lightbox/dist/css/lightbox.css" rel="stylesheet" type="text/css"/>
        <title>Herbst - Lager</title>
    </head>
    <body>
        <div id="wrapper">
            <div class="content-main">
                <div class="content-box ">
                    <a id="home" href="index.php">HOME</a>
                    <?php
                    if (empty($page) || !file_exists('pages/' . $page . '.php')) {
                        include 'pages/frontpage.php';
                    } if (file_exists('pages/' . $page . '.php')) {
                        include 'pages/' . $page . '.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>


</html>