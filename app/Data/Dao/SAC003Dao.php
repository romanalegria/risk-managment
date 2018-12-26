<?php

namespace App\Data\Dao;

use App\Data\Entities\SAC003Entity;

class SAC003Dao
{
	public static function all()
	{
		$Funcionalidad = SAC003Entity::orderBy('S03FunCod','desc')->paginate(4);
		if	($Funcionalidad->count() > 0)
		{
			return $Funcionalidad;			
		}
		return [];
	}

	public static function byId($id)
	{
		$Funcionalidad = SAC003Entity::where('S03FunCod',$id)->first();
		if ($Funcionalidad) {
			return $Funcionalidad;
		}
		return null;
	}

	public static function byName($buscar,$criterio)
	{
		$Funcionalidad = SAC003Entity::where($criterio, 'like', '%' .$buscar. '%')->orderBy('S03FunCod','desc')->paginate(6);
		if ($Funcionalidad) {
			return $Funcionalidad;
		}
		return null;
	}

	public static function save($ModCod, $FunDes, $FunVig, $FunAcc, $id = null)
	{		
		
		$Funcionalidad = null;
		if ($id != null) {			
			//$Funcionalidad = SAC003Entity::find($id)->first();
			$Funcionalidad = SAC003Entity::where('S03FunCod',$id)->first();
			if (!$Funcionalidad) {
				return null;
			}
		}else{
			$Funcionalidad = new SAC003Entity();
		}

		$Funcionalidad->S02ModCod = $ModCod;
		$Funcionalidad->S03FunDes = $FunDes;		
		$Funcionalidad->S03FunVig = $FunVig;
		$Funcionalidad->S03FunAcc = $FunAcc;
		if ($Funcionalidad->save()) {
			return $Funcionalidad;
		}
		return null;
	}


	public static function delete($id)
	{
		$Funcionalidad = null;			
		if ($id != null) {
			$Funcionalidad = SAC003Entity::where('S03FunCod',$id)->first();
			if ($Funcionalidad != null) {
				return $Funcionalidad->delete();
			}
		}
		return false;
	}

	
}