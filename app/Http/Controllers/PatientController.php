<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Show patient details and appointments by token.
     */
    public function showByToken($token)
    {
        // Find patient by token
        $patient = Patient::where('patient_token', $token)->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found.'
            ], 404);
        }

        // Fetch appointments with related services
        $appointments = $patient->appointments()
            ->with('services')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'schedule_datetime' => $appointment->schedule_datetime->format('Y-m-d H:i'),
                    'status' => $appointment->status,
                    'services' => $appointment->services->map(function ($service) {
                        return [
                            'id' => $service->id,
                            'name' => $service->name,
                            'price' => $service->price,
                        ];
                    }),
                ];
            });

        return response()->json([
            'patient' => [
                'id' => $patient->id,
                'name' => $patient->name,
                'email' => $patient->email,
                'contact_no' => $patient->contact_no,
                'token' => $patient->patient_token,
            ],
            'appointments' => $appointments,
        ]);
    }
}
