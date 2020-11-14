<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Roomfeature extends Mmb  {

	protected $table = 'room_features';
	protected $primaryKey = 'roomfeatureID';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT room_features.* FROM room_features  ";
	}

	public static function queryWhere(  ){

		return "  WHERE room_features.roomfeatureID IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

}
