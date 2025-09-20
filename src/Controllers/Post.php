
<?php

class Post{
    public function post($req, $res){
        echo 'welcome from post ' . "{id} ". $req->params['id'] . " ::::: {post} " . $req->params['post'] . " ::::: " . $req->method . ' --- ' , $req->uri;
    }
}