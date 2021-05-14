<?php include '../includes/db.php';

	if( isset($_REQUEST['del_item_id']) ) {
		$del_sql = "DELETE FROM items WHERE item_id = '$_REQUEST[del_item_id]'";
		mysqli_query($conn, $del_sql);
	}
	
	if( isset($_REQUEST['edit_form']) ) {
		$item_title = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_title']));
		$item_description = mysqli_real_escape_string($conn, $_REQUEST['item_description']);
		$item_category = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_category']));
		$item_quantity = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_quantity']));
		$item_cost = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_cost']));
		$item_price = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_price']));
		$item_discount = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_discount']));
		$item_delivery = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_delivery']));
		
		$item_up_sql = "UPDATE items SET item_title = '$item_title', item_description = '$item_description', item_cat = '$item_category', item_qty = '$item_quantity', item_cost = '$item_cost', item_price = '$item_price', item_discount = '$item_discount', item_delivery = '$item_delivery' WHERE item_id = '$_REQUEST[edit_id]' ";
		$item_ins_run = mysqli_query($conn, $item_up_sql);
		
		
	}

?>


<table class="table table-bordered table-striped;">

	<thead>
	
		<tr class="item-head">
			<th>Serial #</th>
			<th>Image</th>
			<th>Item Title</th>
			<th>Item Description</th>
			<th>Item Category</th>
			<th>Item Qty</th>
			<th>Item Cost</th>
			<th>Item Discount</th>
			<th>Item Price</th>
			<th>Item Delivery</th>
			<th>Actions</th>
		</tr>
	</thead>
	
	<tbody>
		<?php
		
		$c = 1;
		$sel_sql = "SELECT * FROM items";
		$sel_run = mysqli_query($conn, $sel_sql);
		while($rows = mysqli_fetch_assoc($sel_run) ) {
			$discounted_price = $rows['item_price'] - $rows['item_discount'];
			
			echo "

				<tr>
					<td>$c</td>
					<td><img src='../$rows[item_image]' style='width:100px;'></td>
					<td>$rows[item_title]</td>
					<td>"; echo strip_tags($rows['item_description']); echo "</td>
					<td>$rows[item_cat]</td>
					<td>$rows[item_qty]</td>
					<td>$rows[item_cost]</td>
					<td>$rows[item_discount]</td>
					<td>$discounted_price($rows[item_price])</td>	
					<td>$rows[item_delivery]</td>
					<td>
					
						<div class='dropup'>
							<button class='btn btn-red btn-danger dropdown-toggle' data-toggle='dropdown'>Actions<span class='caret'></span></button>
							<ul class='dropdown-menu dropdown-menu-right'>"; ?>
								<li>
									<a href="#edit_modal_<?php echo $rows['item_id']; ?>" data-toggle='modal'>Edit</a>
								</li>
								<li>
									<a href="javascript:;" onclick="del_item(<?php echo $rows['item_id']; ?>);">Delete</a>
								</li>
							<?php echo "</ul>
						</div>
						
						<div class='modal fade' id='edit_modal_$rows[item_id]'>
							<div class='modal-dialog'>
								<div class='modal-content'>
								
									<div class='modal-header'>
										<button class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title'>Edit Item</h4>
									</div>
									
									<div class='modal-body'>
										<form onsubmit='return edit_form($rows[item_id]);' id='edit_form$rows[item_id]'>
											
											<div class='form-group'>
												<label>Item Title</label>
												<input type='text' id='item_title$rows[item_id]' value='$rows[item_title]' class='form-control' required>
											</div>
											<div class='form-group'>
												<label>Item Description</label>
												<textarea id='item_description$rows[item_id]' value='$rows[item_description]' class='form-control' required></textarea>
											</div>
											<div class='form-group'>
												<label>Item Category</label>
												<select class='form-control' id='item_category$rows[item_id]' required>
													<option>Select a Category</option>";
													
														$cat_sql = "SELECT * FROM item_cat";
														$cat_run = mysqli_query($conn, $cat_sql);
														while($cat_rows = mysqli_fetch_assoc($cat_run) ) {
															$cat_name = ucwords($cat_rows['cat_name']);
															if($cat_rows['cat_slug'] == '') {
																$cat_slug = $cat_rows['cat_name'];
															} else {
																$cat_slug = $cat_rows['cat_slug'];
															}
															
															if($cat_slug == $rows['item_cat']) {
																echo "<option selected value='$cat_slug'>$cat_name</option>";
															} else {
																echo "<option value='$cat_slug'>$cat_name</option>";
															}
															
														}
													
												echo "</select>
											</div>
											
											<div class='form-group'>
												<label>Item Quantity</label>
												<input type='number' id='item_quantity$rows[item_id]' value='$rows[item_qty]' class='form-control' required>
											</div>
											
											<div class='form-group'>
												<label>Item Cost</label>
												<input type='number' id='item_cost$rows[item_id]' value='$rows[item_cost]' class='form-control' required>
											</div>
											
											<div class='form-group'>
												<label>Item Price</label>
												<input type='number' id='item_price$rows[item_id]' value='$rows[item_price]' class='form-control' required>
											</div>
											
											<div class='form-group'>
												<label>Item discount</label>
												<input type='number' id='item_discount$rows[item_id]' value='$rows[item_discount]' class='form-control' required>
											</div>
											
											<div class='form-group'>
												<label>Item Delivery</label>
												<input type='number' id='item_delivery$rows[item_id]' value='$rows[item_delivery]' class='form-control'>
											</div>
											
											<div class='form-group'>
												
												<button class='btn btn-primary btn-block'>Submit</button>
											</div>
											
										</form>
									</div>
									
									<div class='modal-footer'>
										<button class='btn btn-danger' data-dismiss='modal'>Close</button>
									</div>
									
								</div>
							</div>
						</div>
						
					</td>
				</tr>"; ?>
				
			<?php 
			$c++;
		}
		?>
		
	</tbody>
	
</table>









