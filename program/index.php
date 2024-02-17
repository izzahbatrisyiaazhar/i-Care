<?php 
//$category_ids = isset($_GET['cids']) ? $_GET['cids'] : 'all';
?>
<style>
    .heading {
  background: url(uploads/3.2.png) no-repeat;
  /*background-color: #aed3e3;*/
  background-size: cover;
  background-position: center;
  /*text-align: center;*/
  padding-top: 5rem;
  padding-bottom: 5rem;
  width:100%;
}

.heading h1 {
  color: black;
  font-size: 4rem;
  text-align: right;
  padding-right: 3rem;
}

.heading p {
  padding-top: .5rem;
  font-size: 1.45rem;
  padding-right: 21rem;
  text-align: center;
  color: #666;
}

.heading p a {
  color: black;
  padding-right: .5rem;
}

.heading p a:hover {
  color: #df6f79;
}
    </style>

    <div class="heading">
        <h1>Emergency Relief Programs</h1>
        <p> <a href="index.php">Home >></a> Programs </p>
    </div>

<div class="content py-3">
    <div class="row">
        
        <div class="col-md-12">
            <div class="card card-outline card-primary shadow rounded-0">
                <div class="card-body">
                    <div class="container-fluid">
                       
                        <div class="row" id="product_list">
                            <?php 
         
                            $program = $conn->query("SELECT * FROM program");
                            while($row = $program->fetch_assoc()):
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 product-item">
                                <a href="./?page=program/view_program&id=<?= $row['id'] ?>" class="card shadow rounded-0 text-reset text-decoration-none">
                                <div class="product-img-holder position-relative">
                                    <img src="<?= validate_image($row['image_path']) ?>" alt="Product-image" class="img-top product-img bg-gradient-gray">
                                </div>
                                    <div class="card-body border-top border-gray">
                                        <h5 class="card-title text-truncate w-100"><strong><?= $row['name'] ?></strong></h5>
                                       
                                        <br>
                                        <p class="card-text truncate-3 w-100"><small><?= strip_tags(html_entity_decode($row['description'])) ?></small></p>
                                    </div>
                                </a>
                            </div>
                            <?php endwhile; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
