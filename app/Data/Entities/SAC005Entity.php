<?php 
  namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class SAC005Entity extends Model
{
	protected $table = 'SAC005';
	protected $primaryKey = 'S05EmPCod';

	const CREATED_AT    =   'S05FecTra';
    const UPDATED_AT    =   'S00FecMod';

	protected $fillable = [
		'S05EmPCod',
		'S05EmPRut',
		'S05EmPNom',
		'S05EmPRSo',
		'S05EmPVig',
		'S05EmPNor',
		'S05EmPApr',
		'S05EmPAmr',
		'S05EmPCor',

	];

	protected $hidden = [
		'S05EmPCod',
		'S05EmPRut',
		'S05EmPNom',
		'S05EmPRSo',
		'S05EmPVig',
		'S05EmPNor',
		'S05EmPApr',
		'S05EmPAmr',
		'S05EmPCor',
		'S05FecTra',
		'S05FecMod',
	];

	protected $appends = ['EmPCod','EmPRut','EmPNom','EmPRSo','EmPVig','EmPNor','EmPApr','EmPAmr','EmPCor','FecTra','FecMod'];

	public function getEmPCodAttribute()
	{
		return $this->S05EmPCod;
	}

	public function getEmPRutAttribute()
	{
		return $this->S05EmPRut;
	}	

	public function getEmPNomAttribute()
	{
		return $this->S05EmPNom;
	}	

	public function getEmPRSoAttribute()
	{
		return $this->S05EmPRSo;
	}

	public function getEmPVigAttribute()
	{
		return $this->S05EmPVig;
	}

	public function getEmPNorAttribute()
	{
		return $this->S05EmPNor;
	}

	public function getEmPAprAttribute()
	{
		return $this->S05EmPApr;
	}

	public function getEmPAmrAttribute()
	{
		return $this->S05EmPAmr;
	}

	public function getEmPCorAttribute()
	{
		return $this->S05EmPCor;
	}

	public function getFecTraAttribute()
	{
		return $this->S05FecTra;
	}

	public function getFecModAttribute()
	{
		return $this->S05FecMod;
	}

}

