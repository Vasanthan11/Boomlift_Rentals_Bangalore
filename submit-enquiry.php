<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize fields
    $fullName  = htmlspecialchars(trim($_POST['fullName'] ?? ''));
    $email     = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone     = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $location  = htmlspecialchars(trim($_POST['location'] ?? ''));
    $equipment = htmlspecialchars(trim($_POST['equipment'] ?? ''));
    $message   = htmlspecialchars(trim($_POST['message'] ?? '')); // in case you add it later

    // Basic required validation
    if ($fullName === '' || $phone === '') {
        echo "Error: Full Name and Contact Number are required.";
        exit;
    }

    // Where the enquiry email should go
    $to = "info@boomliftbangalore.com"; // change if you want to use a different email

    $subject = "New Enquiry - Boom/Scissor Lift Rental";

    // Build email content
    $body  = "A new enquiry has been submitted from the boom lift enquiry form:\n\n";
    $body .= "Full Name: $fullName\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Location: $location\n";
    $body .= "Equipment: $equipment\n";

    if (!empty($message)) {
        $body .= "\nAdditional Message:\n$message\n";
    }

    // Email headers
    $headers  = "From: Enquiry Form <noreply@yourdomain.com>\r\n";
    if (!empty($email)) {
        $headers .= "Reply-To: $email\r\n";
    }
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        // On success, redirect to thank you page
        header("Location: thank-you.html");
        exit;
    } else {
        echo "There was an error sending your enquiry. Please try again later or contact us by phone.";
        exit;
    }
} else {
    echo "Invalid request method.";
    exit;
}
