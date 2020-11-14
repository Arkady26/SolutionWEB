<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Quotation;
use App\Models\Bookings;
use App\Models\Booktour;
use App\Models\Roomfeature;
use App\Models\Package;
use App\Models\Tours;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\App;
use Validator, Input, Redirect ;

class QuotationController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'quotation';
	static $per_page	= '100000';

	public function __construct()
	{

		$this->model = new Quotation();

		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'quotation',
			'return'	=> self::returnUrl()

		);

		\App::setLocale(CNF_LANG);
		if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

		$lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
		\App::setLocale($lang);
		}



	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'quotationID');
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query
		// Filter Search for query
		$filter = '';
		if(!is_null($request->input('search')))
		{
			$search = 	$this->buildSearch('maps');
			$filter = $search['param'];
			$this->data['search_map'] = $search['maps'];
		}


		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query
		$results = $this->model->getRows( $params );

		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
		$pagination->setPath('quotation');

		$this->data['rowData']		= $results['rows'];
		// Build Pagination
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();
		// Row grid Number
		$this->data['i']			= ($page * $params['limit'])- $params['limit'];
		// Grid Configuration
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \App\Library\SiteHelpers::viewColSpan($this->info['config']['grid']);
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		$this->data['fields'] =  \App\Library\AjaxHelpers::fieldLang($this->info['config']['grid']);
		// Master detail link if any
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
		// Render into template
// var_dump($this->data);exit;

		return view('quotation.index',$this->data);
	}



	function getUpdate(Request $request, $id = null)
	{

		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('quotation');
		}
		$this->data['fields'] =  \App\Library\AjaxHelpers::fieldLang($this->info['config']['forms']);

        $this->data['items'] = \DB::table('quotation_products')->where('InvID', $this->data['row']['quotationID'])->get();

		$this->data['id'] = $id;
		return view('quotation.form',$this->data);
	}

	public function getShow( Request $request, $id = null)
	{

		if($this->access['is_detail'] ==0)
		return Redirect::to('dashboard')
			->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['fields'] 		=  \App\Library\SiteHelpers::fieldLang($this->info['config']['grid']);
			$this->data['id'] = $id;
			$this->data['access']		= $this->access;
			$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
			$this->data['fields'] =  \App\Library\AjaxHelpers::fieldLang($this->info['config']['grid']);
            $this->data['items']		= \DB::table('quotation_products')->where('InvID', $id)->get();
			$this->data['prevnext'] = $this->model->prevNext($id);

             if(!is_null($request->input('pdf')))
			{
				$html = view('quotation.pdf', $this->data)->render();
				// return \PDF::loadHtml($html)->save('Quotation-'.$id.'.pdf')->output();
				$pdf = App::make('dompdf.wrapper');
				$pdf->loadHTML($html);
				return $pdf->stream();
			}

			return view('quotation.view',$this->data);
		} else {
			return Redirect::to('quotation')->with('messagetext',\Lang::get('core.norecord'))->with('msgstatus','error');
		}
	}

	function postCopy( Request $request)
	{
	    foreach(\DB::select("SHOW COLUMNS FROM quotation ") as $column)
        {
			if( $column->Field != 'quotationID')
				$columns[] = $column->Field;
        }

		if(count($request->input('ids')) >=1)
		{
			$toCopy = implode(",",$request->input('ids'));
			$sql = "INSERT INTO quotation (".implode(",", $columns).") ";
			$sql .= " SELECT ".implode(",", $columns)." FROM quotation WHERE quotationID IN (".$toCopy.")";
			\DB::insert($sql);
			return Redirect::to('quotation')->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
		} else {

			return Redirect::to('quotation')->with('messagetext',\Lang::get('core.note_selectrow'))->with('msgstatus','error');
		}

	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost('tb_quotation');
			$data["payment_type"] = "";

			$id = $this->model->insertRow($data , $request->input('quotationID'));
            			// Subt Item Save
			if(isset($_POST['Items']))
			{

				\DB::table('quotation_products')->where('InvID', $id)->delete();
				$Items = $_POST['Items'] ;
				for($i=0; $i < count($Items); $i++)
				{
					$dataItems = array(
						'Code' 	    => $_POST['Code'][$i],
						'Items' 	=> $_POST['Items'][$i],
						'Qty' 		=> $_POST['Qty'][$i],
						'Amount' 	=> $_POST['Amount'][$i],
						'InvID'		=> $id
					);

					\DB::table('quotation_products')->insert($dataItems);
				}
			}


			if(!is_null($request->input('apply')))
			{
				$return = 'quotation/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'quotation?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('quotationID') =='')
			{
				\App\Library\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\App\Library\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}



			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');

		} else {

			return Redirect::to('quotation/update/'. $request->input('quotationID'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}

	}

	public function postDelete( Request $request)
	{

		if($this->access['is_remove'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows
		if(count($request->input('ids')) >=1)
		{
			$this->model->destroy($request->input('ids'));
            \DB::table('quotation_products')->whereIn('InvID', $request->input('ids'))->delete();


			\App\Library\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfully");
			// redirect
			return Redirect::to('quotation')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('quotation')
        		->with('messagetext',\Lang::get('core.note_noitemdeleted'))->with('msgstatus','error');
		}

	}

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Quotation();
		$info = $model::makeInfo('quotation');

		$data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note']

		);

		if($mode == 'view')
		{
			$id = $_GET['view'];
			$row = $model::getRow($id);
			if($row)
			{
				$data['row'] =  $row;
				$data['fields'] 		=  \App\Library\SiteHelpers::fieldLang($info['config']['grid']);
				$data['id'] = $id;
				return view('quotation.public.view',$data);
			}

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'quotationID' ,
				'order'		=> 'asc',
				'params'	=> '',
				'global'	=> 1
			);

			$result = $model::getRows( $params );
			$data['tableGrid'] 	= $info['config']['grid'];
			$data['rowData'] 	= $result['rows'];

			$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
			$pagination = new Paginator($result['rows'], $result['total'], $params['limit']);
			$pagination->setPath('');
			$data['i']			= ($page * $params['limit'])- $params['limit'];
			$data['pagination'] = $pagination;
			return view('quotation.public.index',$data);
		}


	}

	function postSavepublic( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost('quotation');
			 $this->model->insertRow($data , $request->input('quotationID'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}

	}

	function product_from_bookingnsID(Request $request){
		$bookingsID = $request->input("bookingsID");
		$booking = Bookings::find($bookingsID);
		$product = array();
		$product['productcode'] = $booking->bookingno;
		$booktour = Booktour::where("bookingID", $bookingsID)->first();

		if($booktour!=null){
			if($booktour->formula==1){
				$package = Package::find($booktour->packageID);
				$product['itemname'] = $package->tour_code;
				$roomfeatures = Roomfeature::where('packageID', $booktour->packageID)->get();
				$product['amount'] = 0;

				foreach ($roomfeatures as $roomfeature) {
					$product['amount'] += $roomfeature->cost;
				}
				$product['currencyID'] = $package->currencyID;
			}
			else{
				$tour = Tours::find($booktour->tourID);
				$product['itemname'] = $tour->tour_name;
				$product['amount'] = $tour->cost;
				$product['currencyID'] = $tour->currencyID;
			}
		}
		return response()->json(array(
			'status'=>'success',
			'product'=> $product,
		));
	}


}
