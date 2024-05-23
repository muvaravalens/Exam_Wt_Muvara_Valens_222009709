<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
</head>
<body style="background-color:skyblue;">

<?php
include('database_connection.php');

if (isset($_GET['query'])) {
    // Sanitize the input to avoid SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    $queries = [
        'asset' => "SELECT asset_id, asset_name, asset_description, asset_url 
                    FROM asset 
                    WHERE asset_id LIKE '%$searchTerm%' 
                    OR asset_name LIKE '%$searchTerm%'
                    OR asset_description LIKE '%$searchTerm%'
                    OR asset_url LIKE '%$searchTerm%'",

        'campaign' => "SELECT campaign_id, campaign_name, project_id, start_date, end_date, campaign_description 
                       FROM campaign 
                       WHERE campaign_id LIKE '%$searchTerm%' 
                       OR campaign_name LIKE '%$searchTerm%'
                       OR project_id LIKE '%$searchTerm%'
                       OR start_date LIKE '%$searchTerm%'
                       OR end_date LIKE '%$searchTerm%'
                       OR campaign_description LIKE '%$searchTerm%'",

        'clients' => "SELECT client_id, client_name, client_email, client_phone, client_company 
                      FROM clients 
                      WHERE client_id LIKE '%$searchTerm%' 
                      OR client_name LIKE '%$searchTerm%'
                      OR client_email LIKE '%$searchTerm%'
                      OR client_phone LIKE '%$searchTerm%'
                      OR client_company LIKE '%$searchTerm%'",

        'projects' => "SELECT project_id, project_name, client_id, start_date, end_date, project_description 
                       FROM projects 
                       WHERE project_id LIKE '%$searchTerm%' 
                       OR project_name LIKE '%$searchTerm%'
                       OR client_id LIKE '%$searchTerm%'
                       OR start_date LIKE '%$searchTerm%'
                       OR end_date LIKE '%$searchTerm%'
                       OR project_description LIKE '%$searchTerm%'",

        'team' => "SELECT team_id, team_name, team_member_name, team_member_email, team_member_phone 
                   FROM team 
                   WHERE team_id LIKE '%$searchTerm%' 
                   OR team_name LIKE '%$searchTerm%'
                   OR team_member_name LIKE '%$searchTerm%'
                   OR team_member_email LIKE '%$searchTerm%'
                   OR team_member_phone LIKE '%$searchTerm%'",

        'users' => "SELECT user_id, first_name, last_name, username, email 
                    FROM users 
                    WHERE user_id LIKE '%$searchTerm%' 
                    OR first_name LIKE '%$searchTerm%'
                    OR last_name LIKE '%$searchTerm%'
                    OR username LIKE '%$searchTerm%'
                    OR email LIKE '%$searchTerm%'"
    ];

    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table: " . ucfirst($table) . "</h3>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>";
                foreach ($row as $key => $value) {
                    echo "<strong>$key</strong>: $value ";
                }
                echo "</p>";
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}

echo '<a href="home.html"><button>&larr; Back to home</button></a>';
?>

</body>
</html>
