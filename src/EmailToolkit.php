<?php
class EmailToolkit{
    public $email = null;

    function validateEmail($email){
        $this->email = substr(strrchr($email, "@"), 1);
        if($this->email){
            $arr = dns_get_record($this->email, DNS_MX);
            if (@$arr[0]['host'] == $this->email && !empty(@$arr[0]['target'])) {
                return $arr[0]['target'];
            }
        }

    }
}