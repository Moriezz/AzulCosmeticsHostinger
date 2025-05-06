<?php
session_start();
include("config.php");

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add items to your wishlist.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the product ID is passed
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Check if the product exists
    $product_query = "SELECT * FROM products WHERE ProductID = $product_id";
    $product_result = mysqli_query($conn, $product_query);
    if ($product = mysqli_fetch_assoc($product_result)) {
        // Insert product into the wishlist
        $wishlist_query = "INSERT INTO wishlist (UserID, ProductID) VALUES ($user_id, $product_id)";
        if (mysqli_query($conn, $wishlist_query)) {
            echo "Product added to wishlist!";
        } else {
            echo "Error adding to wishlist: " . mysqli_error($conn);
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID is required.";
}
?>
