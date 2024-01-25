<?php
// Set the receiving email address
$receiving_email_address = 'contact@example.com';

// Check if the PHP Email Form library is available
if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);

    // Create an instance of the PHP_Email_Form class
    $contact = new PHP_Email_Form;

    // Enable AJAX mode
    $contact->ajax = true;

    // Set email parameters
    $contact->to = $receiving_email_address;
    $contact->from_name = htmlspecialchars($_POST['name']); // Sanitize input
    $contact->from_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize and validate email
    $contact->subject = htmlspecialchars($_POST['subject']); // Sanitize input

    // Uncomment below code if you want to use SMTP to send emails. Replace with your SMTP credentials.
    /*
    $contact->smtp = array(
        'host' => 'your_smtp_host',
        'username' => 'your_smtp_username',
        'password' => 'your_smtp_password',
        'port' => '587',
    );
    */

    // Add form data to the email message
    $contact->add_message(htmlspecialchars($_POST['name']), 'From');
    $contact->add_message(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 'Email');
    $contact->add_message(htmlspecialchars($_POST['message']), 'Message', 10);

    // Attempt to send the email and handle errors
    $send_result = $contact->send();

    if ($send_result === true) {
        echo 'success'; // or any response you want on successful submission
    } else {
        echo 'error'; // or handle the error appropriately
        error_log('Email sending error: ' . $send_result); // Log the error for debugging
    }
} else {
    die('Unable to load the "PHP Email Form" Library!');
}
?>
