<?php

    spl_autoload_register(function($file){
        include '../db-helpers/' . $file . '.php';
    });