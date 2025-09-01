<?php

use Illuminate\Support\Facades\Route;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;



Route::post('/appointments', function (Request $request) {
    try {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email',
            'contact_no' => 'required|string',
            'services'   => 'required|array|min:1',
            'services.*' => 'exists:services,service_id',
            'schedule_datetime' => 'required|date',
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'errors' => $e->errors()
        ], 422);
    }

    // check if patient exists
    $patient = Patient::where('email', $request->email)->first();

    if ($patient) {
        // check if they have a pending appointment
        $hasPending = Appointment::where('patient_id', $patient->patient_id)
            ->where('status', 'pending')
            ->exists();

        // allow multiple appointments ONLY for your email
        if ($hasPending && $request->email !== "jayvieletada@gmail.com") {
            return response()->json([
                'error' => 'You already have a pending appointment. Please wait until it is completed or canceled.'
            ], 422);
        }
    } else {
        // if new patient, create one
        $patient = Patient::create($request->only([
            'first_name',
            'last_name',
            'email',
            'contact_no'
        ]));
    }

    //create appointments with confirmation code
  $appointments = [];
    foreach ($request->services as $serviceId) {
        $appointments[] = Appointment::create([
            'patient_id'         => $patient->patient_id,
            'service_id'         => $serviceId,
            'schedule_datetime'  => $request->schedule_datetime,
            'status'             => 'pending',
            'confirmation_code'  => generateConfirmationCode(),
        ]);
    }

    $appointments = collect($appointments); 

    // send confirmation email
    if ($appointments->isNotEmpty()) {
        Mail::to($patient->email)->send(
            new AppointmentConfirmationMail($patient, $appointments)
    );

    }

    return response()->json([
        'message' => 'Appointments booked successfully',
        'patient_token' => $patient->token,
        'appointments' => $appointments
    ]);
});

Route::get('/appointments/{token}', function ($token) {
    //find the patient via token
    $patient = Patient::where('token', $token)-> first();

    if(!$patient) {
        return response()->json([
            'error' => 'Patient not found.'
        ], 404);
    }

    $appointments = Appointment::where('patient_id', $patient->patient_id)
    ->with('service')
    ->get();

    return response()->json([
        'patient'=> $patient,
        'appointments' => $appointments
    ]);
});


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