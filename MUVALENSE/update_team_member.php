<?php
include('database_connection.php');

// Fetch team information if team_id is provided
if (isset($_GET['team_id'])) {
    $team_id = $_GET['team_id'];
    
    $stmt = $connection->prepare("SELECT * FROM team WHERE team_id = ?");
    $stmt->bind_param("i", $team_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $team_id = $row['team_id'];
        $team_name = $row['team_name'];
        $team_member_name = $row['team_member_name'];
        $team_member_email = $row['team_member_email'];
        $team_member_phone = $row['team_member_phone'];
    } else {
        echo "Team not found.";
        exit(); // Stop execution if no matching record
    }
} else {
    echo "No team ID specified.";
    exit(); // Stop execution if no team_id is provided
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Team</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?'); // Confirmation prompt
        }
    </script>
</head>
<body style="background-color: lightblue;">
    <h2>Update Team Information</h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="team_id">Team Id:</label>
        <input type="number" id="team_id" name="team_id" value="<?php echo htmlspecialchars($team_id); ?>" readonly>
        <br><br>

        <label for="team_name">Team Name:</label>
        <input type="text" id="team_name" name="team_name" value="<?php echo htmlspecialchars($team_name); ?>">
        <br><br>
        
        <label for="team_member_name">Team Member Name:</label>
        <input type="text" id="team_member_name" name="team_member_name" value="<?php echo htmlspecialchars($team_member_name); ?>">
        <br><br>
        
        <label for="team_member_email">Team Member Email:</label>
        <input type="email" id="team_member_email" name="team_member_email" value="<?php echo htmlspecialchars($team_member_email); ?>">
        <br><br>
        
        <label for="team_member_phone">Team Member Phone:</label>
        <input type="tel" id="team_member_phone" name="team_member_phone" value="<?php echo htmlspecialchars($team_member_phone); ?>">
        <br><br>
        
        <input type="submit" name="update" value="Update">
        <a href="./team.php">Go Back to Form</a>
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $team_id = $_POST['team_id'];
    $team_name = $_POST['team_name'];
    $team_member_name = $_POST['team_member_name'];
    $team_member_email = $_POST['team_member_email'];
    $team_member_phone = $_POST['team_member_phone'];

    $stmt = $connection->prepare("UPDATE team SET team_name = ?, team_member_name = ?, team_member_email = ?, team_member_phone = ? WHERE team_id = ?");
    $stmt->bind_param("ssssi", $team_name, $team_member_name, $team_member_email, $team_member_phone, $team_id);
    $stmt->execute();
    
    header('Location: team.php');
    exit();
}
?>
