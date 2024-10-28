<?php include('header.php'); ?>


<style>
.box{
	  width: 100%;
      height: 100vh;
      background-color: #f4f4f9;
      
      
    } 
    .btn-custom {
       width: 100px;
       color: black;
       margin-top: 10px;
       font-weight: bold;
       margin-bottom: 10px;
       background-color: #98D5D3;          
    }
    .btn-custom:hover{ 
       color: #fff;
    }

    .text-danger{
    	color: red;
    	font-size: 15px;
        font-weight: bold;  
    }
</style>
	
<div class="box">
	<div class="container">
		
		<a href="empty_cart.php" class="btn btn-custom">
			Empty Cart
		</a>
		
		<table class="table table-striped">
			<thead>
			    <tr>
			      <th scope="col" width="10%">#</th>
			      <th scope="col" width="20%">Picture</th>
			      <th scope="col" width="50%">Name</th>
			      <th scope="col" width="10%">Price</th>
			      <th scope="col" width="10%">Action</th>
			    </tr>
		  	</thead>
		  	<tbody>
		<?php

			$total = 0;
			
			if( isset($_SESSION['cart'])==true ){
				$products = $_SESSION['cart'];


				$total = 0;
				foreach( $products as $value ){

					$result = $connection->query("SELECT * FROM product WHERE product_id='$value'");

					$data = mysqli_fetch_assoc($result);

					$total = $total + $data['price'];

					?>

					<tr>
				      <td scope="row"><?php echo $data['product_id']; ?></td>
				      <td>
				      	<img src="products/<?php echo $data['pic']; ?>" class="img-fluid" width="100px" />
				      </td>
				      <td><?php echo $data['name']; ?></td>
				      <td>$<?php echo $data['price']; ?></td>
				      <td>
					    <a href="remove.php?product_id=<?php echo $data['product_id']; ?>" class="btn btn-custom">
					        Remove
					    </a>
					</td>
				    </tr>

					<?php

				}

			}
			
		?>

				<tr>
			      <th scope="row"><strong>Total</strong></th>
			      <td>
			      	
			      </td>
			      <td></td>
			      <td>$<?php echo $total; ?></td>
			      <td></td>
			    </tr>
			</tbody>
		</table>
	</div>
</div>
<?php include('footer.php'); ?>

