<?php
require_once('utility.php');
session_start();
header('Location: login.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['username']) && isset($_POST['password']) && 
        !empty($_POST['username']) && !empty($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $isPasswordCorrect = checkPassword($password);
        $isEmailCorrect = checkEmail($username);

        if(!$isEmailCorrect) {
            $_SESSION[MSG] = EMAIL_INCORRECT;
        }
        else if(!$isPasswordCorrect) {
            $_SESSION[MSG] = PASSWORD_INCORRECT;
        }
        else {
            $username = mySanitizeString($username);
            $retVal = tryLogin($username, $password);
            if($retVal == LOGIN_TEACHER_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION['mySession'] = $username;
                $_SESSION['myUserType'] = 'TEACHER';
                header('Location: user_teacher.php');
            } else if($retVal == LOGIN_PARENT_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION['mySession'] = $username;
                $_SESSION['myUserType'] = 'PARENT';
                header('Location: user_parent.php');
            } else if($retVal == LOGIN_SECRETARY_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION['mySession'] = $username;
                $_SESSION['myUserType'] = 'SECRETARY_OFFICER';
                header('Location: user_secretary.php');
            } else if($retVal == LOGIN_PRINCIPAL_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION['mySession'] = $username;
                $_SESSION['myUserType'] = 'PRINCIPAL';
                header('Location: user_principal.php');
            } else if($retVal == LOGIN_ADMIN_OK) {
                $_SESSION['time'] = time(); 
                $_SESSION['mySession'] = $username;
                $_SESSION['myUserType'] = 'SYS_ADMIN';
                header('Location: user_admin.php');
            } else if($retVal == CHANGE_PASSWORD) {                
                header('Location: update_password.php');
            } else {
                $_SESSION[MSG] = $retVal;
            }
        }
    } else {
        $_SESSION[MSG] = LOGIN_FAILED;
    }
} else {
    $_SESSION[MSG] = LOGIN_FAILED;
}
?>