<head>
    <!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script	src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
</head>

<style>
    #sys_logo{
        width:5em !important;
        height:5em !important;
        object-fit:scale-down !important;
        object-position:center center !important;
    }

    
  .chart-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
  }
  
  #barChart {
    width: 45%;
  }
  
  #pieChart {
    width: 45%;
  }

  
  
  @media (max-width: 768px) {
    .chart-container {
      flex-wrap: wrap;
    }
    
    #barChart,
    #pieChart {
      width: 100%;
      margin-bottom: 1rem;
    }
  }

</style>

<?php $month = isset($_GET['month']) ? $_GET['month'] : date("Y-m"); ?> <!--retrieve month from URL parameter not db-->

<div class="content py-3">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Report</h5>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="callout callout-primary shadow rounded-0">
                    <form action="" id="filter" method="GET">
                        <div class="row align-items-end">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="form-group form-inline">
                                    <div style="display: flex;">
                                        <label for="program_id" class="control-label">Show </label>
                                        
                                        <select name="program_id" id="program_id" style="margin-left:1rem;" class="form-control rounded-0" required>
                                            <option value="">Select a program</option>
                                            <?php
                                                $program_qry = $conn->query("SELECT id, name FROM program");
                                                while ($row = mysqli_fetch_assoc($program_qry)) {
                                                $selected = '';
                                                if(isset($_GET['program_id']) && $_GET['program_id'] == $row['id']) {
                                                    $selected = 'selected';
                                                }
                                                echo "<option value='".$row['id']."' ".$selected.">".$row['name']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="program_id"  class="control-label" style="margin-left:1rem;">report</label>
                                        <input type="hidden" name="page" value="reports/index">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="form-group" >
                                    <!--<button class="btn btn-primary btn-flat btn-sm" style="margin-left:3rem;"><i class="fa fa-filter"></i> Filter</button>-->
                                    <button type="submit" class="btn btn-primary btn-flat btn-sm" style="margin-left:5rem;"><i class="fa fa-filter"></i> Filter</button>
                                    <button class="btn btn-light border btn-flat btn-sm" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>

                    <!--<div class="chart-container">
                        <canvas id="barChart"></canvas>
                        <canvas id="pieChart"></canvas>
                    </div>-->
                    <div id="outprint">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-header"><strong><center>Bar Chart</center></strong></div>
                                    <div class="card-body">
                                        <div class="chart-container bar-chart">
                                            <canvas id="barChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-header"><strong><center>Pie Chart</center></strong></div>
                                    <div class="card-body">
                                        <div class="chart-container pie-chart">
                                            <canvas id="pieChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                        <div class="clear-fix mb-3"></div>
                            
                                <table class="table table-bordered table-stripped" id="program-table">
                                    <colgroup>
                                        <col width="5%">
                                        <col width="25%">
                                        <col width="40%">
                                        <col width="30%">
                                        <!--<col width="20%">
                                        <col width="15%">
                                        <col width="15%">-->
                                    </colgroup>
                                    <thead>
                                        <tr class="">
                                            <th class="card-header text-center align-middle py-1">#</th>
                                            <th class="card-header text-center align-middle py-1">Category Name</th>
                                            <th class="card-header text-center align-middle py-1">Description</th>
                                            <th class="card-header text-center align-middle py-1">Total Donated Goods</th>
                                            <!--<th class="text-center align-middle py-1">Date Created</th>
                                            <th class="text-center align-middle py-1">Ref. Code</th>
                                            <th class="text-center align-middle py-1">Client</th>
                                            <th class="text-center align-middle py-1">Vendor</th>
                                            <th class="text-center align-middle py-1">Status</th>
                                            <th class="text-center align-middle py-1">Total Amount</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php 
                                            $i = 1;
                                            $total = 0;
                                            $prev_category = '';
                                            $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : '';

                                            $orders = $conn->query("SELECT donation.*, program.name as program_name, category_list.name as category_name, category_list.description as description, SUM(donated_goods.quantity) as quantity
                                                                    FROM donation
                                                                    INNER JOIN program ON program.id = donation.program_id
                                                                    INNER JOIN donated_goods ON donation.id = donated_goods.donation_id
                                                                    INNER JOIN category_list ON category_list.id = donated_goods.category_id
                                                                    WHERE donation.status = 1 " . ($program_id ? "AND program.id = $program_id " : "") .
                                                                    "GROUP BY category_name
                                                                    ORDER BY category_name");

                                            while($row = $orders->fetch_assoc()):
                                                $category = $row['category_name'];
                                                $quantity = $row['quantity'];
                                                $total += $quantity;
                                                
                                                // Check if the category is the same as the previous row
                                                if($category === $prev_category) {
                                                    continue; // Skip the row if the category has already been displayed
                                                }
                                                $prev_category = $category;
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle px-2 py-1"><?php echo $i++; ?></td>
                                                    <td class="align-middle px-2 py-1"><?= $category ?></td>
                                                    <td class="align-middle px-2 py-1"><?= $row['description'] ?></td>
                                                    <td class="align-middle px-2 py-1"><center><?php echo format_num($quantity) ?></center></td>
                                                </tr>
                                            <?php endwhile; ?>
                                    </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center px-1 py-1 align-middle" colspan="3">Grand Total</th>
                                                <th class="text-right px-1 py-1 align-middle"><center><?= format_num($total) ?></center></th>
                                            </tr>
                                        </tfoot>
                                
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<noscript id="print-header">

<div class="d-flex align-items-center">
    <div class="col-auto text-center pl-4">
        <img src="<?= validate_image($_settings->info('logo')) ?>" alt=" System Logo" id="sys_logo" class="img-circle border border-dark">
    </div>
    <div class="col-auto flex-shrink-1 flex-grow-1 px-4">

    <?php 
    
    $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : '';

    $report = $conn->query("SELECT * from program where id = '{$_GET['program_id']}' ");
    while($row = $report->fetch_assoc()):
        $program = $row['name'];

    ?>

        <h4 class="text-center m-0"><?= $_settings->info('name') ?></h4>
        <h3 class="text-center m-0"><b><?= $program ?> Report</b></h3>
        <h5 class="text-center m-0">As of <?= date("l, F j, Y") ?></h5>
    </div>
    <?php endwhile; ?>
</div>
<hr>
</noscript>
<script>
    $(function(){

        // Check if program_id is empty
        if (!getUrlParameter('program_id')) 
        {
        // Remove chart and table data
        $('#barChart').remove();
        $('#pieChart').remove();
        $('#program-table tbody').empty().append($('<tr>').append($('<td colspan="4" class="text-center">').text("No data available for selected program.")));
        $('#program-table tfoot').empty();
    }

        
        $('#filter').submit(function(e){
            e.preventDefault()

            // Get the selected program id
            var programId = $('#program_id').val();

            /*location.href = "./?page=reports/index&"+$(this).serialize();*/

            // Redirect to the reports page with the selected program id as a query parameter
            window.location.href = "./?page=reports/index&program_id=" + programId;
        })


        /*$('#print').click(function() {
            start_loader();
            var head = $('head').clone();
            var p = $('#outprint').clone();
            var el = $('<div>');
            var header = $($('noscript#print-header').html()).clone();
            head.find('title').text("Emergency Relief Program Report - Print View");
            el.append(head);
            el.append(header);

            // Convert bar chart to image
            var barChartImage = $('#barChart')[0].toDataURL();
            var barChartContainer = p.find('.bar-chart');
            barChartContainer.empty().append($('<img>').attr('src', barChartImage));

            // Convert pie chart to image
            var pieChartImage = $('#pieChart')[0].toDataURL();
            var pieChartContainer = p.find('.pie-chart');
            pieChartContainer.empty().append($('<img>').attr('src', pieChartImage));

            el.append(p);

            var nw = window.open("", "_blank", "width=1000,height=900,top=50,left=75");
            nw.document.write(el.html());
            nw.document.close();

            setTimeout(() => {
                nw.print();
                setTimeout(() => {
                    nw.close();
                    end_loader();
                }, 200);
            }, 500);
        });*/

        $('#print').click(function() {
            start_loader();
            var head = $('head').clone();
            var p = $('#outprint').clone();
            var el = $('<div>');
            var header = $($('noscript#print-header').html()).clone();

            var currentDateTime = new Date().toLocaleString('en-MY'); // Get the current date

            var programNameFromDatabase = ""; // Initialize the program name variable

            var selectedProgramId = $('#program_id').val();

            // Make an AJAX request to retrieve the program name from the server
            $.ajax({
                url: 'reports/get_program_name.php', // Specify the URL of your PHP script that retrieves the program name
                method: 'GET',
                data: {
                    program_id: selectedProgramId // Pass the selected program ID in the AJAX request
                },
                success: function(response) {
                    programNameFromDatabase = response; // Assign the retrieved program name to the variable

                    var title = programNameFromDatabase + " Report " + currentDateTime;
                    head.find('title').text(title);

                    el.append(head);
                    el.append(header);

                    // Convert bar chart to image
                    var barChartImage = $('#barChart')[0].toDataURL();
                    var barChartContainer = p.find('.bar-chart');
                    barChartContainer.empty().append($('<img>').attr('src', barChartImage));

                    // Convert pie chart to image
                    var pieChartImage = $('#pieChart')[0].toDataURL();
                    var pieChartContainer = p.find('.pie-chart');
                    pieChartContainer.empty().append($('<img>').attr('src', pieChartImage));

                    el.append(p);

                    var nw = window.open("", "_blank", "width=1000,height=900,top=50,left=75");
                    nw.document.write(el.html());
                    nw.document.close();

                    setTimeout(() => {
                        nw.print();
                        setTimeout(() => {
                            nw.close();
                            end_loader();
                        }, 200);
                    }, 500);
                },
                error: function() {
                    // Handle error if program name retrieval fails
                }
            });
});


        
    // Get URL query parameter by name
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };
        

    })

    
    // Get the data for the charts
    var barData = {
        labels: [],
        datasets: [{
            label: 'Total Donated Goods',
            data: [],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };
    <?php
        $orders->data_seek(0); // reset pointer to the beginning
        while($row = $orders->fetch_assoc()):
            $category = $row['category_name'];
            $quantity = $row['quantity'];
    ?>
        barData.labels.push('<?= $category ?>');
        barData.datasets[0].data.push(<?= $quantity ?>);
    <?php endwhile; ?>

    var pieData = {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };
    <?php
    $orders->data_seek(0); // reset pointer to the beginning
    $i = 0;
    $total_quantity = 0;

    while($row = $orders->fetch_assoc() and $i < 6):
        $quantity = $row['quantity'];
        $total_quantity += $quantity;

    ?>
        
        <?php $i++; ?>
    <?php endwhile; ?>

    <?php
    $orders->data_seek(0); // reset pointer to the beginning
    $i = 0;

    while($row = $orders->fetch_assoc() and $i < 6):
        $category = $row['category_name'];
        $quantity = $row['quantity'];

        // Calculate percentage
        $percentage = round(($quantity / $total_quantity) * 100);

        // Add label with percentage
        $label = "$category ($percentage%)";
    ?>
    

    pieData.labels.push('<?= $label?>');
    pieData.datasets[0].data.push(<?= $quantity ?>);
        
        <?php $i++; ?>
    <?php endwhile; ?>

    // Create the charts
    var ctx1 = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx1, {
        type: 'bar',
        data: barData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    var ctx2 = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx2, {
        type: 'pie',
        data: pieData,
        options: {
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });




</script>

