<?php 
session_start();
session_destroy();
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
header('Location: index.php');
session_start();
$_SESSION['error_msg'] = "<div class=\"alert alert-info\">Please enter your ID</div>";
//2015-0648
?>