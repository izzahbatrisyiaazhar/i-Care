<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT d.*,donor.code as donor_code,donor.contact as contact, 
    CONCAT(donor.firstname,' ',donor.lastname) as donor, 
    p.name as `program` from `donation` d 
    inner join program p on d.program_id = p.id inner join donor on d.donor_id = donor.id 
    where d.id = '{$_GET['id']}' ");

    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
?>
		<center>Unknown Donation Activity</center>
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
    .prod-img{
        width:calc(100%);
        height:auto;
        max-height: 10em;
        object-fit:scale-down;
        object-position:center center
    }
    .pl-2{
        margin-bottom:1rem;
    }

    .tooltip-inner{
  border: 1px solid black; 
  color: #000; 
  background-color: rgba(255, 255, 255, 1);  
}

</style>
<div class="container-fluid">

    <!--column biru starts -->
	<div class="row">
        <div class="col-4 border bg-gradient-primary"><span class="">Reference Code</span></div>
        <div class="col-8 border"><span class="font-weight-bolder"><?= isset($code) ? $code : '' ?></span></div>
        <div class="col-4 border bg-gradient-primary"><span class="">Emergency Relief Program</span></div>
        <div class="col-8 border"><span class="font-weight-bolder"><?= isset($program) ? $program: '' ?></span></div>
        <div class="col-4 border bg-gradient-primary"><span class="">Donor</span></div>
        <div class="col-8 border"><span class="font-weight-bolder"><?= isset($donor) ? $donor_code.' - '.$donor : '' ?></span></div>
        <div class="col-4 border bg-gradient-primary"><span class="">Phone Number</span></div>
        <div class="col-8 border"><span class="font-weight-bolder"><?= isset($contact) ? $contact: '' ?></span></div>
        <div class="col-4 border bg-gradient-primary"><span class="">Status</span></div>
        <div class="col-8 border"><span class="font-weight-bolder">
            <?php 
            $status = isset($status) ? $status : '';
                switch($status){
                    case 0:
                        echo '<span class="badge badge-secondary bg-gradient-warning px-3 rounded-pill">Pending</span>';
                        break;
                    case 1:
                        echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Completed</span>';
                        break;
                    default:
                        echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
                        break;
                }
            ?>
            <?//php if($status != 5): ?>
            <span class="pl-2"><a href="javascript:void(0)" id="update_status"><small><b>Update Status</b></small></a></span>
            <?//php endif; ?>
        </div>
    </div>
    <!--column biru ends -->
    <div class="clear-fix mb-2"></div>
    <div id="order-list" class="row" style="margin-top:1rem;">
    <?php
    // Initialize variables
    $gtotal = 0;
    $categoryTotal = array();

    // Fetch donated goods
    $donation = $conn->query("SELECT dg.*, c.name as category from donated_goods dg inner join category_list c on dg.category_id = c.id where dg.donation_id='{$id}' order by c.name asc");

    while ($prow = $donation->fetch_assoc()):
        // Get the category name and quantity for each donated good
        $categoryName = $prow['category'];
        $quantity = $prow['quantity'];

        // Add the quantity to the category total
        if (!isset($categoryTotal[$categoryName])) {
            $categoryTotal[$categoryName] = $quantity;
        } else {
            $categoryTotal[$categoryName] += $quantity;
        }

        // Update the grand total
        $gtotal += $quantity;
    ?>
        <!-- Category row -->
        <?php if (!isset($currentCategory) || $currentCategory !== $categoryName): 
            $i = 1;
            ?>
            <?php if (isset($currentCategory)): 
                
                ?>
                
                <!-- Display the total quantity for the previous category -->
                <tr>
                    <!--<td></td>
                    <td></td>-->
                    <td class="text-right" colspan="6"><strong>Total: <?= $categoryTotal[$currentCategory] ?></strong></td>
                </tr>
                </tbody>
                </table>
            </div>
            <?php endif; ?>

            <div class="col-12 border">
                <table>
                    <div class="d-flex">
                        <tr>
                            <td>
                                <div class="col-10 h6 font-weight-bold text-left">Category:</div>
                            </td>
                            <td>
                                <div class="col-10 h6 font-weight-bold text-left" style="width:30rem;"><?= $categoryName ?></div>
                            </td>
                        </tr>
                    </div>
                </table>
                <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="15%">Image</th>
                        <th scope="col" width="10%">Name</th>
                        <th scope="col" width="10%">Quantity</th>
                        <th scope="col" width="10%">Condition</th>
                        <th scope="col" width="30%">Description</th>
                    </tr>
                </thead>
                <tbody>
        <?php endif; ?>

        <!-- Donated goods row -->
        <tr>
            <td><?= $i++; ?></td>
            <td><img src="<?= validate_image($prow['image_path']) ?>" alt="" class="img-center prod-img border bg-gradient-gray"></td>
            <td><?= $prow['name'] ?></td>
            <td><?= $prow['quantity'] ?></td>
            <td>
    <?php 
        switch($prow['goods_condition']){
            case 0:
                echo '<span class="badge badge-secondary bg-gradient-light border px-3 rounded-pill">
                          Brand New 
                          <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="Never used. May come with original packaging or tag."></i>
                      </span>';
                break;
            case 1:
                echo '<span class="badge badge-success bg-gradient-light border px-3 rounded-pill">
                          Like New 
                          <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="Used once or twice. As good as new"></i>
                      </span>';
                break;
            case 2:
                echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">
                          Lightly Used 
                          <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="Used with care. Flaws, if any, are barely noticeable."></i>
                      </span>';
                break;
            case 3:
                echo '<span class="badge badge-warning bg-gradient-warning px-3 rounded-pill">
                          Well Used 
                          <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="Has minor flaws or defects."></i>
                      </span>';
                break;
            case 4:
                echo '<span class="badge badge-success bg-gradient-danger px-3 rounded-pill">
                          Heavily Used 
                          <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="Has obvious signs of use or defects."></i>
                      </span>';
                break;
            default:
                echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">
                          N/A 
                          <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="Not applicable"></i>
                      </span>';
                break;
        }
    ?>
</td>

            <td><?= $prow['description'] ?></td>
        </tr>

        <?php $currentCategory = $categoryName; ?>
    <?php endwhile; ?>

    <!-- Display the total quantity for the last category -->
    <tr>
        <td class="text-right" colspan="6"><strong>Total: <?= $categoryTotal[$currentCategory] ?></strong></td>
        
    </tr>
    </tbody>
    </table>
    </div>

    <!-- Display the grand total -->
    <div class="col-12 border">
        <h4 class="text-right">Grand Total: <?= $gtotal ?></h4>
    </div>

	<div class="clear-fix mb-3"></div>
	<div class="text-right" style=" width:100%; margin-top:2rem;">
		<button class="btn btn-default bg-gradient-dark text-light btn-sm btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
	</div>
</div>
<script>
    $(function(){

        $('#update_status').click(function(){
  
            uni_modal_second("Update Donation Status - <b><?= isset($code) ? $code : '' ?></b>","donation_activity/update_status.php?id=<?= isset($id) ? $id : '' ?>")
        })

        $('[data-toggle="tooltip"]').tooltip()

        
    })
   
</script>



