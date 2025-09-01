<?php

namespace App\Mail;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $appointments;

    public function __construct($patient, $appointments)
    {
        $this->patient = $patient;
        $this->appointments = $appointments;
    }

    public function build()
    {
        return $this->subject('Your Appointment Confirmation')
            ->view('emails.appointment_confirmation')
            ->with([
                'patient' => $this->patient,
                'appointments' => $this->appointments
            ]);
    }
}
