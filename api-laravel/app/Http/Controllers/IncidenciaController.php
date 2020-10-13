<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\JwtAuth;
use App\Models\incidencia;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\Flysystem\Exception;

class IncidenciaController extends Controller
{
    public function index(Request $request){

        $incidencias = incidencia::all()->load('user');
        
        return response()->json(array(
            'incidencias'=> $incidencias,
            'status'=> 'success'
        ),200);

    }

    public function show(Request $request){ 
        //puede haber usuarios con un mismo nombre
        //sacamos los ids de todos los usuarios

        $json= $request->input('json',null);
        $params = json_decode($json);

        $incidencias = array();
        $incidencia = null;
        $usuarios = user::where('name',$params->name)->get();   
        foreach($usuarios as $usuario){
            //por cada usuario cogemos su id y miramos si tiene alguna incidencia
            $incidencia = incidencia::where('user_id',$usuario['id'])->get()->load('user');
            if(count($incidencia) != 0){
                array_push($incidencias,$incidencia);
            }
        }        
        return response()->json(array(
            'incidencia'=> $incidencias,
            'status'=> 'success'
        ),200);
    }

    public function showDates(Request $request){

        $json= $request->input('json',null);
        $params = json_decode($json);

        $incidencias = incidencia::whereBetween('created_at',[$params->desde,$params->hasta])->get()->load('user');
        
        return response()->json(array(
            'incidencias'=> $incidencias,
            'status'=> 'success'
        ),200);
    
    }

}

