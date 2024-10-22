<?php

use App\Http\Controllers\AgdController;
use App\Http\Controllers\AssignRoomController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BatchRegistrationController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CampFeeController;
use App\Http\Controllers\CampVenueController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\GeneralSettings;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LookupCodeController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QrcodesController;
use App\Http\Controllers\RegistrantController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleMenuController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
Artisan::call('up');
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('logout', [LoginController::class, 'logout']);
//Route::get('/run_test', function (){
//    $registrant = \App\Registrant::find(1);
//
//    $agd = DB::table('agd_member_list')->where('agdlang_id','=', $registrant->agdlang_id)
//        ->where('total_left','>',0)->first();
//    if ($agd){
//        return $agd->code;
//    }else {
//        return "False";
//    }
//});

//Route::get('/pass',function(){
//    return bcrypt('02580258');
//});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/passwordreset', [HomeController::class , 'passwordreset'])->name('passwordreset');
Route::post('/changepassword', [HomeController::class , 'changepassword'])->name('changepassword');
Route::get("/testsms",[HomeController::class, 'testSms']);

//User Management routes
Route::resource('user', 'UserController');
Route::get('unblock', [UserController::class, 'unblock'])->name('user.unblock');
//Route::get('mobappuser', [UserController::class, 'mobappuser'])->name('user.mobappuser');
//Route::get('mobappuseradd', [UserController::class, 'mobappuseradd'])->name('user.mobappuseradd');
//Route::post('mobappuserstore', [UserController::class, 'mobappuserstore'])->name('user.mobappuserstore');
//Route::post('mobappuserblock', [UserController::class, 'mobappuserblock'])->name('user.mobappuserblock');
//Route::delete('mobappuserdestroy/{id}', [UserController::class, 'mobappuserdestroy'])->name('user.mobappuserdestroy');
//Route::get('mobappuserunblock', [UserController::class, 'mobappuserunblock'])->name('user.mobappuserunblock');

//Camper (Registrant) Management routes
Route::resource('registrant', 'RegistrantController');
Route::get('camper', [RegistrantController::class, 'camper'])->name('camper');
Route::get('nonpaidindividual', [RegistrantController::class, 'nonpaidindividual'])->name('camper.nonpaidindividual');
Route::get('onlinepaidcampers', [RegistrantController::class, 'onlinepaidcampers'])->name('camper.onlinepaidcampers');

//authorize online paid entries
Route::get('paidcampers', [RegistrantController::class, 'paidcampers'])->name('registrant.paidcampers');
Route::get('paidchapters', [RegistrantController::class, 'paidchapters'])->name('registrant.paidchapters');
Route::get('onlinepaidcampers', [RegistrantController::class, 'onlinepaidcampers'])->name('registrant.onlinepaidcampers');
Route::get('revokeauthorization', [RegistrantController::class, 'revokeauthorization'])->name('registrant.revokeauthorization');

Route::get('/paid/applicants', [RegistrantController::class, 'general'])->name('general');
Route::get('/rawdata', [RegistrantController::class, 'rawdata'])->name('rawdata');
Route::get('camperdetails', [RegistrantController::class, 'camperdetails'])->name('registrant.camperdetails');
Route::get('/view/applicant/{value}', [RegistrantController::class, 'profile'])->name('view.applicant');

//already registered camper retrieve route (registered prev year)
Route::get('registeredcamper', [RegistrantController::class, 'registeredcamper'])->name('registrant.registeredcamper');
Route::get('camper-info-update/{status?}', [RegistrantController::class, 'camper_update_page'])->name('registrant.camper_info_update');
Route::post('verify-registrant', [RegistrantController::class, 'verify_camper'])->name('registrant.verify_camper');
Route::post('verify-token', [RegistrantController::class, 'verify_token'])->name('registrant.verify_token');

Route::post('registrant-steps/{step}', [RegistrantController::class, 'camper_steps_save'])->name('registrant.steps_save');
Route::get('my-profile', [RegistrantController::class, 'viewMyProfile'])->name('registrant.MyProfile');
Route::get('registrant-logout', [RegistrantController::class, 'camper_logout'])->name('registrant.camper_logout');

Route::post('camperauthorize',[RegistrantController::class, 'camperauthorize'])->name('registrant.camperauthorize');
Route::post('camperonlineauthorize',[RegistrantController::class, 'camperonlineauthorize'])->name('registrant.camperonlineauthorize');

//Route::get('/dttest', [RegistrantController::class, 'dttest']);
//Route::get('/campregister',[RegistrantController::class, 'ghg']);

//camper tags
Route::get('campertag', [RegistrantController::class, 'campertag'])->name('registrant.campertag');
//    Route::get('campertagtest', [RegistrantController::class, 'campertagtest'])->name('registrant.campertagtest');
Route::post('campertaggenerate', [RegistrantController::class, 'campertaggenerate'])->name('registrant.campertaggenerate');


//Camp Fees
Route::resource('campfee', 'CampFeeController');
Route::get("campercatfees/{catid}",[CampFeeController::class, 'getCamperCatFees'])->name("camper.catfees");


Route::resource('bacthregistration', 'BatchRegistrationController');
//Route::get('onlinepaidchapters', [BatchRegistrationController::class, 'onlinepaidchapters'])->name('batchregistration.onlinepaidchapters');
Route::get('nonpaidchapters', [BatchRegistrationController::class, 'nonpaidchapters'])->name('chapter.nonpaidchapters');
Route::get('onlinepaidchapters', [BatchRegistrationController::class, 'onlinepaidchapters'])->name('chapter.onlinepaidchapters');
Route::post('authorizedpaidchaptermembers', [BatchRegistrationController::class, 'authorizedpaidchaptermembers'])->name('chapter.authorizedpaidchaptermembers');
Route::post('authorizechapterlist', [BatchRegistrationController::class, 'authorizechapterlist'])->name('chapter.authorizechapterlist');

Route::post('verify-chapter', [BatchRegistrationController::class, 'verify_chapter'])->name('registrant.verify_chapter');
Route::get('registeredchapter', [BatchRegistrationController::class, 'registeredchapter'])->name('registrant.registeredchapter');
Route::post('retrievechapter', [BatchRegistrationController::class, 'retrievechapter'])->name('registrant.retrievechapter');
Route::post('chapterprogress', [BatchRegistrationController::class, 'chapterprogress'])->name('registrant.chapterprogress');
Route::post('chapter_save_progress', [BatchRegistrationController::class, 'chapter_save_progress'])->name('bacthregistration.chapter_save_progress');
Route::post('chaptermemberedit', [BatchRegistrationController::class, 'chaptermemberedit'])->name('batchregistration.chaptermemberedit');
Route::post('chaptermemberdelete', [BatchRegistrationController::class, 'chaptermemberdelete'])->name('batchregistration.chaptermemberdelete');
Route::post('batchmemberlist', [BatchRegistrationController::class, 'getBatchMemberList'])->name('batchregistration.batchmemberlist');
Route::put('chapter-info-update/{batch_no?}/include_camper', [BatchRegistrationController::class, 'includeCamper'])->name('batchregistration.includeCamper');
Route::put('chapter-info-update/{batch_no?}/exclude_camper', [BatchRegistrationController::class, 'excludeCamper'])->name('batchregistration.excludeCamper');
Route::get('chapter-info-update/{batch_no?}/{status?}', [BatchRegistrationController::class, 'chapter_update_page'])->name('batchregistration.chapter_info_update');

Route::post('importExcel', [BatchRegistrationController::class, 'importExcel']);
Route::post('downloadExcel', [BatchRegistrationController::class, 'downloadExcel'])->name('bacthregistration.downloadExcel');
Route::post('batchregister', [BatchRegistrationController::class, 'batchregister']);
Route::get('testBatches', [BatchRegistrationController::class, 'testBatches']);
Route::post('batchregisternew', [BatchRegistrationController::class, 'batchregisternew']);

Route::get('importtokens', [BatchRegistrationController::class, 'importTokens'])->name('batchregistration.importtokens');
Route::post('doimporttokens', [BatchRegistrationController::class, 'doimportTokens'])->name('batchregistration.doimporttokens');

Route::get('batch-registration/onscreen', [BatchRegistrationController::class, 'batchform'])->name('table_batch');
Route::post('batch-registration', [BatchRegistrationController::class, 'batchform_save'])->name('table_batch.save');
Route::post('chapteronlineauthorize',[BatchRegistrationController::class, 'chapteronlineauthorize'])->name('batchregistration.chapteronlineauthorize');

//BatchRegistration other routes
Route::get('/mergechapters',[BatchRegistrationController::class, 'mergechapters'])->name('batchregistration.mergechapters');

//Payment
Route::resource('payment','PaymentController');
Route::get('/paymentrequest',[PaymentController::class, 'onlinepaymentrequest'])->name('payment.paymentrequest');
Route::get('/paymentTransfer',[PaymentController::class, 'transferFromPayment'])->name('payment.transferFromPayment');
//Route::get('testpayment/{_token}/{batch_no}',[PaymentController::class, 'testpayment'])->name('payment.testpayment');
Route::post('makepayment',[PaymentController::class, 'makepayment'])->name('payment.makepayment');
Route::get('/paymentreceipt',[PaymentController::class, 'onlinepaymentreceipt'])->name('payment.paymentreceipt');

//Route::middleware(['initPwdChanged'])->group(function () {

//Lookup Code
Route::resource('lookupcode','LookupCodeController');

//Menu Items
Route::resource('menu','MenuItemController');
//Lookup
Route::resource('lookup','LookupController');
Route::get('/lookupindex/{lookupid}', [LookupController::class, 'lookupindex']);

//Permission
Route::resource('permission','PermissionController');

//Roles
Route::resource('roles','RoleController');

//Other routes
//Route::get('/passwordreset', 'AuxilliaryController@passwordreset');

Route::get('/rolemenuajax/{roleid}', [RoleMenuController::class, 'rolemenu']);
Route::get('/assignmenu', [RoleMenuController::class, 'assignmenu']);
Route::get('/mapmenu',['as' => 'assignmenu.mapmenu','uses'=> [RoleMenuController::class, 'mapmenu']]);


Route::get('/assign-room', [AssignRoomController::class, 'index'])->name('assign');
Route::get('/allocate', [AssignRoomController::class, 'allocate'])->name('allocate');
Route::get('/assign-room/search', [AssignRoomController::class, 'search'])->name('search');
Route::get('/bulk_assign-room', [AssignRoomController::class, 'assignBulk'])->name('assignBulk');
Route::get('/batch-allocation', [AssignRoomController::class, 'batchAllocation'])->name('batchAllocation');
Route::post('/assign-room/assign', [AssignRoomController::class, 'assign'])->name('assignment');
Route::put('/assign-room/manual', [AssignRoomController::class, 'manual'])->name('manual.assignment');
Route::put('/assign-room/transfer', [AssignRoomController::class, 'transfer'])->name('manual.transfer');

// Residence Route
Route::get('/camp-venues', [CampVenueController::class, 'index']);
Route::post('/camp-venue', [CampVenueController::class, 'store'])->name('venue.store');
Route::post('/camp-venue/edit', [CampVenueController::class, 'get_venue_info'])->name('venue.edit');
Route::post('/camp-venue/update', [CampVenueController::class, 'update'])->name('venue.update');

// Residence Route
//    Route::resource('/residence', 'ResidenceController');
Route::get('/{venue_slug}/residences', [ResidenceController::class, 'get_venue_residences'])->name('venue.residences');
Route::get('/{venue_slug}/residence/add-new', [ResidenceController::class, 'create'])->name('create_residence');
Route::post('/{venue_slug}/residence', [ResidenceController::class, 'store'])->name('save_residence');
Route::get('/{venue_slug}/residence/{id}', [ResidenceController::class, 'edit'])->name('edit_residence');
Route::put('/{venue_slug}/residence/{id}', [ResidenceController::class, 'update'])->name('update_residence');
Route::delete('/{venue_slug}/residence/{id}/delete', [ResidenceController::class, 'destroy'])->name('destroy_residence');
Route::get('all-blocks', [ResidenceController::class, 'get_all_blocks'])->name('residence.get_blocks');
Route::get('all-floors', [ResidenceController::class, 'get_all_floors'])->name('residence.get_all_floors');
Route::get('all-rooms', [ResidenceController::class, 'get_all_rooms'])->name('residence.get_all_rooms');
Route::get('/{venue_slug}/residence/{id}/blocks', [ResidenceController::class, 'blocks'])->name('residence.blocks');
Route::post('/{venue_slug}/residence/{id}/blocks', [ResidenceController::class, 'blockstore'])->name('residence.add_blocks');
Route::get('/residence/get_datatable', [ResidenceController::class, 'get_Datatable']);
Route::post('/{venue_slug}/residence/set-room-gender', [ResidenceController::class, 'set_room_gender'])->name('residence.set_gender');
//    Route::get('/camp-venue/{venue_slug}/residences', [ResidenceController::class, 'venue'])->name('venue.residences');
//    Route::post('/residence/{id}/blocks', [ResidenceController::class, 'blockstore'])->name('residence.add_blocks');
//    Route::get('/residence/get_datatable', [ResidenceController::class, 'get_Datatable']);

// Blocks Routes
Route::get('/block', [BlockController::class, 'index'])->name('blocks');
Route::get('/get_blocks', [BlockController::class, 'get_blocks'])->name('get_blocks');
Route::get('/block/{id}/edit', [BlockController::class, 'edit'])->name('blocks.edit');
Route::get('/block/{id}/generate_room', [BlockController::class, 'generate_rooms'])->name('block.generate_room');
Route::get('/block/{id}/edit_rooms', [BlockController::class, 'edit_rooms'])->name('edit_rooms');
Route::post('/block/store_rooms', [BlockController::class, 'store_rooms'])->name('block.store_rooms');
Route::put('/block/update_rooms/{id}', [BlockController::class, 'update_rooms'])->name('update_rooms');
Route::put('/block/{id}', [BlockController::class, 'update'])->name('block.update');

// Rooms Routes
Route::resource('/room', 'RoomController');
Route::get('/room/view',[RoomController::class, 'getBody']);
Route::post('room/clear-members',[RoomController::class, 'clear_room'])->name('room.clear_members');
Route::get('/block/{id}/rooms', [RoomController::class, 'index'])->name('rooms');
Route::get('manualroomsetup', [RoomController::class, 'manualroomsetup'])->name('rooms.manualroomsetup');
Route::post('savemanualrooms', [RoomController::class, 'savemanualrooms'])->name('rooms.savemanualrooms');

// Reports Route
Route::get('/report', [ReportsController::class, 'index'])->name('report');
Route::get('/report/applicants', [ReportsController::class, 'camperReport'])->name('report.campers');
Route::get('/report/accounts', [ReportsController::class, 'accountReport'])->name('report.accounts');
Route::get('/report/camperstocounsel', [ReportsController::class, 'campersToCounsel'])->name('report.camperstocounsel');
Route::get('/financialreport',[ReportsController::class, 'financialreport'])->name('report.financialreport');
Route::get('/genericreport',[ReportsController::class, 'genericreport'])->name('report.genericreport');

Route::get('/records',[ReportsController::class, 'records'])->name('report.records');
Route::get('/allpaidcampers',[ReportsController::class, 'allpaidcampers'])->name('report.paidcampers');
Route::get('/repchapterleaders',[ReportsController::class, 'repchapterleaders'])->name('report.repchapterleaders');

//System audit trails
Route::get('/audittrail',[AuditController::class, 'index'])->name('audit');

//serve food
Route::get('/serve-meals',[MealsController::class, 'serve_meals'])->name('meal.serve');
Route::get('/check-serve-meals',[MealsController::class, 'check_serve_meals'])->name('meal.check_serve');
Route::get('/server/login',[MealsController::class, 'server_login'])->name('meal.server.login');
Route::get('/server/logout',[MealsController::class, 'server_logout'])->name('meal.logout');
Route::post('/server',[MealsController::class, 'server'])->name('meal.server');

//meal settings
Route::get('/meals/settings',[MealsController::class, 'settings'])->name('meal.settings');
Route::post('/meals/settings/save_schedule',[MealsController::class, 'save_mealSchedule'])->name('meal.save_schedule');
Route::get('/meals/activate_next_meal',[MealsController::class, 'activeNextMeal'])->name('meal.activeNextMeal');
Route::post('/meals/remove_official',[MealsController::class, 'remove_official'])->name('meal.remove_official');
Route::post('/meals/remove_meal',[MealsController::class, 'remove_meal'])->name('meal.remove_meal');
Route::post('/meals/add_official',[MealsController::class, 'save_official'])->name('meal.save_meal_official');

Route::post('/meals/centres',[MealsController::class, 'save_centre'])->name('meal.save_centre');
Route::post('/meals/foods',[MealsController::class, 'save_food'])->name('meal.save_food');
Route::post('/meals/centres-remove',[MealsController::class, 'remove_centre'])->name('meal.remove_centre');
Route::post('/meals/foods-remove',[MealsController::class, 'remove_food'])->name('meal.remove_food');
Route::get('/meals/codes/{size}',[MealsController::class, 'codes'])->name('meal.codes');

//AGD
Route::get('/agd-settings',[AgdController::class, 'index'])->name('agd');
Route::post('/agd-settings/save',[AgdController::class, 'save'])->name('agd.save');
Route::get('/assignAGD_no/{id}',[AgdController::class, 'assignAGD_no'])->name('agd.assign');

// Messaging Routes
Route::resource('message', 'MessageController');
Route::get('/testMessage', [MessageController::class, 'testMessage']);
Route::get('tokens', [MessageController::class, 'tokens'])->name('message.tokens');
Route::post('batchtokensend', [MessageController::class, 'batchtokensend'])->name('message.batchtokensend');

//Random QR-Code Generator
Route::get('build-qrcodes',[QrcodesController::class, 'index'])->name('qrcodes');
Route::post('build-qrcodes/generate',[QrcodesController::class, 'generate'])->name('qrcodes.generate');
Route::delete('blockqrcode/{id}',[QrcodesController::class, 'blockqrcode'])->name('qrcodes.blockqrcode');

//Error Log
Route::resource('error','ErrorLogController');
//General Settings
Route::get('settings',[GeneralSettings::class, 'index'])->name('settings');
Route::post('settings/save-venue',[GeneralSettings::class, 'saveThisYearVenue'])->name('settings.saveThisYearVenue');
//});

