<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	/*function save_shop_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM `shop_type_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Shop Type already exists.";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `shop_type_list` set {$data} ";
			}else{
				$sql = "UPDATE `shop_type_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				if(empty($id))
				$resp['msg'] = " New Shop Type successfully saved.";
				else
				$resp['msg'] = " Shop Type successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_shop_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `shop_type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Shop Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}*/

	//category functions starts

	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and admin_id = '{$admin_id}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Category already exists.";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `category_list` set {$data} ";
			}else{
				$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				if(empty($id))
				$resp['msg'] = " New Category successfully saved.";
				else
				$resp['msg'] = " Category successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `category_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	//category functions ends

    //program functions starts
	function save_program(){
		$_POST['location'] = htmlentities($_POST['location']);
		$_POST['description'] = htmlentities($_POST['description']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `program` where `name` = '{$name}' and admin_id = '{$admin_id}' /*and delete_flag = 0*/".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = ' Program Name Already exists.';
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `program` set {$data} ";
			}else{
				$sql = "UPDATE `program` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$prid = empty($id) ? $this->conn->insert_id : $id;
				$resp['prid'] = $prid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = " New Program successfully saved.";
				else
					$resp['msg'] = " Program successfully updated.";
				
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/program"))
					mkdir(base_app."uploads/program");
					$fname = 'uploads/program/'.($prid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg']=" Image failed to upload due to invalid file type.";
					}else{
						list($width, $height) = getimagesize($upload);
						$new_height = $height; 
						$new_width = $width; 
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
								if(isset($uploaded_img) && $uploaded_img == true){
									$qry = $this->conn->query("UPDATE `program` set image_path = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$prid' ");
								}
						}else{
						$resp['msg']=" Image failed to upload due to unkown reason.";
						}
					}
					
				}
			}else{
				$resp['status'] = 'failed';
				if(empty($id))
					$resp['msg'] = " Program has failed to save.";
				else
					$resp['msg'] = " Program has failed to update.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}

		if($resp['status'] == 'success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function delete_program(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `program` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Program successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	//program functions ends

    /*
	function save_product(){
		$_POST['description'] = htmlentities($_POST['description']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `product_list` where vendor_id = '{$vendor_id}' and `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != '{$id}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = ' Product Name Already exists.';
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `product_list` set {$data} ";
			}else{
				$sql = "UPDATE `product_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$pid = empty($id) ? $this->conn->insert_id : $id;
				$resp['pid'] = $pid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = " New Product successfully saved.";
				else
					$resp['msg'] = " Product successfully updated.";
				
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/products"))
					mkdir(base_app."uploads/products");
					$fname = 'uploads/products/'.($pid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg']=" But Image failed to upload due to invalid file type.";
					}else{
						list($width, $height) = getimagesize($upload);
						$new_height = $height; 
						$new_width = $width; 
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
								if(isset($uploaded_img) && $uploaded_img == true){
									$qry = $this->conn->query("UPDATE `product_list` set image_path = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$pid' ");
								}
						}else{
						$resp['msg']=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}
			}else{
				$resp['status'] = 'failed';
				if(empty($id))
					$resp['msg'] = " Product has failed to save.";
				else
					$resp['msg'] = " Product has failed to update.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}

		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `product_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	//product functions ends


	function add_to_cart()
	{
		$_POST['client_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM cart_list where product_id = '{$product_id}' && client_id = '{$client_id}'")->num_rows;
		if($check > 0){
			$sql = "UPDATE cart_list set quantity = quantity + {$quantity} where product_id = '{$product_id}' && client_id = '{$client_id}' ";
		}else{
			$sql = "INSERT INTO cart_list set {$data}";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$resp['msg'] = " Product has added to cart.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " The product has failed to add to the cart.";
			$resp['error'] = $this->conn->error. "[{$sql}]";
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	function update_cart_qty()
	{
		extract($_POST);
		$update_cart = $this->conn->query("UPDATE `cart_list` set `quantity` = '{$quantity}' where id = '{$cart_id}'");
		if($update_cart){
			$resp['status'] = 'success';
			$resp['msg'] = ' Product Quantity has updated successfully';
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = ' Product Quantity has failed to update';
			$resp['error'] = $this->conn->error;
		}
		
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	function delete_cart()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `cart_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$resp['msg'] = " Cart Item has been deleted successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Cart Item has failed to delete.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] =='success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}

	function place_order()
	{
		extract($_POST);
		$inserted=[];
		$has_failed=false;
		$gtotal = 0;
		$vendors = $this->conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$this->settings->userdata('id')}')) order by `shop_name` asc");
		$prefix = date('Ym-');
		$code = sprintf("%'.05d",1);
		while($vrow = $vendors->fetch_assoc()):
			$data = "";
			while(true){
				$check = $this->conn->query("SELECT * FROM order_list where code = '{$prefix}{$code}' ")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$ref_code = $prefix.$code;
			$data = "('{$ref_code}','{$this->settings->userdata('id')}','{$vrow['id']}','{$this->conn->real_escape_string($delivery_address)}')";
			$sql = "INSERT INTO `order_list` (`code`,`client_id`,`vendor_id`,`delivery_address`) VALUES {$data}";
			$save = $this->conn->query($sql);
			if($save){
				$oid = $this->conn->insert_id;
				$inserted[] = $oid;
				$data = "";
				$gtotal = 0 ;
				$products = $this->conn->query("SELECT c.*, p.name as `name`, p.price,p.image_path FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$this->settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}' order by p.name asc");
				while($prow = $products->fetch_assoc()):
					$total = $prow['price'] * $prow['quantity'];
					$gtotal += $total;
					if(!empty($data)) $data .= ", ";
						$data .= "('{$oid}', '{$prow['product_id']}', '{$prow['quantity']}', '{$prow['price']}')";
				endwhile;
				$sql2 = "INSERT INTO `order_items` (`order_id`,`product_id`,`quantity`,`price`) VALUES {$data}";
				$save2= $this->conn->query($sql2);
				if($save2){
					$this->conn->query("UPDATE `order_list` set `total_amount` = '{$gtotal}' where id = '{$oid}'");
				}else{
					$has_failed = true;
					$resp['sql'] = $sql2;
					break;
				}
			}else{
				$has_failed = true;
				$resp['sql'] = $sql;
				break;
			}
		endwhile;
		if(!$has_failed){
			$resp['status'] = 'success';
			$resp['msg'] = " Order has been placed";
			$this->conn->query("DELETE FROM `cart_list` where client_id ='{$this->settings->userdata('id')}'");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Order has failed to place";
			$resp['error'] = $this->conn->error;
			if(count($inserted) > 0){
				$this->conn->query("DELETE FROM `order_list` where id in (".(implode(',',array_values($inserted))).") ");
			}
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);

		return json_encode($resp);
	}

	function cancel_order()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `order_list` set `status` = 5 where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order has been cancelled successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}*/

	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `donation` set `status` = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Donation Status has been updated successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = " Donation Status has failed to update.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}

	// function add_new_donation(){
	// 	$resp = array();
	// 	$resp['status'] = 'success';
	// 	extract($_POST);
	// 	// Generate a unique filename for the image
	// 	$filename = uniqid() . '_' . basename($_FILES['image']['name']);
	// 	// Specify the target directory where the image will be moved
	// 	$target_dir = '../uploads/donation/';
	// 	$target_path = $target_dir . $filename;
	// 	$uniqueCode = uniqid();
	// 	// Move the uploaded image to the target directory
	// 	if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
	// 		$stmt = $this->conn->prepare("INSERT INTO donation (program_id, donor_id,code) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
	// 		$stmt->bind_param("iisssisss", $program_id, $donor_id, $name, $category, $condition, $qty, $description, $filename, $uniqueCode);
	// 		if($stmt->execute()){
	// 			$resp['status'] = 'success';
	// 			$resp['msg'] = " Donation has been sent successfully.";
	// 		}else{
	// 			$resp['status'] = 'error';
	// 			$resp['msg'] = " Donation Status has failed to update.";
	// 			$resp['error'] = $stmt->error;
	// 		}
	// 	} else {
	// 		$resp['status'] = 'error';
	// 		$resp['msg'] = " Failed to move the uploaded image.";
	// 	}
	// 	return json_encode($resp);
	// } 

	function add_new_image(){
		$resp = array();
		$resp['status'] = 'success';
		extract($_POST);

		// Generate a unique filename for the image
		$filename = uniqid() . '_' . basename($_FILES['image']['name']);
		// Specify the target directory where the image will be moved
		$target_dir = '../uploads/donation/';
		$target_path = $target_dir . $filename;
		$uniqueCode = uniqid();
		// Move the uploaded image to the target directory
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
			
			$resp['status'] = 'success';
			$resp['urlPath'] = $filename;
			$resp['msg'] = " Donation has been sent successfully.";
			
		} else {
			$resp['status'] = 'error';
			$resp['msg'] = " Failed to move the uploaded image.";
		}
		return json_encode($resp);
	} 


	function add_new_donation(){

		$has_failed=false; 
		$status = 0;
		// $uniqueCode = uniqid();
		$pid = $_POST['program_id'];
		$did= $_POST['donor_id'];
		$total= $_POST['total'];
		$donoritem = json_decode($_POST['donor_item']);   

		$prefix = date('Ym-');
		$code = sprintf("%'.05d",1);

		$sqlCheck = "SELECT code FROM donation ORDER BY id DESC LIMIT 1";
		$resultCheck =  $this->conn->query($sqlCheck);
		if ($resultCheck->num_rows > 0) {

			$row = $resultCheck->fetch_assoc();
			$oldcode = explode('-', $row['code']);
			$newcode = intval($oldcode[1]) + 1;
			$convCode = sprintf("%'.05d",$newcode);
			$unicode = $prefix.$convCode;
		   
		} else {
			$unicode = $prefix.$code;
		}


		$sql1 = "INSERT INTO donation (`program_id`,`donor_id`,`total_goods`, `code`, `status`) VALUES ('{$pid}', '{$did}', '{$total}', '{$unicode}' ,'{$status}')";
		$save1= $this->conn->query($sql1);
		if($save1){

			$oid = $this->conn->insert_id;
			foreach($donoritem as $key => $val) {
			 	
				$name = $val->name;
				$cid = $val->category;
				$condition = $val->condition;
				$qty = $val->qty;
				$desc = $this->conn->real_escape_string($val->description);
				$image = 'uploads/donation/' . $val->image;
	  			$sql2 = "INSERT INTO donated_goods (`donation_id`,`category_id`,`name`, `image_path`, `quantity`, `description`, `goods_condition`) VALUES ('{$oid}', '{$cid}', '{$name}', '{$image}' ,'{$qty}', '{$desc}', '{$condition}')";
				$save2= $this->conn->query($sql2);

			}
		
			
		}else{
			$has_failed = true;
			$resp['sql'] = $sql1;
		}

		if(!$has_failed){
			$resp['status'] = 'success';
			$resp['msg'] = " Donation details have been submitted";
			
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Donation details have failed to submit";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}

		return json_encode($resp);


	}
	


	// function add_new_donation(){
		// $_POST['donor_id'] = $this->settings->userdata('id');
		// $_POST['']
		// extract($_POST);
		// $inserted=[];
		// foreach($_POST as $k =>$v){
		// 	if(!in_array($k,array('id'))){
		// 		if(!empty($data)) $data .=",";
		// 		$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
		// 	}


		// }
		// $has_failed=false; 
		// $status = 0;


		// $uniqueCode = uniqid();
		// $pid = $_POST['program_id'];
		// $did= $_POST['donor_id'];
		// $total= $_POST['total'];
		// $donoritem = json_decode($_POST['donor_item']);
		
		// $sql1 = "INSERT INTO donation (program_id,donor_id,total_goods, code, status) VALUES ('$pid', '$did', '$total', '$status')";
		// $save1= $this->conn->query($sql1);
		// if($save1){
			
		// }else{
		// 	$has_failed = true;
		// 	$resp['sql'] = $sql1;
		// 	break;
		// }


		// if(!$has_failed){
		// 	$resp['status'] = 'success';
		// 	$resp['msg'] = " Donation details have been submitted";
			
		// }else{
		// 	$resp['status'] = 'failed';
		// 	$resp['msg'] = " Donation details have failed to submit";
		// 	$resp['error'] = $this->conn->error;
		// 	// if(count($inserted) > 0){
		// 	// 	$this->conn->query("DELETE FROM `donation` where id in (".(implode(',',array_values($inserted))).") ");
		// 	// }
		// }
		// if($resp['status'] == 'success'){
		// 	$this->settings->set_flashdata('success',$resp['msg']);
		// }

		// return json_encode($resp);



		// echo '<pre>';
	 //    print_r(json_decode($_POST['donor_item']));
	 //    echo '</pre>';

	    // return;


		// $program = $this->conn->query("SELECT * FROM `program`");
		// $prefix = date('Ym-');
		// $code = sprintf("%'.05d",1);

	    
		// while($pr_row = $program->fetch_assoc()):
		// 	$data = "";
		// 	while(true){
		// 		$check = $this->conn->query("SELECT * FROM donation where code = '{$prefix}{$code}' ")->num_rows;
		// 		if($check > 0){
		// 			$code = sprintf("%'.05d",ceil($code) + 1);
		// 		}else{
		// 			break;
		// 		}
		// 	}

	
		// 	$ref_code = $prefix.$code;
		// 	$data = "('{$ref_code}','{$this->settings->userdata('id')}','{$pr_row['id']}','{$status}')";
		// 	$sql = "INSERT INTO `donation` (`code`,`donor_id`,`program_id`,`status`) VALUES {$data}";
		// 	$save = $this->conn->query($sql);
		// 	if($save){
		// 		$oid = $this->conn->insert_id;
		// 		$inserted[] = $oid;
		// 		$data = "";
		// 		$gtotal = 0 ;
		// 		$goods = $this->conn->query("SELECT dg.*, c.name as category from donated_goods dg inner join category_list c on dg.category_id = c.id where dg.donation_id='{$oid}'");
		// 		while($grow = $goods->fetch_assoc()):
		// 			$gtotal += $grow['quantity'];
		// 			if(!empty($data)) $data .= ", ";
		// 				$data .= "('{$oid}', '{$grow['category_id']}', '{$grow['quantity']}')";
		// 		endwhile;
				 
		// 		$sql2 = "INSERT INTO `donated_goods` (`donation_id`,`category_id`,`quantity`) VALUES {$data}";
		// 		$save2= $this->conn->query($sql2);
		// 		if($save2){
		// 			$this->conn->query("UPDATE `donation` set `total_goods` = '{$gtotal}' where id = '{$oid}'");
		// 		}else{
		// 			$has_failed = true;
		// 			$resp['sql'] = $sql2;
		// 			break;
		// 		}
		// 	}else{
		// 		$has_failed = true;
		// 		$resp['sql'] = $sql;
		// 		break;
		// 	}
		// endwhile;
		// if(!$has_failed){
		// 	$resp['status'] = 'success';
		// 	$resp['msg'] = " Donation details have been submitted";
			
		// }else{
		// 	$resp['status'] = 'failed';
		// 	$resp['msg'] = " Donation details have failed to submit";
		// 	$resp['error'] = $this->conn->error;
		// 	if(count($inserted) > 0){
		// 		$this->conn->query("DELETE FROM `donation` where id in (".(implode(',',array_values($inserted))).") ");
		// 	}
		// }
		// if($resp['status'] == 'success')
		// $this->settings->set_flashdata('success',$resp['msg']);

		// return json_encode($resp);
	// }






}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_shop_type':
		echo $Master->save_shop_type();
	break;
	case 'delete_shop_type':
		echo $Master->delete_shop_type();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_program':
		echo $Master->save_program();
	break;
	case 'delete_program':
		echo $Master->delete_program();
	break;
	case 'add_new_donate':
		echo $Master->add_new_donation();
	break;
	case 'add_new_image':
		echo $Master->add_new_image();
	break;
	/*case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
	break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
	break;
	case 'delete_cart':
		echo $Master->delete_cart();
	break;
	case 'place_order':
		echo $Master->place_order();
	break;
	case 'cancel_order':
		echo $Master->cancel_order();
	break;*/
	case 'update_status':
		echo $Master->update_status();
	break;
	default:
		// echo $sysset->index();
		break;
}