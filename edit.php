<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[favicons]-->
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="../img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="../img/favicons/manifest.json">
    <link rel="mask-icon" href="../img/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <!--[favicons end]-->

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/main.css">

    <script src="../js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <script src="../js/main.js"></script>
</head>
<?php
session_start();
if (!isset($_SESSION['logged']) && $_SESSION['logged'] == false) {
    header("Location: index.php");
    exit();
}
?>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../session.php"><?php echo($_SESSION['username']); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" role="form" method="POST">
                <a class="btn btn-primary" href="../logout.php" role="button">Wyloguj się</a>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<?php

require("connect.php"); //zwraca zmienną $connection

$username = $_SESSION['username'];
$query = "SELECT `id`, `prev_lvl` FROM `user` WHERE `username` ='$username'";
$prev = $connection->query($query);
$prev = $prev->fetch_assoc();

$id = $_GET['id'];

$query = "SELECT `prev_lvl` FROM `user` WHERE `id` ='$id'";
$pr = $connection->query($query);
$pr = $pr->fetch_assoc();

if (!($prev['prev_lvl'] - $pr['prev_lvl'] >= 0 || $id != $prev['id'])) {
    header("Location: ../users.php?err=1");
} else {
?>
    <div class="container">
        <?php
        $query = "SELECT * FROM `user` WHERE `id`=" . $_GET['id'] . ';';
        $result = $connection->query($query);
        $row = $result->fetch_array();
        echo '<form method="post">';
        echo '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
        echo '<label for="nazwa">Nazwa </label>';
        echo '<input type="text" name="nazwa" placeholder="' . $row['username'] . '" value="' . $row['username'] . '"/>';
        echo '<label for="email">Email </label>';
        echo '<input type="text" name="email" placeholder="' . $row['email'] . '" value="' . $row['email'] . '"/>';
        echo '<label for="haslo">Hasło </label>';
        echo '<input type="text" name="haslo" value="' . md5($row['password']) . '" />';
        if ($prev['prev_lvl'] >= 3) {
            echo '<label for="poz">';
            echo '<input type="text" name="poz" value="' . $row['prev_lvl'] . '" placeholder="' . $row['email'] . '"/>';
        }
        echo '<button type="submit" class="btn btn-success">Zatwierdź!</button>';
        echo '<a type="submit" href="../users.php" role="button" class="btn btn-primary">Zatwierdź i wróć</a>';
        echo "</form>";
        ?>
        <footer>
            <p>&copy; Kamil Owczarz 2017</p>
        </footer>
    </div> <!-- /container -->
<?php } ?>
</body>
</html>

