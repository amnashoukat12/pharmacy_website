<?php
include('connection.php');
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_id'] == 'user_id') {
        header('Location: index.php');
    } else {
        header('Location: login.php');
    }
}

$email_error = '';
$password_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        if (empty($email)) {
            $email_error = "please enter email";
        }
        if (empty($password)) {
            $password_error = "please enter password";
        }
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please enter correct email format.";
        } else {
            if ($email_error == '' && $password_error == '') {
                $encpassword = md5($password);
                $selectquery = "SELECT * FROM sign_up WHERE email = '$email' AND password = '$encpassword'";
                $result = $connection->query($selectquery);

                if ($result->num_rows == 0) {
                    $email_error = "This email or password combination does not match.";
                } else {
                    $data = mysqli_fetch_assoc($result);
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['fullname'] = $data['fullname'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['password'] = $data['password'];

                    header("Location: index.php");
                    exit();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<style>
    body {
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f4f4f9;
        font-family: 'Montserrat', sans-serif;
    }
    .user {
        color: red;
        font-weight: 500;
        margin-bottom: 5px;
    }
    .alert {
        color: #fff;
    }
    .form-container {
        width: 80%;
        padding: 30px;
        max-width: 400px;
        position: absolute;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }
    .input-group {
        margin-bottom: 15px;
    }
    .input-group label {
        color: #555;
        display: block;
        margin-bottom: 5px;
    }
    .input-group input {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
    }
    .input-group input:focus {
        outline: none;
        border-color: #007bff;
    }
    .btn {
        color: #fff;
        width: 100%;
        border: none;
        cursor: pointer;
        font-size: 16px;
        padding: 10px 15px;
        border-radius: 4px;
        background-color: #007bff;
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #0056b3;
    }
    .message {
        text-align: center;
        margin-top: 15px;
    }
    .message a {
        color: #007bff;
        text-decoration: none;
    }
    .message a:hover {
        text-decoration: underline;
    }
    .hidden {
        opacity: 0;
        pointer-events: none;
        transform: translateY(-20px);
    }
</style>

<div class="form-container" id="login-form-container">
    <form action="login.php" method="POST" class="login-form">
        <h2>Login to Pharmacy</h2>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php if (isset($email)) echo htmlspecialchars($email); ?>">
            <?php echo "<div class='user'>$email_error</div>"; ?>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php if (isset($password)) echo htmlspecialchars($password); ?>">
            <?php echo "<div class='user'>$password_error</div>"; ?>
        </div>
        <button type="submit" class="btn">Login</button>
        <p class="message">Don't have an account? <a href="sign_up.php" id="signup-link">Sign up</a></p>
    </form>
</div>

</body>
</html>
