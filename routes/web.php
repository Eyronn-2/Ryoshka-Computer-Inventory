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

Route::get('/', function () {
	return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('dashboard', function () {
	return view('layouts.master');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('categories', 'CategoryController');
	Route::get('/apiCategories', 'CategoryController@apiCategories')->name('api.categories');
	Route::get('/api/archived-categories', 'CategoryController@apiArchivedCategories');
	Route::post('/categories/unarchive/{id}', 'CategoryController@unarchive');
	Route::get('/exportCategoriesAll', 'CategoryController@exportCategoriesAll')->name('exportPDF.categoriesAll');
	Route::get('/exportCategoriesAllExcel', 'CategoryController@exportExcel')->name('exportExcel.categoriesAll');

	Route::resource('customers', 'CustomerController');
	Route::get('/apiCustomers', 'CustomerController@apiCustomers')->name('api.customers');
	Route::get('/api/archived-customers', 'CustomerController@apiArchivedCustomers');
	Route::post('/customers/unarchive/{id}', 'CustomerController@unarchive');
	Route::post('/importCustomers', 'CustomerController@ImportExcel')->name('import.customers');
	Route::get('/exportCustomersAll', 'CustomerController@exportCustomersAll')->name('exportPDF.customersAll');
	Route::get('/exportCustomersAllExcel', 'CustomerController@exportExcel')->name('exportExcel.customersAll');

	Route::resource('sales', 'SaleController');
	Route::get('/apiSales', 'SaleController@apiSales')->name('api.sales');
	Route::post('/importSales', 'SaleController@ImportExcel')->name('import.sales');
	Route::get('/exportSalesAll', 'SaleController@exportSalesAll')->name('exportPDF.salesAll');
	Route::get('/exportSalesAllExcel', 'SaleController@exportExcel')->name('exportExcel.salesAll');

	Route::resource('suppliers', 'SupplierController');
	Route::get('/apiSuppliers', 'SupplierController@apiSuppliers')->name('api.suppliers');
	Route::post('/importSuppliers', 'SupplierController@ImportExcel')->name('import.suppliers');
	Route::get('/exportSupplierssAll', 'SupplierController@exportSuppliersAll')->name('exportPDF.suppliersAll');
	Route::get('/exportSuppliersAllExcel', 'SupplierController@exportExcel')->name('exportExcel.suppliersAll');
	Route::get('api/archived-suppliers', 'SupplierController@apiArchivedSuppliers');
	Route::post('suppliers/unarchive/{id}', 'SupplierController@unarchive');

	Route::resource('products', 'ProductController');
	Route::get('/apiProducts', 'ProductController@apiProducts')->name('api.products');
	Route::get('/api/archived-products', 'ProductController@apiArchivedProducts');
	Route::post('/products/unarchive/{id}', 'ProductController@unarchive');

	Route::resource('productsOut', 'ProductOutController');
	Route::get('/apiProductsOut', 'ProductOutController@apiProductsOut')->name('api.productsOut');
	Route::get('/exportProductOutAll', 'ProductOutController@exportProductOutAll')->name('exportPDF.productOutAll');
	Route::get('/exportProductOutAllExcel', 'ProductOutController@exportExcel')->name('exportExcel.productOutAll');
	Route::get('/exportProductOut/{id}', 'ProductOutController@exportProductOut')->name('exportPDF.productOut');
	Route::get('api/productsOut', 'ProductOutController@apiProductsOut');
	Route::get('api/archived-products-out', 'ProductOutController@apiArchivedProductsOut');
	Route::post('productsOut/unarchive/{id}', 'ProductOutController@unarchive');

	Route::resource('productsIn', 'ProductInController');
	Route::get('/apiProductsIn', 'ProductInController@apiProductsIn')->name('api.productsIn');
	Route::get('/exportProductInAll', 'ProductInController@exportProductInAll')->name('exportPDF.productInAll');
	Route::get('/exportProductInAllExcel', 'ProductInController@exportExcel')->name('exportExcel.productInAll');
	Route::get('/exportProductIn/{id}', 'ProductInController@exportProductIn')->name('exportPDF.productIn');
	Route::get('api/productsIn', 'ProductInController@apiProductsIn');
	Route::get('api/archived-products-in', 'ProductInController@apiArchivedProductsIn');
	Route::post('productsIn/unarchive/{id}', 'ProductInController@unarchive');

	Route::resource('user', 'UserController');
	Route::get('/apiUser', 'UserController@apiUsers')->name('api.users');
});
