<?php


class notFound{
    public function index($req, $res){
        return $res->view('404');
    }
}