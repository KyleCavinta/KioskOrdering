<?php

    include '../includes/class-loader.php';

    $insertObj = new Insert();
    $selectObj = new Select();
    
    $adminID = $selectObj->getIncrementedID("employee", "AdminID");
    $fName = $_POST['firstname'];
    $lName = $_POST['lastname'];
    $pos = $_POST['pos'];
    $uName = $_POST['username'];
    $pswd = $_POST['pswd'];
    $res = $insertObj->setEmployee($adminID, $fName, $lName, $pos);
    
    if($res){
        $res = $insertObj->setEmployeeAccount($adminID, $uName, $pswd);
        if($res){
            echo true;
        }
        else{
            echo false;
        }
    }
    else{
        echo false;
    }