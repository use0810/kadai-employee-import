<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportEmployeeController;

// CSVアップロードAPI（POST）
Route::post('/import-employees', [ImportEmployeeController::class, 'import']);

// CORSプリフライト（OPTIONS）全対応
Route::options('/{any}', function () {
    return response()->json([], 204);
})->where('any', '.*');