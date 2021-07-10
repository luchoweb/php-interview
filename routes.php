<?php

use controllers\RouterController as Route;
use controllers\FormController as Form;

Route::add('/', function(){
    $form = new Form;
    $form->index();
});

Route::add('/add', function(){
    Form::add($_POST["email"], $_POST["name"]);
}, "POST");

Route::run(FOLDER_PATH);