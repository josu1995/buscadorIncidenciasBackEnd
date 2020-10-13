<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(Request $request){
        //Recoger post
        $json= $request->input('json',null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $nombre= (!is_null($json) && isset($params->name)) ? $params->name : null;
        $surname= (!is_null($json) && isset($params->surname)) ? $params->surname : null;
        $role= 'ROLE_USER';
        $password= (!is_null($json) && isset($params->password)) ? $params->password : null;

        if(!is_null($email) && !is_null($nombre) && !is_null($password)){
            
            //Crear el usuario

            $user = new User();
            $user->email = $email;
            $user ->name = \strtoupper($nombre);
            $user ->surname = \strtoupper($surname);
            $user ->role = $role;

            $pwd = hash('sha256',$password);
            $user ->password = $pwd;

            //Comprobar usuario duplicado

            $isset_user = User::where('email','=',$email)->first();

            if(is_null($isset_user)){
                //Guardar
                $user->save();

                $data = array(
                    'status'=>'success',
                    'code' => '200',
                    'message' => 'Usuario registrado correctamente'
                );

            }else{
                $data = array(
                    'status'=>'error',
                    'code' => '400',
                    'message' => 'Usuario duplicado'
                );
            }


        }else{
            $data = array(
                'status'=>'error',
                'code' => '400',
                'message' => 'Usuario no creado'
            );
            
        }
        return response()->json($data,200);
    }

    public function login(Request $request){

        $jwtAuth = new JwtAuth();

        //Recivir datos post

        $json = $request->input('json',null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params ->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params ->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params ->gettoken)) ? $params->gettoken : null;

        //Cifrar pass
        $pwd = hash('SHA256',$password);    

        if(!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false')){
            $signUp = $jwtAuth->singUp($email,$pwd);

        }elseif($getToken != null){
            $signUp = $jwtAuth->singUp($email,$pwd,$getToken);

        }else{
            $signUp = array(
            'status'=>'error',
            'code' => '400',
            'message' => 'Envia tus datos por post');

        }

        return response()->json($signUp,200);
    }
}
