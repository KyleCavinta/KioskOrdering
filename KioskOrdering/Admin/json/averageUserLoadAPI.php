<?php

    include '../includes/class-loader.php';
    $selectObj = new Select();

    $days = [
        ["day" => "Sunday", "count" => 0],
        ["day" => "Monday", "count" => 0],
        ["day" => "Tuesday", "count" => 0],
        ["day" => "Wednesday", "count" => 0],
        ["day" => "Thursday", "count" => 0],
        ["day" => "Friday", "count" => 0],
        ["day" => "Saturday", "count" => 0],
    ];

    $opt = $_GET['opt'];
    $arr = [];

    if($opt == "Last Week"){
        $arr = $selectObj->getLastweekTableActivity();
    }
    else if($opt == "This Week"){
        $arr = $selectObj->getThisWeekTableActivity();
    }

    foreach($arr as $r){
        $idx = array_search(date('l', strtotime($r['EnteredAt'])), array_column($days, "day"));
        $days[$idx]['count'] = $r['AveLoad'];
    }

    echo json_encode($days);