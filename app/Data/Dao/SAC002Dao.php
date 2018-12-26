<?php

namespace App\Data\Dao;

use App\Data\Entities\SAC002Entity;

class SAC002Dao
{
	public static function all()
	{
		$Modulo = SAC002Entity::orderBy('S02ModCod','desc')->paginate(4);
		if	($Modulo->count() > 0)
		{
			return $Modulo;
		}
		return [];
	}

	public static function byId($id)
	{
		$Modulo = SAC002Entity::where('S02ModCod',$id)->first();
		if ($Modulo) {
			return $Modulo;
		}
		return null;
	}

	public static function byName($buscar,$criterio)
	{
		$Modulo = SAC002Entity::where($criterio, 'like', '%' .$buscar. '%')->orderBy('S02ModCod','desc')->paginate(6);
		if ($Modulo) {
			return $Modulo;
		}
		return null;
	}

	public static function save($ModDes, $ModTem, $ModVig, $id = null)
	{
		$Modulo = null;
		if ($id != null) {			
			//$Modulo = SAC002Entity::find($id)->first();
			$Modulo = SAC002Entity::where('S02ModCod',$id)->first();
			if (!$Modulo) {
				return null;
			}
		}else{
			$Modulo = new SAC002Entity();
		}

		$Modulo->S02ModDes = $ModDes;
		$Modulo->S02ModTem = $ModTem;		
		$Modulo->S02ModVig = $ModVig;		
		if ($Modulo->save()) {
			return $Modulo;
		}
		return null;
	}


	public static function delete($id)
	{
		$Modulo = null;			
		if ($id != null) {
			$Modulo = SAC002Entity::find($id)->first();
			if ($Modulo != null) {
				return $Modulo->delete();
			}
		}
		return false;
	}

	// public static function desactivar($id)
	// {
	// 	$Modulo = null;			
	// 	if ($id != null) {
	// 		$Modulo = SAC002Entity::where('S02ModCod',$id)->first();
	// 		if ($Modulo != null) {
	// 			$Modulo->S00PerCon = 0;
	// 			if ($Modulo->save()) 
	// 			{
	// 				return $Modulo;
	// 			}
	// 		}
	// 	}
	// 	return false;
	// }

	// public static function activar($id)
	// {
	// 	$Modulo = null;			
	// 	if ($id != null) {
	// 		$Modulo = SAC002Entity::where('S00PerCod',$id)->first();
	// 		if ($Modulo != null) {
	// 			$Modulo->S00PerCon = 1;
	// 			if ($Modulo->save()) 
	// 			{
	// 				return $Modulo;
	// 			}
	// 		}
	// 	}
	// 	return false;
	// }


	
}