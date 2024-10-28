<?php include('header.php'); ?>

<?php

  $name_error = '';
  $price_error = '';
  $availability_error = '';
  $description_error = '';
  $pic_error = '';
  $success = '';

  if( $_SERVER['REQUEST_METHOD']=='POST' ){
    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $description = $_POST['description'];

    

    if( $_FILES['pic']['name']!='' ){
      $filename = $_FILES['pic']['name'];
      $tmp_name = $_FILES['pic']['tmp_name'];
    }else{
      $pic_error = "Enter upload product picture";
    }

   
    

    if( empty($name) || empty($price) || empty($availability) || empty($description) ){

      if( empty($name) ){
        $name_error = "Enter your product name";
      }

      if( empty($price) ){
        $price_error = "Please enter product price";
      }

      if( empty($availability) ){
        $availability_error = "Please enter availability";
      }

      if( empty($description) ){
        $description_error = "Please enter description";
      }
          

    }else{


      if( $_FILES['pic']['name']!='' ){
        move_uploaded_file($tmp_name, 'products/'.$filename);
      }


      $user_id = $_SESSION['user_id'];

      $desc = str_replace("'", "", $description);

      $selectquery = "INSERT INTO product SET user_id='$user_id', name='$name', price='$price', availability='$availability', description='$desc', pic='$filename'";


      if( $connection->query($selectquery) ){
        $success = "Product have been successfully added";
      }

      

    }

  }

?>
<style>
    .box{
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f4f4f9;
    	  font-family: 'Montserrat', sans-serif;
    }
    .box .container {
        width: 400px; 
        height: 70vh auto; 
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.6);
    }

    .form-control{
        width: 300px; 
        padding: 5px;
        border-radius: 10px;
        background-color: white;
    }

    label {
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 5px; 
    }
    .form{
        margin-top: 10px;
     }
    .btn-custom {
        width: 50%;
        color: black;
        margin-top: 5px;
        font-weight: bold;
        background-color: #99644d;
    }
    .btn-custom:hover{ 
      color: #fff;
      background-color: #99644d; 
    }

    .text-danger{
        color: red;
        font-size: 12px;
        font-weight: bold;    
    }
  
</style>
<div class="box">  
  <div class="container d-flex justify-content-center">
    
    <div class="row d-flex justify-content-center align-items-center">
      
      <div class="col-md-12 col-sm-12 col-lg-12 p-3">
        
        <?php
          if( $success!='' ){
            echo '<div class="alert alert-success">'.$success.'</div>';
          }
        ?>
        

        <form action="add_product.php" method="POST" enctype="multipart/form-data">


          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Picture</label>

            <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="pic" >
            
            <?php echo "<div class='text-danger smalltext'>".$pic_error."</div>"; ?>
          </div>

          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Name</label>

            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" value="">
            
            <?php echo "<div class='text-danger smalltext'>".$name_error."</div>"; ?>
          </div>


          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Price</label>

            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="price" value="">
            
            <?php echo "<div class='text-danger smalltext'>".$price_error."</div>"; ?>
          </div>

          <div class="mb-2">
            <label for="availability">Availability:</label>
            <select class="form-control" id="availability" name="availability">
                <option value="">Select Availability</option>
                <option value="Available">Available</option>
                <option value="Not_Available">Not Available</option>
            </select>

            <?php echo "<div class='service'>".$availability_error."</div>"; ?>
         </div>

          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Description</label>

            <textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="description"></textarea>
            
            <?php echo "<div class='text-danger smalltext'>".$description_error."</div>"; ?>
          </div>

          <button type="submit" class="btn btn-custom">Add Product</button>
        </form>

      </div>

    </div>

  </div>
</div>

<?php include('footer.php'); ?>
