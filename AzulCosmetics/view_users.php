<?php
// Database connection
$host = "localhost"; // Replace with your database host
$user = "root";      // Replace with your database username
$pass = "";          // Replace with your database password
$db = "astrogear_db"; // Replace with your database name
$port = 3308;        // Port number (3308 in your case)

$connection = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to fetch all users from the Users table
$sql = "SELECT id, first_name, last_name, email, phone FROM Users ORDER BY last_name";
$result = $connection->query($sql);
?>

<h2>Users List</h2>

<!-- Table to display users -->
<table border="1">
    <thead>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Action</th> <!-- New column for Edit button -->
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . htmlspecialchars($user['id']) . '</td>
                        <td>' . htmlspecialchars($user['first_name']) . '</td>
                        <td>' . htmlspecialchars($user['last_name']) . '</td>
                        <td>' . htmlspecialchars($user['email']) . '</td>
                        <td>' . htmlspecialchars($user['phone']) . '</td>
                        <td><a href="admin.php?edit_user=' . $user['id'] . '" class="btn btn-warning btn-sm">Edit</a></td> <!-- Edit button -->
                    </tr>';
            }
        } else {
            echo '
                    <tr>
                        <td colspan="6">No users found.</td> <!-- Adjusted colspan -->
                    </tr>';
        }
        ?>
    </tbody>
</table>

<?php
// Close the database connection
$connection->close();
?>