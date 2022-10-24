<?php
    session_start();

    include '../includes/class-loader.php';
    $updateObj = new Update();
    $insertObj = new Insert();
    $selectObj = new Select();

    $resultSet = [];

    $res = $updateObj->updateTableStatus($_POST['table-no'], "Occupied");
    array_push($resultSet, $updateRes);

    $actID = $selectObj->getIncrementedID('table_activity', 'ActivityID');
    $res = $insertObj->setTableActivity($actID, $_POST['table-no']);

    $_SESSION['TABLE_NO'] = $_POST['table-no'];