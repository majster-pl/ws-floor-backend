<?php

use App\Mail\BookingConfirmation;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

// use Illuminate\Support\Facades\Route;
// Below route initialed only to handle /login request all the rest to be hanbled by api/v1.php

Auth::routes();
// Route::view('/login', function () {
//     return view("auth.login");
// });
// Route::middleware('auth.basic')->get('/home', function (Request $request) {
//     return Auth::user();
// });
