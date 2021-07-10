<?php

namespace controllers;

use views\Home as HomeView;

class FormController
{
    public function index()
    {
        HomeView::setForm('addSubscribers');
    }
}
