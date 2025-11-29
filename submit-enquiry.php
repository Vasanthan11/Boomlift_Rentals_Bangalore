<?php
// submit-enquiry.php

// 1. CONFIGURATION
$toEmail   = "info@boomliftrentalsbangalore.com";  // TODO: put your email here
$subject   = "New Enquiry - Boom / Scissor / Man Lift";
$fromEmail = "no-reply@boomliftrentalsbangalore.com"; // or any domain email you control

// 2. HELPER: sanitize
function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// 3. GET POST DATA
$fullName  = isset($_POST['fullName']) ? clean_input($_POST['fullName']) : '';
$email     = isset($_POST['email'])    ? clean_input($_POST['email'])    : '';
$phone     = isset($_POST['phone'])    ? clean_input($_POST['phone'])    : '';
$location  = isset($_POST['location']) ? clean_input($_POST['location']) : '';
$equipment = isset($_POST['equipment'])? clean_input($_POST['equipment']): '';
// If you re-enable the textarea, also grab it here:
// $message  = isset($_POST['message'])  ? clean_input($_POST['message'])  : '';

$errors = [];

// 4. BASIC VALIDATION
if ($fullName === '') {
    $errors[] = "Full Name is required.";
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid Email Address is required.";
}
if ($phone === '') {
    $errors[] = "Contact Number is required.";
}
if ($location === '') {
    $errors[] = "Area / Location is required.";
}

// 5. BUILD EMAIL BODY
$equipmentLabel = $equipment !== '' ? $equipment : 'Not specified';

$emailBody  = "New enquiry received from boomliftrentalbangalore.com\n\n";
$emailBody .= "Full Name   : {$fullName}\n";
$emailBody .= "Email       : {$email}\n";
$emailBody .= "Phone       : {$phone}\n";
$emailBody .= "Location    : {$location}\n";
$emailBody .= "Equipment   : {$equipmentLabel}\n";
// If you add message field back:
// $emailBody .= "Message     : {$message}\n";

$headers   = "From: {$fromEmail}\r\n";
$headers  .= "Reply-To: {$email}\r\n";
$headers  .= "Content-Type: text/plain; charset=UTF-8\r\n";

// 6. OUTPUT START – SIMPLE HTML PAGE
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiry Submission</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: "Poppins", Arial, sans-serif;
            background: linear-gradient(135deg, #DDA853 30%, #27548A 80%, #3183B4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: #F3F3E0;
        }
        .result-card {
            max-width: 520px;
            width: 100%;
            background-color: rgba(3, 16, 28, 0.92);
            border-radius: 18px;
            padding: 1.8rem 1.8rem 2rem;
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            text-align: left;
        }
        .result-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
        }
        .result-text {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .error-list {
            margin: 0.6rem 0 1rem;
            padding-left: 1.2rem;
            font-size: 0.95rem;
        }
        .error-list li {
            margin-bottom: 0.25rem;
        }
        .btn-back {
            display: inline-block;
            margin-top: 0.4rem;
            padding: 0.6rem 1.3rem;
            border-radius: 999px;
            border: none;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background-color: #DDA853;
            color: #183B4E;
        }
        .btn-back:hover {
            background-color: #F3F3E0;
        }
        .small-note {
            font-size: 0.85rem;
            opacity: 0.85;
            margin-top: 0.8rem;
        }
    </style>
</head>
<body>
<div class="result-card">
<?php
// 7. SEND OR SHOW ERRORS
if (!empty($errors)) {
    echo '<h1 class="result-title">Please check your details</h1>';
    echo '<p class="result-text">We could not submit your enquiry because some required information is missing or invalid:</p>';
    echo '<ul class="error-list">';
    foreach ($errors as $err) {
        echo '<li>' . $err . '</li>';
    }
    echo '</ul>';
    echo '<a class="btn-back" href="javascript:history.back()">Go back to the form</a>';
} else {
    // Attempt to send email
    $mailSent = @mail($toEmail, $subject, $emailBody, $headers);

    if ($mailSent) {
        echo '<h1 class="result-title">Thank you – enquiry submitted</h1>';
        echo '<p class="result-text">We have received your details. Our Bangalore team will review your requirement and get back to you shortly with a boom lift / scissor lift / man lift quote.</p>';
    } else {
        echo '<h1 class="result-title">Enquiry received (email not sent)</h1>';
        echo '<p class="result-text">Your details were captured, but the mail function could not be executed on this server.</p>';
    }

    echo '<div class="small-note">';
    echo 'Summary of details:<br>';
    echo 'Name: ' . $fullName . '<br>';
    echo 'Email: ' . $email . '<br>';
    echo 'Phone: ' . $phone . '<br>';
    echo 'Location: ' . $location . '<br>';
    echo 'Equipment: ' . $equipmentLabel . '<br>';
    echo '</div>';
    echo '<a class="btn-back" href="form.html" style="margin-top:1rem;">Back to enquiry form</a>';
}
?>
</div>
</body>
</html>
