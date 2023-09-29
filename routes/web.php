<?php

use App\Http\Controllers\ClientController;
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
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/clients', [ClientController::class, 'showAllClients']);
    Route::post('/addClient', [ClientController::class, 'addClient']);
    Route::get('/viewClient/{id}', [ClientController::class, 'viewClient']);
    Route::get('/search', [ClientController::class, 'searchClient']);
    Route::post('/addHistory', [ClientController::class, 'addHistory']);
    Route::put('/updateClient/{id}', [ClientController::class, 'updateClient']);
    Route::put('/editHistory/{id}', [ClientController::class, 'editHistory']);
    Route::get('/getServices/{id}', [ClientController::class, 'getServices']);
    Route::get('/medicines', [ClientController::class, 'getMedicines']);
    Route::post('/addMedicine', [ClientController::class, 'addMedicine']);
    Route::put('/editMedicine', [ClientController::class, 'editMedicine']);
    Route::post('/addService', [ClientController::class, 'addService']);
    Route::get('/viewService/{id}', [ClientController::class, 'viewService']);
    Route::post('/addLog', [ClientController::class, 'addLog']);
    Route::get('/household', [ClientController::class, 'household']);
    Route::get('/view-members/{id}', [ClientController::class, 'view_members']);
    Route::post('/newHousehold', [ClientController::class, 'newHousehold']);
    Route::post('/newHholdStat', [ClientController::class, 'newHholdStat']);
    Route::post('/newHholdStat2', [ClientController::class, 'newHholdStat2']);
    Route::get('/household-members/{id}', [ClientController::class, 'householdMembers']);
    Route::get('printClient/{id}', [ClientController::class, 'printClient']);
    Route::get('printBCfindings/{id}', [ClientController::class, 'printBCfindings']);
    Route::post('addIndigency', [ClientController::class, 'addIndigency']);
    Route::post('editIndigency/{id}', [ClientController::class, 'editIndigency']);
    Route::get('client-logs', [ClientController::class, 'client_logs']);
    Route::get('filter-logs', [ClientController::class, 'filterLogs']);
});

require __DIR__.'/auth.php';
