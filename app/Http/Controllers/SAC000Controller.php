<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Data\Dao\SAC000Dao;
use Illuminate\Support\Facades\Storage;


class SAC000Controller extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar ==''){
            $perfil = SAC000Dao::all();    
        }
        else{
            $perfil = SAC000Dao::byName($buscar,$criterio);
        }

        
        
        return[
            'pagination' => [
                'total'         => $perfil->total(),
                'current_page'  => $perfil->currentPage(),
                'per_page'      => $perfil->perPage(),
                'last_page'     => $perfil->lastPage(),
                'from'          => $perfil->firstItem(),
                'to'            => $perfil->lastItem(),
            ],
                'perfil' => $perfil

        ];
        

        //return $perfil;          
               
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
    	$perfil=SAC000Dao::byId($id);
    	
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[                
                'PerNom' => 'required',
                'PerDes' => 'required',
                'TipEmp' => 'required',
                'PerVig' => 'required',
                'ResTra' => 'required',
                'PerCon' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
                $perfil = SAC000Dao::save(
                    $request->input('PerNom'), 
                    $request->input('PerDes'),
                    $request->input('TipEmp'),
                    $request->input('PerVig'),
                    $request->input('ResTra'),
                    $request->input('PerCon'));

                if($perfil != null)
                {
                    $data = ControllerResponses::createdResp(['id'=> $perfil->S00PerCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function update($id, Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[
                'PerNom' => 'required',
                'PerDes' => 'required',
                'TipEmp' => 'required',
                'PerVig' => 'required',
                'ResTra' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else {
                $perfil = SAC000Dao::save($request->input('PerNom'),
                 $request->input('PerDes'),
                 $request->input('TipEmp'), 
                 $request->input('PerVig'),
                 $request->input('ResTra'),
                 $request->input('PerCon'),$id);
                if($perfil != null){
                    $data = ControllerResponses::createdResp(['id'=> $perfil->S00PerCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function desactivar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');

            $data = ControllerResponses::badRequestResp();
        
            $desactivar = SAC000Dao::desactivar($id);
            $data = ControllerResponses::okResp(['status'=> $desactivar]);
                
        return response()->json($data, $data->code);
    }

    public function activar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');
            $data = ControllerResponses::badRequestResp();
        
            $activar = SAC000Dao::activar($id);
            $data = ControllerResponses::okResp(['status'=> $activar]);
                
        return response()->json($data, $data->code);
    }    
    
    public function destroy($id, Request  $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
        
            $delete = SAC000Dao::delete($id);
            $data = ControllerResponses::okResp(['status'=> $delete]);
                
        return response()->json($data, $data->code);
    }
    

   

  
}