<?php

namespace App\Data\Dao;

use App\Data\Entities\Userentity;
use Illuminate\Support\Facades\Hash;

class UserDao
{
	
	public static function all()
	{
		$users = UserEntity::all();
		if($users->count() > 0){
			return $homes;
		}
		return [];
	}
	
	public static function byId($id)
	{
		$user = UserEntity::find($id)->first();
		if($user){
			return $user;
		}
		return null;
	}
	
	public static function save($name,$email, $password , $id = null)
	{
		$user = null;
		if($id != null){
			$user = UserEntity::find($id)->first();
			if(!$user){
				return null;
			}
		}else{
			$user = new UserEntity();
		}	
		$user->name = $name;
        $user->email = $email;
		$user->password = Hash::make($password);		
        if($user->save())
        {
			return $user;
		}
		return null;
	}
    
    public static function getByEmail($mail)
    {
        $mailUser = UserEntity::where('email', '=', $mail)->first();
		if($mailUser){
			return $mailUser;
		} 
		return null;
	}

	public static function changePassword($id,$password)
	{
		$user = null;
		if($id != null and $password != null)
		{
			//$home = HomeEntity::find($id)->first();	
			$user = UserEntity::where('id', '=', $id)->first();		
			if(!$user){
				return null;
			}

			$user->password = Hash::make($password);
			if($user->save()) {				
				return $user;
			}
		}
		
	}

}