<?php
    namespace app\common\lib

    class Aes interface encryptCore{
	private $key = null;

	public function __construct(){
	    $this->key = config('app.aeskey');
	}

	public function encrypt($data){
	    
	    return $encrypt_data;
	}

	public function decrypt($data){
	
	    return $decrypt_data;
	}
    }

