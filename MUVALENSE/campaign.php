<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Campaigns</title>
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
    <h1>Campaign Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
        <label for="campaign_id">Campaign Id:</label>
        <input type="number" id="campaign_id" name="campaign_id" required><br><br>
        <label for="campaign_name">Campaign Name:</label>
        <input type="text" id="campaign_name" name="campaign_name" required><br><br>
        <label for="project_id">Project Id:</label>
        <input type="number" id="project_id" name="project_id" required><br><br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br><br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br><br>
        <label for="campaign_description">Campaign Description:</label><br>
        <textarea id="campaign_description" name="campaign_description" required></textarea><br><br>
        <input type="submit" name="add" value="Insert"><br><br>
        <a href="./home.html">Go Back to Home</a>
    </form>
<?php
include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $campaign_id = sanitize_input($connection, $_POST['campaign_id']);
        $campaign_name = sanitize_input($connection, $_POST['campaign_name']);
        $project_id = sanitize_input($connection, $_POST['project_id']);
        $start_date = sanitize_input($connection, $_POST['start_date']);
        $end_date = sanitize_input($connection, $_POST['end_date']);
        $campaign_description = sanitize_input($connection, $_POST['campaign_description']);

        $stmt = $connection->prepare("INSERT INTO campaign (campaign_id, campaign_name, project_id, start_date, end_date, campaign_description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $campaign_id, $campaign_name, $project_id, $start_date, $end_date, $campaign_description); 

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }

    $sql = "SELECT * FROM campaign";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Campaigns</h2>
    <table>
        <tr>
            <th>Campaign Id</th>
            <th>Campaign Name</th>
            <th>Project Id</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Campaign Description</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $campaign_id = $row["campaign_id"];
                echo "<tr>
                        <td>{$row['campaign_id']}</td>
                        <td>{$row['campaign_name']}</td>
                        <td>{$row['project_id']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>{$row['campaign_description']}</td>
                        <td><a style='padding:4px' href='delete_campaign.php?campaign_id=$campaign_id'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_campaign.php?campaign_id=$campaign_id'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        ?>
    </table>

    <footer>
        <center>
            <b>UR CBE BIT &copy; 2024 &reg;, Designed by: muvara valens</b>
        </center>
    </footer>

    <?php
    $connection->close();
    ?>
</body>
</html>
