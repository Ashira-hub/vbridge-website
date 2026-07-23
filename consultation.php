<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $company = htmlspecialchars($_POST['company']);
    $service = htmlspecialchars($_POST['service']);
    $other_service = isset($_POST['other_service']) ? htmlspecialchars($_POST['other_service']) : '';
    $message = htmlspecialchars($_POST['message']);

    // If "Other" is selected, save the custom service
    if ($service == "Other" && !empty($other_service)) {
        $service = $other_service;
    }

    // Save to PostgreSQL
    $query = "INSERT INTO consultations
    (fullname, email, phone, company_name, service, note)
    VALUES ($1, $2, $3, $4, $5, $6)";

    $result = pg_query_params(
        $conn,
        $query,
        array(
            $name,
            $email,
            $phone,
            $company,
            $service,
            $message
        )
    );

    if (!$result) {
        $error = "Database error: " . pg_last_error($conn);
    }

    // Email configuration
    $to = "kiervyxestole@gmail.com";
    $subject = "New Consultation Request from " . $name;

    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Company: $company\n";
    $email_content .= "Service: $service\n";
    $email_content .= "Message:\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if ($result && mail($to, $subject, $email_content, $headers)) {
        $success = true;
    } else {
        $success = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Free Consultation - VBridge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/consultation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <a href="index.php" class="logo">
            <img src="assets/vbridge_logo.png" alt="VenBridge Logo">
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Consultation Form -->
    <div class="consultation-container">
        <div class="consultation-header">
            <h1>Book a Free Consultation</h1>
            <p>Fill out the form below and we'll get back to you within 24 hours.</p>
        </div>

        <?php if (isset($success) && $success): ?>
            <div class="success-message">
                <strong>Thank you!</strong> Your consultation request has been submitted successfully. We'll be in touch soon.
            </div>
        <?php elseif (isset($error)): ?>
            <div class="error-message">
                <strong>Oops!</strong> <?php echo $error; ?>
            </div>
        <?php elseif (isset($success) && !$success): ?>
            <div class="error-message">
                <strong>Oops!</strong> There was an error submitting your request. Please try again or contact us directly at venbridgeoutsourcing@gmail.com
            </div>
        <?php endif; ?>

        <form class="consultation-form" method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required placeholder="john@example.com">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" id="phone" name="phone" required placeholder="">
            </div>

            <div class="form-group">
                <label for="company">Company Name</label>
                <input type="text" id="company" name="company" placeholder="Your Company">
            </div>

            <div class="form-group">
                <label for="service">Service Interested In *</label>
                <select id="service" name="service" required onchange="toggleOtherService()">
                    <option value="">Select a service</option>
                    <option value="Executive Assistant">Executive Assistant</option>
                    <option value="Bookkeeping">Bookkeeping</option>
                    <option value="Healthcare VA">Healthcare VA</option>
                    <option value="Customer Support">Customer Support</option>
                    <option value="Social Media">Social Media</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="other-service-group" style="display: none;">
                <label for="other_service">Please specify the service *</label>
                <input type="text" id="other_service" name="other_service" placeholder="Describe the specific service you're interested in">
            </div>

            <div class="form-group">
                <label for="message">Tell us about your needs *</label>
                <textarea id="message" name="message" required placeholder="Describe your business needs and what you're looking for in a virtual assistant..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Request Consultation</button>
        </form>

        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="js/consultation.js"></script>
</body>
</html>