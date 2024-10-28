<?php
include('connection.php'); 


function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardholderName = isset($_POST['cardholder_name']) ? sanitize_input($_POST['cardholder_name']) : '';
    $cardNumber = isset($_POST['card_number']) ? sanitize_input($_POST['card_number']) : '';
    $startDate = isset($_POST['start_date']) ? sanitize_input($_POST['start_date']) : '';
    $endDate = isset($_POST['end_date']) ? sanitize_input($_POST['end_date']) : '';
    $bankName = isset($_POST['bank_name']) ? sanitize_input($_POST['bank_name']) : '';

    
    if (empty($cardholderName) || empty($cardNumber) || empty($startDate) || empty($endDate) || empty($bankName)) {
        echo "All fields are required.";
        exit;
    }

    $sql = "INSERT INTO payments (cardholder_name, card_number, start_date, end_date, bank_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sssss', $cardholderName, $cardNumber, $startDate, $endDate, $bankName);

    if ($stmt->execute()) {
        header("Location: thank_you.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
} else {
    echo "Invalid request method.";
}
?>
