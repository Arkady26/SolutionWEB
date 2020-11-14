<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class teamtypes extends Mmb  {

	protected $table = 'team_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT team_types.* FROM team_types  ";
	}

	public static function queryWhere(  ){

		return "  WHERE team_types.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
