<?php
require("config.php");

try {

    // SQL query to fetch data from the files table
    $stmt = $conn->prepare("
        SELECT f.file_id, f.file_name, f.unique_id, o.order_id, f.order_name, f.description
        FROM files f 
        INNER JOIN orders o ON f.order_id = o.order_id
    ");

    $stmt->execute();

    // Begin HTML output
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Order List</title>
        <style>
            .header-cls {
                font-size: 24px;
                font-weight: bold;
                margin-top: 20px;
                text-align: center;
            }
            .view-table {
                margin: 20px auto;
                width: 80%;
            }
            .file-preview {
                cursor: pointer;
                color: blue;
            }
        </style>
    </head>
    <body>
    <h2 class="header-cls">Order List</h2>
    <div class="view-table">
        <table class="table table-bordered border-primary">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Order Name</th>
                    <th>Description</th>
                    <th>Uploaded Files</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Fetch the result and display in table rows
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['file_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['order_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>";
                
                // Explode file names to show each file as a clickable link
                $file_names = explode(',', $row["file_name"]);
                foreach ($file_names as $file_name) {
                    echo "<a href='uploads/" . htmlspecialchars($file_name) . "' class='file-preview' target='_blank'>View</a>, ";
                }
                
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <script>
    // JavaScript for handling file preview
    document.addEventListener('DOMContentLoaded', function() {
        const filePreviewLinks = document.querySelectorAll('.file-preview');
        
        filePreviewLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const fileUrl = this.getAttribute('href');
                window.open(fileUrl, '_blank');
            });
        });
    });
    </script>
    </body>
    </html>
    <?php

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>