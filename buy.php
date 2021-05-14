<?php session_start();
	include "includes/db.php"; 
	
	if( isset($_GET['chk_item_id']) ) {
		$date = date('Y-m-d h:i:s');
		$rand_num = mt_rand();
		
		if( isset($_SESSION['ref']) ) {
		
		
		} else {
			$_SESSION['ref'] = $date.'_'.$rand_num;
		}
		
		$chk_sql = "INSERT INTO checkout (chk_item, chk_ref, chk_timing, chk_qty) VALUES ('$_GET[chk_item_id]', '$_SESSION[ref]', '$date', 1)";
		
		if(mysqli_query($conn, $chk_sql)) {
			
			?> <script>window.location = "buy.php"; </script><?php
		}
		
	}
	
	if( isset($_POST['order_submit']) )  {
		$name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
		$email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
		$contact = mysqli_real_escape_string($conn, strip_tags($_POST['contact']));
		$state = mysqli_real_escape_string($conn, strip_tags($_POST['state']));
		$delivery_address = mysqli_real_escape_string($conn, strip_tags($_POST['delivery_address']));
		
		$order_ins_sql = "INSERT INTO orders (order_name, order_email, order_contact, order_state, order_delivery_address, order_checkout_ref, order_total) VALUES ('$name', '$email', '$contact', '$state', '$delivery_address', '$_SESSION[ref]', '$_SESSION[grand_total]')";
		
		mysqli_query($conn, $order_ins_sql);
	}
	


?>

<html>
	<head>
		<title>Shopping Cart</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script>
			function ajax_func() {
				xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function() {
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
						}
				}
				
				xmlhttp.open('GET', 'buy_process.php', true);
				xmlhttp.send();
			}
			
			function del_func(chk_id) {
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
					}
					
				}
				
				xmlhttp.open('GET', 'buy_process.php?chk_del_id='+chk_id, true);
				xmlhttp.send();
			}
			
			function up_chk_qty(chk_qty, chk_id) {
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
					}
					
				}
				xmlhttp.open('GET', 'buy_process.php?up_chk_qty='+chk_qty+'&up_chk_id='+chk_id, true);
				xmlhttp.send();
			}
		</script>
	</head>
	<body onload="ajax_func();">
		<?php include 'includes/header.php'; ?>
		<div class="container">
		
			<div class="page-header">
				<h2 class="text-left">Checkout</h2>
				<p class="text-right"> 
				<button class="btn btn-success" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">
					Proceed Button
				</button>
				</p>
				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
						 
						  </div>
						  <div class="modal-body">
							<form method="post">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" name="name" class="form-control">
								</div>
								<div class="form-group">
									<label for="email">Email Address</label>
									<input type="text" name="email" class="form-control">
								</div>
								<div class="form-group">
									<label for="contact">Contact Number</label>
									<input type="text" name="contact" class="form-control">
								</div>
								<div class="form-group">
									<label for="states">State</label>
									<input list="states" name="state" id="state" class="form-control">
									<datalist id="states">
										<option value="AL">Alabama</option>
										<option value="AK">Alaska</option>
										<option value="AZ">Arizona</option>
										<option value="AR">Arkansas</option>
										<option value="CA">California</option>
										<option value="CO">Colorado</option>
										<option value="CT">Connecticut</option>
										<option value="DE">Delaware</option>
										<option value="DC">District Of Columbia</option>
										<option value="FL">Florida</option>
										<option value="GA">Georgia</option>
										<option value="HI">Hawaii</option>
										<option value="ID">Idaho</option>
										<option value="IL">Illinois</option>
										<option value="IN">Indiana</option>
										<option value="IA">Iowa</option>
										<option value="KS">Kansas</option>
										<option value="KY">Kentucky</option>
										<option value="LA">Louisiana</option>
										<option value="ME">Maine</option>
										<option value="MD">Maryland</option>
										<option value="MA">Massachusetts</option>
										<option value="MI">Michigan</option>
										<option value="MN">Minnesota</option>
										<option value="MS">Mississippi</option>
										<option value="MO">Missouri</option>
										<option value="MT">Montana</option>
										<option value="NE">Nebraska</option>
										<option value="NV">Nevada</option>
										<option value="NH">New Hampshire</option>
										<option value="NJ">New Jersey</option>
										<option value="NM">New Mexico</option>
										<option value="NY">New York</option>
										<option value="NC">North Carolina</option>
										<option value="ND">North Dakota</option>
										<option value="OH">Ohio</option>
										<option value="OK">Oklahoma</option>
										<option value="OR">Oregon</option>
										<option value="PA">Pennsylvania</option>
										<option value="RI">Rhode Island</option>
										<option value="SC">South Carolina</option>
										<option value="SD">South Dakota</option>
										<option value="TN">Tennessee</option>
										<option value="TX">Texas</option>
										<option value="UT">Utah</option>
										<option value="VT">Vermont</option>
										<option value="VA">Virginia</option>
										<option value="WA">Washington</option>
										<option value="WV">West Virginia</option>
										<option value="WI">Wisconsin</option>
										<option value="WY">Wyoming</option>
									</datalist>
										
								</div>
					
								<div class="form-group">
									<label for="address">Delivery address</label>
									<textarea class="form-control" name="delivery_address"></textarea>
								</div>
								<div class="form-group">
									<input type="submit" name="order_submit" class="btn btn-danger btn-lg btn-block" value="Submit">
								</div>
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

				  </div>
				</div>
			</div>
							
			<div class="panel panel-default">
				<div class="panel-heading">Order Detail</div>
				<div class="panel-body">
				
					<div id="get_processed_data"></div>
					
					
				</div>
			</div>
		</div>
		<br><br><br><br><br>
		<?php include 'includes/footer.php'; ?>
	</body>
</html>