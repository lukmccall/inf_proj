<?php
require('connect.php');
if (isset($_POST['username']) and isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";

    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
    } else {
        $fmsg = "Błędne dane logowania.";
    }
}
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Cześć " . $username . "";
    header('Location: ../session.php');;
} else {
}
?>