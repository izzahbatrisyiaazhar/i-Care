<!DOCTYPE html>
<html>
<head>
  <title>Info Tag Example</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-fy46pSl3QqC3NMPU0g6Uo/6UvR6zWn1Dd1bKJeb+zPl+Fxpl3wqfJjiSbULYfZGz9ac+DOuvK4lOJ4Fh1Q2Qbw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `program` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo "<script> alert('Unkown Program ID.'); location.replace('./?page=program') </script>";
        exit;
    }
}else{
    echo "<script> alert('Program ID is required.'); location.replace('./?page=program') </script>";
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

#donateFormContainer {
  display: flex;
  justify-content: center;
  clear: both;
  flex-direction: column;
}

#donateForm {

  width: 65rem; 
  /*max-width: 950px; */
  display: block;
}
.form-container {
  display: block;
  margin-bottom: 20px; 
  border: 1px solid rgba(0, 0, 0, 0.125);
}
hr.new {
  border-top: 1px solid rgba(0, 0, 0, 0.125);;
}

a{
  color:black;
}

a:hover{
  color: #0d6efd; /* Replace with your desired shade of blue */
  text-decoration: none;
}

/* Set a fixed height for the img and textarea elements */
.form-group.col-md-6 img{
  height: 255px;
  width: 500px;
}

/* Apply a margin-top to the textarea element to align it with the img element */
/*.form-group.col-md-6 textarea {
  margin-top: 10px;
}*/

</style>


<div class="content py-3">
  <div class="card card-outline card-primary rounded-0 shadow">
    <div class="content py-3" id="desc">
      <div class="card card-outline rounded-0 shadow" style="border:solid; border-width:thin;border-color: lightgrey;">
        <div class="card-body">
          <div class="container-fluid">
            <div id="msg"></div>
              <div class="row" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                <div class="col-lg-8 col-md-7 col-sm-12" >
                  <h2 class="title"><b><a href="./?page=program/view_program&id=<?= $id ?>"><?= $name ?></a></b></h2><br/>
                  <div style="width:65rem;"><?= html_entity_decode($description) ?></div>
                </div>
              </div><br/>

              <div class="col-md-12 d-flex align-items-center justify-content-center" style="height: 100%;" id="donateFormContainer">
              
                <div class="form-container">
                    <div class="card-header">
                      <h5><strong>Donated Goods Detail #1</strong></h5>
                    </div>

                    <input type="hidden" id="program_id" name="program_id" value="<?= $id?>">
                    <input type="hidden" id="donor_id" name="donor_id" value="<?= $_settings->userdata('id')?>">
                    <form id="donateForm" class="p-4">
                     
                       
                        <div class="row">
                            <div class="form-group col-12  col-md-6">
                                <label for="firstname" class="control-label">Name</label>
                                <input type="text" id="name" autofocus name="name" class="form-control form-control-sm form-control-border" required>
                            </div>
                            <div class="form-group col-12  col-md-6">
                                <label for="lastname" class="control-label">Category</label>
                                <select class="form-control form-control-sm form-control-border" id="category" name="category" required>
                                  <option value="">Select a category</option>
                                    <?php
                                      $program_qry = $conn->query("SELECT id, name FROM category_list where status = 1");
                                      $arrCat = array();

                                      while ($row = mysqli_fetch_assoc($program_qry)) {

                                        $arrC = array('name'=>$row['name'], 'cid'=>$row['id']);
                                        array_push($arrCat, $arrC);
                                        $selected = '';

                                      if(isset($_GET['category_id']) == $row['id']) {
                                          $selected = 'selected';
                                      }
                                         echo "<option value='".$row['id']."' ".$selected.">".$row['name']."</option>";
                                      }

                                    
                                        
                                    ?>
                                  <!-- <option value="">Others</option> -->
                                </select>
                                <?php 

                                  $arrCat = json_encode($arrCat);
                                  // echo '<pre>';
                                  // print_r($arrCat);
                                  // echo '</pre>';
                                ?>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-12  col-md-6">
                          <label for="condition" class="control-label">Condition</label>
                          <select class="form-control form-control-sm form-control-border" id="condition" name="condition" required>
                            <option value="">Select a condition</option>
                            <option value="0">Brand New</option>
                            <option value="1">Like New</option>
                            <option value="2">Lightly Used</option>
                            <option value="3">Well Used</option>
                            <option value="4">Heavily Used</option>
                          </select>
                          <small id="info" class="form-text text-muted"></small>
                        </div>
                            <div class="form-group col-12  col-md-6">
                                <label for="qty" class="control-label">Quantity</label>
                                <input type="number" id="qty" autofocus name="qty" class="form-control form-control-sm form-control-border" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12  col-md-6">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" id="description" class="form-control form-control-sm rounded-0 summernote" required></textarea>
                             
                            </div>

                            <div class="form-group col-12  col-md-6">
                              <label for="goods_img" class="control-label">Image</label>
                              <div class="image-container">
                                <input type="file" id="goods_img" name="img" class="form-control form-control-sm form-control-border" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg" <?= !isset($id) ? 'required' : '' ?>>
                                <img src="<?= validate_image(isset($image) ? $image : "") ?>" alt="Goods Image" id="gimg" class="border border-gray img-thumbnail mt-2">
                              </div>
                            </div>
                            
                        </div>
                  </form>
               </div>
               
               <!--new form container should be placed here-->

              

            </div>
          </div>

          <div class="float-right">
            <button type="button" class="btn btn-sm  btn-success" id="addForm" > <span class="fa fa-plus"></span> Add </button>
            <button type="button" class="btn btn-sm btn-danger" id="removeForm"> <span class="fa fa-remove"></span> Remove </button>
          </div>
          <div>
            <br/><br/>
            <hr class="new p-3">
            <button class="btn  btn-primary float-right col-md-3 " type="button" id="submit"><i class="#"></i><center>Submit</center></button>
          </div>


        </div>
      </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-P/KOgs7C+EEWljZh8s1xNRXNl+bYvYIa10kiFg1wMtcCBmpikyv+vt22jcfGQfLu"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

  //get category array from php;
  var arrCat = '<?php echo $arrCat; ?>';
  arrCat = JSON.parse(arrCat);

  const selectElement = document.getElementById('condition');
  const infoElement = document.getElementById('info');

  selectElement.addEventListener('change', function(event) {
    const selectedValue = event.target.value;

    // Remove any previously added info tag
    infoElement.innerHTML = '';

    if (selectedValue === '0') {
      infoElement.innerHTML = '<i class="fas fa-info-circle ml-1" title="Brand New"></i> Never used. May come with original packaging or tag.';
    } else if (selectedValue === '1') {
      infoElement.innerHTML = '<i class="fas fa-info-circle ml-1" title="Like New"></i> Used once or twice. As good as new.';
    } else if (selectedValue === '2') {
      infoElement.innerHTML = '<i class="fas fa-info-circle ml-1" title="Lightly Used"></i> Used with care. Flaws, if any, are barely noticeable.';
    } else if (selectedValue === '3') {
      infoElement.innerHTML = '<i class="fas fa-info-circle ml-1" title="Well Used"></i> Has minor flaws or defects.';
    } else if (selectedValue === '4') {
      infoElement.innerHTML = '<i class="fas fa-info-circle ml-1" title="Heavily Used"></i> Has obvious signs of use or defects.';
    }
    else {
      infoElement.innerHTML = '<i class="fas fa-info-circle ml-1" title=""></i>Not applicable';
    }

    
  });

  function displayImg(input,_this) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#gimg').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}else{
					$('#gimg').attr('src', '<?= validate_image(isset($image) ? $image : "") ?>');
			}
		}

  $(document).ready(function(){

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })

       
	});

  

 /* var formCount = 1; // keep track of the number of forms created

    $("#addForm").click(function() { // button click 
      var newForm = $(".form-container:first").clone(); // clone the first form container --> from the header 
      newForm.find(".card-header h5:first strong:first").text("Donated Goods Detail #" + (++formCount)); // change the header text
      newForm.find("input[type='text'], input[type='number'], input[type='file'], textarea").not("#program_id, #donor_id").val(""); // clear the input fields except for program_id and donor_id
      newForm.find("select").prop('selectedIndex',0); // reset select box
      newForm.insertAfter(".form-container:last"); // add the new form container after the last one
      newForm.find(".form-group:last").remove(); // remove the last form group (condition)
      newForm.find(".form-text:last").remove(); // remove the last form text (description)
      
      // clone the image input and preview container
      var imageContainer = newForm.find('.image-container:first').clone();
      newForm.find('.form-group.col-md-6:first').after(imageContainer);

    });

    // To remove the description and muted text for the condition, you can add the following code before the .clone() method:
    $(".form-container .card-body .form-row:not(:first-child)").hide();
    $(".form-container .card-body .form-row:first-child .col-md-6:not(:first-child) small").hide();*/

//Get the "Add Donated Goods" button
const addButton = document.querySelector('#addForm');

// Get the donate form
// start from the form no header 
const formContainer = document.querySelector('.form-container');

// Set the number of donated goods already displayed
let numDonatedGoods = 1;

// Add event listener to the "Add Donated Goods" button
addButton.addEventListener('click', () => {

               var option = "";
               // console.log(arrCat);
               // loop php array category to option & append
              if(arrCat.length > 0){


                $(arrCat).each(function(){

                      option +=  `<option value="${this.cid}">${this.name}</option>`;

                });

              }
              
              numDonatedGoods++;

              var newForm = `<div class="form-container" data-id="fm${numDonatedGoods}">
                                <div class="card-header">
                                  <h5><strong>Donated Goods Detail #${numDonatedGoods}</strong></h5>
                                </div>
                                  <form id="donateForm" class="p-4">
                                   
                                      <div class="row">
                                          <div class="form-group col-12  col-md-6">
                                              <label for="firstname" class="control-label">Name</label>
                                              <input type="text" id="name" autofocus name="name" class="form-control form-control-sm form-control-border" required>
                                          </div>
                                          <div class="form-group col-12  col-md-6">
                                              <label for="lastname" class="control-label">Category</label>
                                              <select class="form-control form-control-sm form-control-border" id="category" name="category" required>
                                                <option value="">Select a category</option>
                                                ${option}
                                                  
                                              </select>
                                          </div>
                                      </div>
                                      <div class="row">
                                      <div class="form-group col-12  col-md-6">
                                        <label for="condition" class="control-label">Condition</label>
                                        <select class="form-control form-control-sm form-control-border" id="condition" name="condition" required>
                                          <option value="">Select a condition</option>
                                          <option value="0">Brand New</option>
                                          <option value="1">Like New</option>
                                          <option value="2">Lightly Used</option>
                                          <option value="3">Well Used</option>
                                          <option value="4">Heavily Used</option>
                                        </select>
                                        <small id="info" class="form-text text-muted"></small>
                                      </div>
                                          <div class="form-group col-12  col-md-6">
                                              <label for="qty" class="control-label">Quantity</label>
                                              <input type="number" id="qty" autofocus name="qty" class="form-control form-control-sm form-control-border" required>
                                          </div>
                                      </div>

                                      <div class="row">
                                          <div class="form-group col-12  col-md-6">
                                              <label for="description" class="control-label">Description</label>
                                              <textarea name="description" id="description" class="form-control form-control-sm rounded-0 summernote" required></textarea>
                                           
                                          </div>

                                          <div class="form-group col-12  col-md-6">
                                            <label for="goods_img" class="control-label">Image</label>
                                            <div class="image-container">
                                              <input type="file" id="goods_img" name="img" class="form-control form-control-sm form-control-border" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg" alt="Goods Image" id="gimg" class="border border-gray img-thumbnail mt-2">

                                              <img src="<?= validate_image(isset($image) ? $image : "") ?>" alt="Goods Image" id="gimg" class="border border-gray img-thumbnail mt-2">
                                            </div>
                                          </div>
                                          
                                      </div>
                                </form>
                     </div>`;





          // Clone the donate form
          // const newDonatedGoods = formContainer.cloneNode(true); //nak clone dari form-container 

          // // Set the new donated goods' ID and header
          // numDonatedGoods++;
          // newDonatedGoods.id = `formContainer${numDonatedGoods}`;
          // //the title is inside the form 
          // newDonatedGoods.querySelector('h5').textContent = `Donated Goods Detail #${numDonatedGoods}`;




          // // Clear the new donated goods' input fields, except for program_id and donor_id
          // //must add for select and form-text 
          // const inputFields = newDonatedGoods.querySelectorAll('input, textarea, small, img');
          // inputFields.forEach((field) => {
            
          //     field.value = '';
            
          // });

          //newForm.find("select").prop('selectedIndex',0); // reset select box


          // Wrap the cloned form in a new container element and append it to the donateFormContainer
          //append -> add (something) to the end of a written document.
          // const newFormContainer = document.createElement('div');
          // newFormContainer.classList.add('.form-container');
          // newFormContainer.appendChild(newDonatedGoods);

          // append new item to donateFormContainer;
          $('#donateFormContainer').append(newForm);

          // initiaze summernote agn
          $('.summernote').summernote({
              height: 200,
              toolbar: [
                  [ 'style', [ 'style' ] ],
                  [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                  [ 'fontname', [ 'fontname' ] ],
                  [ 'fontsize', [ 'fontsize' ] ],
                  [ 'color', [ 'color' ] ],
                  [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                  [ 'table', [ 'table' ] ],
                  [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
              ]
          })



});



// Get the "Remove Donated Goods" button
const removeButton = document.querySelector('#removeForm');

// Add event listener to the "Remove Donated Goods" button
removeButton.addEventListener('click', () => {
  
  // Only remove if there is more than one form container
  if (numDonatedGoods > 1) {
    // Remove the last form container
    // const lastFormContainer = donateFormContainer.lastElementChild;
    // donateFormContainer.removeChild(lastFormContainer);
    $(`.form-container[data-id="fm${numDonatedGoods}"]`).remove();
    numDonatedGoods--;

  }else{
     console.log('Cant remove any more');
  }

});



const submitButton = document.querySelector('#submit');

submitButton.addEventListener('click', (event) => {
  event.preventDefault(); 
  //ensures that when the button is clicked,
  //the form is not submitted and the page does not reload.

  const donatedGoodsForms = document.querySelectorAll('.form-container form');

    var arrData = [];
    var programid = $('input[name="program_id"]').val().trim();
    var donorid = $('input[name="donor_id"]').val().trim(); 

    var lengthForm = donatedGoodsForms.length;
    console.log(lengthForm);
    var count = 1;

    $('.form-container form').each(async function(){

      
          var name = $(this).find('input[name="name"]').val().trim();
          var category = $(this).find('select[name="category"] option:selected').val().trim();
          var condition = $(this).find('select[name="condition"] option:selected').val().trim();
          var qty = $(this).find('input[name="qty"]').val().trim();
          var desc = $(this).find('textarea[name="description"]').summernote('code');
          var image = $(this).find('input[name="img"]')[0].files[0];
          

          const formDataImg = new FormData();
          formDataImg.append('image', image);

          // upload image first & get path 
          await fetch(_base_url_+'classes/Master.php?f=add_new_image', {
            method: 'POST',
            body: formDataImg
          }) .then((response) => {
    
              return response.json(); // Parse response as JSON
          }).then((data) => {

                console.log(data.status);
                console.log(data.urlPath);

                // push each item data to array
                arrData.push({'name': name, 'category': category, 'condition': condition, 'qty': qty, 'description': `${desc}`, 'image': data.urlPath});

          }).catch((error) => {
            console.error(error);
          });

          if(count == lengthForm){

                // check if last item  then run api to save item array
                const formData = new FormData();
                formData.append('donor_id', donorid);
                formData.append('program_id', programid);
                formData.append('total', count);
                formData.append('donor_item', JSON.stringify(arrData));

                fetch(_base_url_+'classes/Master.php?f=add_new_donate', {
                  method: 'POST',
                  body: formData
                })
                .then((response) => {
                  console.log('After fetch');
                  return response.json(); // Parse response as JSON
                })
                .then((data) => {
                  // Handle the response data
                  console.log(data);
                  // Update the UI with the response message and Bootstrap classes
                  if(data.status === 'success') {
                    $('#msg').text(data.msg).removeClass().addClass('alert alert-success');
                    // Redirect to a page after 2 seconds
                    // setTimeout(function() {
                      window.location.href = _base_url_+'?page=donation_history/my_donations'; // Replace with your desired URL
                    // }, 2000); // 2000 milliseconds = 2 seconds

                  } else {
                    $('#msg').text(data.msg).removeClass().addClass('alert alert-warning');
                  }
                  // You can perform other actions based on the response data
                })
                .catch((error) => {
                  console.error(error);
                });

          }

          count++;
         
    })


        
         




  




  

    
});





				
</script>







</html>