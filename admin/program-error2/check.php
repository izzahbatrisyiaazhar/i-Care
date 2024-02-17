//program functions starts
	<?function save_program(){
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

		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_program(){
		extract($_POST);
		/*$del = $this->conn->query("UPDATE `product_list` set `delete_flag` = 1 where id = '{$id}'");*/
		$del = $this->conn->query("DELETE FROM `program` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Program successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}?>
	//program functions ends