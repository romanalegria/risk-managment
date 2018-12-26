<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Data\Dao\SAC003Dao;
use App\Data\Entities\SAC002Entity;
use Illuminate\Support\Facades\Storage;


class SAC003Controller extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar ==''){
            $funcionalidad = SAC003Dao::all();   
            \Log::info($funcionalidad); 
        }
        else{
            $funcionalidad = SAC003Dao::byName($buscar,$criterio);
        }        
        
        return[
            'pagination' => [
                'total'         => $funcionalidad->total(),
                'current_page'  => $funcionalidad->currentPage(),
                'per_page'      => $funcionalidad->perPage(),
                'last_page'     => $funcionalidad->lastPage(),
                'from'          => $funcionalidad->firstItem(),
                'to'            => $funcionalidad->lastItem(),
            ],
                'funcionalidad' => $funcionalidad

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
    	$funcionalidad=SAC003Dao::byId($id);
    	
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[
                'ModCod' => 'required',
                'FunDes' => 'required',                
                'FunVig' => 'required',
                'FunAcc' => 'required',                               
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
                $funcionalidad = SAC003Dao::save(
                    $request->input('ModCod'), 
                    $request->input('FunDes'), 
                    $request->input('FunVig'),
                    $request->input('FunAcc'));

                if($funcionalidad != null)
                {
                    $data = ControllerResponses::createdResp(['id'=> $funcionalidad->S02ModCod]);
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
                'ModCod' => 'required',
                'FunDes' => 'required',                
                'FunVig' => 'required',
                'FunAcc' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else {
                $funcionalidad = SAC003Dao::save(
                 $request->input('ModCod'), 
                 $request->input('FunDes'),
                 $request->input('FunVig'),
                 $request->input('FunAcc'),$id);
                if($funcionalidad != null){
                    $data = ControllerResponses::createdResp(['id'=> $funcionalidad->S02ModCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

   
    
    public function destroy($id, Request  $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
        
            $delete = SAC003Dao::delete($id);
            $data = ControllerResponses::okResp(['status'=> $delete]);
                
        return response()->json($data, $data->code);
    }
    

   

  
}