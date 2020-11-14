<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Mmb  {

	protected $table = 'add_on';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'description', 'status'];
	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT add_on.* FROM add_on  ";
	}

	public static function queryWhere(  ){

		return "  WHERE add_on.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
