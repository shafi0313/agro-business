<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\StockController;
use App\Http\Controllers\Auth\Role\RoleController;
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
use App\Http\Controllers\Backend\VisitorInfoController;
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
use App\Http\Controllers\Backend\PurchaseProductController;
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
use App\Http\Controllers\Auth\Permission\PermissionController;
use App\Http\Controllers\Backend\OfficeIncomeReportController;
use App\Http\Controllers\Backend\PurchaseLedgerBookController;
use App\Http\Controllers\Backend\OfficeExpenseReportController;
use App\Http\Controllers\Backend\LabelSendToRepackingController;
use App\Http\Controllers\Backend\Report\SalesAndStockController;
use App\Http\Controllers\Backend\ProPurchaseLedgerBookController;
use App\Http\Controllers\Backend\SalesInvoiceCashReturnController;


Route::post('logged_in', [LoginController::class, 'authenticate']);
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/visitor_info', [DashboardController::class, 'VisitorInfo'])->name('VisitorInfo');

// !APP BACKUP
Route::get('web-backup/password', [BackupController::class, 'password'])->name('admin.backup.password');
Route::post('web-backup/checkPassword', [BackupController::class, 'checkPassword'])->name('admin.backup.checkPassword');
Route::get('web-backup/confirm', [BackupController::class, 'index'])->name('admin.backup.index');

Route::post('backup-file', [BackupController::class, 'backupFiles'])->name('admin.backup.files');
Route::post('backup-db', [BackupController::class, 'backupDb'])->name('admin.backup.db');

// Route::get('web-backup/restore', [BackupController::class, 'restoreLoad'])->name('admin.backup.restore');
// Route::post('web-backup/restore/post', [BackupController::class, 'restore'])->name('admin.backup.restore.post');

Route::post('/backup-download/{name}/{ext}', [BackupController::class, 'downloadBackup'])->name('admin.backup.download');
Route::post('/backup-delete/{name}/{ext}', [BackupController::class, 'deleteBackup'])->name('admin.backup.delete');

Route::get('/visitor-info', [VisitorInfoController::class, 'index'])->name('admin.visitorInfo.index');
Route::post('/visitor-info/delete-selected', [VisitorInfoController::class, 'destroySelected'])->name('admin.visitorInfo.destroySelected');
Route::get('/visitor-info/delete-all', [VisitorInfoController::class, 'destroyAll'])->name('admin.visitorInfo.destroyAll');

// Route::post('web-backup/setpass', 'WebBackupController@setPass')->name('backup.setPass');
// Route::get('web-backup/', 'WebBackupController@index')->name('backup.index');

Route::post('role/permission/{role}', [RoleController::class, 'assignPermission'])->name('admin.role.permission');
Route::resource('role', RoleController::class, [
    'names'=>[
        'index'=> 'admin.role.index',
        'create'=> 'admin.role.create',
        'store'=> 'admin.role.store',
        'edit'=> 'admin.role.edit',
        'update'=> 'admin.role.update',
        'show'=> 'admin.role.show',
        'destroy'=> 'admin.role.destroy',
    ]
]);
Route::resource('permission', PermissionController::class, [
    'names'=>[
        'index'=> 'admin.permission.index',
        'create'=> 'admin.permission.create',
        'store'=> 'admin.permission.store',
        'edit'=> 'admin.permission.edit',
        'update'=> 'admin.permission.update',
        'destroy'=> 'admin.permission.destroy',
    ]
]);

Route::prefix('reset-password')->group(function () {
    Route::get('/create', [ResetPasswordController::class, 'create'])->name('admin.myProfile.resetPassdord.create');
    Route::post('/store', [ResetPasswordController::class, 'store'])->name('admin.myProfile.resetPassdord.store');
});

Route::prefix('/company-info')->controller(CompanyInfoController::class)->group(function(){
    Route::get('/admin', 'adminIndex')->name('admin.companyInfo.adminIndex');
    Route::post('/admin', 'adminUpdate')->name('admin.companyInfo.adminUpdate');
    Route::get('/front', 'frontIndex')->name('admin.companyInfo.frontIndex');
    Route::post('/front', 'frontUpdate')->name('admin.companyInfo.frontUpdate');

});

// User Start________________________________________________________________________________________________________________

Route::resource('/admin-user', AdminUserController::class)->except(['show']);
Route::post('/admin-user/user-file-store', [AdminUserController::class, 'userFileStore'])->name('admin.userFileStore');
Route::get('/admin-user/file/destroy/{id}', [AdminUserController::class, 'userFileDestroy'])->name('admin.userFileDestroy');

Route::resource('/employee', UserEmployeeController::class)->except('show');
Route::post('employee/user-file-store', [UserEmployeeController::class, 'userFileStore'])->name('employee.userFileStore');
Route::get('/employee/file/destroy/{id}', [UserEmployeeController::class, 'userFileDestroy'])->name('employee.userFileDestroy');


Route::resource('/employee-cat', EmployeeCatController::class)->only(['index','create']);
Route::post('/employee-main-store', [EmployeeCatController::class, 'mainStore'])->name('empCat.mainStore');
Route::post('/employee-sub-store', [EmployeeCatController::class, 'subStore'])->name('empCat.subStore');
Route::get('/get-employee', [EmployeeCatController::class, 'getEmp'])->name('empCat.getEmp');
Route::get('/get-all-employee', [EmployeeCatController::class, 'getAllEmp'])->name('empCat.getAllEmp');
Route::resource('/employee-main-cat', EmployeeMainController::class)->except(['create','show']);

Route::resource('/company-store', UserStoreController::class);
Route::post('/company-store/user-file-store', [UserStoreController::class, 'userFileStore'])->name('store.userFileStore');
Route::get('/company-store/file/destroy/{id}', [UserStoreController::class, 'userFileDestroy'])->name('store.userFileDestroy');

Route::resource('/company-factory', UserFactoryController::class);
Route::post('/company-factory/user-file-store', [UserFactoryController::class, 'userFileStore'])->name('factory.userFileStore');
Route::get('/company-factory/file/destroy/{id}', [UserFactoryController::class, 'userFileDestroy'])->name('factory.userFileDestroy');

Route::resource('/customer', UserCustomerController::class);
Route::post('/customer/user-file-store', [UserCustomerController::class, 'userFileStore'])->name('customer.userFileStore');
Route::get('/customer/file/destroy/{id}', [UserCustomerController::class, 'userFileDestroy'])->name('customer.userFileDestroy');

Route::resource('/supplier', UserSupplierController::class);
Route::post('/supplier/user-file-store', [UserSupplierController::class, 'userFileStore'])->name('supplier.userFileStore');
Route::get('/supplier/file/destroy/{id}', [UserSupplierController::class, 'userFileDestroy'])->name('supplier.userFileDestroy');
// User End________________________________________________________________________________________________________________

Route::resource('/user', UserController::class);
Route::post('/user/user-file-store', [UserController::class, 'userFileStore'])->name('user.userFileStore');
Route::get('/user/file/destroy/{id}', [UserController::class, 'userFileDestroy'])->name('user.userFileDestroy');


Route::get('/select-type', [UserController::class, 'userType'])->name('user.userType');

Route::resource('/user-bank-ac', UserBankAcController::class);

// New stock
Route::prefix('stock')->group(function () {
    Route::prefix('store')->group(function () {
        Route::get('/', [StockNewController::class, 'index'])->name('stock.store.index');
        Route::get('/create', [StockNewController::class, 'create'])->name('stock.store.create');
        Route::post('/store', [StockNewController::class, 'store'])->name('stock.store.store');
        Route::get('/previous/{id}', [StockNewController::class, 'previous'])->name('stock.store.previous');
        // Route::get('/edit/{id}', [StockNewController::class, 'edit'])->name('stock.store.edit');
        Route::post('/update', [StockNewController::class, 'update'])->name('stock.store.update');
        Route::get('/close/{product_id}/{pack_size_id}', [StockNewController::class, 'close'])->name('stock.store.close');
        Route::post('/close', [StockNewController::class, 'close'])->name('stock.store.close');
    });
    Route::prefix('bulk')->group(function () {
        Route::get('/', [BulkStockController::class, 'index'])->name('stock.bulk.index');
        Route::get('/create', [BulkStockController::class, 'create'])->name('stock.bulk.create');
        Route::post('/store', [BulkStockController::class, 'store'])->name('stock.bulk.store');
        Route::get('/previous/{id}', [BulkStockController::class, 'previous'])->name('stock.bulk.previous');
        Route::get('/edit/{id}', [BulkStockController::class, 'edit'])->name('stock.bulk.edit');
        Route::post('/update', [BulkStockController::class, 'update'])->name('stock.bulk.update');
        Route::post('/close', [BulkStockController::class, 'close'])->name('stock.bulk.close');
    });
});

Route::get('/total-stock/select-date', [TotalStockController::class, 'selectDate'])->name('totalStock.selectDate');
Route::post('/total-stock/report/by-date', [TotalStockController::class, 'report'])->name('totalStock.report');

// Global______________________________________________________________________________________________________________________________
Route::get('autocomplete', [GlobalController::class, 'autocomplete'])->name('autocomplete');
Route::get('PurchaseProductSearch', ['as'=>'PurchaseProductSearch','uses'=> 'App\Http\Controllers\Backend\GlobalController@PurchaseProductSearch']);
Route::get('/bulk-pack-size', [GlobalController::class, 'bulkPackSize'])->name('bulkPackSize');
Route::get('/bulk-size', [GlobalController::class, 'bulkSize'])->name('bulkSize');
Route::get('/bulkStockCheck/get/quantity', [SendToRepackingController::class, 'bulkStockCheck'])->name('bulkStockCheck');

Route::get('autocomplete', [GlobalController::class, 'autocomplete'])->name('autocomplete');
Route::get('productSearch', ['as'=>'productSearch','uses'=> 'App\Http\Controllers\Backend\GlobalController@productSearch']);

Route::get('autocomplete', [GlobalController::class, 'autocomplete'])->name('autocomplete');
Route::get('invoiceSearch', ['as'=>'invoiceSearch','uses'=> 'App\Http\Controllers\Backend\GlobalController@invoiceSearch']);


Route::get('/invoice/get/product-size', [GlobalController::class, 'productSize'])->name('productSize');
Route::get('/invoice/get/amt', [GlobalController::class, 'dueAmt'])->name('dueAmtInvoice');
Route::get('/invoice/get/product-size-id', [GlobalController::class, 'productSizeId'])->name('productSizeId');
Route::get('/productStockCheck/get/quantity', [GlobalController::class, 'productStockCheck'])->name('productStockCheck');

Route::get('/invoice/get/price-cash', [GlobalController::class, 'productPriceCash'])->name('productPriceCash');

Route::get('/invoice/get/bulk-price', [GlobalController::class, 'bulkPrice'])->name('bulkPrice');

Route::get('/invoice/get/bankAc', [GlobalController::class, 'bankAc'])->name('bankAc');


// Sales Report ____________________________________________________________________
Route::prefix('/sales-report')->group(function () {
    Route::get('/cash', [SalesReportController::class, 'userCash'])->name('empReport.user');
    Route::get('/cash/select-date/{id}', [SalesReportController::class, 'selectDateCash'])->name('empReport.selectDate');
    Route::post('/cash/show-report', [SalesReportController::class, 'showReportCash'])->name('empReport.showReport');

    Route::get('/credit', [SalesReportController::class, 'userCredit'])->name('empReport.userCredit');
    Route::get('/credit/select-date/{id}', [SalesReportController::class, 'selectDateCredit'])->name('empReport.selectDateCredit');
    Route::post('/credit/show-report', [SalesReportController::class, 'showReportCredit'])->name('empReport.showReportCredit');
});

Route::prefix('collection-report')->group(function () {
    Route::get('/employee', [CollectionReportController::class, 'user'])->name('collectionReport.user');
    Route::get('/select-date/{id}', [CollectionReportController::class, 'selectDate'])->name('collectionReport.selectDate');
    Route::post('/show-report', [CollectionReportController::class, 'showReport'])->name('collectionReport.showReport');
});


Route::resource('/bank-list', BankListController::class)->except(['show']);
Route::resource('/slider', SliderController::class)->except(['show']);
Route::resource('/about', AboutController::class)->only(['edit','update']);
Route::resource('/pack-size', PackSizeController::class)->except(['create','show']);


Route::resource('/customer-report', CustomerReportController::class)->except(['create','show']);


// Account
Route::get('/account/salesStatement', [AccountsController::class, 'salesStatement'])->name('account.salesStatement');
Route::resource('/account-payment', AccountPaymentController::class)->only(['index','store']);
Route::get('/account-payment/{id}', [AccountPaymentController::class, 'createId'])->name('payment.createId');
Route::get('/get/bank-account-balance', [AccountPaymentController::class, 'bankBalance'])->name('payment.bankBalance');


Route::resource('/office-expense-cat', OfficeExpenseCatController::class)->except(['create','edit','show']);
Route::post('/office-expense-sub-cat', [OfficeExpenseCatController::class, 'subCatStore'])->name('officeExpense.subCatStore');
Route::put('/office-expense-sub-cat/edit/{id}', [OfficeExpenseCatController::class, 'subCatEdit'])->name('officeExpense.subCatEdit');

Route::resource('/office-income-cat', OfficeIncomeCatController::class)->except(['create','edit','show']);
Route::post('/income-expense-sub-cat', [OfficeIncomeCatController::class, 'subCatStore'])->name('officeIncome.subCatStore');
Route::put('/income-expense-sub-cat/edit/{id}', [OfficeIncomeCatController::class, 'subCatEdit'])->name('officeIncome.subCatEdit');

Route::resource('/office-expense', OfficeExpenseController::class)->except(['edit','show']);
Route::get('/get-office-expense', [OfficeExpenseController::class, 'expenseCat'])->name('get.expenseCat');

Route::resource('/office-income', OfficeIncomeController::class)->except(['edit','show']);
Route::get('/get-office-income', [OfficeIncomeController::class, 'incomeCat'])->name('get.incomeCat');



Route::prefix('office-expense-report')->group(function () {
    Route::get('/select-date', [OfficeExpenseReportController::class, 'selectDate'])->name('officeExp.selectDate');
    Route::post('/show-report', [OfficeExpenseReportController::class, 'report'])->name('officeExp.report');
    Route::get('/view/{id}/{form_date}/{to_date}/{expId}', [OfficeExpenseReportController::class, 'reportView'])->name('officeExp.reportView');
});

Route::prefix('office-income-report')->group(function () {
    Route::get('/select-date', [OfficeIncomeReportController::class, 'selectDate'])->name('officeIn.selectDate');
    Route::post('/show-report', [OfficeIncomeReportController::class, 'report'])->name('officeIn.report');
    Route::get('/view/{id}/{form_date}/{to_date}/{expId}', [OfficeIncomeReportController::class, 'reportView'])->name('officeIn.reportView');
});

Route::resource('/account-received', AccountReceivedController::class)->only(['index','store','show','destroy']);
Route::prefix('/account_received')->controller(AccountReceivedController::class)->group(function(){
    Route::get('/received/{id}', 'createId')->name('received.createId');
    Route::get('/get/bank-info', 'bankInfo')->name('received.bankInfo');
    Route::get('/sales-info', 'salesInvInfo')->name('received.salesInvInfo');
    Route::get('/trash', 'trash')->name('received.trash');
});


Route::get('/main-account/select-date', [AccountMainController::class, 'selectDate'])->name('mainAccount.selectDate');
Route::get('/main-account', [AccountMainController::class, 'index'])->name('mainAccount.index');

// Cash Book
Route::prefix('cash-book')->group(function () {
    Route::get('/select-date', [CashBookController::class, 'selectDate'])->name('cashBook.selectDate');
    Route::get('', [CashBookController::class, 'report'])->name('cashBook.report');
    Route::post('/previous', [CashBookController::class, 'cashPreStore'])->name('cashBook.cashPreStore');
});

Route::prefix('bank-statement')->group(function () {
    Route::get('/select-date', [BankStatementController::class, 'selectDate'])->name('bankStatement.selectDate');
    Route::get('/', [BankStatementController::class, 'index'])->name('bankStatement.index');
    Route::post('/previous', [BankStatementController::class, 'bankPreStore'])->name('bankStatement.bankPreStore');
});

Route::get('/withdraw', [WithdrawDepositController::class, 'wCreate'])->name('bankWithdraw.wCreate');
Route::post('/withdraw/store', [WithdrawDepositController::class, 'wStore'])->name('bankWithdraw.wStore');
Route::get('/deposit', [WithdrawDepositController::class, 'dCreate'])->name('bankDeposit.dCreate');
Route::post('/deposit/store', [WithdrawDepositController::class, 'dStore'])->name('bankDeposit.dStore');

// Product
Route::resource('/product-category', ProductCatController::class);
Route::resource('/license-category', LicenseCatController::class);
Route::resource('/product-license', ProductLicenseController::class);

Route::resource('/product', ProductController::class);
Route::get('/product/get/product-size', [ProductController::class, 'productSize'])->name('product.productSize');
Route::post('/product-add', [ProductController::class, 'addSizePrice'])->name('addSizePriceAdd');
Route::get('/pro_delete-pack-size/{packId}', [ProductController::class, 'deletePackSize'])->name('deletePackSize');

// Raw Material
Route::resource('/raw-material', RawMaterialController::class);
Route::get('/raw-material/get/product-size', [RawMaterialController::class, 'productSize'])->name('rawMaterial.productSize');
Route::post('/raw-material-add', [RawMaterialController::class, 'addSizePrice'])->name('rawMaterial.addSizePriceAdd');
Route::get('/product_delete-pack-size/{packId}', [RawMaterialController::class, 'deletePackSize'])->name('rawMaterial.deletePackSize');

// Bulk Start ________________________________________________________________________________
// Bulk Purchase
Route::resource('/purchase-bulk', BulkPurchaseController::class);
Route::prefix('purchase_bulk')->group(function () {
    Route::get('/create/{id}', [BulkPurchaseController::class, 'createId'])->name('purchaseBulk.create');
    Route::get('/show/{supplier_id}/{challan_no}', [BulkPurchaseController::class, 'showInvoice'])->name('purchaseBulk.show');
    // All
    Route::get('/all/show', [BulkPurchaseController::class, 'allInvoice'])->name('purchaseBulk.allInvoice');
    // By Date
    Route::get('/select-date', [BulkPurchaseController::class, 'selectDate'])->name('purchaseBulk.selectDate');
    Route::post('/show/all/challan/by-date', [BulkPurchaseController::class, 'allInvoiceByDate'])->name('purchaseBulk.allInvoiceByDate');

    Route::get('/product_Pack_Sizes', [BulkPurchaseController::class, 'productPackSizes'])->name('purchaseBulk.productPackSizes');
    Route::get('/get/productSize', [BulkPurchaseController::class, 'productSize'])->name('purchaseBulk.productSize');
    Route::get('/get/price', [BulkPurchaseController::class, 'productPrice'])->name('purchaseBulk.invoicePrice');

    Route::get('/print/challan/{supplier_id}/{challan_no}', [BulkPurchaseController::class, 'printChallan'])->name('purchaseBulk.printChallan');
    Route::get('/print/invoice/{supplier_id}/{challan_no}', [BulkPurchaseController::class, 'printInvoice'])->name('purchaseBulk.printInvoice');
});


// Sales Bulk
Route::resource('/sales-bulk', BulkSalesController::class);
Route::prefix('sales_bulk')->group(function () {
    Route::get('/create/{id}', [BulkSalesController::class, 'createId'])->name('salesBulk.create');
    Route::get('/show/{supplier_id}/{challan_no}', [BulkSalesController::class, 'showInvoice'])->name('salesBulk.show');
    Route::get('/show/{challan_no}', [BulkSalesController::class, 'destroyInvoice'])->name('salesBulk.destroy');

    Route::get('/print/challan/{customer_id}/{invoice_no}', [BulkSalesController::class, 'printChallan'])->name('bulkSales.printChallan');
    Route::get('/print/invoice/{customer_id}/{invoice_no}', [BulkSalesController::class, 'printInvoice'])->name('bulkSales.printInvoice');

    // All
    Route::get('/all/show', [BulkSalesController::class, 'allInvoice'])->name('salesBulk.allInvoice');
    Route::get('/all/show/{challan_no}', [BulkSalesController::class, 'allInvoiceShow'])->name('salesBulk.allInvoiceShow');
    // By Date
    Route::get('/select-date', [BulkSalesController::class, 'selectDate'])->name('salesBulk.selectDate');
    Route::post('/show/all/challan/by-date', [BulkSalesController::class, 'allInvoiceByDate'])->name('salesBulk.allInvoiceByDate');
    Route::get('/show/all/challan/by-date/{challan_no}', [BulkSalesController::class, 'allInvoiceShowByDate'])->name('salesBulk.allInvoiceShowByDate');


    Route::post('/bulk-sales-repack-unit-challan', [BulkSalesController::class, 'bulkSalesRepackChallan'])->name('salesBulk.bulkSalesRepackChallan');
});



// Send To Repacking
Route::resource('/send-to-repack-unit', SendToRepackingController::class);
Route::get('/send-to-repack-unit/create/{id}', [SendToRepackingController::class, 'createId'])->name('repacking.create');
Route::get('/send-to-repack-unit/show/{supplier_id}/{challan_no}', [SendToRepackingController::class, 'showInvoice'])->name('repacking.show');
Route::get('/send-to-repack-unit/show/{challan_no}', [SendToRepackingController::class, 'destroyInvoice'])->name('repacking.destroy');
Route::get('/send-to-repack-unit/print/challan/{supplier_id}/{invoice_no}', [SendToRepackingController::class, 'printChallan'])->name('repacking.printChallan');

// Send To Production


Route::resource('/send-to-production', SendToProductionController::class);
Route::get('/send-to-production/create/{inv_id}', [SendToProductionController::class, 'createId'])->name('production.create');
Route::get('/send-to-production/show/{supplier_id}/{challan_no}', [SendToProductionController::class, 'showInvoice'])->name('production.show');
Route::get('/send-to-production/show/{challan_no}', [SendToProductionController::class, 'destroyInvoice'])->name('production.destroy');
Route::get('/repack-production-check/{id}', [SendToProductionController::class, 'productionCalShow'])->name('repackingCheck.productionCalShow');

Route::get('/send-to-store/{id}', [SendToProductionController::class, 'productId'])->name('production.productId');

// Route::get('/repack-unit/checked/show/{challan_no}', [RepackUnitController::class, 'showInvoiceAccpeted'])->name('repackingChecked.showInvoiceAccpet');
Route::get('/repack-unit/tracking{', [SendToProductionController::class, 'showInvoiceTracking'])->name('bulkTracking.showInvoice');
Route::post('/repack-unit/on-going/tracking/{id}', [SendToProductionController::class, 'trackingUpdateOnGoing'])->name('bulkTrackingUpdateOnGoing.update');
Route::post('/repack-unit/complete/tracking/{id}', [SendToProductionController::class, 'trackingUpdateComplete'])->name('bulkTrackingUpdateComplete.update');

Route::get('/production-report/select-date', [SendToProductionController::class, 'selectDate'])->name('production.selectDate');
Route::post('/production-report', [SendToProductionController::class, 'report'])->name('production.report');

Route::get('/production-report/delete/{id}', [SendToProductionController::class, 'productionDelete'])->name('production.productionDelete');

// Repack Check and accepted
Route::resource('/repack-check', RepackUnitController::class);
Route::get('/repack-unit/check/show', [RepackUnitController::class, 'showAccpet'])->name('repackingCheck.showAccpet');
Route::get('/repack-unit/check/show/{challan_no}', [RepackUnitController::class, 'showInvoiceAccpet'])->name('repackingCheck.showInvoiceAccpet');


// Production Check and accpted
Route::resource('/production-check', ProductionController::class);
Route::get('/production/check/show', [ProductionController::class, 'showAccpet'])->name('productionCheck.showAccpet');
Route::get('/production/check/show/{challan_no}', [ProductionController::class, 'showInvoiceAccpet'])->name('productionCheck.showInvoiceAccpet');

Route::get('/production/tracking', [ProductionController::class, 'showInvoiceTracking'])->name('productionTracking.showInvoice');

Route::get('/production/checked/show/{challan_no}', [ProductionController::class, 'showInvoiceAccpeted'])->name('productionChecked.showInvoiceAccpet');


// Bulk End ________________________________________________________________________________

// // Equipment Purchase
// Route::resource('/label-purchase', LabelPurchaseController::class);
// Route::get('/label_purchase/create/{id}', [LabelPurchaseController::class, 'createId'])->name('LabelPurchase.create');
// Route::get('/label_purchase/show/{supplier_id}/{challan_no}', [LabelPurchaseController::class, 'showInvoice'])->name('LabelPurchase.show');
// Route::get('/label_purchase/show/{challan_no}', [LabelPurchaseController::class, 'destroyInvoice'])->name('LabelPurchase.destroy');
// // All
// Route::get('/label_purchase/all/show', [LabelPurchaseController::class, 'allInvoice'])->name('LabelPurchase.allInvoice');
// Route::get('/label_purchase/all/show/{challan_no}', [LabelPurchaseController::class, 'allInvoiceShow'])->name('LabelPurchase.allInvoiceShow');
// // By Date
// Route::get('/label_purchase/select-date', [LabelPurchaseController::class, 'selectDate'])->name('LabelPurchase.selectDate');
// Route::post('/label_purchase/show/all/challan/by-date', [LabelPurchaseController::class, 'allInvoiceByDate'])->name('LabelPurchase.allInvoiceByDate');
// Route::get('/label_purchase/show/all/challan/by-date/{challan_no}', [LabelPurchaseController::class, 'allInvoiceShowByDate'])->name('LabelPurchase.allInvoiceShowByDate');

// Route::get('/purchase-bulk/product_Pack_Sizes', [LabelPurchaseController::class, 'productPackSizes'])->name('LabelPurchase.productPackSizes');
// Route::get('/purchase-bulk/get/productSize', [LabelPurchaseController::class, 'productSize'])->name('LabelPurchase.productSize');
// Route::get('/purchase-bulk/get/price', [LabelPurchaseController::class, 'productPrice'])->name('LabelPurchase.invoicePrice');

Route::resource('/label-purchase', LabelPurchaseController::class);
Route::prefix('label-purchase')->controller(LabelPurchaseController::class)->name('labelPurchase.')->group(function () {
    Route::get('/create/{id}', 'createId')->name('create');
    Route::get('/show/{supplier_id}/{challan_no}', 'showInvoice')->name('show');
    Route::get('/destroy/{challan_no}', 'destroyInvoice')->name('destroy');
    // All
    Route::get('/all/show', 'allInvoice')->name('allInvoice');
    Route::get('/all/show/{challan_no}', 'allInvoiceShow')->name('allInvoiceShow');
    // By Date
    Route::get('/select-date', 'selectDate')->name('selectDate');
    Route::post('/show/all/challan/by-date', 'allInvoiceByDate')->name('allInvoiceByDate');
    Route::get('/show/all/challan/by-date/{challan_no}', 'allInvoiceShowByDate')->name('allInvoiceShowByDate');

    Route::get('/product_Pack_Sizes', 'productPackSizes')->name('productPackSizes');
    Route::get('/get/productSize', 'productSize')->name('productSize');
    Route::get('/get/price', 'productPrice')->name('invoicePrice');

    Route::get('/print/challan/{supplier_id}/{challan_no}', 'printChallan')->name('printChallan');
    Route::get('/print/invoice/{supplier_id}/{challan_no}', 'printInvoice')->name('printInvoice');
});


// Send to Repack Unit
Route::resource('/label-send-to-repack-unit', LabelSendToRepackingController::class);
Route::get('/label-send-to-repack-unit/create/{id}', [LabelSendToRepackingController::class, 'createId'])->name('LabelRepacking.create');
Route::get('/label-send-to-repack-unit/show/{supplier_id}/{challan_no}', [LabelSendToRepackingController::class, 'showInvoice'])->name('LabelRepacking.show');
Route::get('/label-send-to-repack-unit/show/{challan_no}', [LabelSendToRepackingController::class, 'destroyInvoice'])->name('LabelRepacking.destroy');

// Sales Start --------------------------------------------------------------------------------------------------------------------
// Sample
Route::resource('/sample-invoive', SalesSampleController::class);
Route::get('/sample/invoice/create/{id}', [SalesSampleController::class, 'createId'])->name('salesSample.create');
// Route::get('/sample/invoice/show-invoive/{customer_id}/{invoice_no}', [SalesSampleController::class, 'showInvoice'])->name('salesSample.show');
// Route::get('/sample/invoice/show-invoive/{invoice_no}', [SalesSampleController::class, 'destroyInvoice'])->name('salesSample.destroy');

// Sample Report
Route::get('/samole-report/select-date', [SalesSampleReportController::class, 'selectDate'])->name('salesSample.selectDate');
Route::post('/samole-report/show/all/challan/by-date', [SalesSampleReportController::class, 'report'])->name('salesSample.report');
Route::get('/samole-report/show/all/challan/by-date/{challan_no}', [SalesSampleReportController::class, 'allInvoiceShowByDate'])->name('salesSample.allInvoiceShowByDate');


Route::get('/sample/invoice/print/challan/{customer_id}/{invoice_no}', [SalesSampleController::class, 'printChallan'])->name('salesSample.printChallan');
Route::get('/sample/invoice/print/invoice/{customer_id}/{invoice_no}', [SalesSampleController::class, 'printInvoice'])->name('salesSample.printInvoice');


// Sales Invoice Cash
Route::resource('/sales-invoice-cash', SalesInvoiceCashController::class);
Route::prefix('sales-of-cash')->group(function () {
    Route::get('/invoice/create/{id}', [SalesInvoiceCashController::class, 'createId'])->name('salesInvoiceCash.Create');
    Route::get('/invoice/eit/{user_id}/{challan_no}', [SalesInvoiceCashController::class, 'edit'])->name('salesInvoiceCash.edit');
    Route::get('/invoice/delete/{id}/{challan_no}', [SalesInvoiceCashController::class, 'delete'])->name('salesInvoiceCash.delete');
    Route::post('/invoice/update', [SalesInvoiceCashController::class, 'update'])->name('salesInvoiceCash.update');
    Route::get('/invoice/cancelInv/{challan_no}', [SalesInvoiceCashController::class, 'cancelInv'])->name('salesInvoiceCash.cancelInv');
    Route::post('/invoice/addUpdate', [SalesInvoiceCashController::class, 'addUpdate'])->name('salesInvoiceCash.addUpdate');
    // Route::get('/invoice/show-invoive/{customer_id}/{invoice_no}', [SalesInvoiceCashController::class, 'showInvoice'])->name('salesInvoiceCash.show');
    // Route::DELETE('/invoice/show-invoive/{invoice_no}', [SalesInvoiceCashController::class, 'destroyInvoice'])->name('salesInvoiceCash.destroy');

    Route::get('/invoice/print/challan/{customer_id}/{invoice_no}', [SalesInvoiceCashController::class, 'printChallan'])->name('salesInvoiceCash.printChallan');
    Route::get('/invoice/print/invoice/{customer_id}/{invoice_no}', [SalesInvoiceCashController::class, 'printInvoice'])->name('salesInvoiceCash.printInvoice');
    Route::get('/sales-invoice/due', [SalesInvoiceCashController::class, 'dueInvoice'])->name('salesInvoice.due');

    // All
    Route::get('/all/show', [SalesInvoiceCashController::class, 'allInvoice'])->name('salesInvoiceCash.allInvoice');
    Route::get('/all/show/{challan_no}', [SalesInvoiceCashController::class, 'allInvoiceShow'])->name('salesInvoiceCash.allInvoiceShow');
    // By Date
    Route::get('/select-date', [SalesInvoiceCashController::class, 'selectDate'])->name('salesInvoiceCash.selectDate');
    Route::post('/show/all/challan/by-date', [SalesInvoiceCashController::class, 'allInvoiceByDate'])->name('salesInvoiceCash.allInvoiceByDate');
    Route::get('/show/all/challan/by-date/{challan_no}', [SalesInvoiceCashController::class, 'allInvoiceShowByDate'])->name('salesInvoiceCash.allInvoiceShowByDate');
});

// Product Purchase
Route::resource('/product-purchase', PurchaseProductController::class);
Route::controller(PurchaseProductController::class)->prefix('/product-purchase')->group(function () {
    Route::get('/invoice/create/{id}', 'createId')->name('purchaseProduct.Create');
    Route::get('/invoice/eit/{user_id}/{challan_no}', 'edit')->name('purchaseProduct.edit');
    Route::get('/invoice/delete/{id}/{challan_no}', 'delete')->name('purchaseProduct.delete');
    Route::post('/invoice/update', 'update')->name('purchaseProduct.update');
    Route::get('/invoice/cancelInv/{challan_no}', 'cancelInv')->name('purchaseProduct.cancelInv');
    Route::post('/invoice/addUpdate', 'addUpdate')->name('purchaseProduct.addUpdate');
    // Route::get('/invoice/show-invoive/{customer_id}/{invoice_no}', 'showInvoice')->name('purchaseProduct.show');
    // Route::DELETE('/invoice/show-invoive/{invoice_no}', 'destroyInvoice')->name('purchaseProduct.destroy');

    // Route::get('/invoice/print/challan/{customer_id}/{invoice_no}', 'printChallan')->name('purchaseProduct.printChallan');
    // Route::get('/invoice/print/invoice/{customer_id}/{invoice_no}', 'printInvoice')->name('purchaseProduct.printInvoice');
    // Route::get('/sales-invoice/due', 'dueInvoice')->name('salesInvoice.due');

    // // All
    // Route::get('/all/show', 'allInvoice')->name('purchaseProduct.allInvoice');
    // Route::get('/all/show/{challan_no}', 'allInvoiceShow')->name('purchaseProduct.allInvoiceShow');
    // // By Date
    // Route::get('/select-date', 'selectDate')->name('purchaseProduct.selectDate');
    // Route::post('/show/all/challan/by-date', 'allInvoiceByDate')->name('purchaseProduct.allInvoiceByDate');
    // Route::get('/show/all/challan/by-date/{challan_no}', 'allInvoiceShowByDate')->name('purchaseProduct.allInvoiceShowByDate');
});

// Sales Stock Report
Route::get('/stock-report', [StockReportController::class, 'index'])->name('stockReport.index');
Route::get('/sales-stock/select-date', [StockReportController::class, 'salesSelectDate'])->name('sales.salesSelectDate');
Route::post('/sales-stock/report', [StockReportController::class, 'salesReport'])->name('stockReport.salesReport');
Route::post('/sample-stock/report', [StockReportController::class, 'sampleReport'])->name('stockReport.sampleReport');
Route::post('/production-stock/report', [StockReportController::class, 'productionReport'])->name('stockReport.productionReport');


// Sales Invoice Cash return
Route::resource('/sales-invoice-cash-return', SalesInvoiceCashReturnController::class);
Route::prefix('sales-of-cash-return')->group(function () {
    Route::get('/create/{id}', [SalesInvoiceCashReturnController::class, 'createId'])->name('salesInvoiceCashReturn.create');
    Route::get('/show-invoive/{customer_id}/{invoice_no}', [SalesInvoiceCashReturnController::class, 'showInvoice'])->name('salesInvoiceCashReturn.show');
    Route::get('/show-invoive/{invoice_no}', [SalesInvoiceCashReturnController::class, 'destroyInvoice'])->name('salesInvoiceCashReturn.destroy');

    // Route::get('autocomplete', [SalesInvoiceCashController::class, 'autocomplete'])->name('autocomplete');
    // Route::get('dueInvoiceSearch', ['as'=>'dueInvoiceSearch','uses'=> 'App\Http\Controllers\Backend\SalesInvoiceCashController@dueInvoiceSearch']);

    Route::get('/print/challan/{customer_id}/{invoice_no}', [SalesInvoiceCashReturnController::class, 'printChallan'])->name('salesInvoiceCashReturn.printChallan');
    Route::get('/print/invoice/{customer_id}/{invoice_no}', [SalesInvoiceCashReturnController::class, 'printInvoice'])->name('salesInvoiceCashReturn.printInvoice');
    // Route::get('/sales-invoice-return/due', [SalesInvoiceCashReturnController::class, 'dueInvoice'])->name('salesInvoice.due');

    // All
    Route::get('/all/show', [SalesInvoiceCashReturnController::class, 'allInvoice'])->name('salesInvoiceCashReturn.allInvoice');
    Route::get('/all/show/{challan_no}', [SalesInvoiceCashReturnController::class, 'allInvoiceShow'])->name('salesInvoiceCashReturn.allInvoiceShow');
    // By Date
    Route::get('/select-date', [SalesInvoiceCashReturnController::class, 'selectDate'])->name('salesInvoiceCashReturn.selectDate');
    Route::post('/show/all/challan/by-date', [SalesInvoiceCashReturnController::class, 'allInvoiceByDate'])->name('salesInvoiceCashReturn.allInvoiceByDate');
    Route::get('/show/all/challan/by-date/{challan_no}', [SalesInvoiceCashReturnController::class, 'allInvoiceShowByDate'])->name('salesInvoiceCashReturn.allInvoiceShowByDate');
});

// // Sales Statement
Route::get('/sales-statement/select-date', [SalesStatementController::class, 'selectDate'])->name('salesStatement.selectDate');
Route::get('/sales-statement/show-invoice', [SalesStatementController::class, 'report'])->name('salesStatement.report');

// Sales End --------------------------------------------------------------------------------------------------------------------

// Author Ledger Book
Route::get('/author-ledger-book', [AuthorLedgerBookController::class, 'index'])->name('authorLedgerBook.index');
Route::get('/author-ledger-book/select-date/{user_id}', [AuthorLedgerBookController::class, 'selectDate'])->name('authorLedgerBook.selectDate');
Route::get('/author-ledger-book/show-invoice', [AuthorLedgerBookController::class, 'showInvoice'])->name('authorLedgerBook.report');
Route::get('/author-ledger-book/show-invoice-all/{user_id}', [AuthorLedgerBookController::class, 'showInvoiceAll'])->name('authorLedgerBook.reportAll');


// Purchase Ledger Book
Route::get('/purchase-ledger-book', [PurchaseLedgerBookController::class, 'index'])->name('purchaseLedgerBook.index');
// Route::post('/purchase-ledger-book/show-invoice/{id}', [PurchaseLedgerBookController::class, 'ledgerUpdate'])->name('purchaseLedgerBook.ledgerUpdate');
Route::get('/purchase-ledger-book/select-date/{supplier_id}', [PurchaseLedgerBookController::class, 'ledgerBookSelectDate'])->name('purchaseLedgerBook.SelectDate');
Route::get('/purchase-ledger-book/show-invoice', [PurchaseLedgerBookController::class, 'showInvoice'])->name('purchaseLedgerBook.showInvoice');
Route::get('/purchase-ledger-book/show-invoice-all/{supplier_id}', [PurchaseLedgerBookController::class, 'indAllLedgerBook'])->name('purchaseLedgerBook.indAllLedgerBook');

Route::get('/purchase-ledger-book/all', [PurchaseLedgerBookController::class, 'allShowInvoice'])->name('purchaseLedgerBook.allShowInvoice');

// Product Purchase Ledger Book
Route::controller(ProPurchaseLedgerBookController::class)->prefix('/product-purchase-ledger-book')->group(function (){
    Route::get('', 'index')->name('proPurchaseLedgerBook.index');
    // Route::post('/show-invoice/{id}', 'ledgerUpdate')->name('proPurchaseLedgerBook.ledgerUpdate');
    Route::get('/select-date/{supplier_id}', 'ledgerBookSelectDate')->name('proPurchaseLedgerBook.SelectDate');
    Route::get('/show-invoice', 'showInvoice')->name('proPurchaseLedgerBook.showInvoice');
    Route::get('/show-invoice-all/{supplier_id}', 'indAllLedgerBook')->name('proPurchaseLedgerBook.indAllLedgerBook');
    Route::get('/all', 'allShowInvoice')->name('proPurchaseLedgerBook.allShowInvoice');

});

// Sales Ledger Book
Route::controller(SalesLedgerBookController::class)->prefix('sales-ledger-book')->name('salesLedgerBook.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/select-date/{customer_id}', 'ledgerBookSelectDate')->name('SelectDate');
    Route::get('/show-invoice', 'indDateLedgerBook')->name('indDateLedgerBook');
    Route::get('/show-invoice-all/{customer_id}', 'indAllLedgerBook')->name('indAllLedgerBook');
    Route::get('/all', 'allShowInvoice')->name('allShowInvoice');
    Route::get('/edit/{id}', 'ledgerReportEdit')->name('ledgerReportEdit');
    Route::post('/update/{id}', 'ledgerReportUpdate')->name('ledgerReportUpdate');
});



// Purchase Ledger Book Download
Route::get('/purchase-ledger-book/show-invoice/pdf/{supplier_id}/{form_date}/{to_date}', [PurchaseLedgerBookController::class, 'showInvoicePdf'])->name('purchaseLedgerBook.showInvoicePdf');
Route::get('/purchase-ledger-book/show-invoice-all/pdf/{supplier_id}', [PurchaseLedgerBookController::class, 'showInvoiceAllPdf'])->name('purchaseLedgerBook.showInvoiceAllPdf');

// Purchase Statement
Route::get('/purchase-statement/select-date', [PurchaseStatementController::class, 'selectDate'])->name('purchaseStatement.selectDate');
Route::get('/purchase-statement/show-invoice', [PurchaseStatementController::class, 'report'])->name('purchaseStatement.report');

Route::get('/repack-stock', [StockController::class, 'repackStockIndex'])->name('repackStock.index');
Route::get('/repack-stock/edit/{id}', [StockController::class, 'repackStockEdit'])->name('repackStock.edit');
Route::post('/repack-stock/update/{id}', [StockController::class, 'repackStockUpdate'])->name('repackStock.update');

Route::get('/label-stock', [StockController::class, 'labelStockIndex'])->name('labelStock.index');
Route::get('/label-stock/edit/{id}', [StockController::class, 'labelStockEdit'])->name('labelStock.edit');
Route::post('/label-stock/update/{id}', [StockController::class, 'labelStockUpdate'])->name('labelStock.update');

Route::get('/Product-stock', [ProductStockController::class, 'index'])->name('store.index');
Route::get('/Product-stock/productSize', [ProductStockController::class, 'productSize'])->name('ProductStock.productSize');
Route::get('/Product-stock/get/price', [ProductStockController::class, 'productPrice'])->name('ProductStock.invoicePrice');
// Route::get('/autocomplete', [ProductStockController::class, 'autocomplete'])->name('ProductStock.autocomplete');
// Route::get('/Product-stock/productSearch', ['as'=>'Product-stock/productSearch','uses'=> 'App\Http\Controllers\Backend\ProductStockController@productSearch']);

Route::prefix('report')->group(function () {
    Route::prefix('sales-and-stock')->group(function () {
        Route::get('/select-date', [SalesAndStockController::class, 'selectDate'])->name('report.salesAndStock.selectDate');
        Route::post('/sales-report', [SalesAndStockController::class, 'salesReport'])->name('report.salesAndStock.salesReport');
        Route::post('/sales-return-report', [SalesAndStockController::class, 'salesReturnReport'])->name('report.salesAndStock.salesReturnReport');
        Route::post('/sample-report', [SalesAndStockController::class, 'sampleReport'])->name('report.salesAndStock.sampleReport');
        Route::post('/production-report', [SalesAndStockController::class, 'productionReport'])->name('report.salesAndStock.productionReport');
    });
    Route::prefix('bulk')->group(function () {
        Route::get('/select-date', [BulkController::class, 'selectDate'])->name('report.bulk.selectDate');
        Route::post('/sales', [BulkController::class, 'sales'])->name('report.bulk.sales');
        Route::post('/purchase', [BulkController::class, 'purchase'])->name('report.bulk.purchase');
        Route::post('/send-to-repack-unit', [BulkController::class, 'sendToRepackUnit'])->name('report.bulk.sendToRepackUnit');
    });
});
