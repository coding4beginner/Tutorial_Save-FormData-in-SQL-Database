<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db = new PDO("sqlite:form_data.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("INSERT INTO submissions (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':message', $_POST['message']);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href = 'index.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success</h5>
                </div>
                <div class="modal-body">
                    <p>Your entry has been successfully submitted!</p>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 3000);
    </script>
</body>
</html>
