<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $company = htmlspecialchars($_POST['company']);
    $service = htmlspecialchars($_POST['service']);
    $other_service = isset($_POST['other_service']) ? htmlspecialchars($_POST['other_service']) : '';
    $hours = htmlspecialchars($_POST['hours']);
    $timeline = htmlspecialchars($_POST['timeline']);
    $message = htmlspecialchars($_POST['message']);
    
    // Email configuration
    $to = "venbridgeoutsourcing@gmail.com";
    $subject = "New VA Hire Request from " . $name;
    
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Company: $company\n";
    if ($service === "Other" && $other_service) {
        $email_content .= "Service Needed: $other_service\n";
    } else {
        $email_content .= "Service Needed: $service\n";
    }
    $email_content .= "Hours Required: $hours\n";
    $email_content .= "Timeline: $timeline\n";
    $email_content .= "Message:\n$message\n";
    
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
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
    <title>Hire a Virtual Assistant - VenBridge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/hire.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <a href="index.php" class="logo">
            <img src="assets/venbridge_logo.png" alt="VenBridge Logo">
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Hire Form -->
    <div class="hire-container">
        <div class="hire-header">
            <h1>Hire a Virtual Assistant</h1>
            <p>Fill out the form below and we'll match you with the perfect VA for your business needs.</p>
        </div>

        <?php if (isset($success) && $success): ?>
            <div class="success-message">
                <strong>Thank you!</strong> Your hire request has been submitted successfully. Our team will contact you within 24 hours to discuss your requirements.
            </div>
        <?php elseif (isset($success) && !$success): ?>
            <div class="error-message">
                <strong>Oops!</strong> There was an error submitting your request. Please try again or contact us directly at venbridgeoutsourcing@gmail.com
            </div>
        <?php endif; ?>

        <form class="hire-form" method="POST" action="">
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
                <label for="company">Company Name *</label>
                <input type="text" id="company" name="company" required placeholder="Your Company">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="service">Service Needed *</label>
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

                <div class="form-group">
                    <label for="hours">Hours Required *</label>
                    <select id="hours" name="hours" required>
                        <option value="">Select hours</option>
                        <option value="Part-time (10-20 hrs/week)">Part-time (10-20 hrs/week)</option>
                        <option value="Part-time (20-30 hrs/week)">Part-time (20-30 hrs/week)</option>
                        <option value="Full-time (40 hrs/week)">Full-time (40 hrs/week)</option>
                        <option value="Flexible/Project-based">Flexible/Project-based</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="other-service-group" style="display: none;">
                <label for="other_service">Please specify the service *</label>
                <input type="text" id="other_service" name="other_service" placeholder="Describe the specific service you need">
            </div>

            <div class="form-group">
                <label for="timeline">When do you need to start? *</label>
                <select id="timeline" name="timeline" required>
                    <option value="">Select timeline</option>
                    <option value="Immediately">Immediately</option>
                    <option value="Within 1 week">Within 1 week</option>
                    <option value="Within 2 weeks">Within 2 weeks</option>
                    <option value="Within 1 month">Within 1 month</option>
                    <option value="Flexible">Flexible</option>
                </select>
            </div>

            <div class="form-group">
                <label for="message">Describe your requirements *</label>
                <textarea id="message" name="message" required placeholder="Tell us about your business, the tasks you need help with, and any specific requirements..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Hire Request</button>
        </form>

        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="js/hire.js"></script>
</body>
</html>