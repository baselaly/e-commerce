<?php

use App\Models\Product;
use Basel\RepositoryPipeline\Repository;
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

Route::get('/', function () {
    return Repository::get(Product::class, ['id' => '2cca5c78-2af3-4bd9-9bd3-a1ded2350b6f'], $perPage = 1);
});
