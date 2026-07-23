<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $company = htmlspecialchars($_POST['company']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $timezone = htmlspecialchars($_POST['timezone']);
    $topic = htmlspecialchars($_POST['topic']);
    $other_topic = isset($_POST['other_topic']) ? htmlspecialchars($_POST['other_topic']) : '';
    $message = htmlspecialchars($_POST['message']);
    
    // Email configuration
    $to = "venbridgeoutsourcing@gmail.com";
    $subject = "New Call Schedule Request from " . $name;
    
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Company: $company\n";
    $email_content .= "Preferred Date: $date\n";
    $email_content .= "Preferred Time: $time\n";
    $email_content .= "Timezone: $timezone\n";
    if ($topic === "Other" && $other_topic) {
        $email_content .= "Topic: $other_topic\n";
    } else {
        $email_content .= "Topic: $topic\n";
    }
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
    <title>Schedule a Call - VenBridge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/schedule.css">
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

    <!-- Schedule Form -->
    <div class="schedule-container">
        <div class="schedule-header">
            <h1>Schedule a Call</h1>
            <p>Pick a time that works for you and we'll discuss how we can help your business grow.</p>
        </div>

        <?php if (isset($success) && $success): ?>
            <div class="success-message">
                <strong>Thank you!</strong> Your call has been scheduled successfully. We'll send you a confirmation email shortly.
            </div>
        <?php elseif (isset($success) && !$success): ?>
            <div class="error-message">
                <strong>Oops!</strong> There was an error scheduling your call. Please try again or contact us directly at venbridgeoutsourcing@gmail.com
            </div>
        <?php endif; ?>

        <form class="schedule-form" method="POST" action="">
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

            <div class="form-row">
                <div class="form-group">
                    <label for="date">Preferred Date *</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time">Preferred Time *</label>
                    <input type="time" id="time" name="time" required>
                </div>
            </div>

            <div class="form-group">
                <label for="timezone">Timezone *</label>
                <select id="timezone" name="timezone" required>
                    <option value="">Select timezone</option>
                    <option value="Eastern Time (ET)">Eastern Time (ET)</option>
                    <option value="Central Time (CT)">Central Time (CT)</option>
                    <option value="Mountain Time (MT)">Mountain Time (MT)</option>
                    <option value="Pacific Time (PT)">Pacific Time (PT)</option>
                    <option value="UTC">UTC</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="topic">Topic of Discussion *</label>
                <select id="topic" name="topic" required onchange="toggleOtherTopic()">
                    <option value="">Select a topic</option>
                    <option value="General Consultation">General Consultation</option>
                    <option value="Executive Assistant Services">Executive Assistant Services</option>
                    <option value="Bookkeeping Services">Bookkeeping Services</option>
                    <option value="Healthcare VA Services">Healthcare VA Services</option>
                    <option value="Customer Support Services">Customer Support Services</option>
                    <option value="Social Media Services">Social Media Services</option>
                    <option value="Pricing & Plans">Pricing & Plans</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="other-topic-group" style="display: none;">
                <label for="other_topic">Please specify the topic *</label>
                <input type="text" id="other_topic" name="other_topic" placeholder="Describe the specific topic you'd like to discuss">
            </div>

            <div class="form-group">
                <label for="message">Additional Notes</label>
                <textarea id="message" name="message" placeholder="Any specific questions or topics you'd like to discuss..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Schedule Call</button>
        </form>

        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="js/schedule.js"></script>
</body>
</html>