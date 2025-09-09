<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
  public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'contact_no'        => 'required|string|max:20',
            'schedule_datetime' => 'required|date',
            'services'          => 'required|array|min:1',
            'services.*'        => 'exists:services,service_id',
]);


        // 2. Create/update patient
        $patient = Patient::updateOrCreate(
            ['email' => $validated['email']],
            [
                'first_name'    => $validated['first_name'],
                'last_name'     => $validated['last_name'],
                'contact_no'    => $validated['contact_no'],
                'patient_token' => Str::random(60),
            ]
        );

        // 3. Check duplicate appointment
        $exists = Appointment::where('patient_id', $patient-> patient_id)
            ->where('schedule_datetime', $validated['schedule_datetime'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You already have an appointment at this time.'
            ], 422);
        }

        // 4. Create appointment
        $appointment = Appointment::create([
        'patient_id'        => $patient-> patient_id,
        'schedule_datetime' => $validated['schedule_datetime'], 
        'confirmation_code'  => generateConfirmationCode(),
    ]);


        // 5. Attach services
        $appointment->services()->attach($validated['services']);

        // 6. Send confirmation email (queued)
        try {
            Mail::to($patient->email)->queue(
                new AppointmentConfirmationMail($patient, $appointment)
            );
        } catch (\Exception $mailEx) {
            Log::error("Mail sending failed: " . $mailEx->getMessage());
        }

        return response()->json([
            'message'     => 'Appointment booked successfully!',
            'appointment' => $appointment->load('services'),
            'patient'     => $patient,
        ], 201);

    } catch (\Exception $e) {
        Log::error("Appointment booking failed: " . $e->getMessage());

        return response()->json([
            'message' => 'Something went wrong while booking the appointment.',
            'error'   => app()->environment('local') ? $e->getMessage() : null,
        ], 500);
    }
}

}
