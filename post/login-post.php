<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:25 PM
 *
 * adds user to session after login
 */

$login = true;
require '../lib/site.inc.php';

if(isset($_POST['user']) && isset($_POST['password'])){
    $users = new Users($site);

    $user = $_POST['user'];
    $user = stripslashes($user);
    //$user = mysqli_real_escape_string($user);

    $password = $_POST['password'];
    $password = stripslashes($password);
    //$password = mysqli_real_escape_string($password);

    $user = $users->login($user, $password);
    if($user !== null && $user->getSecurity() != 3) {
       $_SESSION['user'] = $user;
       header("location: ../");
       exit;
    }


}

header("location: ../login.php");