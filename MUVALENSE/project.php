<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Projects</title>
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
         /* Function to confirm record insertion */
    function confirmInsert() {
      return confirm("Are you sure you want to insert this record?");
    }
  </script>
</head>
<body>
    <h1>Project Form</h1>
    <!-- Form to add a new project -->

     <form method="post" onsubmit="return confirmInsert();">
        <label for="project_id">Project Id:</label>
        <input type="number" id="project_id" name="project_id" required><br><br>
        <label for="project_name">Project Name:</label>
        <input type="text" id="project_name" name="project_name" required><br><br>
        <label for="client_id">Client Id:</label>
        <input type="number" id="client_id" name="client_id" required><br><br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br><br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br><br>
        <label for="project_description">Project Description:</label><br>
        <textarea id="project_description" name="project_description" required></textarea><br><br>
        <input type="submit" name="add" value="Insert"><br><br>
        <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $project_id = sanitize_input($connection, $_POST['project_id']);
        $project_name = sanitize_input($connection, $_POST['project_name']);
        $client_id = sanitize_input($connection, $_POST['client_id']);
        $start_date = sanitize_input($connection, $_POST['start_date']);
        $end_date = sanitize_input($connection, $_POST['end_date']);
        $project_description = sanitize_input($connection, $_POST['project_description']);

        $stmt = $connection->prepare("INSERT INTO projects (project_id, project_name, client_id, start_date, end_date, project_description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $project_id, $project_name, $client_id, $start_date, $end_date, $project_description); 

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }

    $sql = "SELECT * FROM projects";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Projects</h2>
    <table>
        <tr>
            <th>Project Id</th>
            <th>Project Name</th>
            <th>Client Id</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Project Description</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $project_id = $row["project_id"];
                echo "<tr>
                        <td>{$row['project_id']}</td>
                        <td>{$row['project_name']}</td>
                        <td>{$row['client_id']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>{$row['project_description']}</td>
                        <td><a style='padding:4px' href='delete_project.php?project_id=$project_id'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_project.php?project_id=$project_id'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        ?>
    </table>

    <footer>
        <center>
            <b>UR CBE BIT &copy; 2024 &reg;, Designed by: @Muvara Valens</b>
        </center>
    </footer>

    <?php
    $connection->close();// Close the database connection
    ?>
</body>
</html>
