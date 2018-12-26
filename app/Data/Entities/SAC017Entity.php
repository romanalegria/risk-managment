<?php 
  namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;

class SAC005Entity extends Model
{
	protected $table = 'SAC017';
	protected $primaryKey = 'S017EmCCod';

	const CREATED_AT    =   'S017FecTra';
    const UPDATED_AT    =   'S017FecMod';

	protected $fillable = [
		'S017EmCCod',
		'S05EmPCod',
		'S017EmCRut',
		'S017EmCNom',
		'S017EmCRso',
		'S017EmPVig',
		'S017EmCTip',
		'S017EmCNam',
		'S017EmCCmu',
		'S017EmCTpr',
		'S017EmCFcr',
		'S017EmCTpa',
		'S017EmCFca',
		'S017EmCCmu',

	];

	protected $hidden = [
		'S017EmCCod',
		'S05EmPCod',
		'S017EmCRut',
		'S017EmCNom',
		'S017EmCRso',
		'S017EmPVig',
		'S017EmCTip',
		'S017EmCNam',
		'S017EmCCmu',
		'S017EmCTpr',
		'S017EmCFcr',
		'S017EmCTpa',
		'S017EmCFca',		
		'S017FecTra',
		'S017FecMod',
	];

	protected $appends = ['EmCCod','EmPCod','EmCRut','EmCNom','EmCRso','EmPVig','EmCTip','EmCNam','EmCCmu','EmCTpr','EmCFcr','EmCTpa','EmCFca','EmCFca','EmCCmu','FecTra','FecMod'];

	public function getEmCCodAttribute()
	{
		return $this->S017EmCCod;
	}

	public function getEmPCodAttribute()
	{
		return $this->S05EmPCod;
	}

	public function getEmCRutAttribute()
	{
		return $this->S017EmCRut;
	}

	public function getEmCNomAttribute()
	{
		return $this->S017EmCNom;
	}

	public function getEmCRsoAttribute()
	{
		return $this->S017EmCRso;
	}

	public function getEmPVigAttribute()
	{
		return $this->S017EmPVig;
	}		

	public function getEmCTipAttribute()
	{
		return $this->S017EmCTip;
	}		

	public function getEmCNamAttribute()
	{
		return $this->S017EmCNam;
	}	
		
	public function getEmCCmuAttribute()
	{
		return $this->S017EmCCmu;
	}	

	public function getEmCTprAttribute()
	{
		return $this->S017EmCTpr;
	}	
		
	public function getEmCFcrAttribute()
	{
		return $this->S017EmCFcr;
	}	
		
	public function getEmCTpaAttribute()
	{
		return $this->S017EmCTpa;
	}	
		
	public function getEmCFcaAttribute()
	{
		return $this->S017EmCFca;
	}		
	
	public function getEmCCmuAttribute()
	{
		return $this->S017EmCCmu;
	}	     
		
	public function getFecTraAttribute()
	{
		return $this->S017FecTra;
	}

	public function getFecModAttribute()
	{
		return $this->S17FecMod;
	}

	
}
