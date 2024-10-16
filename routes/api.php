<?php

use App\Http\Controllers\Api\VendaController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [VendaController::class, 'index']);
