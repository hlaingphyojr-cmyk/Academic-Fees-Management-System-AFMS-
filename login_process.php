<?php

$mkptErr=$contactErr=$emailErr=$usernameErr=$passwordErr="";
$mkpt = $contact =$email =$username =$password ="";
$flag=0;
if (isset($_POST["submit"])) {
    $mkpt = $_POST["id_no"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(empty($_POST["id_no"]))
    {
        $mkptErr = "MKPT no. is required";
        $flag=1;
        echo $mkptErr;
    }else
    {
        $mkpt = $_POST["id_no"];
        if(!preg_match("/^mkpt-//d{4}$/",$mkpt))
        {
            $mkptErr="Format is mkpt-**** where **** is a 4-digit number";
            $flag=1;
            echo $mkptErr;
        }
    }

    if(empty($_POST["contact"]))
    {
        $contactErr = "Contact no. is required";
        $flag=1;
        echo $contactErr;
    }else
    {
        $contact = $_POST["contact"];
        if(!preg_match("/^+959+//d{9}$/",$_POST["contact"]))
        {
            $contactErr="+959 and others 9 digits is allowed";
            $flag=1;
            echo $_POST["contact"];
        }
    }


    if(empty($_POST["email"]))
    {
        $emailErr = "Email is required";
        $flag=1;
        echo $emailErr;
    }else
    {
        $email = $_POST["email"];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $emailErr="Invalid format";
            $flag=1;
            echo $emailErr;
        }
    }

    if(empty($_POST["username"]))
    {
        $usernameErr = "MKPT no. is required";
        $flag=1;
        echo $usernameErr;
    }else
    {
        $username = $_POST["username"];
        if(!preg_match("/^mkpt-//d{4}$/",$username))
        {
            $usernameErr="Format is mkpt-**** where **** is a 4-digit number";
            $flag=1;
            echo $usernameErr;
        }
    }

    if(empty($_POST["password"]))
    {
        $passwordErr = "Password is required";
        $flag=1;
        echo $passwordErr;
    }else
    {
        $password = $_POST["password"];
        if(!preg_match("(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}",$password))
        {
            $usernameErr="Format is mkpt-****";
            $flag=1;
            echo $usernameErr;
        }
    }
}

?>