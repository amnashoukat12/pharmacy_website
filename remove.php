<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    if (isset($_SESSION['cart']) && in_array($product_id, $_SESSION['cart'])) {
        $index = array_search($product_id, $_SESSION['cart']);

        if ($index !== false) {
            unset($_SESSION['cart'][$index]);

            $_SESSION['cart'] = array_values($_SESSION['cart']);

            header("Location: checkout.php?removed=true");
            exit();
        }
    } else {
        header("Location: checkout.php?error=product_not_found");
        exit();
    }
} else {
    header("Location: checkout.php?error=invalid_request");
    exit();
}
?>
