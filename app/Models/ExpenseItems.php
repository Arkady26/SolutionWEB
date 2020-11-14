<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class expenseitems extends Mmb  {

	protected $table = 'def_expense_items';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'description', 'status'];
	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT def_expense_items.* FROM def_expense_items  ";
	}

	public static function queryWhere(  ){

		return "  WHERE def_expense_items.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
