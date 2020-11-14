<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class expenses extends Mmb  {

	protected $table = 'def_expenses';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT def_expenses.* FROM def_expenses  ";
	}

	public static function queryWhere(  ){

		return "  WHERE def_expenses.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
