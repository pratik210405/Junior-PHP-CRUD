<?php
require "config.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php?message=Invalid+record.&type=error");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: index.php?message=Record+not+found.&type=error");
    exit;
}

$errors = [];

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
                "UPDATE users SET name=?, email=?, phone=?, course=? WHERE id=?"
            );
            $stmt->execute([$name, $email, $phone, $course, $id]);
            header("Location: index.php?message=" . urlencode("User updated successfully.") . "&type=success");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Could not update record. Email may already exist.";
        }
    }

    $user["name"] = $name;
    $user["email"] = $email;
    $user["phone"] = $phone;
    $user["course"] = $course;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small">
    <div class="card form-card">
        <a class="back" href="index.php">← Back to users</a>
        <h1>Edit User</h1>
        <p class="muted">Update the selected user record.</p>

        <?php if ($errors): ?>
        <div class="alert error"><ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

            <label>Course</label>
            <input type="text" name="course" value="<?= htmlspecialchars($user['course']) ?>" required>

            <button class="btn" type="submit">Update User</button>
        </form>
    </div>
</div>
</body>
</html>