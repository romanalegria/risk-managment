<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Data\Dao\SAC005Dao;
use Illuminate\Support\Facades\Storage;


class SAC005Controller extends Controller
{


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar ==''){
            $empresa = SAC005Dao::all();    
        }
        else{
            $empresa = SAC005Dao::byName($buscar,$criterio);
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
    	$empresa=SAC005Dao::byId($id);
    	
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
               
            $validate = \Validator::make($request->all(),[                
                'EmPRut' => 'required',
                'EmPNom' => 'required',
                'EmPRSo' => 'required',
                'EmPVig' => 'required',
                'EmPNor' => 'required',
                'EmPApr' => 'required',
                'EmPAmr' => 'required',
                'EmPCor' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else
            {
                $empresa = SAC005Dao::save(
                    $request->input('EmPRut'), 
                    $request->input('EmPNom'),
                    $request->input('EmPRSo'),
                    $request->input('EmPVig'),
                    $request->input('EmPNor'),
                    $request->input('EmPApr'),
                    $request->input('EmPAmr'),
                    $request->input('EmPCor'));

                if($empresa != null)
                {
                    $data = ControllerResponses::createdResp(['id'=> $empresa->S05EmPCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function update($id, Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();

            $validate = \Validator::make($request->all(),[
                'EmPRut' => 'required',
                'EmPNom' => 'required',
                'EmPRSo' => 'required',
                'EmPVig' => 'required',
                'EmPNor' => 'required',
                'EmPApr' => 'required',
                'EmPAmr' => 'required',
                'EmPCor' => 'required',
            ]);

            if($validate->fails()){
                $data = ControllerResponses::unprocesableResp($validate->errors());
            }else {
                $empresa = SAC005Dao::save(
                    $request->input('EmPRut'), 
                    $request->input('EmPNom'),
                    $request->input('EmPRSo'),
                    $request->input('EmPVig'),
                    $request->input('EmPNor'),
                    $request->input('EmPApr'),
                    $request->input('EmPAmr'),
                    $request->input('EmPCor'),$id);

                if($empresa != null){
                    $data = ControllerResponses::createdResp(['id'=> $empresa->S05EmPCod]);
                }
            }
        
        return response()->json($data, $data->code);
    }

    public function desactivar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');

            $data = ControllerResponses::badRequestResp();
        
            $desactivar = SAC005Dao::desactivar($id);
            $data = ControllerResponses::okResp(['status'=> $desactivar]);
                
        return response()->json($data, $data->code);
    }

    public function activar($id,Request $request)
    {
            if (!$request->ajax()) return redirect('/');
            $data = ControllerResponses::badRequestResp();
        
            $activar = SAC005Dao::activar($id);
            $data = ControllerResponses::okResp(['status'=> $activar]);
                
        return response()->json($data, $data->code);
    }    
    
    public function destroy($id, Request  $request)
    {
        if (!$request->ajax()) return redirect('/');

        $data = ControllerResponses::badRequestResp();
        
            $delete = SAC005Dao::delete($id);
            $data = ControllerResponses::okResp(['status'=> $delete]);
                
        return response()->json($data, $data->code);
    }
    

   

  
}