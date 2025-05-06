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

// Query to fetch all categories from the Categories table
$sql = "SELECT CategoryID, CategoryName FROM Categories ORDER BY CategoryName";
$result = $connection->query($sql);
?>

<h2>Categories List</h2>

<!-- Table to display categories -->
<table border="1">
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($category = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . htmlspecialchars($category['CategoryID']) . '</td>
                        <td>' . htmlspecialchars($category['CategoryName']) . '</td>
                    </tr>';
            }
        } else {
            echo '
                    <tr>
                        <td colspan="2">No categories found.</td>
                    </tr>';
        }
        ?>
    </tbody>
</table>

<?php
// Close the database connection
$connection->close();
?>