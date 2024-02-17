<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `program` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo "<script> alert('Unkown Product ID.'); location.replace('./?page=program') </script>";
        exit;
    }
}else{
    echo "<script> alert('Product ID is required.'); location.replace('./?page=program') </script>";
    exit;
}
?>
<style>
#prod-img-holder {
    height: 45vh !important;
    width: calc(100%);
    overflow: hidden;
    }

#prod-img {
    object-fit: scale-down;
    height: calc(100%);
    width: calc(100%);
    transition: transform .3s ease-in;
    }
#prod-img-holder:hover #prod-img{
    transform:scale(1.2);
    }

    .heading {
  background: url(uploads/4.1.png) no-repeat;
  /*background-color: #aed3e3;*/
  background-size: cover;
  background-position: center;
  text-align: center;
  padding-top: 2rem;
  padding-bottom: 1rem;
}

.heading h1 {
  color: #222;
  font-size: 4rem;
}

.heading p {
  padding-top: 1rem;
  font-size: 1rem;
  color: #666;
}

.heading p a {
  color: #222;
  padding-right: .5rem;
}

.heading p a:hover {
  color: #df6f79;
}

#prod-img-holder{
    width: 50%;
    padding-left:1rem;
}

#prog-detail{
    width: 48%;
    margin-left: 52%;
    margin-top:-31.3%;
    padding-right:1rem;

}
#desc{
    padding-right:1rem;
    padding-left:1rem;
    
}



</style>
<div class="heading">
    <h1><?= $name ?></h1>
    <!--figure out nnti-->
    <p> <a href="index.php">Home >></a> <a href="./?page=program">Programs >></a> <?= $name ?></p>
</div>

<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="content py-3">
                <div class="position-relative overflow-hidden" id="prod-img-holder">
                    <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="<?= $row['name'] ?>" id="prod-img" class="img-thumbnail bg-gradient-gray">
                </div>
        </div>

        <div class="content py-3" id="prog-detail" >
            <div class="card card-outline rounded-0 shadow" style="border:solid; border-width:thin;border-color: lightgrey;">
                <div class="card-header">
                    <h5 class="card-title" style=" width:30rem; text-align:center;"><b>Program Detail</b></h5>
                    <!--<h5 class="card-title"><b>Program Detail</b></h5>-->
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div id="msg"></div>
                        <div class="row">
                            <!--<div class="col-lg-4 col-md-5 col-sm-12 text-center">
                                <div class="position-relative overflow-hidden" id="prod-img-holder">
                                    <img src="<?//= validate_image(isset($image_path) ? $image_path : "") ?>" alt="<?//= $row['name'] ?>" id="prod-img" class="img-thumbnail bg-gradient-gray">
                                </div>
                            </div>-->
                            <div class="col-lg-8 col-md-7 col-sm-12">
                                <!--<h3><b><?//= $name ?></b></h3>-->
                                <div class="d-flex w-100">
                                    <div class="col-auto px-0">
                                        <strong>Date: </strong>
                                        <br><p class="m-0"><?= $date ?></p><br>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-auto px-0">
                                        <strong>Time: </strong><br>
                                        <p class="m-0"><?= $time ?></p><br>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-auto px-0">
                                        <strong>Location: </strong><br>
                                        <p class="m-0" style="width:30rem;"><?= $location ?></p><br>
                                    </div>
                                </div>
                                <!--<div class="row align-items-end">
                                    <div class="col-md-3 form-group">
                                        <input type="number" min = "1" id= 'qty' value="1" class="form-control rounded-0 text-center">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button class="btn btn-primary btn-flat" type="button" id="add_to_cart"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                                    </div>
                                </div>
                                <div class="w-100"><?//= html_entity_decode($description) ?></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="content py-3" id="desc">
            <div class="card card-outline rounded-0 shadow" style="border:solid; border-width:thin;border-color: lightgrey;">
                <div class="card-header">
                    <h5 class="card-title" style="width:68rem; text-align:center;"><b>Description</b></h5>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div id="msg"></div>
                        <div class="row">
                            <!--<div class="col-lg-4 col-md-5 col-sm-12 text-center">
                                <div class="position-relative overflow-hidden" id="prod-img-holder">
                                    <img src="<?//= validate_image(isset($image_path) ? $image_path : "") ?>" alt="<?//= $row['name'] ?>" id="prod-img" class="img-thumbnail bg-gradient-gray">
                                </div>
                            </div>-->
                            <div class="col-lg-8 col-md-7 col-sm-12">
                                <!--<h3><b><?//= $name ?></b></h3>
                                <div class="d-flex w-100">
                                    <div class="col-auto px-0"><small class="text-muted">Vendor: </small></div>
                                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0"><small class="text-muted"><?//= $vendor ?></small></p></div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-auto px-0"><small class="text-muted">Category: </small></div>
                                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0"><small class="text-muted"><?//= $category ?></small></p></div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-auto px-0"><small class="text-muted">Price: </small></div>
                                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0 pl-3"><small class="text-primary"><?//= format_num($price) ?></small></p></div>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-md-3 form-group">
                                        <input type="number" min = "1" id= 'qty' value="1" class="form-control rounded-0 text-center">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button class="btn btn-primary btn-flat" type="button" id="add_to_cart"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                                    </div>
                                </div>-->
                                <div style="width:65rem;"><?= html_entity_decode($description) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--    </div>
</div>-->
        <!--<div class="content py-3" id="donate-btn">-->
            <!--<div class="col-md-3 form-group">-->
            <a href="<?php echo base_url ?>/?page=program/donate_program&id=<?= $id ?>" class="btn btn-large btn-primary rounded-pill col-lg-3 col-md-5 col-sm-12"  style="border:solid; margin-left:51.7rem; width:68.5rem; margin-bottom:1rem; height:5rem;"><i class="#"></i><center>Donate Here!</center></a>
                <!--btn redirect to donate-->
            <!--</div>--> 
        <!--</div>-->
    </div>
</div>



<script>
    function add_to_cart(){
        var pid = '<?= isset($id) ? $id : '' ?>';
        var qty = $('#qty').val();
        var el = $('<div>')
        el.addClass('alert alert-danger')
        el.hide()
        $('#msg').html('')
        start_loader()
        $.ajax({
            url:_base_url_+'classes/Master.php?f=add_to_cart',
            method:'POST',
            data:{product_id:pid,quantity:qty},
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast('An error occurred.','error')
                end_loader()
            },
            success:function(resp){
                if(resp.status =='success'){
                    location.reload()
                }else if(!!resp.msg){
                    el.text(resp.msg)
                    $('#msg').append(el)
                    el.show('slow')
                    $('html, body').scrollTop(0)
                }else{
                    el.text("An error occurred. Please try to refresh this page.")
                    $('#msg').append(el)
                    el.show('slow')
                    $('html, body').scrollTop(0)
                }
                end_loader()
            }
        })
    }
    $(function(){
        $('#add_to_cart').click(function(){
            if('<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 3 ?>'){
                add_to_cart();
            }else{
                location.href = "./login.php"
            }
        })
    })
</script>