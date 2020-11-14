<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Part extends Mmb  {

	protected $table = 'parts';
	protected $primaryKey = 'partID';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT parts.* FROM parts  ";
	}

	public static function queryWhere(  ){

		return "  WHERE parts.partID IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
