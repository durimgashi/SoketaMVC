<?php

namespace App\Utils;

class Validator {

    /**
     * @var array $patterns
     */
    public $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+',
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha'         => '[\p{L}]+',
        'words'         => '[\p{L}\s]+',
        'alphanum'      => '[\p{L}0-9]+',
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address'       => '[\p{L}0-9\s.,()°-]+',
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email'         => "[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+"
    );
    public $errorclass;

    /**
     * @var array $errors
     */
    public $errors = array();


    public function name($name){

        $this->name = $name;
        return $this;

    }

    public function errorclass($name){
        $this->errorclass = $name;
        return $this;
    }
    public function value($value){

        $this->value = $value;
        return $this;

    }


    public function file($value){

        $this->file = $value;
        return $this;

    }

    public function pattern($name){

        if($name == 'array'){

            if(!is_array($this->value)){
                $this->errors[$this->errorclass] = 'Format of '.$this->name.' field is invalid.';
            }

        }else{

            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[$this->errorclass] = 'Format of '.$this->name.' field is invalid.';
            }

        }
        return $this;

    }


    public function customPattern($pattern){

        $regex = '/^('.$pattern.')$/u';
        if($this->value != '' && !preg_match($regex, $this->value)){
            $this->errors[$this->errorclass] = 'Format of '.$this->name.' field is invalid.';
        }
        return $this;

    }


    public function required(){

        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
            $this->errors[$this->errorclass] = 'Field '.$this->name.' is required.';

        }
        return $this;

    }

    public function min($length){

        if(is_string($this->value)){

            if(strlen($this->value) < $length){
                $this->errors[$this->errorclass] = 'Value of '.$this->name.' should be at least ' . $length . ' characters';
            }

        }else{

            if($this->value < $length){
                $this->errors[$this->errorclass] = 'Value of '.$this->name.' is lower than expected.';
            }

        }
        return $this;

    }


    public function max($length){

        if(is_string($this->value)){

            if(strlen($this->value) > $length){
                $this->errors[$this->errorclass] = 'Value of '.$this->name.' is higher than expected.';
            }

        }else{

            if($this->value > $length){
                $this->errors[$this->errorclass] = 'Value of '.$this->name.' is higher than expected.';
            }

        }
        return $this;

    }


    public function equal($value){

        if($this->value != $value){
            $this->errors[$this->errorclass] = 'Value of '.$this->name.' is a mismatch.';
        }
        return $this;

    }

    public function maxSize($size){

        if($this->file['error'] != 4 && $this->file['size'] > $size){
            $this->errors[$this->errorclass] = 'The file '.$this->name.' exceeds the maximum size of '.number_format($size / 1048576, 2).' MB.';
        }
        return $this;

    }

    public function ext($extension){

        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
            //$this->errors[$this->errorclass] = 'File '.$this->name.' is not '.$extension.' extension.';
            $this->errors[$this->errorclass] = 'File format is not supported!';
        }
        return $this;

    }
    public function exts($extensions){
        $errors = [];
        $counter = 0;

        foreach($extensions as $extension)
        {
            if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
                $errors[$this->errorclass] = 'File '.$this->name.' is not '.$extension.' extension.';
                $counter++;
            }
        }
        if($counter == count($extensions)){
            $this->errors[$this->errorclass] = reset($errors);
        }
        return $this;

    }

    public function purify($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }


    public function isSuccess(){
        if(empty($this->errors)) return true;
    }


    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }

    public function displayErrors(){

        $html = '<ul>';
        foreach($this->getErrors() as $error){
            $html .= '<li>'.$error.'</li>';
        }
        $html .= '</ul>';

        return $html;

    }


    public function result(){

        if(!$this->isSuccess()){

            foreach($this->getErrors() as $error){
                echo "$error\n";
            }
            exit;

        }else{
            return true;
        }

    }


    public static function is_int($value){
        if(filter_var($value, FILTER_VALIDATE_INT)) return true;
    }

    static function is_float($value){
        if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
    }


    public static function is_alpha($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
    }


    public static function is_alphanum($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
    }

    public static function is_url($value){
        if(filter_var($value, FILTER_VALIDATE_URL)) return true;
    }

    public static function is_uri($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
    }


    public static function is_bool($value){
        if(is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
    }


    public static function is_email($value){
        if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
    }

}