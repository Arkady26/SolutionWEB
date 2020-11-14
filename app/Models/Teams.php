<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Teams extends Mmb  {

	protected $table = 'teams';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT teams.* FROM teams  ";
	}

	public static function queryWhere(  ){

		return "  WHERE teams.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
