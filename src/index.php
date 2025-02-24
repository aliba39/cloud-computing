<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Database connection settings
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'myappdb';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: 'rootpassword';

try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Add a new message if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $message = $_POST['message'];
    $stmt = $pdo->prepare("INSERT INTO messages (content) VALUES (:message)");
    $stmt->execute(['message' => $message]);
}

// Retrieve messages from the database
$stmt = $pdo->query("SELECT * FROM messages ORDER BY id DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple PHP App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?></h1>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </header>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="message">Add Message:</label>
                        <input type="text" name="message" id="message" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        
        <h2 class="mb-3">Messages:</h2>
        <ul class="list-group">
            <?php if ($messages): ?>
                <?php foreach ($messages as $msg): ?>
                    <li class="list-group-item"><?= htmlspecialchars($msg['content']) ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No messages yet.</li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
