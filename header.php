<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy-Website</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('connection.php'); ?>


<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <a class="navbar-brand" href="#">AlHabib <span>Pharmacy</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            '.$_SESSION['fullname'].'
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="index.php">Home</a>
                            <a class="dropdown-item" href="checkout.php">Check out</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#products">Products</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact Us</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                          </li>';
                }
            ?>
        </ul>
    </div>
</nav>
