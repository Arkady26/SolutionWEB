<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Tourfeature extends Mmb  {

	protected $table = 'tour_features';
	protected $primaryKey = 'tour_feature_id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){
		return "  SELECT tour_features.* FROM tour_features";
	}

	public static function queryWhere(  ){
		return "  WHERE tour_features.tour_features_id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
