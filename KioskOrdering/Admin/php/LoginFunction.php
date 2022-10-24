<?php

session_start();
include '../includes/class-loader.php';
$selectObj = new Select();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $uName = $_POST['username'];
    $uPass = $_POST['password'];
    $uRole = $_POST['role'];

    $admin = $selectObj->getAdminByUsernamePasswordRole($uName, $uPass, $uRole);
    if($admin){
        switch($uRole){
            case "admin":
                $_SESSION['ADMIN_ID'] = $admin['AdminID'];
                header('location: ../pages/dashboard.php');
                break;

            case "cashier":
                $_SESSION['ADMIN_ID'] = $admin['AdminID'];
                header('location: ../pages/cashier.php');
                break;

            case "kitchen":
                $_SESSION['ADMIN_ID'] = $admin['AdminID'];
                header('location: ../pages/kitchen.php');
                break;
        }
    }
    else{
        header('location: ../pages/login.php?st=err');
    }
}