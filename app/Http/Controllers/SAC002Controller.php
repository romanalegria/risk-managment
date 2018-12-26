<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Data\Dao\SAC002Dao;
use Illuminate\Support\Facades\Storage;


class SAC002Controller extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar ==''){
            $modulo = SAC002Dao::all();    
        }
        else{
            $modulo = SAC002Dao::byName($buscar,$criterio);
        }

        
        
        return[
            'pagination' => [
                'total'         => $modulo->total(),
                'current_page'  => $modulo->currentPage(),
                'per_page'      => $modulo->perPage(),
                'last_page'     => $modulo->lastPage(),
                'from'          => $modulo->firstItem(),
                'to'            => $modulo->lastItem(),
            ],
                'modulo' => $modulo

        ];
        

        //return $perfil;          
               
    }

    public function selectModulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $modulos = SAC002Dao::all();

        return ['modulos' => $modulos];

    }

    public function create()
    {
       
    }


    public function show($id)
    {
        $data = ControllerResponses::okResp();
        return response()->json($data, $data->code);
    }

    public function edit($id)
    {
    	$modulo=SAC002Dao::byId($id);
    	
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[                
                'ModDes' => 'required',
                'ModTem' => 'required',                
                'ModVig' => 'required',               
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
                $modulo = SAC002Dao::save(
                    $request->input('ModDes'), 
                    $request->input('ModTem'),
                    $request->input('ModVig'));

                if($modulo != null)
                {
                    $data = ControllerResponses::createdResp(['id'=> $modulo->S02ModCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function update($id, Request $request)
    {
       \Log::info($request->all());

        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[
                'ModDes' => 'required',
                'ModTem' => 'required',                
                'ModVig' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else {
                $modulo = SAC002Dao::save($request->input('ModDes'),
                 $request->input('ModTem'),
                 $request->input('ModVig'),$id);
                if($modulo != null){
                    $data = ControllerResponses::createdResp(['id'=> $modulo->S02ModCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function desactivar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');

            $data = ControllerResponses::badRequestResp();
        
            $desactivar = SAC002Dao::desactivar($id);
            $data = ControllerResponses::okResp(['status'=> $desactivar]);
                
        return response()->json($data, $data->code);
    }

    public function activar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');
            $data = ControllerResponses::badRequestResp();
        
            $activar = SAC002Dao::activar($id);
            $data = ControllerResponses::okResp(['status'=> $activar]);
                
        return response()->json($data, $data->code);
    }    
    
    public function destroy($id, Request  $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
        
            $delete = SAC002Dao::delete($id);
            $data = ControllerResponses::okResp(['status'=> $delete]);
                
        return response()->json($data, $data->code);
    }
    

   

  
}