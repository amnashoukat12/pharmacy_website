<?php
include('connection.php');

$fullname_error = '';
$email_error = '';
$password_error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($fullname)) {
        $fullname_error = "Please enter your fullname";
    } elseif (strlen($fullname) < 3) {
        $fullname_error = "Your name should be greater than 3 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        $fullname_error = "Fullname can only contain letters";
    }

    if (empty($email)) {
        $email_error = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Enter a valid email address";
    }

    if (empty($password)) {
        $password_error = "Please enter your password";
    } else {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $password_error = 'Password should be at least 8 characters
            <br>◙ at least one upper case letter(A),
            <br>◙ one number(1),
            <br>◙ one special character(@).';
        }
    }

    if (empty($fullname_error) && empty($email_error) && empty($password_error)) {

        $selectquery = "SELECT * FROM sign_up WHERE email = '$email'";

        $result = $connection->query($selectquery);

        if ($result->num_rows == 0) {

            $encpassword = md5($password);
            $insertquery = "INSERT INTO sign_up (fullname, email, password) VALUES ('$fullname', '$email', '$encpassword')";

            if ($connection->query($insertquery)) {
                $success = "You have successfully registered. Please <a href='login.php'>login</a>";
                $fullname = '';
                $email = '';
                $password = '';
            } else {
                $email_error = "This email already exists. Please login";
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
    <title>Pharmacy Sign Up</title>
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
        color: #151515;
    }
    .form-container {
        width: 80%;
        padding: 30px;
        max-width: 400px;
        border-radius: 8px;
        position: absolute;
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
        border: none;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
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
        transform: translateY(-20px);
        pointer-events: none;
    }
</style>

<div class="form-container" id="signup-form-container">
    <?php
    if ($success != '') {
        echo '<div class="alert">' . $success . '</div>';
    }
    ?>
    <form action="sign_up.php" method="POST" class="signup-form">
        <h2>Sign Up for Pharmacy</h2>
        <div class="input-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php if (isset($fullname)) echo htmlspecialchars($fullname); ?>" autocomplete="off">
            <?php echo "<div class='user'>$fullname_error</div>"; ?>
        </div>
        <div class="input-group">
            <label for="signup-email">Email</label>
            <input type="email" id="signup-email" name="email" value="<?php if (isset($email)) echo htmlspecialchars($email); ?>" autocomplete="off">
            <?php echo "<div class='user'>$email_error</div>"; ?>
        </div>
        <div class="input-group">
            <label for="signup-password">Password</label>
            <input type="password" id="signup-password" name="password" value="<?php if (isset($password)) echo htmlspecialchars($password); ?>" autocomplete="off">
            <?php echo "<div class='user'>$password_error</div>"; ?>
        </div>
        <button type="submit" class="btn">Sign Up</button>
        <p class="message">Already have an account? <a href="login.php" id="login-link">Login</a></p>
    </form>
</div>



</body>
</html>
