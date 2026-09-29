<?php
require "config.php";

$errors = [];
$name = $email = $phone = $course = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $course = trim($_POST["course"] ?? "");

    if ($name === "") $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Enter a valid email address.";
    if ($phone === "" || !preg_match('/^[0-9+\-\s]{10,15}$/', $phone)) $errors[] = "Enter a valid phone number.";
    if ($course === "") $errors[] = "Course is required.";

    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, phone, course) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$name, $email, $phone, $course]);
            header("Location: index.php?message=" . urlencode("User added successfully.") . "&type=success");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Could not save record. Email may already exist.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add User</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small">
    <div class="card form-card">
        <a class="back" href="index.php">← Back to users</a>
        <h1>Add User</h1>
        <p class="muted">Create a new user record.</p>

        <?php if ($errors): ?>
        <div class="alert error"><ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" required>

            <label>Course</label>
            <input type="text" name="course" value="<?= htmlspecialchars($course) ?>" placeholder="e.g. BCA" required>

            <button class="btn" type="submit">Save User</button>
        </form>
    </div>
</div>
</body>
</html>