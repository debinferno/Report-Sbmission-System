<!doctype html>
<html>
<head>
<!--<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">-->
<title>iReport-View Report</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="http://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!-- INCLUDES -->
<link rel="stylesheet" href="/tatasteel/css/bootstrap-table-expandable.css">
<script src="/tatasteel/js/bootstrap-table-expandable.js"></script>
</head>
<body>
<?php include 'partials/_dbconnect.php';?>
<?php include 'partials/_header.php';?>
<?php include 'header3.php';?>


<div class="container">
  <h3>REPORT</h3>
  <?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['startdate']) && $_POST['enddate']==""){
    $pr_id=$_POST['pr_id'];
    $start_date=$_POST['startdate'];
    $end_date=$_POST['startdate'];
  }
  elseif(isset($_POST['startdate']) && $_POST['enddate']!=""){
    $pr_id=$_POST['pr_id'];
    if($_POST['startdate']>=$_POST['enddate']){
      $start_date=$_POST['enddate'];
      $end_date=$_POST['startdate'];
    }
    else{
      $start_date=$_POST['startdate'];
      $end_date=$_POST['enddate'];
    }
    }
    if ($start_date==$end_date){
      echo"<label><b>Date :</b></label> <label><b>".date("d-m-Y", strtotime($start_date))."</b></label>";
    }
    else{
      echo"<label><b>From</b></label> <label><b>".date("d-m-Y", strtotime($start_date))."</b></label> <label><b>To</b></label> <label><b>".date("d-m-Y", strtotime($end_date))."</b></label>";
    }
  }
  ?>
  <table class="table table-hover table-expandable">
    <thead>
      <tr>
        <th>Sl.</th>
        <th>Area/Work Item</th>
        <th>UOM</th>
        <th>Plan Quantity</th>
        <th>Actual Quantity</th>
        <th>Scope</th>
        <th>Till Date</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
    <?php 
          $sql = "SELECT * FROM `discipline`";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            echo "<tr id='expand'><td>".$row['disc_id']."</td><td colspan='7'><span class='uppercase-text'><b>".$row['disc_name']."</b></span></td></tr>";
            }
          ?>

    </tbody>
    </table>

    <table class="expandable-table">
    <?php 
          $sql = "SELECT * FROM `discipline`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          $pr_id;
          $start_date;
          $end_date;
          if($_SERVER["REQUEST_METHOD"] == "POST"){
          if(isset($_POST['startdate']) && $_POST['enddate']==""){
            $pr_id=$_POST['pr_id'];
            $start_date=$_POST['startdate'];
            $end_date=$_POST['startdate'];
          }
          elseif(isset($_POST['startdate']) && $_POST['enddate']!=""){
            $pr_id=$_POST['pr_id'];
            if($_POST['startdate']>=$_POST['enddate']){
              $start_date=$_POST['enddate'];
              $end_date=$_POST['startdate'];
            }
            else{
              $start_date=$_POST['startdate'];
              $end_date=$_POST['enddate'];
            }
            }
          while($row = mysqli_fetch_assoc($result)){
            $sno =$row['disc_id'] ;
            $count=0;
            //$dsql="SELECT * FROM `".$row['disc_name']."`";
            $dsql = "SELECT * FROM `report` WHERE pr_id = '".$pr_id."' AND disc_id = '".$sno."' AND date >= '".$start_date."' AND date <= '".$end_date."' ORDER BY date DESC, cat_id ";
            $dresult = mysqli_query($conn, $dsql);
            $drow = mysqli_fetch_assoc($dresult);
            while($drow){
            //echo $drow['cat_id'];
            $count++;
            $rsql="SELECT * FROM `".$row['disc_name']."` WHERE cat_id='".$drow['cat_id']."'";
            $rresult = mysqli_query($conn, $rsql);
            $rrow = mysqli_fetch_assoc($rresult);
            echo "<tr id='".$sno."'>
            <td scope='row'>". $count. "</td>
            <td>". $rrow['cat_name'] . "</td>
            <td>". $rrow['uom'] . "</td>
            <td>". $drow['tar_set'] . "</td>
            <td>". $drow['tar_ach'] . "</td>
            <td>". $drow['total'] . "</td>
            <td>". $drow['till_date'] . "</td>
            <td colspan='2'>". date("d-m-Y", strtotime($drow['date'])) . "</td>

          </tr>";
          $next= mysqli_fetch_assoc($dresult);
          if($next==""){
            $date=NULL;
          }
          elseif(isset($next)){
            $date=$next['date'];
          }
          $psql="SELECT * FROM projects WHERE pr_id='".$pr_id."'";
          $presult = mysqli_query($conn, $psql);
          $prow = mysqli_fetch_assoc($presult);
          if($date==NULL || $drow['date']!=$date){
            if($prow['enddate']!="" && $drow['date']>$prow['enddate']){
            echo "<tr id='".$sno."'><td></td><td colspan='8'>Deadline exceeded</td></tr>";
            }
            else{
              echo "<tr id='".$sno."'><td></td><td colspan='8'></td></tr>";
            }         

            }
            $drow=$next;
          }
           if($count==0){
            echo "<tr id='".$sno."'><th></th><td colspan='8'>No records found</td></tr>";
          }
          
          }
        }
        
          ?>
          </table>
</div>
<style>body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;
  }
  
  
  .container {
    max-width: 1000px; /* Adjust the maximum width of the container */
    margin: 0 auto;
    margin-top: 20px; /* Adjust the margin-top value to create space below the navbar */
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  }
  
  h3 {
    margin-top: 0;
   /* Change the color of the header */
  }


  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 10px;
  }
  
  th {
    background-color: #f8f8f8;
    font-weight: bold;
  }
  
.uppercase-text {
    text-transform: uppercase;
  }</style>



<!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  

</body>
</html>