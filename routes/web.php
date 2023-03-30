<?php

use Illuminate\Support\Facades\Cookie;
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

Route::get('/', 'HomeController@dashboard');
Route::get('/forgot-password', 'Auth\LoginController@forgot_password');
Route::get('/register', 'Auth\LoginController@register');
Route::get('/login', 'Auth\LoginController@index');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/proseslogin', 'Auth\LoginController@login')->name('proseslogin');
Route::post('/register', 'Auth\LoginController@proses_registrasi')->name('proses-registrasi');
Route::get('/register/success', 'Auth\LoginController@register_sukses');
Route::get('/confirm/{id}', 'Auth\LoginController@proses_konfirmasi');
Route::get('/product/range-price/{h1}/{h2}', 'ProductController@price_range');
Route::get('/product/sub-category/{id}', 'ProductController@sub_category');
Route::get('/product/category/{id}', 'ProductController@category');
Route::get('/product/sub-sub-category/{id}', 'ProductController@sub_sub_category');
Route::get('/display-product', 'ProductController@index');
Route::get('/faq', function () {
    $id = "30";
    $user = "Andi Alif";
    $trans_id = "TR-16529122022";
    $menu = "Mitsal";
    $detail = "Order di proses oleh $user";
    $status = 2;
    $stokis = "SLS07";
    $hsl = update_status_transaksi_branch($id, $status, null, $user, $menu, $detail, $stokis);
    dd($hsl);
});

Route::get('/panduan', function () {
    response('Panduan page');
});

Route::get('/conntact-us', function () {
    response('Contact Us page');
});


Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
Route::get('/pages/{slug}', 'PagesController@pages');

Route::get('/search', 'SearchController@index')->name('findproduk');
Route::get('/defaultProduk/{id}', 'SearchController@defaultproduk');
Route::get('/detil-produk/{slug}', 'ProductController@detilproduk');
Route::get('/detil-produk/{slug}/{reff}', 'ProductController@detilproduk');
Route::get('/produk/{id}', 'ProductController@produk');
Route::get('/categoryproduct/{id}/{id2}/{id3}/{name}', 'ProductController@categoryproduct');
Route::get('/filterproduct/{id}', 'SearchController@filter');
Route::get('/bukti-pembayaran/{id}', 'TransactionController@foto_bukti_pembayaran');

Route::group(['middleware' => 'isCustomerLogin'], function () {
    Route::get('/konfirmasi-pembayaran/{id}', 'MyorderController@konfirmasi_pembayaran');
    Route::get('/kirim-bukti-pembayaran/{id}', 'MyorderController@kirim_bukti_pembayaran');
    Route::post('/kirim-bukti-pembayaran', 'MyorderController@proses_kirim_bukti_pembayaran')->name('kirim_bukti_pembayaran');

    Route::get('/cart', 'CartController@index');
    Route::post('/add-cart', 'CartController@create')->name('add-cart');
    Route::get('/getqty/find/{id}', 'CartController@find');
    Route::post('/updateqty', 'CartController@updateqty')->name('update-qty');
    Route::get('/deletecart/{id}', 'CartController@delete');
    Route::post('/add-dummy', 'CartController@dummy')->name('add-dummy');
    Route::post('/delete-dummy', 'CartController@deletedummy')->name('delete-dummy');
    Route::get('/checkout-finish/{id}', 'CheckoutController@checkout_finish');
    Route::get('/detil-transaksi/{id}', 'TransactionController@detil_transaksi');

    Route::get('/checkout', 'CheckoutController@index');
    Route::get('/kota/{id}', 'CheckoutController@get_city');
    Route::get('/origin={city_origin}&destination={city_destination}&destinationType={destinationType}&weight={weight}&courier={courier}', 'CheckoutController@get_ongkir');
    Route::post('/changepick', 'CheckoutController@changepick')->name('change-pick');

    Route::get('/dashboard', 'UsersController@index');
    Route::post('/updateavatar', 'UsersController@updateavatar')->name('update-avatar');
    Route::post('/addcontact', 'UsersController@addcontact')->name('add-contact');
    Route::post('/updatecontact', 'UsersController@updatecontact')->name('update-contact');
    Route::get('/deletecontact/{id}', 'UsersController@delete');
    Route::post('/updatestatus', 'UsersController@updatestatus')->name('update-status');
    Route::get('/contact/find/{id}', 'UsersController@find');

    Route::get('/city/find/{id}', 'HomeController@city_list');
    Route::get('/subdistrict/find/{id}', 'HomeController@subdistrict_list');

    Route::get('/test/payment', 'CheckoutController@bankTransferCharge');
    Route::post('/transaction/payment', 'CheckoutController@transaction')->name('add-transaction');

    Route::get('/myorder', 'MyorderController@index');
    Route::get('/cekresi/{kurir}/{resi}', 'MyorderController@cekresi')->name('cekresi');
    Route::post('/cekresi', 'MyorderController@cekresi')->name('cekresi');
    Route::get('/tracking', 'MyorderController@tracking');
});
Route::group(['middleware' => 'isBackEndLogin'], function () {

    Route::get('/backend/dashboard', 'Backend\DashboardController@index');
    Route::get('/backend/detil-transaksi/{id}', 'TransactionController@detil_transaksi_backend');
    Route::get('/backend/profile', 'Backend\profileController@index');
    Route::post('/backend/profile', 'Backend\profileController@update')->name('update_profile_admin');

    Route::get('/banner/backend', 'Backend\BannerController@index');
    Route::get('/backend/banner/', 'Backend\BannerController@index');
    Route::post('/backend/createbanner', 'Backend\BannerController@create')->name('create-banner');
    Route::get('/backend/banner/delete/{id}', 'Backend\BannerController@delete')->name('delete-banner');
    Route::get('/backend/banner/find/{id}', 'Backend\BannerController@find');
    Route::post('/backend/updatebanner', 'Backend\BannerController@update')->name('update-banner');
    Route::get('/backend/sub-category/{id}', 'Backend\ProductController@sub_category');
    Route::get('/backend/sub-sub-category/{id}', 'Backend\ProductController@sub_sub_category');
    Route::get('/backend/transaction/proses/{id}', 'TransactionController@proses');
    Route::get('/backend/transaction/kemas/{id}', 'TransactionController@kemas');
    Route::get('/backend/transaction/kirim/{id}', 'TransactionController@kirim');
    Route::get('/backend/transaction/selesai/{id}', 'TransactionController@selesai');
    Route::get('/backend/transaction/batal/{id}', 'TransactionController@batal');
    Route::get('/backend/transaction/bayar/{id}', 'TransactionController@dibayar');
    Route::post('/backend/transaction/kirim', 'TransactionController@proses_kirim')->name('proses-kirim');
    Route::post('/backend/transaction/kirim', 'TransactionController@proses_kirim')->name('proses-kirim');
    Route::post('/backend/bank/save', 'Backend\bankController@create')->name('save_bank_backend');
    Route::post('/backend/bank/update', 'Backend\bankController@update')->name('update_bank_backend');
    Route::get('/backend/bank/delete/{id}', 'Backend\bankController@delete')->name('delete_bank_backend');
    Route::get('/backend/bank/find/{id}', 'Backend\bankController@find');
    Route::get('/backend/bank', 'Backend\bankController@index');
    Route::post('/backend/photo-profile', 'Backend\profileController@proses_upload_foto')->name('upload_foto_backend');
    Route::get('/backend/photo-profile', 'Backend\profileController@upload_foto')->name('upload_foto_profile');
    Route::get('/backend/admin', 'Backend\adminController@index');
    Route::post('/backend/admin/save', 'Backend\adminController@create')->name('save_admin_backend');
    Route::post('/backend/admin/update', 'Backend\adminController@update')->name('update_admin_backend');
    Route::get('/backend/admin/delete/{id}', 'Backend\adminController@delete')->name('delete_admin_backend');
    Route::get('/backend/admin/find/{id}', 'Backend\adminController@find');
    Route::post('/backend/change_password/update', 'Backend\adminController@proses_ubah_password')->name('proses_ubah_password_backend');

    Route::get('/backend/cekresi/{kurir}/{resi}', 'MyorderController@cekresi_backend');
    Route::get('/backend/transaction/log/{id}', 'MyorderController@cek_log_transaction');

    Route::get('/product/backend', 'Backend\ProductController@index');
    Route::get('/backend/product', 'Backend\ProductController@index');
    Route::post('/backend/createproduct', 'Backend\ProductController@create')->name('create-product');
    Route::get('/backend/product/delete/{id}', 'Backend\ProductController@delete')->name('delete-product');
    Route::get('/backend/product/find/{id}', 'Backend\ProductController@find');
    Route::get('/backend/detil-produk/{slug}', 'Backend\ProductController@detil_produk');
    Route::get('/backend/produk', 'Backend\ProductController@index');


    Route::post('/backend/updateproduct', 'Backend\ProductController@update')->name('update-product');

    Route::get('/backend/category', 'Backend\CategoryController@index');
    Route::post('/backend/createcategory', 'Backend\CategoryController@create')->name('create-category');
    Route::get('/backend/category/delete/{id}', 'Backend\CategoryController@delete')->name('delete-category');
    Route::get('/backend/category/find/{id}', 'Backend\CategoryController@find');
    Route::post('/backend/updatecategory', 'Backend\CategoryController@update')->name('update-category');
    Route::get('/backend/satuan', 'Backend\SatuanController@index');
    Route::post('/backend/satuan', 'Backend\SatuanController@create')->name('create-satuan');
    Route::get('/backend/satuan/delete/{id}', 'Backend\SatuanController@delete')->name('delete-satuan');
    Route::get('/backend/satuan/find/{id}', 'Backend\SatuanController@find');
    Route::post('/backend/satuan/update', 'Backend\SatuanController@update')->name('update-satuan');
    Route::get('/backend/pages', 'Backend\PagesController@index');
    Route::post('/backend/pages/create', 'Backend\PagesController@create')->name('create-pages');
    Route::get('/backend/pages/delete/{id}', 'Backend\PagesController@delete')->name('delete-pages');
    Route::get('/backend/pages/find/{id}', 'Backend\PagesController@find');
    Route::post('/backend/pages/update', 'Backend\PagesController@update')->name('update-pages');
    Route::get('/backend/branch', 'Backend\BranchController@index');
    Route::post('/backend/branch', 'Backend\BranchController@create')->name('create-branch');
    Route::post('/backend/branch/update', 'Backend\BranchController@update')->name('update-branch');
    Route::post('/backend/branch/setpass', 'Backend\BranchController@set_password')->name('update-branch-password');

    Route::get('/backend/branch/delete/{id}', 'Backend\BranchController@delete')->name('delete-branch');
    Route::get('/backend/branch/find/{id}', 'Backend\BranchController@find');


    Route::get('/backend/subsubcategory', 'Backend\SubSubCategoryController@index');
    Route::post('/backend/createsubsubcategory', 'Backend\SubSubCategoryController@create')->name('create-subsubcategory');
    Route::get('/backend/subsubcategory/delete/{id}', 'Backend\SubSubCategoryController@delete')->name('delete-subsubcategory');
    Route::get('/backend/subsubcategory/find/{id}', 'Backend\SubSubCategoryController@find');
    Route::post('/backend/updatesubsubcategory', 'Backend\SubSubCategoryController@update')->name('update-subsubcategory');
    Route::post('/backend/createsubcategory', 'Backend\SubCategoryController@create')->name('create-subcategory');

    Route::get('/backend/product/subcategory/', 'Backend\SubCategoryController@index');
    Route::get('/backend/subcategory/delete/{id}', 'Backend\SubCategoryController@delete')->name('delete-subcategory');
    Route::get('/backend/subcategory/find/{id}', 'Backend\SubCategoryController@find');
    Route::post('/backend/updatesubcategory', 'Backend\SubCategoryController@update')->name('update-subcategory');

    Route::get('/backend/product/display', 'Backend\DisplayController@index');
    Route::post('/backend/createdisplay', 'Backend\DisplayController@create')->name('create-display');
    Route::get('/backend/display/delete/{id}', 'Backend\DisplayController@delete')->name('delete-display');
    Route::get('/backend/display/find/{id}', 'Backend\DisplayController@find');
    Route::post('/backend/updatedisplay', 'Backend\DisplayController@update')->name('update-display');
    route::get('/backend/moota/cek-mutasi/{tg1}', 'MootaController@cek_mutasi');
    Route::get('/backend/transaction/confirmasi-pembayaran/{id}', 'MyorderController@konfirmasi_pembayaran_backend');
    Route::get('/backend/city/{id}', 'Backend\BranchController@get_city');
    Route::get('/backend/subdistrict/{id}', 'Backend\BranchController@get_subdistrict');
});

Route::group(['middleware' => 'isBranchLogin'], function () {
    Route::get('/branch/dashboard', 'Branch\LoginController@dashboard');
    Route::get('/branch/produk', 'Branch\TransactionController@produk');
    Route::get('/branch/cekresi/{kurir}/{resi}', 'MyorderController@cekresi_branch');
    Route::get('/branch/detil-transaksi/{id}', 'Branch\TransactionController@detil_transaksi');
    Route::get('/branch/detil-produk/{slug}', 'Branch\TransactionController@detil_produk');

    Route::get('/branch/transaction/proses/{id}', 'Branch\TransactionController@proses');
    Route::get('/branch/transaction/kemas/{id}', 'Branch\TransactionController@kemas');
    Route::get('/branch/transaction/kirim/{id}', 'Branch\TransactionController@kirim');
    Route::get('/branch/transaction/selesai/{id}', 'Branch\TransactionController@selesai');
    Route::get('/branch/transaction/batal/{id}', 'Branch\TransactionController@batal');
    Route::get('/branch/transaction/bayar/{id}', 'Branch\TransactionController@dibayar');
    Route::post('/branch/transaction/kirim', 'Branch\TransactionController@proses_kirim')->name('branch-proses-kirim');
    Route::post('/branch/transaction/kirim', 'Branch\TransactionController@proses_kirim')->name('branch-proses-kirim');
    Route::get('/branch/transaction/selesai/{id}', 'Branch\TransactionController@selesai');
    Route::get('/branch/transaction', 'Branch\TransactionController@daftar_transaction');
    Route::get('/branch/transaction/by_date', 'Branch\TransactionController@transaction_by_date');
    Route::post('/branch/transaction/by_date', 'Branch\TransactionController@process_transaction_by_date')->name('process-transaction-by-date');
    Route::get('/branch/transaction/by_month', 'Branch\TransactionController@transaction_by_month');
    Route::post('/branch/transaction/by_month', 'Branch\TransactionController@process_transaction_by_month')->name('process-transaction-by-month');
    Route::get('/branch/transaction/by_year', 'Branch\TransactionController@transaction_by_year');
    Route::post('/branch/transaction/by_year', 'Branch\TransactionController@process_transaction_by_year')->name('process-transaction-by-year');
});
Route::get('/branch/login', 'Branch\LoginController@index');
Route::get('/branch/logout', 'Branch\LoginController@logout');
Route::post('/prosesloginbranch', 'Branch\LoginController@login')->name('prosesloginbranch');
Route::get('/backend/transaction/{id}', 'TransactionController@transaction');

Route::get('/backend/login', 'Backend\LoginController@index');
Route::get('/backend/logout', 'Backend\LoginController@logout');
Route::post('/prosesloginbackend', 'Backend\LoginController@login')->name('prosesloginbackend');
Route::get('/logoutbackend', 'Backend\LoginController@logout');

Route::get('/api/transaction/update-status/', 'ApiController@update_status');
//Route::post('/api/transaction/update-status', 'ApiController@update_status');
Route::get('/api/transaction/{reff}', 'ApiController@transaction_for_refferal');
Route::get('/api/transaction/', 'ApiController@transaction_for_refferal');
Route::get('/api/status-transaction/', 'ApiController@status_transaction_for_refferal');
Route::get('/api/snw/status-transaction/', 'ApiController@status_transaction');
Route::get('/api/detil-transaction/', 'ApiController@detil_transaction_for_refferal');
Route::get('/api/customer/{reff}', 'ApiController@customer_for_refferal');
Route::get('/api/customer/', 'ApiController@customer_for_refferal');
Route::get('/api/bank/{id}', 'ApiController@bank_for_refferal');
Route::get('/api/bank', 'ApiController@bank_for_refferal');
Route::get('/api/mitsal/detail_transaction', 'ApiController@detil_transaksi');


Route::post('/webhook', 'WebhookController@index');

Route::get('/{id}', 'HomeController@replika');
Route::get('/moota/test', 'MootaController@test');
Route::get('/moota/get-mutation', 'MootaController@get_mutation');
Route::get('/moota/getprofil', 'MootaController@getProfile');
route::get('/moota/get-mutation-by-amount/{amount}/{tgl}', 'MootaController@get_mutation_by_amount');
route::get('/moota/get-mutation-by-date/{tg1}/{tg2}', 'MootaController@get_mutation_by_date');
