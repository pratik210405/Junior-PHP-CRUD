<?php
require "config.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php?message=" . urlencode("User deleted successfully.") . "&type=success");
} else {
    header("Location: index.php?message=" . urlencode("Invalid record.") . "&type=error");
}
exit;
?>