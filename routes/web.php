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
Auth::routes();

/*
|--------------------------------------------------------------------------
| Route Untuk Umum
|--------------------------------------------------------------------------
*/
Route::get('/','HomeController@index');
Route::get('/contact', 'HomeController@contact');
Route::get('/landing', 'HomeController@landing');

Route::group(['middleware'=>['auth']], function() {

	Route::get('/home', 'HomeController@index')->name('home');



	# ====================
	#     GETSERVICE
	# ====================
	Route::prefix('getservice')->group(function() {
		Route::get('/bulkfollows', 'GetserviceController@bulkfollows');
		Route::get('/irvankede', 'GetserviceController@irvankede');
		Route::get('/gatenz', 'GetserviceController@gatenz');
		Route::get('/smmindo', 'GetserviceController@smmindo');
		Route::get('/get_portal', 'GetserviceController@portalpulsa');
		Route::get('/get_portal_pln', 'GetserviceController@portalpulsa_pln');
		Route::get('/get_portal/category', 'GetserviceController@portalpulsa_cat');
	});


	# ====================
	#     OTHERS MENU
	# ====================
	Route::get('/hall_of_fame', 'HomeController@hof')->name('hof');
	Route::get('/contact', 'HomeController@contact');
	Route::get('/activity', 'HomeController@activity');
	Route::get('/balance_usage', 'HomeController@balance_usage');

	Route::get('/news', 'HomeController@news');
	Route::get('/contact', 'HomeController@contact');
	Route::get('/voucher', 'HomeController@voucher');
	Route::post('/voucher', 'HomeController@voucher_post');
	Route::post('/logout', 'Auth\LoginController@logout');

	# ====================
	#     	  OVO
	# ====================
	Route::prefix('ovo')->group(function() {
		Route::get('login/{nohp}', 'OVOController@login');
		Route::get('checkBalance/', 'OVOController@balance');
	});

	# ====================
	#     ORDER MENU
	# ====================
	Route::prefix('order')->group(function() {
		Route::prefix('sosmed')->group(function(){
			Route::get('/',"OrderController@sosmed")->name('order_sosmed');
			Route::post('/',"OrderController@sosmed_post")->name('order_sosmed_post');
			Route::get('/mass',"OrderController@sosmed_mass")->name('order_sosmed_mass');
			Route::post('/mass',"OrderController@sosmed_mass_post")->name('order_sosmed_mass_post');
			Route::get('/terms_of_service', 'OrderController@tos')->name('sosmed_tos');
			Route::get("/history", "OrderController@sosmed_history")->name('sosmed_history');	
			Route::get("/statistic", "OrderController@sosmed_statistic")->name('sosmed_statistic');	
			Route::get("/invoice/{id}", "OrderController@invoice")->name('sosmed_invoice');	
		
			Route::group(['prefix'=>'ajax', 'middleware'=>['auth','AjaxMiddleware']], function(){
				Route::post('/get_service', 'OrderController@get_service');
				Route::post('/get_service_data', 'OrderController@get_service_data');
				Route::post('/get_price', 'OrderController@get_price');
				Route::post('/check_sosmed', 'OrderController@check_sosmed');

				Route::get('/get_service', 'HomeController@returnHome');
				Route::get('/get_service_data', 'HomeController@returnHome');
				Route::get('/get_price', 'HomeController@returnHome');
				Route::get('/check_sosmed', 'HomeController@returnHome');
			});

		});


		Route::prefix('pulsa')->group(function() {
			Route::get('/','OrderController@pulsa')->name('order_pulsa');
			Route::post('/','OrderController@pulsa_order')->name('post_pulsa');
			Route::get('/history','OrderController@pulsa_history')->name('order_pulsa_history');
			Route::get('/statistic','OrderController@pulsa_statistic')->name('pulsa_statistic');

			Route::prefix('/ajax')->group(function(){
				Route::post('/get_service_pulsa','OrderController@get_service_pulsa');
				Route::post('/get_type_pulsa','OrderController@get_type_pulsa');
				Route::post('/get_price_pulsa','OrderController@get_price_pulsa');

				Route::get('/get_service_pulsa','HomeController@returnHome');
				Route::get('/get_type_pulsa','HomeController@returnHome');
				Route::get('/get_price_pulsa','HomeController@returnHome');
			});

		});

	});


	# ====================
	#     DEPOSIT MENU
	# ====================
	Route::prefix('/deposit')->group(function() {
		Route::get('/','DepositController@index');
		Route::get('/new','DepositController@deposit');
		Route::post('/new','DepositController@deposit_add');
		Route::get('/history','DepositController@history');
		Route::delete('/history', 'DepositController@cancel_deposit');


		Route::post('get_method','DepositController@get_method');
		Route::post('get_rate','DepositController@get_rate');
		Route::get('get_method','HomeController@returnHome');
		Route::get('get_rate','HomeController@returnHome');
	});


	Route::prefix('/ticket')->group(function() {
		Route::get('/','TicketController@index');
		Route::get('/add','TicketController@add_view');
		Route::post('/add','TicketController@add');
		Route::get('/{id}','TicketController@detail');
		Route::post('/{id}','TicketController@detail_add');
	});



	Route::prefix('users')->group(function() {
		Route::get('/','UsersController@index');
		Route::get('/settings','UsersController@setting');
		Route::post('/settings','UsersController@update');
	});


});

Route::prefix('/price')->group(function(){
	Route::get('/sosmed', 'PriceController@sosmed');
	Route::post('/sosmed/detail', 'PriceController@detail_ajax')->middleware('AjaxMiddleware');
	Route::get('/pulsa', 'PriceController@pulsa');
});


Route::group(['prefix'=>'staff', 'middleware'=>['auth','ExceptMember']], function() {
	Route::get('/voucher',"StaffController@voucher");
	Route::post('/voucher',"StaffController@voucher_post");
	Route::delete('/voucher',"StaffController@voucher_delete");
	Route::get('/add_user',"StaffController@add_user");
	Route::post('/add_user',"StaffController@add_user_post");
});



Route::group(['prefix'=>'developer', 'middleware'=>['auth','Developer'] ],function() {
	Route::get('/','AdminController@index');
	Route::get('/report', 'AdminController@report');
	Route::get('/activity', 'AdminController@activity');


	Route::prefix('/configuration')->group(function() {
		Route::get('/', 'Admin\OthersController@configuration');
		Route::put('/', 'Admin\OthersController@configuration_update');
	});


	Route::prefix('/invitation_code')->group(function() {
	
		Route::get('/','Admin\InvitecodeController@invitation_code');
		Route::post('/', 'Admin\InvitecodeController@invitation_code_add');
		Route::post('/random', 'Admin\InvitecodeController@invitation_code_add_random');
		Route::delete('/','Admin\InvitecodeController@invitation_code_delete');
	
	});


	Route::prefix('custom_price')->group(function() {
	
		Route::get('/','Admin\OthersController@custom_price');
		Route::post('/','Admin\OthersController@custom_price_post');
		Route::delete('/','Admin\OthersController@custom_price_delete');
	
	});


	Route::prefix('/services')->group(function(){
		Route::get('/', 'Admin\ServiceSosmedController@services')->name('dev_services');
		Route::delete('/', 'Admin\ServiceSosmedController@delete_services');
		Route::get('/detail/{id}', 'Admin\ServiceSosmedController@detail_services')->name('dev_services_detail');
		Route::get('/add', 'Admin\ServiceSosmedController@add_services')->name('dev_services_add');
		Route::post('/add', 'Admin\ServiceSosmedController@post_add_services')->name('dev_services_add_post');
		Route::get('/edit/{id}', 'Admin\ServiceSosmedController@edit_services')->name('dev_services_edit');
		Route::post('/edit/{id}', 'Admin\ServiceSosmedController@update_services')->name('dev_services_update');
	});

	Route::prefix('/services_pulsa')->group(function(){
		Route::get('/', 'Admin\ServicePulsaController@services_pulsa')->name('dev_services_pulsa');
		Route::delete('/', 'Admin\ServicePulsaController@delete_services_pulsa');
		Route::get('/detail/{id}', 'Admin\ServicePulsaController@detail_services_pulsa');
		Route::get('/add', 'Admin\ServicePulsaController@services_pulsa_add');
		Route::post('/add', 'Admin\ServicePulsaController@post_add_services_pulsa');
		Route::get('/edit/{id}', 'Admin\ServicePulsaController@edit_services_pulsa');
		Route::post('/edit/{id}', 'Admin\ServicePulsaController@update_services_pulsa');
	});

	Route::prefix('/services_cat')->group(function(){
		Route::get('/', 'Admin\ServiceCatController@service_cat')->name('services_cat');
		Route::get('/add', 'Admin\ServiceCatController@add_service_cat')->name('dev_services_add');
		Route::post('/add', 'Admin\ServiceCatController@post_add_service_cat')->name('dev_services_add_post');
		Route::delete('/', 'Admin\ServiceCatController@delete_service_cat')->name('dev_services_delete');
		Route::get('/edit/{id}', 'Admin\ServiceCatController@edit_service_cat')->name('dev_services_edit');
		Route::post('/edit/{id}', 'Admin\ServiceCatController@update_service_cat')->name('dev_services_update');

		Route::prefix('pulsa')->group(function() {
				Route::get('/', 'Admin\ServiceCatPulsaController@service_cat_pulsa')->name('services_cat_pulsa');
				Route::get('/add','Admin\ServiceCatPulsaController@add_services_cat_pulsa')->name('services_cat_pulsa_add');
				Route::post('/add','Admin\ServiceCatPulsaController@services_cat_pulsa_add_post')->name('services_cat_pulsa_add_post');
				Route::get('/edit/{id}', 'Admin\ServiceCatPulsaController@service_cat_pulsa_edit')->name('services_cat_pulsa_edit');
				Route::put('/edit/{id}', 'Admin\ServiceCatPulsaController@service_cat_pulsa_update')->name('services_cat_pulsa_update');
				Route::delete('/','Admin\ServiceCatPulsaController@service_cat_pulsa_delete');
				Route::delete('/oprator','Admin\ServiceCatPulsaController@service_cat_oprator_delete');



				Route::get('add_operator', 'Admin\ServiceCatPulsaController@operator_add');
				Route::post('add_operator', 'Admin\ServiceCatPulsaController@operator_add_post');
				Route::get('edit_operator/{id}','Admin\ServiceCatPulsaController@operator_edit');
				Route::put('edit_operator/{id}','Admin\ServiceCatPulsaController@operator_update');
				Route::delete('/operator_delete','Admin\ServiceCatPulsaController@operator_delete');
		});

	});


	Route::prefix('/orders')->group(function(){

		# MANAGE ORDERS SOSMED #
		Route::prefix('/sosmed')->group(function(){
			Route::get('/','Admin\OrderSosmedController@manage_orders_sosmed');
			Route::get('/edit/{id}','Admin\OrderSosmedController@edit_orders_sosmed');
			Route::post('/edit/{id}','Admin\OrderSosmedController@update_orders_sosmed');
		});


		# MANAGE ORDERS PULSA #
		Route::prefix('/pulsa')->group(function(){
			Route::get('/', 'Admin\OrderPulsaController@manage_orders_pulsa');
			Route::get('/edit/{id}', 'Admin\OrderPulsaController@edit_orders_pulsa');
			Route::post('/edit/{id}', 'Admin\OrderPulsaController@update_orders_pulsa');
		});


	});


	Route::prefix('/users')->group(function(){
		Route::get('/','Admin\UsersController@manage_users');
		Route::delete('/','Admin\UsersController@delete_users');
		Route::get('/add','Admin\UsersController@add_users');
		Route::post('/add','Admin\UsersController@add_users_post');
		Route::get('/edit/{id}','Admin\UsersController@edit_users');
		Route::post('/edit/{id}','Admin\UsersController@update_users');
		Route::get('/detail/{id}', 'Admin\UsersController@users_detail');
	});


	Route::prefix('/deposit')->group(function(){
		Route::get('/','Admin\DepositController@manage_deposit');	
		Route::post('/accept','Admin\DepositController@accept_deposit');	
		Route::post('/decline','Admin\DepositController@decline_deposit');

		Route::prefix('/method')->group(function(){
			Route::get('/','Admin\DepositMethodController@deposit_method');
			Route::get('/add','Admin\DepositMethodController@add_deposit_method');
			Route::post('/add', 'Admin\DepositMethodController@post_deposit_method');
			Route::get('/edit/{id}', 'Admin\DepositMethodController@edit_deposit_method');
			Route::put('/edit/{id}', 'Admin\DepositMethodController@update_deposit_method');
			Route::delete('/','Admin\DepositMethodController@delete_deposit_method');
		});

	});

	Route::prefix('providers')->group(function(){
		Route::get('/','ProviderController@index');
		Route::get('/add','ProviderController@add');
		Route::post('/add','ProviderController@add_post');
		Route::get('/edit/{id}','ProviderController@edit');
		Route::post('/edit/{id}','ProviderController@update');
		Route::delete('/','ProviderController@delete');
	});

	Route::prefix('/news')->group(function(){
		Route::get('/','Admin\NewsController@manage_news');
		Route::get('/add','Admin\NewsController@add_news');
		Route::post('/add','Admin\NewsController@add_news_post');
		Route::get('/edit/{id}','Admin\NewsController@edit_news');
		Route::post('/edit/{id}','Admin\NewsController@update_news');
		Route::delete('/','Admin\NewsController@delete_news');
	});



	Route::prefix('/ticket')->group(function() {
		Route::get('/','Admin\TicketController@ticket_index');
		Route::post('/','Admin\TicketController@ticket_close');
		Route::get('/{id}','Admin\TicketController@ticket_detail');
		Route::post('/{id}','Admin\TicketController@ticket_detail_add');
	});


	Route::prefix('staff')->group(function() {
		Route::get('/', 'Admin\StaffController@staff');
		Route::get('/add', 'Admin\StaffController@add_staff');
		Route::post('/add', 'Admin\StaffController@add_staff_post');
		Route::get('/edit/{id}', 'Admin\StaffController@edit_staff');
		Route::put('/edit/{id}', 'Admin\StaffController@update_staff');
		Route::delete('/','Admin\StaffController@delete_staff');
	});

	
});



Route::middleware('auth','AjaxMiddleware')->group(function() {
	Route::post('read_news', 'HomeController@read_news');
});


Route::prefix('api')->group(function(){
	Route::get('/sosmed', function() {
		return response()->json(['error'=>'Incorrect Request']);
	});

	Route::post('/sosmed', 'APIController@sosmed')->name('api_sosmed');
	Route::get('/sosmed/doc', 'APIController@sosmed_doc');
	Route::post('/pulsa', 'APIController@pulsa')->name('api_pulsa');
	Route::get('/pulsa', function() {
		return response()->json(['error'=>'Incorrect Request']);
	});

	Route::get('/pulsa/doc', 'APIController@pulsa_doc');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', function(){
	return redirect('/');
});
