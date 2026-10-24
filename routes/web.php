<?php



use App\Http\Controllers\CashAccountController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\CashTransferController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DailyBookController;
use App\Http\Controllers\EstimateSaleController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OpenPayableController;
use App\Http\Controllers\OpenReceivableController;
use App\Http\Controllers\OpenStockController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\ReceivedController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;



//routing of application
Route::redirect("/register","/login");
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::resource('/user', UserController::class)->middleware('auth');


Route::resource('/cashTransfer', CashTransferController::class)->middleware('auth');
Route::resource('/cash', CashController::class)->middleware('auth');
Route::resource('/cashAccount', CashAccountController::class)->middleware('auth');
Route::get('/accountCash', [CashAccountController::class, 'account'])->middleware('auth');
Route::get('/getcashAccount',  [CashAccountController::class, "getcashAccount"])->middleware('auth');

Route::resource('/customer', CustomerController::class)->middleware('auth');
Route::get('/getCustomer',  [CustomerController::class, "getCustomer"])->middleware('auth');
Route::get('/accountCustomer', [CustomerController::class, 'account'])->middleware('auth');
Route::get('/unpaidCustomer', [CustomerController::class, 'unpaidCustomer'])->middleware('auth');
Route::get('/customerPrevBalance/{id}', [CustomerController::class, 'customerBalance'])->middleware('auth');



Route::resource('/supplier', SupplierController::class)->middleware('auth');
Route::get('/getSupplier',  [SupplierController::class, "getSupplier"])->middleware('auth');
Route::get('/accountSupplier', [SupplierController::class, 'account'])->middleware('auth');

Route::group(['prefix' => 'account/'], function ($id) {
    Route::get('/supplier/{id}', [SupplierController::class, 'accountShow']);
    Route::get('/customer/{id}', [CustomerController::class, 'accountShow']);
    Route::get('/cashAccount/{id}', [CashAccountController::class, 'accountShow']);
});


Route::resource('/item',  ItemController::class)->middleware('auth');
Route::get('/getItem',  [ItemController::class, "getItem"])->middleware('auth');
Route::get('/getItemByName',  [ItemController::class, "getItemByName"])->middleware('auth');
Route::get('/getItemsByQty',  [ItemController::class, "getItemsByQty"])->middleware('auth');

Route::resource('/stock',  StockController::class)->middleware('auth');
Route::get('/getStock',  [StockController::class, "getStock"])->middleware('auth');
Route::get('/currentStock',  [StockController::class, 'currentStock'])->middleware('auth');
Route::resource('/openStock',  OpenStockController::class)->middleware('auth');


Route::group(['prefix' => 'currentStock'], function ($id) {
    Route::get('/stock/{id}', [StockController::class, 'inStock']);
    Route::get('/minusStock', [StockController::class, 'minusStock']);
});


Route::resource('/stockTransfer',  StockTransferController::class)->middleware('auth');
Route::resource('/cashAccount',  CashAccountController::class)->middleware('auth');
Route::resource('/currency',  CurrencyController::class)->middleware('auth');
Route::get('/getCurrency',  [CurrencyController::class, 'getCurrency'])->middleware('auth');


Route::resource('/estimateSale',  EstimateSaleController::class)->middleware('auth');
Route::get('/estimatesaleview',  [EstimateSaleController::class, 'saleView'])->middleware('auth');
Route::get('/estimateSalePrint',  [EstimateSaleController::class, 'salePrint'])->middleware('auth');
Route::get('/estimateGetSaleBill',  [EstimateSaleController::class, 'getSaleBill'])->middleware('auth');
Route::get('/estimatePrintSaleBill',  [EstimateSaleController::class, 'printSaleBill'])->middleware('auth');

Route::resource('/sale',  SaleController::class)->middleware('auth');
Route::get('/saleview',  [SaleController::class, 'saleView'])->middleware('auth');
Route::get('/salePrint',  [SaleController::class, 'salePrint'])->middleware('auth');
Route::get('/getSaleBill',  [SaleController::class, 'getSaleBill'])->middleware('auth');
Route::get('/printSaleBill',  [SaleController::class, 'printSaleBill'])->middleware('auth');


Route::resource('/purchase',  PurchaseController::class)->middleware('auth');
Route::get('/purchaseview',  [PurchaseController::class, 'purchaseView'])->middleware('auth');
Route::get('/purchasePrint',  [PurchaseController::class, 'purchasePrint'])->middleware('auth');
Route::get('/getPurchaseBill',  [PurchaseController::class, 'getPurchaseBill'])->middleware('auth');

Route::resource('/purchaseReturn',  PurchaseReturnController::class)->middleware('auth');
Route::get('/purchasereturnview',  [PurchaseReturnController::class, 'purchaseReturnView'])->middleware('auth');
Route::get('/getPurchaseReturn',  [PurchaseReturnController::class, 'getPurchaseReturn'])->middleware('auth');
Route::get('/purchaseReturnPrint',  [PurchaseReturnController::class, 'purchasePrint'])->middleware('auth');

Route::resource('/payment',  PaymentController::class)->middleware('auth');
Route::resource('/openPayable', OpenPayableController::class)->middleware('auth');


Route::resource('/saleReturn',  SaleReturnController::class)->middleware('auth');
Route::get('/salereturnview',  [SaleReturnController::class, 'returnView'])->middleware('auth');
Route::get('/getSaleReturn',  [SaleReturnController::class, 'getSaleReturn'])->middleware('auth');
Route::get('/saleReturnPrint',  [SaleReturnController::class, 'saleReturnPrint'])->middleware('auth');

Route::resource('/openReceivable', OpenReceivableController::class)->middleware('auth');
Route::resource('/received',  ReceivedController::class)->middleware('auth');

Route::resource('/expenseCategory', ExpenseCategoryController::class)->middleware('auth');
Route::resource('/expense',  ExpenseController::class)->middleware('auth');
Route::get('/getExpenseCategory',  [ExpenseCategoryController::class, 'getExpenseCategory'])->middleware('auth');
Route::resource('/setting',  SettingController::class)->middleware('auth');
Route::get('/clean',  [SettingController::class, 'clean'])->middleware('auth');
Route::post('/cleanRun',  [SettingController::class, 'cleanRun'])->middleware('auth');

Route::resource('/dailyBook', DailyBookController::class)->middleware('auth');
Route::resource('/unit', UnitController::class)->middleware('auth');


Route::group(['prefix' => 'report'], function ($id) {
    Route::get('/income', [ReportController::class, 'income']);
    Route::get('/purchase', [ReportController::class, 'purchase']);
    Route::get('/purchaseReturn', [ReportController::class, 'purchaseReturn']);
    Route::get('/sale', [ReportController::class, 'sale']);
    Route::get('/saleReturn', [ReportController::class, 'saleReturn']);
    Route::get('/payment', [ReportController::class, 'payment']);
    Route::get('/received', [ReportController::class, 'received']);
    Route::get('/expense', [ReportController::class, 'expense']);
    Route::get('/summery', [ReportController::class, 'summery']);
    Route::get('/cash', [ReportController::class, 'cash']);
    Route::get('/item', [ReportController::class, 'item']);
    Route::get('/asset', [ReportController::class, 'asset']);
    Route::get('/expire', [ReportController::class, 'expire']);
});
Route::group(['prefix' => 'ajax/report'], function ($id) {
    Route::get('/income', [ReportController::class, 'incomeShow']);
    Route::get('/purchase', [ReportController::class, 'purchaseShow']);
    Route::get('/purchaseReturn', [ReportController::class, 'purchaseReturnShow']);
    Route::get('/sale', [ReportController::class, 'saleShow']);
    Route::get('/saleReturn', [ReportController::class, 'saleReturnShow']);
    Route::get('/saleReturn', [ReportController::class, 'saleReturnShow']);
    Route::get('/payment', [ReportController::class, 'paymentShow']);
    Route::get('/received', [ReportController::class, 'receivedShow']);
    Route::get('/expense', [ReportController::class, 'expenseShow']);
    Route::get('/summery', [ReportController::class, 'summeryShow']);
    Route::get('/itemPurchase', [ReportController::class, 'itemPurchaseShow']);
    Route::get('/itemSale', [ReportController::class, 'itemSaleShow']);
    Route::get('/cash', [ReportController::class, 'cashShow']);
    Route::get('/dailyBook', [DailyBookController::class, 'dailyBookShow']);
    Route::get('/expire', [ReportController::class, 'expireShow']);
});
Route::get('language/{lang}', function ($lang) {
    $user = User::find(Auth::id());
    $user->language = $lang;
    $user->save();
    return redirect()->back();
})->name("language");

Route::get('/backup', [BackupController::class, 'showBackupForm'])->name('backup.form'); // Show form
Route::post('/backup', [BackupController::class, 'createBackup'])->name('backup'); // Create backup
Route::get('/backup/restore', [BackupController::class, 'showRestoreForm'])->name('backup.restore.form'); // Show restore form
Route::post('/backup/restore', [BackupController::class, 'restoreBackup'])->name('backup.restore'); // Restore backup
