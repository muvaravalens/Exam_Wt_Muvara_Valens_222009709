<?php
include('database_connection.php');

// Fetch project information if project_id is provided
if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    
    $stmt = $connection->prepare("SELECT * FROM projects WHERE project_id = ?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $project_id = $row['project_id'];
        $project_name = $row['project_name'];
        // Add other project details if needed
    } else {
        echo "Project not found.";
        exit(); // Stop execution if no matching record
    }
} else {
    echo "No project ID specified.";
    exit(); // Stop execution if no project_id is provided
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Project</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?'); // Confirmation prompt
        }
    </script>
</head>
<body style="background-color: lightblue;">
    <h2>Update Project Information</h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="project_id">Project Id:</label>
        <input type="number" id="project_id" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>" readonly>
        <br><br>

        <label for="project_name">Project Name:</label>
        <input type="text" id="project_name" name="project_name" value="<?php echo htmlspecialchars($project_name); ?>">
        <br><br>
        
        <!-- Add other project fields here -->
        
        <input type="submit" name="update" value="Update">
        <a href="./project.php">Go Back to Form</a>
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $project_id = $_POST['project_id'];
    $project_name = $_POST['project_name'];
    // Add other project fields if needed

    $stmt = $connection->prepare("UPDATE projects SET project_name = ? WHERE project_id = ?");
    $stmt->bind_param("si", $project_name, $project_id);
    $stmt->execute();
    
    header('Location: project.php');
    exit();
}
?>
