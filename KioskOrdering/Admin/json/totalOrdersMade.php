<?php

    include '../includes/class-loader.php';
    
    $selectObj = new Select();
    echo json_encode($selectObj->getTotalOrdersMade());