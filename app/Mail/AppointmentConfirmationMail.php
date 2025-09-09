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

    public Patient $patient;
    public Appointment $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Patient $patient, Appointment $appointment)
    {
        $this->patient = $patient;
        $this->appointment = $appointment;
    }

    /**
     * Build the message.  
     */
    public function build()
    {
        return $this->subject('Your Appointment Confirmation')
            ->view('emails.appointment_confirmation')
            ->with([
                'patient' => $this->patient,
                'appointments' => collect([$this->appointment]) // wrap in collection
            ]);
    }
}
