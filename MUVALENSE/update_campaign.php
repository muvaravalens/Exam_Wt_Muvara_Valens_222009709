<?php
include('database_connection.php');

// Fetch campaign information if campaign_id is provided
if (isset($_GET['campaign_id'])) {
    $campaign_id = $_GET['campaign_id'];
    
    $stmt = $connection->prepare("SELECT * FROM campaign WHERE campaign_id = ?");
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $campaign_id = $row['campaign_id'];
        $campaign_name = $row['campaign_name'];
        $project_id = $row['project_id'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $campaign_description = $row['campaign_description'];
    } else {
        echo "Campaign not found.";
        exit(); // Stop execution if no matching record
    }
} else {
    echo "No campaign ID specified.";
    exit(); // Stop execution if no campaign_id is provided
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Campaign</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?'); // Confirmation prompt
        }
    </script>
</head>
<body style="background-color: lightblue;">
    <h2>Update Campaign Information</h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="campaign_id">Campaign Id:</label>
        <input type="number" id="campaign_id" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>" readonly>
        <br><br>

        <label for="campaign_name">Campaign Name:</label>
        <input type="text" id="campaign_name" name="campaign_name" value="<?php echo htmlspecialchars($campaign_name); ?>">
        <br><br>
        
        <label for="project_id">Project Id:</label>
        <input type="number" id="project_id" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">
        <br><br>
        
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
        <br><br>
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
        <br><br>
        
        <label for="campaign_description">Campaign Description:</label>
        <textarea id="campaign_description" name="campaign_description"><?php echo htmlspecialchars($campaign_description); ?></textarea>
        <br><br>
        
        <input type="submit" name="update" value="Update">
        <a href="./campaign.php">Go Back to Campaign Form</a>
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $campaign_id = $_POST['campaign_id'];
    $campaign_name = $_POST['campaign_name'];
    $project_id = $_POST['project_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $campaign_description = $_POST['campaign_description'];

    $stmt = $connection->prepare("UPDATE campaign SET campaign_name = ?, project_id = ?, start_date = ?, end_date = ?, campaign_description = ? WHERE campaign_id = ?");
    $stmt->bind_param("sisssi", $campaign_name, $project_id, $start_date, $end_date, $campaign_description, $campaign_id);
    $stmt->execute();
    
    header('Location: campaign.php');
    exit();
}
?>
