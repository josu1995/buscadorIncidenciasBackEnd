<?php

namespace App\Helpers;


use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth{
    public $key;

    public function __construct()
    {
        $this -> key = 'esta-es-mi-clave-secreta-89723467823460';
    }
    public function singUp($email,$password,$getToken = null){


        $user = User::where(
            array(
                "email" => $email,
                "password" => $password

            ))->first();

        $signUp = false;
        if(is_object($user)){
            $signUp = true;
        }    

        if($signUp){
            //Generar token y devolverlo
            $token = array(
                'sub' => $user -> id,
                'email' => $user ->email,
                'name' => $user -> name,
                'surname' => $user -> surname,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            );
            
            $jwt = JWT::encode ($token,$this->key,'HS256');
            $decode = JWT::decode ($jwt,$this->key,array('HS256'));

            if(is_null($getToken)){
                return $jwt;
            }else{
                return $decode;
            }

        }else{

            //Generar error
            return array(
                'status'=>'error',
                'code' => '400',
                'message' => 'Login ha fallado'
            );
        }

    }

    public function checkToken($jwt,$getIdentity = false){
        var_dump($getIdentity);
        $auth = false;
        $decoded = JWT::decode($jwt,$this->key, array('HS256'));

        try{
            $decoded = JWT::decode($jwt,$this->key, array('HS256'));          
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }
        
        if(isset ($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }else{
            $auth = false;
        }
        

        if($getIdentity){
            return $decoded;
        }
        
        return $auth;
    }
}