<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h2>Hello {{ $patient->first_name }} {{ $patient->last_name }}</h2>
    <p>Thank you for booking your appointment at <strong>District Smile Dental Clinic</strong>.</p>

    <p><strong>Appointment Details:</strong></p>
    <ul>
        <li><strong>Service:</strong> {{ $appointment->service->service_name ?? 'Dental Service' }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->schedule_datetime)->format('F j, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->schedule_datetime)->format('h:i A') }}</li>
    </ul>

    <p>Your Confirmation code is: <strong>{{ $patient->confirmation_code }}</strong></p>
    <p>Please keep this code safe to view your appointment.</p>
    <br>

    <p>Regards, <br> District Smile Dental Clinic</p>
</body>
</html>
