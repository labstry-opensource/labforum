<?php

function checkTranslationExists($lang, $lang_path_to_file){
    return (file_exists(LAF_ROOT_PATH . "/locale/{$lang}/") &&
        file_exists(LAF_ROOT_PATH . "/locale/{$lang}{$lang_path_to_file}")
    );
}

function loadTranslation($lang, $lang_path_to_file){
    include LAF_ROOT_PATH . "/locale/{$lang}{$lang_path_to_file}";
}

function get_template_dir(){
    return LAF_ROOT_PATH . '/template';
}

function load_view($view_name, $data){
    extract($data);
    if(file_exists(LAF_ROOT_PATH . "/views/{$view_name}.php")){
        include LAF_ROOT_PATH . '/views/' .$view_name . '.php';
    }
}
