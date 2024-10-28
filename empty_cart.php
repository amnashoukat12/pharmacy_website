<?php

	session_start();

	unset($_SESSION['cart']);

	header('Location: explor.php');

?>