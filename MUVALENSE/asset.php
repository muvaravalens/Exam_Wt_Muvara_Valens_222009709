<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Assets</title>
     <style>
        body {
            background-color: green;
            margin: 30px 40px 55px 74px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }

        body {
            background-color: green;
            margin: 30px 40px 55px 74px;
        }
    </style>
    <script>
    function confirmInsert() {
      return confirm("Are you sure you want to insert this record?");
    }
  </script>
</head>
<body>
    <h1>Asset Form</h1>
   <form method="post" onsubmit="return confirmInsert();">
        <label for="asset_id">Asset Id:</label>
        <input type="number" id="asset_id" name="asset_id" required><br><br>
        <label for="asset_name">Asset Name:</label>
        <input type="text" id="asset_name" name="asset_name" required><br><br>
        <label for="asset_description">Asset Description:</label><br>
        <textarea id="asset_description" name="asset_description" required></textarea><br><br>
        <label for="asset_url">Asset URL:</label>
        <input type="url" id="asset_url" name="asset_url" required><br><br>
        <input type="submit" name="add" value="Insert"><br><br>
        <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $asset_id = sanitize_input($connection, $_POST['asset_id']);
        $asset_name = sanitize_input($connection, $_POST['asset_name']);
        $asset_description = sanitize_input($connection, $_POST['asset_description']);
        $asset_url = sanitize_input($connection, $_POST['asset_url']);

        $stmt = $connection->prepare("INSERT INTO asset (asset_id, asset_name, asset_description, asset_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $asset_id, $asset_name, $asset_description, $asset_url); 

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }

    $sql = "SELECT * FROM asset";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Assets</h2>
    <table>
        <tr>
            <th>Asset Id</th>
            <th>Asset Name</th>
            <th>Asset Description</th>
            <th>Asset URL</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $asset_id = $row["asset_id"];
                echo "<tr>
                        <td>{$row['asset_id']}</td>
                        <td>{$row['asset_name']}</td>
                        <td>{$row['asset_description']}</td>
                        <td>{$row['asset_url']}</td>
                        <td><a style='padding:4px' href='delete_asset.php?asset_id=$asset_id'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_asset.php?asset_id=$asset_id'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        ?>
    </table>

    <footer>
        <center>
            <b>UR CBE BIT &copy; 2024 &reg;, Designed by: @Muvara Valens</b>
        </center>
    </footer>

    <?php
    $connection->close();
    ?>
</body>
</html>
