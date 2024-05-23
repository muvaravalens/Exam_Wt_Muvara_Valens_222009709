<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team</title>
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
    <h1>Team Form</h1>
     <form method="post" onsubmit="return confirmInsert();">
        <label for="team_id">Team Id:</label>
        <input type="number" id="team_id" name="team_id" required><br><br>
        <label for="team_name">Team Name:</label>
        <input type="text" id="team_name" name="team_name" required><br><br>
        <label for="team_member_name">Team Member Name:</label>
        <input type="text" id="team_member_name" name="team_member_name" required><br><br>
        <label for="team_member_email">Team Member Email:</label>
        <input type="email" id="team_member_email" name="team_member_email" required><br><br>
        <label for="team_member_phone">Team Member Phone:</label>
        <input type="text" id="team_member_phone" name="team_member_phone" required><br><br>
        <input type="submit" name="add_team" value="Insert"><br><br>
        <a href="./home.html">Go Back to Home</a>
    </form>

   <?php
include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_team'])) {
        $team_id = sanitize_input($connection, $_POST['team_id']);
        $team_name = sanitize_input($connection, $_POST['team_name']);
        $team_member_name = sanitize_input($connection, $_POST['team_member_name']);
        $team_member_email = sanitize_input($connection, $_POST['team_member_email']);
        $team_member_phone = sanitize_input($connection, $_POST['team_member_phone']);

        $stmt = $connection->prepare("INSERT INTO team (team_id, team_name, team_member_name, team_member_email, team_member_phone) VALUES (?, ?, ?, ?, ?)");
        
        // Check if the prepare statement is successful
        if ($stmt) {
            $stmt->bind_param("issss", $team_id, $team_name, $team_member_name, $team_member_email, $team_member_phone); 

            if ($stmt->execute()) {
                echo "New record has been added successfully.<br><br>";
            } else {
                echo "Error inserting data: " . $stmt->error;
            }
    
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $connection->error;
        }
    }

    $sql = "SELECT * FROM team";
    $result = $connection->query($sql);
    ?>

    <h2>Table of Team Projects</h2>
    <table>
        <tr>
            <th>Team Id</th>
            <th>Team Name</th>
            <th>Team Member Name</th>
            <th>Team Member Email</th>
            <th>Team Member Phone</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $team_id = $row["team_id"];
                echo "<tr>
                        <td>{$row['team_id']}</td>
                        <td>{$row['team_name']}</td>
                        <td>{$row['team_member_name']}</td>
                        <td>{$row['team_member_email']}</td>
                        <td>{$row['team_member_phone']}</td>
                        <td><a style='padding:4px' href='delete_team_member.php?team_id=$team_id'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_team_member.php?team_id=$team_id'>Update</a></td> 
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
