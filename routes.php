<?php

use db\Database as db;
use controllers\RouterController as Router;
use controllers\FormController as Form;

Router::add('/', function(){
    $form = new Form;
    $form->index();
});

Router::add('/add', function(){
    Form::addSubscriber($_POST["email"], $_POST["name"]);
}, "POST");

Router::run(ROOT_PATH);