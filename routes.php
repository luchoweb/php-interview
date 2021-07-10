<?php

use controllers\RouterController as Route;

Route::add('/', function(){
    echo "HOME";
});

Route::run(FOLDER_PATH);