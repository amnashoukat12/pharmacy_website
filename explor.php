<?php include('header.php'); ?>

<style>
  body {
    background-color: #f4f4f9;
    font-family: 'Montserrat', sans-serif;
  }

  .btn-custom {
    width: 80px;
    border: none;
    color: black;
    font-size: 12px;
    font-weight: bold;
    border-radius: 4px;
    background-color: #98D5D3;
    transition: background-color 0.3s ease;
  }

  .btn-custom:hover {
    color: #fff;
    background-color: #77bfb8;
  }

  .custom-btn {
    width: 80px;
    border: none;
    color: black;
    font-weight: bold;
    border-radius: 4px;
    background-color: #98D5D3;
    transition: background-color 0.3s ease;
  }

  .custom-btn:hover {
    color: #fff;
    background-color: #77bfb8;
  }

  .search {
    width: 150px;
  }

  .card {
    width: 350px;
    height: auto;
    overflow: hidden;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    transition: transform 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .card:hover {
    transform: scale(1.03);
  }

  .card-img-top {
    width: 100%;        
    height: 200px;      
    object-fit: cover; 
    transition: opacity 0.3s ease;
  }

  .card-body {
    padding: 15px;
  }

  .card-title {
    color: #333;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 8px;
  }

  .card-text {
    color: #555;
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 10px;
  }

  .text-body-custom {
    color: #777;
    font-size: 12px;
  }

  .d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card .btn {
    padding: 6px 10px;
    font-size: 11px;
  }
</style>

<?php
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    $result1 = $connection->query("SELECT * FROM product WHERE name LIKE '%$keyword%'");
}
?>

<div class="container mt-4">
  <form action="explor.php" method="GET" class="d-flex" role="search">
    <input class="search form-control me-2" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php if (isset($keyword)) { echo $keyword; } ?>">
    <button class="btn btn-custom" type="submit">Search</button>
  </form>
</div>

<div class="container mt-3">
  <div class="row">
    <?php
    if (isset($_GET['keyword'])) {
        if ($result1->num_rows == 0) {
            echo '<p class="mt-4">No products found for this keyword.</p>';
        } else {
            while ($data = mysqli_fetch_assoc($result1)) {
    ?>
                <div class="col-md-4">
                    <div class="card mt-3">
                        <img src="products/<?php echo $data['pic']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($data['description'], 0, 50), ENT_QUOTES, 'UTF-8'); ?>...</p>
                            <p class="card-text">
                                <h6 class="text-body-custom">Availability: <?php echo htmlspecialchars($data['availability'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                <br>
                                <h6 class="text-body-custom">Price: PKR <?php echo htmlspecialchars($data['price'], ENT_QUOTES, 'UTF-8'); ?></h6>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#buyNowModal">
                                    <i class="bi bi-bag-heart-fill"></i> BUY NOW
                                </a>
                                <a href="add_cart.php?product_id=<?php echo htmlspecialchars($data['product_id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn custom-btn">
                                    <i class="bi bi-cart-fill"></i> Add Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
    <?php
            }
        }
    } else {
        $query = "SELECT * FROM product ORDER BY name DESC";

        $result = $connection->query($query);

        if ($result->num_rows == 0) {
            echo '<p class="mt-4">No products found.</p>';
        } else {
            while ($data = mysqli_fetch_assoc($result)) {
                $user_id = $data['user_id'];
                $userinfo = $connection->query("SELECT * FROM sign_up WHERE user_id='$user_id'");
                $userinfodata = mysqli_fetch_assoc($userinfo);
    ?>
                <div class="col-md-4">
                    <div class="card mt-3">
                        <img src="products/<?php echo $data['pic']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($data['description'], 0, 50), ENT_QUOTES, 'UTF-8'); ?>...</p>
                            <p class="card-text">
                                <h6 class="text-body-custom">Availability: <?php echo htmlspecialchars($data['availability'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                <br>
                                <h6 class="text-body-custom">Price: PKR <?php echo htmlspecialchars($data['price'], ENT_QUOTES, 'UTF-8'); ?></h6>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#buyNowModal">
                                    <i class="bi bi-bag-heart-fill p-2"></i> BUY NOW
                                </a>
                                <a href="add_cart.php?product_id=<?php echo htmlspecialchars($data['product_id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn custom-btn">
                                    <i class="bi bi-cart-fill"></i> Add Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }
    ?>
  </div>
</div>

<div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyNowModalLabel">Payment Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="process_payment.php" method="POST">
                    <div class="mb-3">
                        <label for="cardholderName" class="form-label">Cardholder Name</label>
                        <input type="text" class="form-control" id="cardholderName" name="cardholder_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">ATM Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="card_number" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="text" class="form-control" id="startDate" name="start_date" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="text" class="form-control" id="endDate" name="end_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bankName" class="form-label">Bank Name</label>
                        <input type="text" class="form-control" id="bankName" name="bank_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include('footer.php'); ?>
