<?php 
  namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class SAC003Entity extends Model
{
	protected $table = 'SAC003';
	protected $primaryKey = 'S03FunCod';

	const CREATED_AT    =   'S03FecTra';
    const UPDATED_AT    =   'S03FecMod';

	protected $fillable = [
        'S02ModCod',
        'S03FunCod',
		'S03FunDes',		
		'S03FunVig',		
        'S03FunAcc',
	];

	protected $hidden = [
		'S02ModCod',
        'S03FunCod',
		'S03FunDes',		
		'S03FunVig',		
        'S03FunAcc',
		'S03FecTra',
		'S03FecMod',
	];

	protected $appends = ['ModCod','FunCod','FunDes','FunVig','FunAcc','FecTra','FecMod'];

	public function getModCodAttribute()
	{
		return $this->S02ModCod;
    }
    
    public function getFunCodAttribute()
	{
		return $this->S03FunCod;
    }

	public function getFunDesAttribute()
	{
		return $this->S03FunDes;
	}	
	
	public function getFunVigAttribute()
	{
		return $this->S03FunVig;
	}

    public function getFunAccAttribute()
	{
		return $this->S03FunAcc;
	}

	public function getFecTraAttribute()
	{
		return $this->S03FecTra;
	}

	public function getFecModAttribute()
	{
		return $this->S03FecMod;
	}

	public function S002Entity()
	{		
		return $this->belongsTo('App\Data\Entities\SAC002Entity','S02ModCod','S02ModCod');
		
	}

	
}
