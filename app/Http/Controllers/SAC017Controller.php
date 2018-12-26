<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Data\Dao\SAC017Dao;
use Illuminate\Support\Facades\Storage;


class SAC017Controller extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar ==''){
            $empresa = SAC017Dao::all();    
        }
        else{
            $empresa = SAC017Dao::byName($buscar,$criterio);
        }

        
        
        return[
            'pagination' => [
                'total'         => $empresa->total(),
                'current_page'  => $empresa->currentPage(),
                'per_page'      => $empresa->perPage(),
                'last_page'     => $empresa->lastPage(),
                'from'          => $empresa->firstItem(),
                'to'            => $empresa->lastItem(),
            ],
                'empresa' => $empresa

        ];
        

        
               
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
    	$empresa=SAC017Dao::byId($id);
    	
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
               
            $validate = \Validator::make($request->all(),[                
                'EmCRut' => 'required',
                'EmCNom' => 'required',
                'EmCRso' => 'required',
                'EmPVig' => 'required',                
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
                $empresa = SAC017Dao::save(
                    $request->input('EmCRut'), 
                    $request->input('EmCNom'),
                    $request->input('EmCRso'),
                    $request->input('EmPVig')
                    );

                if($empresa != null)
                {
                    $data = ControllerResponses::createdResp(['id'=> $empresa->S017EmCCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function update($id, Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[
                'EmCRut' => 'required',
                'EmCNom' => 'required',
                'EmPRso' => 'required',
                'EmPVig' => 'required',                
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else {
                $empresa = SAC017Dao::save(
                    $request->input('EmCRut'), 
                    $request->input('EmCNom'),
                    $request->input('EmCRso'),
                    $request->input('EmPVig'),$id);

                if($empresa != null){
                    $data = ControllerResponses::createdResp(['id'=> $empresa->S017EmCCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function desactivar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');

            $data = ControllerResponses::badRequestResp();
        
            $desactivar = SAC017Dao::desactivar($id);
            $data = ControllerResponses::okResp(['status'=> $desactivar]);
                
        return response()->json($data, $data->code);
    }

    public function activar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');
            $data = ControllerResponses::badRequestResp();
        
            $activar = SAC017Dao::activar($id);
            $data = ControllerResponses::okResp(['status'=> $activar]);
                
        return response()->json($data, $data->code);
    }    
    
    public function destroy($id, Request  $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
        
            $delete = SAC017Dao::delete($id);
            $data = ControllerResponses::okResp(['status'=> $delete]);
                
        return response()->json($data, $data->code);
    }
    

   

  
}