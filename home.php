<style>
    
</style>

<div class="col-lg-12 py-5">
    <div class="contain-fluid">
        <div class="card card-outline card-dark shadow rounded-0">
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <h3 class="text-center"><b>Welcome</b></h3>
                    <hr>
                    <div class="welcome-content">
                        <?php include("welcome.html") ?>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="clear-fix mb-3"></div>
        <h3 class="text-center"><b>Emergency Relief Programs</b></h3>
        <center><hr class="w-25"></center>
        <div class="row" id="product_list">
            <?php 
            $program = $conn->query("SELECT * FROM program order by RAND() limit 3");
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
        <div class="clear-fix mb-2"></div>
        <div class="text-center">
            <a href="./?page=program" class="btn btn-large btn-primary rounded-pill col-lg-3 col-md-5 col-sm-12">Explore More Programs</a>
        </div>
    </div>
</div>