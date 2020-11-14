<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class grouptypes extends Mmb  {

	protected $table = 'group_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT group_types.* FROM group_types  ";
	}

	public static function queryWhere(  ){

		return "  WHERE group_types.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
