<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Auth;


Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    if (!method_exists($user, 'createToken')) {
        return response()->json(['message' => 'createToken method not found'], 500);
    }
    $token = $user->createToken('TokenName')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
    Route::get('/places/{place}', [PlaceController::class, 'show'])->name('places.show');
    Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('places.update');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.destroy');
});
