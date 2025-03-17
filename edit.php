<!-- edit_entry.php -->
<?php
if (isset($_GET['id'])) {
    try {
        $db = new PDO("sqlite:form_data.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $db->prepare("SELECT * FROM submissions WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$entry) {
            die("Entry not found.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $db->prepare("UPDATE submissions SET name = :name, email = :email, message = :message WHERE id = :id");
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':message', $_POST['message']);
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        
        header("Location: list_entries.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Edit Entry</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($entry['id']); ?>">
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($entry['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($entry['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message:</label>
            <textarea name="message" class="form-control" required><?php echo htmlspecialchars($entry['message']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="list_entries.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>