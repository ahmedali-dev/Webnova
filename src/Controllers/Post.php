
<?php

class Post{
    public function post($req, $res, $next){
        echo '<hr>';
        echo '<br>welcome from post ' . "{id} ". $req->params['id'] . " ::::: {post} " . $req->params['post'] . " ::::: " . $req->method . ' --- ' , $req->uri;
        echo '<hr>';
        // echo $next() ? 'is True' : 'is False';
    }
}