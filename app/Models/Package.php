<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Package extends Mmb  {

	protected $table = 'packages';
	protected $primaryKey = 'packageID';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT packages.* FROM packages  ";
	}

	public static function queryWhere(  ){

		return "  WHERE packages.packageID IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

}
