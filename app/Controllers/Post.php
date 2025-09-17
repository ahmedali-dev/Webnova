<?php

// namespace App\Controllers;
use App\Database\User;
class Post{
    public function post(){
        $us = new User();
        $us->getall(); 
        echo 'welcome from post';
    }
}