<?php


use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Stmt\Return_;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContactReturnController;
use App\Models\ContactReturn;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Route::apiResource('include-call', ContactController::class);
//Route::apiResource('return-call', ContactController::class);
//Route::post('/login', [TestController::class, 'login']);
//Route::post('/register', [TestController::class, 'register']);
//Route::post('/logout', [TestController::class, 'logout'])->middleware('auth:sanctum');
//Route::get('/me', [TestController::class, 'me'])->middleware('auth:sanctum');
//Route::post('/test', [TestController::class, 'login']);
//Route::middleware(['auth:sanctum', 'validate.access'])->post('/me', [TestController::class, 'me']);
//Route::apiResource('return-call', ContactReturnController::class);
//Route::middleware('validate.access')->get('/me', [TestController::class, 'me']);



//Route::apiResource('include-call', ContactController::class);
//Route::apiResource('return-call', ContactController::class);

Route::prefix('v1')->group(function () {

    Route::apiResource('include-call', ContactController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('auth:sanctum');

    Route::apiResource('return-call', ContactController::class)
        ->only(['index', 'show'])
        ->middleware('auth:sanctum');
});


Route::prefix('hml')->group(
    function () {

        Route::get('me', [TestController::class, 'me']);
        Route::post('login', [TestController::class, 'login']);
        Route::post('logout', [TestController::class, 'logout']);
        Route::post('register', [TestController::class, 'register']);
        Route::apiResource('include-call', TestController::class)
            ->only(['store'])->middleware('auth:sanctum');

        Route::apiResource('return-call', TestController::class)
            ->only(['index', 'show'])->middleware('auth:sanctum');
    }
);


Route::middleware('validate.access')->get('/rota-protegida', function () {
    return 'Esta rota é protegida.';
});
