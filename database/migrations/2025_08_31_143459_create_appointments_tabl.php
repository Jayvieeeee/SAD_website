<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');

            // Appointment belongs to a patient
            $table->foreignId('patient_id')
                  ->constrained('patients', 'patient_id')
                  ->cascadeOnDelete();

            $table->dateTime('schedule_datetime');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
