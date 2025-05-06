<?php
// Include database configuration
include 'config.php';

// Define arrays of product IDs for the rows
$row1ProductIds = [1, 2, 3, 7, 8, 10, 12, 26, 28]; // Product IDs for the first row
$row2ProductIds = [4, 5, 6, 9, 11, 24, 25, 27, 29]; // Product IDs for the second row
$row3ProductIds = [3, 23, 22]; // Endorsement - Laptop
$row4ProductIds = [18, 20];
// Function to fetch products based on product IDs
function fetchProducts($conn, $productIds) {
    // Check if the array is empty
    if (empty($productIds)) {
        return [];
    }

    // Convert the array to a comma-separated string for SQL
    $productIdsPlaceholder = implode(',', array_fill(0, count($productIds), '?'));

    // Build the query
    $sql = "
        SELECT p.ProductID, p.ProductName, p.Price, p.ProductImages, p.Category, c.CategoryName
        FROM products p
        LEFT JOIN categories c ON p.Category = c.CategoryID
        WHERE p.ProductID IN ($productIdsPlaceholder)
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the product ID values dynamically
    $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all results as an associative array
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch products for each row
$row1Products = fetchProducts($conn, $row1ProductIds);
$row2Products = fetchProducts($conn, $row2ProductIds);
$row3Products = fetchProducts($conn, $row3ProductIds);
$row4Products = fetchProducts($conn, $row4ProductIds);  // ENDORSEMENT - Desktops

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroGear</title>
    <!--Bootstraps-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!--CSS-->
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="file.png">
</head>

<body>
    <nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="index.php"><img src="Astrogear black cropped.png" alt="Logo" class="logo"></a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php"><i class="fa-solid fa-heart fa-2xl"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="astrogear-login.html"><i class="fa-solid fa-user fa-2xl"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <!--This is the intro header-->
    <header class="page-header header container-fluid">
        <div class="overlay"></div>
        <div class="description">
            <h1>WELCOME TO <span id="header-logo"><img src="Astrogear black cropped.png" alt="AstroGear"></span></h1>
            <p>Founded by <span id="founders">Denise Ambat, Juztine Bayucan, Aven Buena, Jirah Costales, Joemar Saberon</span>  in 2024, Astro Gear Services technology-based retailer that specializes in selling computer parts directly to consumers, effectively bypassing third-party retailers and wholesalers. This direct-to-consumer model allows AstroGear to offer competitive pricing and a more streamlined shopping experience for tech enthusiasts and casual buyers alike.</p>
            <a href="all_Products.php"  style="text-decoration:none;"><button
            style="
             background-color: transparent;
    border: 1px solid white;
    width: 150px;
    height: 50px;
    font-family: 'Poppins', sans-serif;
    color: white;
    font-weight: bold;
    border-radius: 10px;
    outline:none;
            
            "
            
            
            >SHOP NOW</button></a>
        </div>
    </header>   

    <div class="grid-container2">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="carousel 1.png" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="carousel 2.png" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="carousel 3.png" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
    </div>

    <!--This is the product carousel-->
    <div class="product-grid">
        <div class="product-container swiper">
            <div class="product-wrapper">
                <ul class="product-list swiper-wrapper">
                    <li class="product-card swiper-slide">
                        <a href="processors.php" class="product-link">
                            <img src="productImages/processors/ryzen77800x.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Processors</p>
                            <h2 class="product-title">PROCESSORS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="motherboard.php" class="product-link">
                            <img src="productImages/motherboards/gigabyteBB550m.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Motherboards</p>
                            <h2 class="product-title">MOTHERBOARDS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="gpu.php" class="product-link">
                            <img src="productImages/gpu/rx7900xtx.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Graphics Cards</p>
                            <h2 class="product-title">GRAPHICS CARDS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="memory.php" class="product-link">
                            <img src="productImages/memory/gskillRam1.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Memory</p>
                            <h2 class="product-title">MEMORY</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="ssd.php" class="product-link">
                            <img src="productImages/solidStateDrive/samsung990pro.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Solid State Drives</p>
                            <h2 class="product-title">SSD</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="psu.php" class="product-link">
                            <img src="productImages/powerSupply/seasonicPsu.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Power Supply</p>
                            <h2 class="product-title">POWER SUPPLY</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="case.php" class="product-link">
                            <img src="productImages/case/lianliCase.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Pc Case</p>
                            <h2 class="product-title">PC CASE</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="laptop.php" class="product-link">
                            <img src="productImages/laptop/rogZyphyrusG14Square.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Laptops</p>
                            <h2 class="product-title">LAPTOPS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="monitor.php" class="product-link">
                            <img src="productImages/monitor/msiMonitor.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Monitors</p>
                            <h2 class="product-title">Monitors</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="keyboard.php" class="product-link">
                            <img src="productImages/keyboard/wooting60he.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Keyboards</p>
                            <h2 class="product-title">KEYBOARDS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="mouse.php" class="product-link">
                            <img src="productImages/mouse/lamzuAtlantis.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Mouse</p>
                            <h2 class="product-title">MOUSE</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="headphones.php" class="product-link">
                            <img src="productImages/headset/logitechGproX.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Headphones</p>
                            <h2 class="product-title">HEADPHONES</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="Desktop.php" class="product-link">
                            <img src="productImages/prebuilt/beast.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Desktop</p>
                            <h2 class="product-title">DESKTOPS</h2>
                        </a>
                    </li>

                </ul>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>

    

    <!--This is for the product endorsement-->
    <div class="endorsement-grid">
        <div class="endorsement-header">
            <div class="endorsement-container1">
                <div class="endoresement-overlay"></div>
                <div class="endoresement-text">
                <!-- DESKTOP -->
                <h1>DESKTOPS</h1>
                </div>
                <div class="endorsement-wrapper swiper">
                    <ul class="endorsement-list swiper-wrapper">
                        <?php foreach ($row4Products as $row): ?>
                        <li class="endorsement-card swiper-slide">
                           
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="endorsement-link">
                                <img src="productImages/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="endorsement-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="endorsement-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="product-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                    <div class="endorsement-buttons">
                                        <button type="submit" class="buy-now-btn">Buy Now</button>
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            <!-- LAPTOPS -->
            <div class="endorsement-container2">
                <div class="endoresement-overlay"></div>
                <div class="endoresement-text">
                <h1>LAPTOPS</h1>
                </div>
                <div class="endorsement-wrapper swiper">
                    <ul class="endorsement-list swiper-wrapper">
                    <?php foreach ($row3Products as $row): ?>
                        <li class="endorsement-card swiper-slide">
                           
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="endorsement-link">
                                <img src="productImages/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="endorsement-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="endorsement-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="product-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                    <div class="endorsement-buttons">
                                        <button type="submit" class="buy-now-btn">Buy Now</button>
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

    <!--Suggested Products-->
    <div class="suggested-products">
        <div class="sug-pos">
        <h2 class="sug-title">Suggested Products</h2>
        </div>
        <div class="suggested-products">
        <div class="suggested-grid">
            <div class="suggested-container swiper">
                <div class="suggested-wrapper">
                    <ul class="suggested-list swiper-wrapper">
                    <?php foreach ($row1Products as $row): ?>
                        <li class="suggested-card swiper-slide">
                        <form method="POST" action="wishlist.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                <button class="add-to-wishlist2" type="submit" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart fa-2xl"></i>
                                </button>
                            </form>
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="suggested-link">
                                <img src="productImages/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="suggested-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="suggested-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="suggested-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                    <div class="endorsement-buttons">
                                        <button type="submit" class="buy-now-btn">Buy Now</button>
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="suggested-products">
        <div class="suggested-grid">
            <div class="suggested-container swiper">
                <div class="suggested-wrapper">
                    <ul class="suggested-list swiper-wrapper">
                    <?php foreach ($row2Products as $row): ?>
                        <li class="suggested-card swiper-slide">
                        <form method="POST" action="wishlist.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                <button class="add-to-wishlist2" type="submit" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart fa-2xl"></i>
                                </button>
                            </form>
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="suggested-link">
                                <img src="productImages/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="suggested-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="suggested-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="suggested-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                    <div class="endorsement-buttons">
                                        <button type="submit" class="buy-now-btn">Buy Now</button>
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    
    
    <!--This is the page footer-->
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">Additional Information</h6>
                    <p>AstroGear is set to make a big impact in the e-commerce industry by offering computer hardware customers a focused, streamlined, and specialized online purchasing experience. AstroGear has the ability to revolutionize the way computer fans make online purchases because of its wide range of products and dedication to customer happiness.</p>
                    <p>AstroGear specializes in computer components, offering products such as CPUs, GPUs, motherboards, memory, SSDs, power supplies, and software. In addition to hardware, the company provides consumer electronics like laptops, mobile phones, and accessories, along with desktop furniture. AstroGear also offers specialized services including custom computer building, cleaning for residential and commercial spaces, and repair services for various devices.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">Contact</h6>
                    <p>1870 Antipolo, Maia Alta, Rizal<br /> astrogear@gmail.com
                        <br /> +63 923 567 8841<br /> +63 992 567 8834</p>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center">
            © 2024 Copyright: astrogear.com
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
    
</body>

</html>