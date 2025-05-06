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

// Handle form submission to insert the product into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $product_name = $_POST['product_name'];
    $category = $_POST['category']; // This should be the category ID now
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Insert query
    $sql = "INSERT INTO Products (ProductName, Category, Quantity, Price, Status) 
            VALUES ('$product_name', '$category', '$quantity', '$price', '$status')";

    if ($connection->query($sql) === TRUE) {
        header("Location: admin.php"); // Redirects back to admin page after adding product
        exit(); // Make sure to exit after redirecting
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
?>

<style>
    select#category {
        width: 210px; 
        height: 30px; 
        font-size: 16px;
        padding: 5px; 
    }

    select#status{
        width: 210px; 
        height: 30px; 
        font-size: 16px;
        padding: 5px; 
        margin-bottom: 5px;
    }
</style>

<h2>Insert Product</h2>
<form action="insert_products.php" method="POST" class="align-items-center">
    <label for="product_name">Product Name:</label><br>
    <input type="text" id="product_name" name="product_name" required><br><br>

    <label for="category">Category:</label><br>
    <select name="category" id="category" required>
        <?php
        // Fetch categories from the database to populate the dropdown
        $category_query = "SELECT CategoryID, CategoryName FROM Categories";
        $result = $connection->query($category_query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['CategoryID'] . "'>" . htmlspecialchars($row['CategoryName']) . "</option>";
            }
        }
        ?>
      </select><br><br>

    <label for="quantity">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity" required><br><br>

    <label for="price">Price:</label><br>
    <input type="number" step="0.01" id="price" name="price" required><br><br>

    <label for="status">Status:</label><br>
    <select id="status" name="status" required>
        <option value="Available">Available</option>
        <option value="Out of Stock">Out of Stock</option> <!-- Changed to match your original status -->
    </select><br><br>

    <button type="submit" class="admin-buttons">Add Product</button>
</form>

<?php
// Close the database connection
$connection->close();
?>