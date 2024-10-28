<?php
	
	session_start();


	$product_id = $_GET['product_id'];

	if( isset($_SESSION['cart']) ){

		$arrayofproducts = $_SESSION['cart'];
		array_push($arrayofproducts, $product_id);

	}else{

		$arrayofproducts = [];
		array_push($arrayofproducts, $product_id);
		
	}
	

	

	$_SESSION['cart'] = $arrayofproducts;

	header("Location: explor.php");

	



?>