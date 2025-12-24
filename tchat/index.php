<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tchat_db");
if (!$conn) die("DB Error: " . mysqli_connect_error());

function esc($c, $s) { return mysqli_real_escape_string($c, trim($s)); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
if (isset($_POST['send_message'])) {
    $msg = esc($conn, $_POST['message']);
    if ($msg != '') {
        $uid = $_SESSION['user_id'];
        mysqli_query($conn, "INSERT INTO messages (user_id, message) VALUES ($uid, '$msg')");
    }
    header("Location: index.php");
    exit;
}

// Fetch last 1000 messages
$msgs = mysqli_query($conn,
    "SELECT m.message, m.created_at, u.username
     FROM messages m JOIN users u ON m.user_id = u.id
     ORDER BY m.created_at DESC LIMIT 1000");
$messages = [];
if ($msgs) {
    while ($row = mysqli_fetch_assoc($msgs)) {
        $messages[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tchat - Realtime</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .chat-box {
            background: #fff;
            width: 90%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            padding: 20px;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h2 {
            margin: 0;
            color: #333;
        }

        .chat-header a {
            color: #e74c3c;
            text-decoration: none;
            font-size: 14px;
        }

        .chat-header a:hover {
            text-decoration: underline;
        }

        .messages {
            background: #f5f5f5;
            height: 300px;
            overflow-y: auto;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
        }

        .message {
            margin-bottom: 12px;
            background: #ecf0f1;
            padding: 10px 12px;
            border-radius: 8px;
            position: relative;
        }

        .message strong {
            color: #2c3e50;
        }

        .message small {
            display: block;
            color: #7f8c8d;
            font-size: 12px;
            margin-top: 4px;
        }

        form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            resize: none;
            font-size: 15px;
        }

        form button {
            margin-top: 10px;
            width: 100%;
            background: #2575fc;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #1a5cd8;
        }

        @media (max-width: 600px) {
            .chat-box {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="chat-box">
    <div class="chat-header">
        <h2>welcome to teamchat: <?=htmlspecialchars($_SESSION['username'])?></h2>
        <a href="?logout=1">Logout</a>
    </div>

    <div class="messages" id="messages">
        <?php foreach (array_reverse($messages) as $m): ?>
            <div class="message">
                <strong><?=htmlspecialchars($m['username'])?>:</strong>
                <?=htmlspecialchars($m['message'])?>
                <small><?=htmlspecialchars($m['created_at'])?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="post" action="">
        <textarea name="message" rows="3" placeholder="Type your message..." required></textarea>
        <button type="submit" name="send_message">Send</button>
    </form>
</div>

<script>
    const msgDiv = document.getElementById('messages');
    msgDiv.scrollTop = msgDiv.scrollHeight;
</script>
</body>
</html>
