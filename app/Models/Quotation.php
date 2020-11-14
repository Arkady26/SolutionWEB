<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Mmb  {
	
	protected $table = 'quotation';
	protected $primaryKey = 'quotationID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT quotation.* FROM quotation";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE quotation.quotationID IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	 

}
