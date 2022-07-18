<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\StockController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\GlobalController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\AccountsController;
use App\Http\Controllers\Backend\BankListController;
use App\Http\Controllers\Backend\CashBookController;
use App\Http\Controllers\Backend\PackSizeController;
use App\Http\Controllers\Backend\StockNewController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\BulkSalesController;
use App\Http\Controllers\Backend\BulkStockController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserStoreController;
use App\Http\Controllers\Backend\LicenseCatController;
use App\Http\Controllers\Backend\ProductCatController;
use App\Http\Controllers\Backend\ProductionController;
use App\Http\Controllers\Backend\RepackUnitController;
use App\Http\Controllers\Backend\TotalStockController;
use App\Http\Controllers\Backend\UserBankAcController;
use App\Http\Controllers\Backend\AccountMainController;
use App\Http\Controllers\Backend\CompanyInfoController;
use App\Http\Controllers\Backend\EmployeeCatController;
use App\Http\Controllers\Backend\RawMaterialController;
use App\Http\Controllers\Backend\Report\BulkController;
use App\Http\Controllers\Backend\SalesReportController;
use App\Http\Controllers\Backend\SalesSampleController;
use App\Http\Controllers\Backend\StockReportController;
use App\Http\Controllers\Backend\UserFactoryController;
use App\Http\Controllers\Backend\BulkPurchaseController;
use App\Http\Controllers\Backend\EmployeeMainController;
use App\Http\Controllers\Backend\OfficeIncomeController;
use App\Http\Controllers\Backend\ProductStockController;
use App\Http\Controllers\Backend\UserCustomerController;
use App\Http\Controllers\Backend\UserEmployeeController;
use App\Http\Controllers\Backend\UserSupplierController;
use App\Http\Controllers\Backend\BankStatementController;
use App\Http\Controllers\Backend\LabelPurchaseController;
use App\Http\Controllers\Backend\OfficeExpenseController;
use App\Http\Controllers\Backend\ResetPasswordController;
use App\Http\Controllers\Backend\AccountPaymentController;
use App\Http\Controllers\Backend\CustomerReportController;
use App\Http\Controllers\Backend\ProductLicenseController;
use App\Http\Controllers\Backend\SalesStatementController;
use App\Http\Controllers\Backend\AccountReceivedController;
use App\Http\Controllers\Backend\OfficeIncomeCatController;
use App\Http\Controllers\Backend\SalesLedgerBookController;
use App\Http\Controllers\Backend\SendToRepackingController;
use App\Http\Controllers\Backend\WithdrawDepositController;
use App\Http\Controllers\Backend\AuthorLedgerBookController;
use App\Http\Controllers\Backend\CollectionReportController;
use App\Http\Controllers\Backend\OfficeExpenseCatController;
use App\Http\Controllers\Backend\SalesInvoiceCashController;
use App\Http\Controllers\Backend\SendToProductionController;
use App\Http\Controllers\Backend\PurchaseStatementController;
use App\Http\Controllers\Backend\SalesSampleReportController;
use App\Http\Controllers\Backend\OfficeIncomeReportController;
use App\Http\Controllers\Backend\PurchaseLedgerBookController;
use App\Http\Controllers\Backend\OfficeExpenseReportController;
use App\Http\Controllers\Backend\LabelSendToRepackingController;
use App\Http\Controllers\Backend\Report\SalesAndStockController;
use App\Http\Controllers\Backend\SalesInvoiceCashReturnController;
use App\Http\Controllers\Backend\VisitorInfoController;

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


Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/register-store', [AuthController::class, 'registerStore'])->name('registerStore');
Route::get('/register-verify/{token}', [AuthController::class, 'registerVerify'])->name('registerVerify');
Route::get('/verify-notification', [AuthController::class, 'verifyNotification'])->name('verifyNotification');

Route::post('/verify-resend', [AuthController::class, 'verifyResend'])->name('verifyResend');

Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
Route::post('/forget-password-process', [AuthController::class, 'forgetPasswordProcess'])->name('forgetPasswordProcess');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password-process', [AuthController::class, 'resetPasswordProcess'])->name('resetPasswordProcess');
Route::get('/reset-verify-notification', [AuthController::class, 'resetVerifyNotification'])->name('resetVerifyNotification');

Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('compressed')->group(function () {
    Route::get('/', 'App\Http\Controllers\Frontend\IndexController@index')->name('index');
    Route::get('/all-products', 'App\Http\Controllers\Frontend\IndexController@allProducts')->name('allProducts');
    Route::get('/all-products/{catId}', 'App\Http\Controllers\Frontend\IndexController@productsByCat')->name('allPproductsByCatroducts');
    Route::get('/read-product/{id}', 'App\Http\Controllers\Frontend\IndexController@productDetails')->name('productDetails');
    Route::get('/about', 'App\Http\Controllers\Frontend\IndexController@about')->name('about');
    Route::get('/contact', 'App\Http\Controllers\Frontend\IndexController@contact')->name('contact');
});
