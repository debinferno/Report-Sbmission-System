<?php
$pr_id;
$user_id;

if(isset($_GET['row_id']) && isset($_GET['sno'])){
  //global $pr_id,$user_id;
  $pr_id = $_GET['row_id'];
  $user_id = $_GET['sno'];
  }


if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    global $pr_id,$user_id;
    //echo $pr_id;
    //echo $user_id;
    $sql = "SELECT * FROM `discipline`";
    $c=0;
    $f=0;
    $n=0;
    $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $sno =$row['disc_id'] ;
            $dsql = "SELECT * FROM `".$row['disc_name']."`";
            $dresult = mysqli_query($conn, $dsql);
            while($drow = mysqli_fetch_assoc($dresult)){
              $n++;
              $dsno=$drow['cat_id'] ;
              if (empty($_POST['aq/'.$sno.'/'.$dsno]) && empty($_POST['pq/'.$sno.'/'.$dsno]) && empty($_POST['scope/'.$sno.'/'.$dsno]) && empty($_POST['td/'.$sno.'/'.$dsno])  ) {
                $c++;
            } else {
                $aq = $_POST['aq/'.$sno.'/'.$dsno];
                $pq = $_POST['pq/'.$sno.'/'.$dsno];
                $scope = $_POST['scope/'.$sno.'/'.$dsno];
                $td = $_POST['td/'.$sno.'/'.$dsno];
                if(empty($_POST['date'])){
                $rsql="INSERT INTO `report` (`pr_id`, `disc_id`, `cat_id`, `tar_ach` ,`tar_set`,`total`,`till_date`,`user_id`) VALUES ( '$pr_id','$sno','$dsno','$aq','$pq','$scope','$td','$user_id')";
                }
                else{
                  $date=$_POST['date'];
                  $rsql="INSERT INTO `report` (`pr_id`, `disc_id`, `cat_id`, `tar_ach` ,`tar_set`,`total`,`till_date`,`user_id`,`date`) VALUES ( '$pr_id','$sno','$dsno','$aq','$pq','$scope','$td','$user_id','$date')";
                } 
                $rresult = mysqli_query($conn, $rsql); 
                if($rresult){
                  $f++;
                }        
              }
            }
          }
            if(($n-$c)==$f && $n!=$c){
              echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong>Report has been submitted
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
            }
            elseif($n!=$c){
              echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong>Sorry!</strong> Report submission was not successful
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
            }
          }


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
    <title>iRecord-Report Submission</title>
  </head>
  <body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php include 'header3.php';?>
     <?php
     echo '<section class="container">
      <header>Project Details</header>

      <form action="'. $_SERVER['REQUEST_URI'] . '" class="form" method="POST">
      <div class="box">
           <label><b>Date</b></label>
            <input type="date" placeholder="Enter date" name="date" id="date" />
          </div>
      <div class="details">
         
        <table class="input-table">

        <tr><th><div class="input-box">
          <label>Area/Work Item</label>
        </div></th>

        <th><div class="input-box">
          <label>UOM</label>
        </div></th>       
        
        
        <th><div class="input-box">
          <label>Plan Quantity</label>
        </div></th>
         
        <th><div class="input-box">
          <label>Actual Quantity</label>
        </div></th>

        <th><div class="input-box">
          <label>Scope</label>
        </div></th>

        <th><div class="input-box">
          <label>Till Date</label>
        </div></th>


        </tr>';



          
          $sql = "SELECT * FROM `discipline`";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            $dsql = "SELECT * FROM `".$row['disc_name']."`";
            $sno =$row['disc_id'] ;
            $dresult = mysqli_query($conn, $dsql);
            $numRows = mysqli_num_rows($dresult);
            if($numRows!=0){
            echo '<tr><th colspan="7"><div class="input-box"><label>'.$row['disc_name'].'</label></div></th></tr>';
          }
            echo "<tr class='expanded-content'>";
            while($drow = mysqli_fetch_assoc($dresult)){
              $dsno=$drow['cat_id'] ;
              echo '<tr><td><div class="input-box"><label>'.$drow['cat_name'].'</label></div></td>

              <td><div class="input-box"><label>'.$drow['uom'].'</label></div></td>

        <td><div class="input-box">
          <input type="text" placeholder="Enter Plan Quantity" name="pq/'.$sno.'/'.$dsno.'" id="pq/'.$sno.'/'.$dsno.'" />
        </div></td>
         
        <td><div class="input-box">
          <input type="text" placeholder="Enter Actual Quantity" name="aq/'.$sno.'/'.$dsno.'" id="aq/'.$sno.'/'.$dsno.'" />
        </div></td>

        <td><div class="input-box">
          <input type="text" placeholder="Enter Scope" name="scope/'.$sno.'/'.$dsno.'" id="scope/'.$sno.'/'.$dsno.'" />
        </div></td>

        <td><div class="input-box">
          <input type="text" placeholder="Enter Till Date" name="td/'.$sno.'/'.$dsno.'" id="td/'.$sno.'/'.$dsno.'" />
        </div></td>
           
          </tr>';
            }
          }
        ?>

        </table>
        </div>
        <button>Submit</button>
      </form>
    </section>;
 


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
    <!-- new JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>

echo '<pre>';
print_r($_POST);
echo '</pre>';