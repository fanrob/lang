<?php
/* заполняет  $rowu или перекидывает на страницу авторизации
players
 id name login en
playinfo
 cookkey pid browser lastip country

*/
if (!isset($AJAX)) $AJAX=false;

if (isset($_COOKIE["logname"])) {       //проверка куков
    if (isset($_COOKIE["key1"])) {
        $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='" . $_COOKIE['logname'] . "' AND key1='" . $_COOKIE["key1"] . "';");
        if ($suser == false) {
            unset($_SESSION['username']);
            if (!$AJAX){
                echo '<meta http-equiv="refresh" content="0; url=index.php">';
                exit;
            } else {
                error_log("log error 1: error query to DB");
                //echo 0;
            }
            exit;
        }

        $count = mysqli_num_rows($suser);
      //  error_log($count);
        if ($count > 0) {
            $rowu  = mysqli_fetch_assoc($suser);
            setcookie("logname", $_COOKIE['logname'], time() + 3600 * 24 * 21, '/'); //ставим кук на 3 недели
            setcookie("key1", $_COOKIE['key1'], time() + 3600 * 24 * 21, '/');
            $_SESSION['username'] = $_COOKIE['logname'];
            $uname = $_SESSION['username'];
        } else {
            unset($_SESSION['username']);
            unset($_COOKIE['logname']);
            unset($_COOKIE['key1']);
            if (!$AJAX){
                echo '<meta http-equiv="refresh" content="0; url=index.php">';
                exit;
            } else {
                error_log("log error 2: logname-key1 not found in DB");
                //echo 0;
            }
            exit;
        }
    }
}



if (!isset($rowu)) {
    if (isset($_SESSION['username'])) {
        $uname = $_SESSION['username'];
        $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
        $rowu  = mysqli_fetch_assoc($suser);
        $count = mysqli_num_rows($suser);
        if ($count <= 0) {
            if (!$AJAX){
                echo '<meta http-equiv="refresh" content="0; url=index.php">';
                exit;
            } else {
                error_log("log error 3: login not found");
                echo 0;
            }
            exit;
        }
    } else {
        if (!$AJAX)
            echo '<meta http-equiv="refresh" content="0; url=index.php">';
        else {
            error_log("log error 4: not logged");
            echo 0;
        }
        exit;
    }
}

