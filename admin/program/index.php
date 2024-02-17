<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Emergency Relief Programs</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" class="btn btn-flat btn-primary" id="create_new"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%"><!--id-->
					<col width="10%"><!--name-->
					<col width="9%"><!--image-->
					<col width="10%"><!--date-->
					<col width="10%"><!--time-->
					<col width="20%"><!--location-->
					<col width="20%"><!--desc-->
					<col width="10%"><!--action-->
				</colgroup>
				<thead>
					<tr class="bg-gradient-secondary">
						<th><center>#</center></th>
						<th><center>Name</center></th>
						<th><center>Image</center></th>
						<th><center>Date</center></th>
						<th><center>Time</center></th>
						<th><center>Location</center></th>
						<th><center>Description</center></th>
						<th><center>Action</center></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `program` where `admin_id` = '{$_settings->userdata('id')}' order by `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<!--remember to change it-->
							<td class="text-center"><img src="<?= validate_image($row['image_path']) ?>" alt="Product Image" class="border border-gray img-thumbnail product-img"></td>
							<td><?php echo date("Y-m-d",strtotime($row['date'])) ?></td>
							<td><?php echo $row['time'] ?></td>
							<td><p class="m-0 truncate-1"><?php echo $row['location'] ?></p></td>
							<td><p class="m-0 truncate-1"><?php echo $row['description'] ?></p></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#create_new').click(function(){
			uni_modal('Add New Emergency Relief Program',"program/manage_program.php")
		})
		$('.view_data').click(function(){
			uni_modal('View Emergency Relief Program Details',"program/view_program.php?id="+$(this).attr('data-id'))
		})
		$('.edit_data').click(function(){
			uni_modal('Edit Emergency Relief Program Details',"program/manage_program.php?id="+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Program permanently?","delete_program",[$(this).attr('data-id')])
		})
		$('table .th,table .td').addClass('align-middle px-2 py-1')
		$('.table').dataTable();
	})
	function delete_program($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_program",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>