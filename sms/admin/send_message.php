<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "student");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sender_id = $_SESSION['user_id'] ?? null;

if (!$sender_id) {
    echo "Please login first.";
    exit();
}

$message_sent = "";

if (isset($_POST['send'])) {
    $recipient = mysqli_real_escape_string($conn, $_POST['recipient']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO messages (sender_id, recipient_email, subject, message)
              VALUES ('$sender_id', '$recipient', '$subject', '$message')";

    if (mysqli_query($conn, $query)) {
        $message_sent = "Message sent successfully!";
    } else {
        $message_sent = "Failed to send message.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: green;
            color: white;
            border: none;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>

<h2>Send Message</h2>

<?php if ($message_sent): ?>
    <p class="success"><?php echo $message_sent; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Recipient Email:</label>
    <input type="email" name="recipient" required>

    <label>Subject:</label>
    <input type="text" name="subject" required>

    <label>Message:</label>
    <textarea name="message" rows="6" required></textarea>

    <input type="submit" name="send" value="Send Message">
</form>
<button><a href="teacher_dashboard.php">dashboard</a></button>
</body>
</html>
