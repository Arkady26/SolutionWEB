<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



$active_multilang = defined('CNF_MULTILANG') ? CNF_LANG : 'en';
\App::setLocale($active_multilang);
if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

    $lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
    \App::setLocale($lang);
}

Route::get('/', 'HomeController@index');
AdvancedRoute::controller('home', 'HomeController');
AdvancedRoute::controller('blog', 'PostController');
AdvancedRoute::controller('post', 'PostController');

AdvancedRoute::controller('user', 'UserController');
Route::get('/user/login', 'UserController@getLogin')->name('user.login');
Route::post('/tickets/change_availableSeats/{id}', 'TicketsController@change_availableSeats')->name('TicketsController.change_availableSeats');
Route::get('/tickets/airlines_of_package', 'TicketsController@airlines_of_package')->name('airlines_of_package');
Route::get('/hotels/get_roomtypes_from_hotel/{id}', 'HotelsController@get_roomtypes_from_hotel')->name('get_roomtypes_from_hotel');
Route::get('/bookesign/update/', 'BookesignController@getUpdate');
Route::post('/bookesign/save/{id}', 'BookesignController@postsave');
Route::get('/bookteam/update/', 'BookteamController@getUpdate');
Route::post('/bookteam/save/{id}', 'BookteamController@postsave');
Route::get('/booktermsconditions/update/', 'BooktermsconditionsController@getUpdate');
Route::post('/booktermsconditions/save/{id}', 'BooktermsconditionsController@postsave');
Route::post('/invoice/product_from_bookingnsID', 'InvoiceController@product_from_bookingnsID');
Route::post('/quotation/product_from_bookingnsID', 'QuotationController@product_from_bookingnsID');
Route::post('/mmb/module/config/{id}', 'mmb\ModuleController@getConfig');

include('pageroutes.php');
include('moduleroutes.php');

Route::get('/restric',function(){

    return view('errors.blocked');

});

AdvancedRoute::controller('mmbapi', 'MmbapiController');
Route::group(['middleware' => 'auth'], function()
{

    Route::get('core/elfinder', 'Core\ElfinderController@getIndex');
    Route::post('core/elfinder', 'Core\ElfinderController@getIndex');
    AdvancedRoute::controller('/dashboard', 'DashboardController');

    AdvancedRoute::controllers([
        'core/users'		=> 'Core\UsersController',
        'notification'		=> 'NotificationController',
        'core/logs'			=> 'Core\LogsController',
        'core/pages' 		=> 'Core\PagesController',
        'core/groups' 		=> 'Core\GroupsController',
        'core/template' 	=> 'Core\TemplateController',
        'core/posts'		=> 'Core\PostsController',
        'core/forms'		=> 'Core\FormsController'
    ]);

});

Route::group(['middleware' => 'auth' , 'middleware'=>'mmbauth'], function()
{

    AdvancedRoute::controllers([
        'core/menu'		    => 'Mmb\MenuController',
        'core/config' 		=> 'Mmb\ConfigController',
        'mmb/module' 		=> 'Mmb\ModuleController',
        'core/tables'		=> 'Mmb\TablesController',
        'core/code'		    => 'Mmb\CodeController',
        'core/rac'			=> 'Mmb\RacController'
    ]);


});
