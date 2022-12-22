<?php

use App\Http\Controllers\BankPaymentController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\GetserviceController;
use App\Http\Controllers\OVOController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Route::get("/",[HomeController::class,"index"]);
Route::get("/contact", [HomeController::class,"contact"]);
Route::get("/landing", [HomeController::class,"landing"]);
Route::get("/check-deposit-bank", [BankPaymentController::class,"cron"]); 
Route::post("/check-envaya", [Admin\OthersController::class,"envaya"]); 

Route::group(["middleware"=>["auth"]], function() {

	Route::get("/home", [HomeController::class,"index"])->name("home");

	# ====================
	#     GETSERVICE
	# ====================
	Route::prefix("getservice")->group(function() {
		Route::get("/bulkfollows", [GetserviceController::class,"bulkfollows"]);
		Route::get("/irvankede", [GetserviceController::class,"irvankede"]);
		Route::get("/gatenz", [GetserviceController::class,"gatenz"]);
		Route::get("/smmindo", [GetserviceController::class,"smmindo"]);
		Route::get("/get_portal", [GetserviceController::class,"portalpulsa"]);
		Route::get("/get_portal_pln", [GetserviceController::class,"portalpulsa_pln"]);
		Route::get("/get_portal/category", [GetserviceController::class,"portalpulsa_cat"]);
	});


	# ====================
	#     OTHERS MENU
	# ====================
	Route::get("/hall_of_fame", [HomeController::class,"hof"])->name("hof");
	Route::get("/contact", [HomeController::class,"contact"]);
	Route::get("/activity", [HomeController::class,"activity"]);
	Route::get("/balance_usage", [HomeController::class,"balance_usage"]);

	Route::get("/news", [HomeController::class,"news"]);
	Route::get("/contact", [HomeController::class,"contact"]);
	Route::get("/voucher", [HomeController::class,"voucher"]);
	Route::post("/voucher", [HomeController::class,"voucher_post"]);

	# ====================
	#     ORDER MENU
	# ====================
	Route::prefix("order")->group(function() {
		Route::prefix("sosmed")->group(function(){
			Route::get("/",[OrderController::class,"sosmed"])->name("order_sosmed");
			Route::post("/",[OrderController::class,"sosmed_post"])->name("order_sosmed_post");
			Route::get("/mass",[OrderController::class,"sosmed_mass"])->name("order_sosmed_mass");
			Route::post("/mass",[OrderController::class,"sosmed_mass_post"])->name("order_sosmed_mass_post");
			Route::get("/terms_of_service", [OrderController::class,"tos"])->name("sosmed_tos");
			Route::get("/history", [OrderController::class,"sosmed_history"])->name("sosmed_history");	
			Route::get("/statistic", [OrderController::class,"sosmed_statistic"])->name("sosmed_statistic");	
			Route::get("/invoice/{id}", [OrderController::class,"invoice"])->name("sosmed_invoice");	
		
			Route::group(["prefix"=>"ajax", "middleware"=>["auth","AjaxMiddleware"]], function(){
				Route::post("/get_service", [OrderController::class,"get_service"]);
				Route::post("/get_service_data", [OrderController::class,"get_service_data"]);
				Route::post("/get_price", [OrderController::class,"get_price"]);
				Route::post("/check_sosmed", [OrderController::class,"check_sosmed"]);

				Route::get("/get_service", [HomeController::class,"returnHome"]);
				Route::get("/get_service_data", [HomeController::class,"returnHome"]);
				Route::get("/get_price", [HomeController::class,"returnHome"]);
				Route::get("/check_sosmed", [HomeController::class,"returnHome"]);
			});

		});


		Route::prefix("pulsa")->group(function() {
			Route::get("/",[OrderController::class,"pulsa"])->name("order_pulsa");
			Route::post("/",[OrderController::class,"pulsa_order"])->name("post_pulsa");
			Route::get("/history",[OrderController::class,"pulsa_history"])->name("order_pulsa_history");
			Route::get("/statistic",[OrderController::class,"pulsa_statistic"])->name("pulsa_statistic");

			Route::prefix("/ajax")->group(function(){
				Route::post("/get_service_pulsa",[OrderController::class,"get_service_pulsa"]);
				Route::post("/get_type_pulsa",[OrderController::class,"get_type_pulsa"]);
				Route::post("/get_price_pulsa",[OrderController::class,"get_price_pulsa"]);

				Route::get("/get_service_pulsa",[HomeController::class,"returnHome"]);
				Route::get("/get_type_pulsa",[HomeController::class,"returnHome"]);
				Route::get("/get_price_pulsa",[HomeController::class,"returnHome"]);
			});

		});

	});


	# ====================
	#     DEPOSIT MENU
	# ====================
	Route::prefix("/deposit")->group(function() {
		Route::get("/",[DepositController::class,"index"]);
		Route::get("/new",[DepositController::class,"deposit"]);
		Route::post("/new",[DepositController::class,"deposit_add"]);
		Route::get("/history",[DepositController::class,"history"]);
		Route::delete("/history", [DepositController::class,"cancel_deposit"]);


		Route::post("get_method",[DepositController::class,"get_method"]);
		Route::post("get_rate",[DepositController::class,"get_rate"]);
		Route::get("get_method",[HomeController::class,"returnHome"]);
		Route::get("get_rate",[HomeController::class,"returnHome"]);
	});


	Route::prefix("/ticket")->group(function() {
		Route::get("/",[TicketController::class,"index"]);
		Route::get("/add",[TicketController::class,"add_view"]);
		Route::post("/add",[TicketController::class,"add"]);
		Route::get("/{id}",[TicketController::class,"detail"]);
		Route::post("/{id}",[TicketController::class,"detail_add"]);
	});



	Route::prefix("users")->group(function() {
		Route::get("/",[UsersController::class,"index"]);
		Route::get("/settings",[UsersController::class,"setting"]);
		Route::post("/settings",[UsersController::class,"update"]);
	});


});

Route::prefix("/price")->group(function(){
	Route::get("/sosmed", [PriceController::class,"sosmed"]);
	Route::post("/sosmed/detail", [PriceController::class,"detail_ajax"])->middleware("AjaxMiddleware");
	Route::get("/pulsa", [PriceController::class,"pulsa"]);
});


Route::group(["prefix"=>"staff", "middleware"=>["auth","ExceptMember"]], function() {
	Route::get("/voucher",[StaffController::class,"voucher"]);
	Route::post("/voucher",[StaffController::class,"voucher_post"]);
	Route::delete("/voucher",[StaffController::class,"voucher_delete"]);
	Route::get("/add_user",[StaffController::class,"add_user"]);
	Route::post("/add_user",[StaffController::class,"add_user_post"]);


	Route::middleware("AdminMiddleware")->group(function() {

		Route::prefix("/orders")->group(function(){

			# MANAGE ORDERS SOSMED #
			Route::prefix("/sosmed")->group(function(){
				Route::get("/",[Admin\OrderSosmedController::class,"manage_orders_sosmed"]);
				Route::get("/edit/{id}",[Admin\OrderSosmedController::class, "edit_orders_sosmed"]);
				Route::post("/edit/{id}",[Admin\OrderSosmedController::class, "update_orders_sosmed"]);
			});

			# MANAGE ORDERS PULSA #
			Route::prefix("/pulsa")->group(function(){
				Route::get("/", [Admin\OrderPulsaController::class, "manage_orders_pulsa"]);
				Route::get("/edit/{id}", [Admin\OrderPulsaController::class, "edit_orders_pulsa"]);
				Route::post("/edit/{id}", [Admin\OrderPulsaController::class, "update_orders_pulsa"]);
			});
		});
		Route::prefix("/deposit")->group(function(){
			Route::get("/",[Admin\DepositController::class, "manage_deposit"]);	
			Route::post("/accept",[Admin\DepositController::class, "accept_deposit"]);	
			Route::post("/decline",[Admin\DepositController::class, "decline_deposit"]);
		});
		Route::prefix("/ticket")->group(function() {
			Route::get("/",[Admin\TicketController::class, "ticket_index"]);
			Route::post("/",[Admin\TicketController::class, "ticket_close"]);
			Route::get("/{id}",[Admin\TicketController::class, "ticket_detail"]);
			Route::post("/{id}",[Admin\TicketController::class, "ticket_detail_add"]);
		});
	});

});



Route::group(["prefix"=>"developer", "middleware"=>["auth","Developer"] ],function() {
	Route::get("/",[AdminController::class, "index"]);
	Route::get("/report", [AdminController::class, "report"]);
	Route::get("/activity", [AdminController::class, "activity"]);

	// Route::prefix("ovo")->group(function() {
	// 	Route::get("login",[OVOController::class, "login"])->name("ovo_login");
	// 	Route::post("login",[OVOController::class, "login_post"]);
	// 	Route::get("verify",[OVOController::class, "verify"])->name("ovo_verify");
	// 	Route::post("verify",[OVOController::class, "verify_post"]);
	// 	Route::get("security_code",[OVOController::class, "security_code"])->name("ovo_security_code");
	// 	Route::post("security_code",[OVOController::class, "security_code_post"]);
	// });


	Route::prefix("/configuration")->group(function() {
		Route::get("/", [Admin\OthersController::class, "configuration"]);
		Route::put("/", [Admin\OthersController::class, "configuration_update"]);
	});


	Route::prefix("/invitation_code")->group(function() {
	
		Route::get("/",[Admin\InvitecodeController::class, "invitation_code"]);
		Route::post("/", [Admin\InvitecodeController::class, "invitation_code_add"]);
		Route::post("/random", [Admin\InvitecodeController::class, "invitation_code_add_random"]);
		Route::delete("/",[Admin\InvitecodeController::class, "invitation_code_delete"]);
	
	});


	Route::prefix("custom_price")->group(function() {
	
		Route::get("/",[Admin\OthersController::class, "custom_price"]);
		Route::post("/",[Admin\OthersController::class, "custom_price_post"]);
		Route::delete("/",[Admin\OthersController::class, "custom_price_delete"]);
	
	});


	Route::prefix("/services")->group(function(){
		Route::get("/", [Admin\ServiceSosmedController::class, "services"])->name("dev_services");
		Route::delete("/", [Admin\ServiceSosmedController::class, "delete_services"]);
		Route::get("/detail/{id}", [Admin\ServiceSosmedController::class, "detail_services"])->name("dev_services_detail");
		Route::get("/add", [Admin\ServiceSosmedController::class, "add_services"])->name("dev_services_add");
		Route::post("/add", [Admin\ServiceSosmedController::class, "post_add_services"])->name("dev_services_add_post");
		Route::get("/edit/{id}", [Admin\ServiceSosmedController::class, "edit_services"])->name("dev_services_edit");
		Route::post("/edit/{id}", [Admin\ServiceSosmedController::class, "update_services"])->name("dev_services_update");
	});

	Route::prefix("/services_pulsa")->group(function(){
		Route::get("/", [Admin\ServicePulsaController::class, "services_pulsa"])->name("dev_services_pulsa");
		Route::delete("/", [Admin\ServicePulsaController::class, "delete_services_pulsa"]);
		Route::get("/detail/{id}", [Admin\ServicePulsaController::class, "detail_services_pulsa"]);
		Route::get("/add", [Admin\ServicePulsaController::class, "services_pulsa_add"]);
		Route::post("/add", [Admin\ServicePulsaController::class, "post_add_services_pulsa"]);
		Route::get("/edit/{id}", [Admin\ServicePulsaController::class, "edit_services_pulsa"]);
		Route::post("/edit/{id}", [Admin\ServicePulsaController::class, "update_services_pulsa"]);
	});

	Route::prefix("/services_cat")->group(function(){
		Route::get("/", [Admin\ServiceCatController::class, "service_cat"])->name("services_cat");
		Route::get("/add", [Admin\ServiceCatController::class, "add_service_cat"])->name("dev_services_add");
		Route::post("/add", [Admin\ServiceCatController::class, "post_add_service_cat"])->name("dev_services_add_post");
		Route::delete("/", [Admin\ServiceCatController::class, "delete_service_cat"])->name("dev_services_delete");
		Route::get("/edit/{id}", [Admin\ServiceCatController::class, "edit_service_cat"])->name("dev_services_edit");
		Route::post("/edit/{id}", [Admin\ServiceCatController::class, "update_service_cat"])->name("dev_services_update");

		Route::prefix("pulsa")->group(function() {
				Route::get("/", [Admin\ServiceCatPulsaController::class, "service_cat_pulsa"])->name("services_cat_pulsa");
				Route::get("/add",[Admin\ServiceCatPulsaController::class, "add_services_cat_pulsa"])->name("services_cat_pulsa_add");
				Route::post("/add",[Admin\ServiceCatPulsaController::class, "services_cat_pulsa_add_post"])->name("services_cat_pulsa_add_post");
				Route::get("/edit/{id}", [Admin\ServiceCatPulsaController::class, "service_cat_pulsa_edit"])->name("services_cat_pulsa_edit");
				Route::put("/edit/{id}", [Admin\ServiceCatPulsaController::class, "service_cat_pulsa_update"])->name("services_cat_pulsa_update");
				Route::delete("/",[Admin\ServiceCatPulsaController::class, "service_cat_pulsa_delete"]);
				Route::delete("/oprator",[Admin\ServiceCatPulsaController::class, "service_cat_oprator_delete"]);

				Route::get("add_operator", [Admin\ServiceCatPulsaController::class, "operator_add"]);
				Route::post("add_operator", [Admin\ServiceCatPulsaController::class, "operator_add_post"]);
				Route::get("edit_operator/{id}",[Admin\ServiceCatPulsaController::class, "operator_edit"]);
				Route::put("edit_operator/{id}",[Admin\ServiceCatPulsaController::class, "operator_update"]);
				Route::delete("/operator_delete",[Admin\ServiceCatPulsaController::class, "operator_delete"]);
		});

	});


	Route::prefix("/orders")->group(function(){

		# MANAGE ORDERS SOSMED #
		Route::prefix("/sosmed")->group(function(){
			Route::get("/",[Admin\OrderSosmedController::class, "manage_orders_sosmed"]);
			Route::get("/edit/{id}",[Admin\OrderSosmedController::class, "edit_orders_sosmed"]);
			Route::post("/edit/{id}",[Admin\OrderSosmedController::class, "update_orders_sosmed"]);
		});


		# MANAGE ORDERS PULSA #
		Route::prefix("/pulsa")->group(function(){
			Route::get("/", [Admin\OrderPulsaController::class, "manage_orders_pulsa"]);
			Route::get("/edit/{id}", [Admin\OrderPulsaController::class, "edit_orders_pulsa"]);
			Route::post("/edit/{id}", [Admin\OrderPulsaController::class, "update_orders_pulsa"]);
		});


	});


	Route::prefix("/users")->group(function(){
		Route::get("/",[Admin\UsersController::class, "manage_users"]);
		Route::delete("/",[Admin\UsersController::class, "delete_users"]);
		Route::get("/add",[Admin\UsersController::class, "add_users"]);
		Route::post("/add",[Admin\UsersController::class, "add_users_post"]);
		Route::get("/edit/{id}",[Admin\UsersController::class, "edit_users"]);
		Route::post("/edit/{id}",[Admin\UsersController::class, "update_users"]);
		Route::get("/detail/{id}", [Admin\UsersController::class, "users_detail"]);
	});


	Route::prefix("/deposit")->group(function(){
		Route::get("/",[Admin\DepositController::class, "manage_deposit"]);	
		Route::post("/accept",[Admin\DepositController::class, "accept_deposit"]);	
		Route::post("/decline",[Admin\DepositController::class, "decline_deposit"]);

		Route::prefix("/method")->group(function(){
			Route::get("/",[Admin\DepositMethodController::class, "deposit_method"]);
			Route::get("/add",[Admin\DepositMethodController::class, "add_deposit_method"]);
			Route::post("/add", [Admin\DepositMethodController::class, "post_deposit_method"]);
			Route::get("/edit/{id}", [Admin\DepositMethodController::class, "edit_deposit_method"]);
			Route::put("/edit/{id}", [Admin\DepositMethodController::class, "update_deposit_method"]);
			Route::delete("/",[Admin\DepositMethodController::class, "delete_deposit_method"]);
		});

	});

	Route::prefix("providers")->group(function(){
		Route::get("/",[Admin\ProviderController::class, "index"]);
		Route::get("/add",[Admin\ProviderController::class, "add"]);
		Route::post("/add",[Admin\ProviderController::class, "add_post"]);
		Route::get("/edit/{id}",[Admin\ProviderController::class, "edit"]);
		Route::put("/edit/{id}",[Admin\ProviderController::class, "update"]);
		Route::delete("/",[Admin\ProviderController::class, "delete"]);
	});

	Route::prefix("/news")->group(function(){
		Route::get("/",[Admin\NewsController::class, "manage_news"]);
		Route::get("/add",[Admin\NewsController::class, "add_news"]);
		Route::post("/add",[Admin\NewsController::class, "add_news_post"]);
		Route::get("/edit/{id}",[Admin\NewsController::class, "edit_news"]);
		Route::post("/edit/{id}",[Admin\NewsController::class, "update_news"]);
		Route::delete("/",[Admin\NewsController::class, "delete_news"]);
	});



	Route::prefix("/ticket")->group(function() {
		Route::get("/",[Admin\TicketController::class, "ticket_index"]);
		Route::post("/",[Admin\TicketController::class, "ticket_close"]);
		Route::get("/{id}",[Admin\TicketController::class, "ticket_detail"]);
		Route::post("/{id}",[Admin\TicketController::class, "ticket_detail_add"]);
	});


	Route::prefix("staff")->group(function() {
		Route::get("/", [Admin\StaffController::class, "staff"]);
		Route::get("/add", [Admin\StaffController::class, "add_staff"]);
		Route::post("/add", [Admin\StaffController::class, "add_staff_post"]);
		Route::get("/edit/{id}", [Admin\StaffController::class, "edit_staff"]);
		Route::put("/edit/{id}", [Admin\StaffController::class, "update_staff"]);
		Route::delete("/",[Admin\StaffController::class, "delete_staff"]);
	});

	
});



Route::middleware("auth","AjaxMiddleware")->group(function() {
	Route::post("read_news", [HomeController::class, 'read_news']);
});


Route::prefix("api")->group(function(){

	# ====================
	#     SOSMED API
	# ====================
	Route::get("/sosmed", [APIController::class, "incorrect_request"]);
	Route::post("/sosmed", [APIController::class, "sosmed"])->name("api_sosmed");
	Route::get("/sosmed/doc", [APIController::class, "sosmed_doc"]);


	# ====================
	#     PULSA API
	# ====================
	Route::post("/pulsa", [APIController::class, "pulsa"])->name("api_pulsa");
	Route::get("/pulsa", [APIController::class, "incorrect_request"]);
	Route::get("/pulsa/doc", [APIController::class, "pulsa_doc"]);

	# ====================
	#     PROFILE API
	# ====================
	Route::post("/profile", [APIController::class, "profile"])->name("api.profile");
	Route::get("/profile", [APIController::class, "incorrect_request"]);
	Route::get("/profile/doc", [APIController::class, "profile_doc"]);

});



