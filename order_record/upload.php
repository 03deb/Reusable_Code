<?php
require("config.php");

try {
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Fetch data from the form
    $order_id = $_POST['order_id'];
    $total_fields = $_POST['total_fields'];
    $order_names = $_POST['order_name'];
    $descriptions = $_POST['description'];
    $unique_ids = $_POST['unique_id'];
    $files = $_FILES['files'];

    // Check if the order_id already exists in the orders table
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE order_id = :order_id");
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] == 0) {
        $stmt = $conn->prepare("INSERT INTO orders (order_id) VALUES (:order_id)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
    }

    // Directory to store uploaded files
    $upload_directory = 'uploads/';

    // Loop through each field
    for ($i = 0; $i < $total_fields; $i++) {
        $order_name = $order_names[$i];
        $description = $descriptions[$i];
        $unique_id = $unique_ids[$i];
        $file_names = [];
        $errors = [];

        // Ensure the upload directory exists, create it if not
        if (isset($files['name'][$i]) && is_array($files['name'][$i]) && !empty(array_filter($files['name'][$i]))) {
            foreach ($files['name'][$i] as $key => $val) {
                $filename = basename($files['name'][$i][$key]);
                $filename = time() . "_" . $filename;
                $target_file = $upload_directory . $filename;
                if (move_uploaded_file($files['tmp_name'][$i][$key], $target_file)) {
                    $file_names[] = $filename;
                } else {
                    $errors[] = "Error uploading file $filename";
                }
            }

            if (!empty($file_names)) {
                // Convert file names array to a comma-separated string
                $file_names_str = implode(',', $file_names);

                // Insert file names into files table as a single entry
                $stmt = $conn->prepare("INSERT INTO files (order_id, order_name, description, unique_id, file_name) VALUES (:order_id, :order_name, :description, :unique_id, :file_name)");
                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':order_name', $order_name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':unique_id', $unique_id);
                $stmt->bindParam(':file_name', $file_names_str);
                $stmt->execute();
                echo "Files for $unique_id uploaded successfully.<br>";
            } else {
                echo "No files were uploaded for $unique_id.<br>";
            }
        } else {
            echo "No file selected for field $i.<br>";
        }
    }

    // Redirect to view.php after successful upload
    header("Location: view.php");
    exit;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
