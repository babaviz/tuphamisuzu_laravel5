<?php

/**
 * All route names are prefixed with 'admin.'.
 */
//Route::group([
//    'prefix'     => 'access',
//    'as'         => 'access.',
//    'namespace'  => 'Access',
//], function () {

    /*
     * User Management
     */
    Route::group([
//        'middleware' => 'access.routeNeedsRole:1',
    ], function () {
        Route::group(['namespace' => 'Product'], function () {
            /*
             * For DataTables
             */
            Route::post('product/get', 'ProductTableController')->name('product.get');

            /*
             * Product Status'
             */
//            Route::get('product/deactivated', 'ProductStatusController@getDeactivated')->name('user.deactivated');
            Route::get('product/deleted', 'ProductStatusController@getDeleted')->name('product.deleted');

            /*
             * Product CRUD
             */
            Route::resource('product', 'ProductController');


            /*
             * Deleted Product
             */
            Route::group(['prefix' => 'product/{deletedProduct}'], function () {
                Route::get('delete', 'ProductStatusController@delete')->name('product.delete-permanently');
                Route::get('restore', 'ProductStatusController@restore')->name('product.restore');
            });
        });

    });
//});

