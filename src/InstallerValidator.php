<?php


class InstallerValidator
{
    protected $post_arr;
    public $error = array();
    public $supported_db = array('mysql', 'mssql', 'oracle');

    public function __construct($post_arr)
    {
        $this->post_arr = $post_arr;
    }

    public function validate()
    {
        $this->validateAccessUsername();
        $this->validateSuperuser();
        $this->validateAccessPassword();
        $this->validateSuperuserPassword();
        $this->validateDBType();
        $this->validateDBName();

        return $this->error;
    }

    public function validateAccessUsername()
    {
        if(empty($this->post_arr['username']))
        {
            $this->error['username'] = 'Username can\'t be empty';
        }
    }
    public function validateSuperuser()
    {
        if(empty($this->post_arr['superuser']))
        {
            $this->error['superuser'] = 'Username can\'t be empty';
        }
    }

    public function validateAccessPassword()
    {
        if(empty($this->post_arr['password']))
        {
            $this->error['password'] = 'Password can\'t be empty';
        }
    }

    public function validateSuperuserPassword()
    {
        if(empty($this->post_arr['superuserpassword']))
        {
            $data['error']['superuserpassword'] = 'Password can\'t be empty';
        }
    }
    public function validateDBType()
    {
        if(empty($this->post_arr['db_type']))
        {
            $data['error']['db_type'] = 'Please choose a database type to continue';
        }
        else if(!in_array($this->post_arr['db_type'], $this->supported_db)){
            $data['error']['db_type'] = 'Unsupported DB Type.';
        }
    }
    public function validateDBName(){
        if(empty($this->post_arr['dbname']))
        {
            $data['error']['dbname'] = 'Please choose a database name. A name that can be known only to you.';
        }
        else if(!preg_match('/^[0-9a-zA-Z$_]+$/', $this->post_arr['dbname']))
        {
            $data['error']['dbname'] = 'Only digits from 0-9, a-z or A-Z alphabets, $ and _ are allowed for database name. Lower cases are recommended.';
        }
    }

}