<?php

namespace App\Data\Dao;

use App\Data\Entities\SAC000entity;

class SAC000Dao
{
	public static function all()
	{
		$Perfil = SAC000Entity::orderBy('S00PerCod','desc')->paginate(4);
		if	($Perfil->count() > 0)
		{
			return $Perfil;
		}
		return [];
	}

	public static function byId($id)
	{
		$Perfil = SAC000entity::where('S00PerCod',$id)->first();
		if ($Perfil) {
			return $Perfil;
		}
		return null;
	}

	public static function byName($buscar,$criterio)
	{
		$Perfil = SAC000entity::where($criterio, 'like', '%' .$buscar. '%')->orderBy('S00PerCod','desc')->paginate(4);
		if ($Perfil) {
			return $Perfil;
		}
		return null;
	}

	public static function save($PerNom, $PerDes, $TipEmp, $PerVig, $ResTra, $PerCon, $id = null)
	{
		$Perfil = null;
		if ($id != null) {
			//$Perfil = SAC000entity::where('S00PerCod',$id)->first();
			$Perfil = SAC000entity::find($id)->first();
			if (!$Perfil) {
				return null;
			}
		}else{
			$Perfil = new SAC000entity();
		}

		$Perfil->S00PerNom = $PerNom;
		$Perfil->S00PerDes = $PerDes;
		$Perfil->S00TipEmp = $TipEmp; 
		$Perfil->S00PerVig = $PerVig;
		$Perfil->S00ResTra = $ResTra;
		$Perfil->S00PerCon = $PerCon;
		if ($Perfil->save()) {
			return $Perfil;
		}
		return null;
	}


	public static function delete($id)
	{
		$Perfil = null;			
		if ($id != null) {
			$Perfil = SAC000entity::find($id)->first();
			if ($Perfil != null) {
				return $Perfil->delete();
			}
		}
		return false;
	}

	public static function desactivar($id)
	{
		$Perfil = null;			
		if ($id != null) {
			$Perfil = SAC000entity::where('S00PerCod',$id)->first();
			if ($Perfil != null) {
				$Perfil->S00PerCon = 0;
				if ($Perfil->save()) 
				{
					return $Perfil;
				}
			}
		}
		return false;
	}

	public static function activar($id)
	{
		$Perfil = null;			
		if ($id != null) {
			$Perfil = SAC000entity::where('S00PerCod',$id)->first();
			if ($Perfil != null) {
				$Perfil->S00PerCon = 1;
				if ($Perfil->save()) 
				{
					return $Perfil;
				}
			}
		}
		return false;
	}


	
}