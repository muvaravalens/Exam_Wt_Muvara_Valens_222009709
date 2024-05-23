<?php
// Include database connection file to establish a connection to the database
include('database_connection.php'); // Modify to match your actual file path

// Check if 'team_id' parameter is set in the request
if (isset($_REQUEST['team_id'])) {
    $team_id = $_REQUEST['team_id'];
    
    // Prepare the SQL statement to delete a record from the team table
    $stmt = $connection->prepare("DELETE FROM team WHERE team_id = ?");
    $stmt->bind_param("i", $team_id); // 'i' indicates that 'team_id' is an integer

    // HTML structure for the page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Team</title>
    <script>
        // Function to confirm the deletion when the form is submitted
        function confirmDelete() {
            return confirm("Are you sure you want to delete this team?");
        }
    </script>
</head>
<body bgcolor="pineapple"> <!-- Unique background color as mentioned -->

    <!-- Form to trigger the deletion process upon submission -->
    <form method="post" onsubmit="return confirmDelete();">
        <!-- Hidden field to carry the team_id value in POST request -->
        <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
        <!-- Submit button for deleting the team record -->
        <input type="submit" value="Delete Team">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Execute the delete statement and check for success
        if ($stmt->execute()) {
            echo "Team record deleted successfully."; 
        } else {
            echo "Error deleting team record: " . $stmt->error; 
        }
    }
    ?>

    <!-- Button to navigate back to the team list -->
    <button onclick="window.location.href='./team.php'">Back to Team List</button>

</body>
</html>
<?php
    // Close the prepared statement after execution
    $stmt->close();
} else {
    echo "Team ID is not set.";
}

// Close the database connection
$connection->close();
?>
