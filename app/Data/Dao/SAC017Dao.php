<?php

namespace App\Data\Dao;

use App\Data\Entities\SAC017entity;

class SAC017Dao
{
	public static function all()
	{
		$empresa = SAC017Entity::orderBy('S017EmCCod','desc')->paginate(4);
		if	($empresa->count() > 0)
		{
			return $empresa;
		}
		return [];
	}

	public static function byId($id)
	{
		$empresa = SAC017entity::where('S017EmCCod',$id)->first();
		if ($empresa) {
			return $empresa;
		}
		return null;
	}

	public static function byName($buscar,$criterio)
	{
		$empresa = SAC017entity::where($criterio, 'like', '%' .$buscar. '%')->orderBy('S017EmCCod','desc')->paginate(4);
		if ($empresa) {
			return $empresa;
		}
		return null;
	}

	
	public static function save($EmPCod,$EmCRut,$EmCNom,$EmCRso,$EmPVig,$EmCTip,$EmCNam,$EmCCmu,$EmCTpr,
	$EmCFcr,$EmCTpa,$EmCFca,$EmCFca,$EmCCmu, $id = null)
	{
		$empresa = null;
		if ($id != null) {
			//$Perfil = SAC000entity::where('S00PerCod',$id)->first();
			$empresa = SAC017entity::find($id)->first();
			if (!$empresa) {
				return null;
			}
		}else{
			$empresa = new SAC017entity();
		}


		$empresa->S05EmPCod = $EmpPCod;
		$empresa->S017EmCRut = $EmCRut;
		$empresa->S017EmCNom = $EmCNom;
		$empresa->S017EmCRso = $EmCRso;
		$empresa->S017EmPVig = $EmCPVig
		$empresa->S017EmCTip = $EmCTip;
		$empresa->S017EmCNam = $EmCNam;
		$empresa->S017EmCCmu = $EmCCmu;		
		$empresa->S017EmCTpr = $EmCTpr;
		$empresa->S017EmCFcr = $EmCFcr;
		$empresa->S017EmCTpa = $EmCTpa;
		$empresa->S017EmCFca = $EmCFca;
		$empresa->S017EmCCmu = $EmCCmu;
		
		if ($empresa->save()) {
			return $empresa;
		}
		return null;
	}


	public static function delete($id)
	{
		$empresa = null;			
		if ($id != null) {
			$empresa = SAC017entity::find($id)->first();
			if ($empresa != null) {
				return $empresa->delete();
			}
		}
		return false;
	}

	public static function desactivar($id)
	{
		$empresa = null;			
		if ($id != null) {
			$empresa = SAC005entity::where('S05EmPCod',$id)->first();
			if ($empresa != null) {
				//$Empresa->S00PerCon =0;
				if ($empresa->save()) 
				{
					return $empresa;
				}
			}
		}
		return false;
	}

	public static function activar($id)
	{
		$Empresa = null;			
		if ($id != null) {
			$Empresa = SAC005entity::where('S05EmPCod',$id)->first();
			if ($Empresa != null) {
				//$Perfil->S00PerCon = 1;
				if ($Empresa->save()) 
				{
					return $Empresa;
				}
			}
		}
		return false;
	}
	
}