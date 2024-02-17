<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `program` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
?>
		<center>Unknown Emergency Relief Program</center>
		<style>
			#uni_modal .modal-footer{
				display:none
			}
		</style>
		<div class="text-right">
			<button class="btn btndefault bg-gradient-dark btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
		</div>
		<?php
		exit;
		}
}
?>
<style>
	#uni_modal .modal-footer{
		display:none
	}

	#prod-img-view{
		width:15em;
		max-height:20;
		object-fit:scale-down;
		object-position: center center;
	}
	
</style>
<div class="container-fluid">
<center><img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="Product Image" class="img-thubmnail p-0 bg-gradient-gray" id="prod-img-view"></center>
	<dl>
        <dt class="text-muted">Program Name</dt>
        <dd class="pl-3"><?= isset($name) ? $name : "" ?></dd>
		<dt class="text-muted">Date</dt>
        <dd class="pl-3"><?= isset($date) ? $date : "" ?></dd>
		<dt class="text-muted">Time</dt>
        <dd class="pl-3"><?= isset($time) ? $time : "" ?></dd>
		<dt class="text-muted">Location</dt>
        <dd class="pl-3"><?= isset($location) ? $location : "" ?></dd>
        <dt class="text-muted">Description</dt>
        <dd class="pl-3"><?= isset($description) ? html_entity_decode($description) : "" ?></dd>
    </dl>
	<div class="clear-fix mb-3"></div>
	<div class="text-right">
		<button class="btn btn-default bg-gradient-dark btn-sm btn-flat" type="button" data-dismiss="modal"><i class="fa f-times"></i> Close</button>
	</div>
</div>
