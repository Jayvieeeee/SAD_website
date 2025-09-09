<?php

use Illuminate\Support\Facades\Route;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\AppointmentController;



Route::post('/appointments', [AppointmentController::class, 'store']);

Route::get('/appointments/{token}', [AppointmentController::class, 'showByToken']);


/**
 * Generate a unique 6-digit confirmation code
 */
function generateConfirmationCode()
{
    do {
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    } while (Appointment::where('confirmation_code', $code)->exists());

    return $code;
}