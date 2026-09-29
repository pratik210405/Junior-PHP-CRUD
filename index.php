<?php
require "config.php";

$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();

$message = $_GET['message'] ?? '';
$type = $_GET['type'] ?? 'success';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header class="topbar">
        <div>
            <h1>PHP CRUD Application</h1>
            <p>Junior PHP Developer Internship Task</p>
        </div>
        <a class="btn" href="create.php">+ Add User</a>
    </header>

    <?php if ($message): ?>
        <div class="alert <?= htmlspecialchars($type) ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <section class="card">
        <div class="card-header">
            <h2>User Records</h2>
            <span><?= count($users) ?> record(s)</span>
        </div>

        <?php if (!$users): ?>
            <div class="empty">No records found. Add your first user.</div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= (int)$user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['course']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td class="actions">
                            <a class="edit" href="edit.php?id=<?= (int)$user['id'] ?>">Edit</a>
                            <a class="delete" href="delete.php?id=<?= (int)$user['id'] ?>"
                               onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </section>

    <footer>Built with PHP, MySQL, PDO, HTML, CSS and JavaScript.</footer>
</div>
</body>
</html>