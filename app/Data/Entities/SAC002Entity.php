<?php 
  namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class SAC002Entity extends Model
{
	protected $table = 'SAC002';
	protected $primaryKey = 'S02ModCod';

	const CREATED_AT    =   'S02FecTra';
    const UPDATED_AT    =   'S02FecMod';

	protected $fillable = [
		'S02ModCod',
		'S02ModDes',		
		'S02ModTem',
		'S02ModVig',		

	];

	protected $hidden = [
		'S02ModCod',
		'S02ModDes',		
		'S02ModTem',
		'S02ModVig',
		'S02FecTra',
		'S02FecMod',
	];

	protected $appends = ['ModCod','ModDes','ModTem','ModVig','FecTra','FecMod'];

	public function getModCodAttribute()
	{
		return $this->S02ModCod;
	}

	public function getModDesAttribute()
	{
		return $this->S02ModDes;
	}	

	public function getModTemAttribute()
	{
		return $this->S02ModTem;
	}	

	
	public function getModVigAttribute()
	{
		return $this->S02ModVig;
	}

	public function getFecTraAttribute()
	{
		return $this->S02FecTra;
	}

	public function getFecModAttribute()
	{
		return $this->S02FecMod;
	}
	
	public function S003Entity()
	{		
		return $this->hasMany('App\Data\Entities\SAC003Entity','S02Modcod','S02ModCod');
		
	}
}
