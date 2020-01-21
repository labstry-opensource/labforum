<?php


class RedirectToolkit
{
    public function set404(){
        http_response_code(404);
        include LAF_PATH . '/error_page/404.php';
        die;
    }
}