<?php

namespace App\Data\Dao;

use App\Data\Entities\SAC005entity;

class SAC005Dao
{
	public static function all()
	{
		$empresa = SAC005Entity::orderBy('S05EmPCod','desc')->paginate(4);
		if	($empresa->count() > 0)
		{
			return $empresa;
		}
		return [];
	}

	public static function byId($id)
	{
		$empresa = SAC000entity::where('S05EmPCod',$id)->first();
		if ($empresa) {
			return $empresa;
		}
		return null;
	}

	public static function byName($buscar,$criterio)
	{
		$empresa = SAC005entity::where($criterio, 'like', '%' .$buscar. '%')->orderBy('S05EmPCod','desc')->paginate(4);
		if ($empresa) {
			return $empresa;
		}
		return null;
	}

	public static function save($EmPRut, $EmPNom, $EmPRSo, $EmPVig, $EmPNor, $EmPApr, $EmPAmr, $EmPCor, $id = null)
	{
		$empresa = null;
		if ($id != null) {
			//$Perfil = SAC000entity::where('S00PerCod',$id)->first();
			$empresa = SAC005entity::find($id)->first();
			if (!$empresa) {
				return null;
			}
		}else{
			$empresa = new SAC005entity();
		}

		$empresa->S05EmPRut = $EmPRut;
		$empresa->S05EmPNom = $EmPNom;
		$empresa->S05EmPRSo = $EmPRSo;
		$empresa->S05EmPVig = $EmPVig;
		$empresa->S05EmPNor = $EmPNor;
		$empresa->S05EmPApr = $EmPApr;
		$empresa->S05EmPAmr = $EmPAmr;
		$empresa->S05EmPCor = $EmPCor;
		if ($empresa->save()) {
			return $empresa;
		}
		return null;
	}


	public static function delete($id)
	{
		$empresa = null;			
		if ($id != null) {
			$empresa = SAC005entity::find($id)->first();
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