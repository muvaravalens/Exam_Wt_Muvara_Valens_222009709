<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Clients</title>
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
    <h1>Client Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
        <label for="client_id">Client Id:</label>
        <input type="number" id="client_id" name="client_id" required><br><br>
        <label for="client_name">Client Name:</label>
        <input type="text" id="client_name" name="client_name" required><br><br>
        <label for="client_email">Client Email:</label>
        <input type="email" id="client_email" name="client_email" required><br><br>
        <label for="client_phone">Client Phone:</label>
        <input type="tel" id="client_phone" name="client_phone" required><br><br>
        <label for="client_company">Client Company:</label>
        <input type="text" id="client_company" name="client_company" required><br><br>
        <input type="submit" name="add" value="Insert"><br><br>
        <a href="./home.html">Go Back to Home</a>
    </form>
<?php
include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $client_id = sanitize_input($connection, $_POST['client_id']);
        $client_name = sanitize_input($connection, $_POST['client_name']);
        $client_email = sanitize_input($connection, $_POST['client_email']);
        $client_phone = sanitize_input($connection, $_POST['client_phone']);
        $client_company = sanitize_input($connection, $_POST['client_company']);

        $stmt = $connection->prepare("INSERT INTO clients (client_id, client_name, client_email, client_phone, client_company) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $client_id, $client_name, $client_email, $client_phone, $client_company); 

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }

    $sql = "SELECT * FROM clients";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Clients</h2>
    <table>
        <tr>
            <th>Client Id</th>
            <th>Client Name</th>
            <th>Client Email</th>
            <th>Client Phone</th>
            <th>Client Company</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $client_id = $row["client_id"];
                echo "<tr>
                        <td>{$row['client_id']}</td>
                        <td>{$row['client_name']}</td>
                        <td>{$row['client_email']}</td>
                        <td>{$row['client_phone']}</td>
                        <td>{$row['client_company']}</td>
                        <td><a style='padding:4px' href='delete_client.php?client_id=$client_id'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_client.php?client_id=$client_id'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
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
