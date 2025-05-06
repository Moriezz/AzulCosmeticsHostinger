<?php
// Include the database connection file
include('config.php');

// Start the session to get the logged-in user's ID
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if the product ID is sent via POST
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id']; // Product ID from the form
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Default quantity to 1 if not set

        // Check if the product already exists in the cart for the logged-in user
        $query = "SELECT Quantity, Price FROM cart WHERE ProductID = ? AND UserID = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ii", $productId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Product exists in the cart, update the quantity and calculate the new total price
                $cartItem = $result->fetch_assoc();
                $newQuantity = $cartItem['Quantity'] + $quantity;

                // Fetch the product's unit price from the products table
                $productQuery = "SELECT Price FROM products WHERE ProductID = ?";
                $productStmt = $conn->prepare($productQuery);
                $productStmt->bind_param("i", $productId);
                $productStmt->execute();
                $productResult = $productStmt->get_result();

                if ($productResult->num_rows > 0) {
                    $product = $productResult->fetch_assoc();
                    $productPrice = $product['Price'];
                    $newTotalPrice = $productPrice * $newQuantity;

                    // Update the cart with the new quantity and price
                    $updateQuery = "UPDATE cart SET Quantity = ?, Price = ? WHERE ProductID = ? AND UserID = ?";
                    if ($updateStmt = $conn->prepare($updateQuery)) {
                        $updateStmt->bind_param("idii", $newQuantity, $newTotalPrice, $productId, $userId);
                        $updateStmt->execute();
                        echo "<script>alert('Product quantity updated in your cart.'); window.location.href='cart.php';</script>";
                    }
                }

                $productStmt->close();
            } else {
                // Product does not exist in the cart, insert it with the correct price
                $productQuery = "SELECT Price FROM products WHERE ProductID = ?";
                $productStmt = $conn->prepare($productQuery);
                $productStmt->bind_param("i", $productId);
                $productStmt->execute();
                $productResult = $productStmt->get_result();

                if ($productResult->num_rows > 0) {
                    $product = $productResult->fetch_assoc();
                    $productPrice = $product['Price'];
                    $totalPrice = $productPrice * $quantity;

                    $insertQuery = "INSERT INTO cart (UserID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)";
                    if ($insertStmt = $conn->prepare($insertQuery)) {
                        $insertStmt->bind_param("iiid", $userId, $productId, $quantity, $totalPrice);
                        $insertStmt->execute();
                        echo "<script>alert('Product quantity updated in your cart.'); window.location.href='cart.php';</script>"; // Return success message
                    }
                } else {
                    echo "Product not found."; // Error if product does not exist
                }

                $productStmt->close();
            }

            $stmt->close();
        }
    } else {
        echo "Please provide a valid product ID."; // Error message if product ID is missing
    }
} else {
    echo "Please log in to add items to your cart."; // Error message if not logged in
}

$conn->close();

?>
