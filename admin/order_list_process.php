<?php
	include '../includes/db.php';
	
	if ( isset($_REQUEST['order_status'] ) ) {
		$up_sql = "UPDATE orders SET order_status = '$_REQUEST[order_status]' WHERE order_id = '$_REQUEST[order_id]'";
		$up_run = mysqli_query($conn, $up_sql);
	}
	
	if( isset($_REQUEST['order_return_status']) ) {
		$up_sql = "UPDATE orders SET order_return_status = '$_REQUEST[order_return_status]' WHERE order_id = '$_REQUEST[order_id]'";
		$up_run = mysqli_query($conn, $up_sql);
	}
?>
<table class="table" table-bordered table-striped>
	<thead>
		<tr class="item-head">
			<th>S.no</th>
			<th>Buyer Name</th>
			<th>Buyer Email</th>
			<th>Buyer Contact</th>
			<th>Buyer State</th>
			<th>Buyer Delivery Address</th>
			<th>Order ref</th>
			<th class="text-right">Total payment</th>
			<th>Order Status</th>
			<th>Return Status</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$c = 1;
			$sql = "SELECT * FROM orders";
			$run = mysqli_query($conn, $sql);
			while($rows = mysqli_fetch_assoc($run) ) {
				if($rows['order_status'] == 0) {
					$status_btn_class = 'btn-warning';
					$status_btn_value = 'Pending';
				} else {
					$status_btn_class = 'btn-success';
					$status_btn_value = 'Sent';
				}
				
				if($rows['order_return_status'] == 0) {
					$return_btn_class = 'btn-danger';
					$return_btn_value = 'Returned';
				} else {
					$return_btn_class = 'btn-primary';
					$return_btn_value = 'No Return';
				}
				echo "
				<tr>
					<td>$c</td>
					<td>$rows[order_name]</td>
					<td>$rows[order_email]</td>
					<td>$rows[order_contact]</td>
					<td>$rows[order_state]</td>
					<td>$rows[order_delivery_address]</td>
					<td>
						<button class='btn btn-info' data-toggle='modal' data-target='#order_chk_modal$rows[order_id]'>$rows[order_checkout_ref]</button>
						<div class='modal fade' id='order_chk_modal$rows[order_id]'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>Header</div>
									<div class='modal-body'>
										<table class='table'>
											<thead>
												<tr>
													<th>S.no</th>
													<th>Item</th>
													<th>Qty</th>
													<th class='text-right'>Price</th>
													<th class='text-right'>Sub Total</th>
												</tr>
											</thead>
											<tbody>";
											//$chk_sql = "SELECT * FROM checkout WHERE chk_ref = '$rows[order_checkout_ref]'";
											$chk_sql = "SELECT * FROM checkout c JOIN items i ON c.chk_item = i.item_id WHERE c.chk_ref = '$rows[order_checkout_ref]'";
											$chk_run = mysqli_query($conn, $chk_sql);
											while($chk_rows = mysqli_fetch_assoc($chk_run) ) {
													if($chk_rows['item_title'] == '') {
														$item_title = 'Sorry Data Deleted';
													} else {
														$item_title = $chk_rows['item_title'];
													}
													
													$total = $chk_rows['chk_qty'] * $chk_rows['item_cost'];
												
												echo "<tr>
													<td>$c</td>
													<td>$item_title</td>
													<td>$chk_rows[chk_qty]</td>
													<td class='text-right'>$chk_rows[item_price]/=</td>
													<td class='text-right'>$total/=</td>
												</tr>";
											}
												
										echo "
										</tbody>
										
										</table>
											<table class='table'>
											<thead>
												<tr>
													<th colspan=2 class='text-center'>Order summary</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Grand Total</td>
													<td class='text-right'>$rows[order_total]/=</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class='modal-footer'>Footer</div>
								</div>
							</div>
						
						</div>
					</td>
					<td class='text-right'>$rows[order_total]/=</td>"; ?>
					<td class='text-center'><button onclick="order_status(<?php echo $rows['order_status'].', '.$rows['order_id']; ?>);" class='btn btn-block btn-sm <?php echo $status_btn_class; ?>'><?php echo$status_btn_value;?></button></td>
					<td class="text-center"><button onclick="return_status(<?php echo $rows['order_return_status'].', '.$rows['order_id']?>)" class="btn btn-primary btn-sm <?php echo $return_btn_class?>"><?php echo $return_btn_value; ?></button></td>
				</tr>
				<?php
				$c++;
			}
		?>
		

	</tbody>
</table>