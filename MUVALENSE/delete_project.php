<?php
// Include database connection file to establish a connection to the database
include('database_connection.php'); // Modify to match your actual file path

// Check if 'project_id' parameter is set in the request
if (isset($_REQUEST['project_id'])) {
    $project_id = $_REQUEST['project_id'];
    
    // Prepare the SQL statement to delete a record from the projects table
    $stmt = $connection->prepare("DELETE FROM projects WHERE project_id = ?");
    $stmt->bind_param("i", $project_id); // 'i' indicates that 'project_id' is an integer

    // HTML structure for the page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Project</title>
    <script>
        // Function to confirm the deletion when the form is submitted
        function confirmDelete() {
            return confirm("Are you sure you want to delete this project?");
        }
    </script>
</head>
<body bgcolor="pineapplesky"> <!-- Unique background color as mentioned -->

    <!-- Form to trigger the deletion process upon submission -->
    <form method="post" onsubmit="return confirmDelete();">
        <!-- Hidden field to carry the project_id value in POST request -->
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <!-- Submit button for deleting the project record -->
        <input type="submit" value="Delete Project">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Execute the delete statement and check for success
        if ($stmt->execute()) {
            echo "Project record deleted successfully."; 
        } else {
            echo "Error deleting project record: " . $stmt->error; 
        }
    }
    ?>

    <!-- Button to navigate back to the project list -->
    <button onclick="window.location.href='./project.php'">Back to Project List</button>

</body>
</html>
<?php
    // Close the prepared statement after execution
    $stmt->close();
} else {
    echo "Project ID is not set.";
}

// Close the database connection
$connection->close();
?>
