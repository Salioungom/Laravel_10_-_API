<?php

use App\Http\Controllers\Api\PostController;

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// //Recupération de la liste des poste
// Route::get('posts',[PostController::class,'index']);
// //Création de poste

// Route::put('posts/edit/{post}',[PostController::class,'update']);
// Route::delete('posts/delete/{post}',[PostController::class,'destroy']
// );

// //Authentification
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function ()
{
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //creation de poste
    Route::post('posts/create',[PostController::class,'store']);
    //modification de poste
    Route::put('posts/edit/{post}',[PostController::class,'update']);
    //suppression de poste
    Route::delete('posts/delete/{post}',[PostController::class,'destroy']
    );
    //suppression de compte
    Route::delete('user/delete',[UserController::class,'destroy']);
    //modification de compte
});
