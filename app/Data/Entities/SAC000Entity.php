<?php 
  namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class SAC000Entity extends Model
{
	protected $table = 'SAC000';
	protected $primaryKey = 'S00PerCod';

	const CREATED_AT    =   'S00FecTra';
    const UPDATED_AT    =   'S00FecMod';

	protected $fillable = [
		'S00PerCod',
		'S00PerNom',
		'S00PerDes',
		'S00TipEmp',
		'S00PerVig',
		'S00ResTra',
		'S00PerCon',

	];

	protected $hidden = [
		'S00PerCod',		
		'S00PerNom',
		'S00PerDes',
		'S00TipEmp',
		'S00PerVig',		
		'S00FecTra',
		'S00FecMod',
		'S00ResTra',
		'S00PerCon',
	];

	protected $appends = ['PerCod','PerNom','PerDes','TipEmp','PerVig','FecTra','FecMod','ResTra','PerCon'];

	public function getPerCodAttribute()
	{
		return $this->S00PerCod;
	}

	public function getPerNomAttribute()
	{
		return $this->S00PerNom;
	}	

	public function getPerDesAttribute()
	{
		return $this->S00PerDes;
	}	

	public function getTipEmpAttribute()
	{
		return $this->S00TipEmp;
	}

	public function getPerVigAttribute()
	{
		return $this->S00PerVig;
	}

	public function getFecTraAttribute()
	{
		return $this->S00FecTra;
	}

	public function getFecModAttribute()
	{
		return $this->S00FecMod;
	}

	public function getResTraAttribute()
	{
		return $this->S00ResTra;
	}

	public function getPerConAttribute()
	{
		return $this->S00PerCon;
	}

}

