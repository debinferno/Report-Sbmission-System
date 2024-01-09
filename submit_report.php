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
$pr_id;
$user_id;
$access;

if(isset($_GET['row_id']) && isset($_GET['sno'])){
  //global $pr_id,$user_id;
  $pr_id = $_GET['row_id'];
  $user_id = $_GET['sno'];
  $access= $_GET['access'];
  $query = $_SERVER['QUERY_STRING'];
  $queryString="?".$query;
  }


if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    global $pr_id,$user_id,$access;
    //echo $pr_id;
    //echo $user_id;
    $sql = "SELECT * FROM `discipline`";
    $c=0;
    $f=0;
    $n=0;
    $k=0;
    $j=0;
    $flag=0;
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
      $sno =$row['disc_id'] ;
      $dsql = "SELECT * FROM `".$row['disc_name']."`";
      $dresult = mysqli_query($conn, $dsql);
      while($drow = mysqli_fetch_assoc($dresult)){
        $n++;
        $dsno=$drow['cat_id'] ;
        if (empty($_POST['aq/'.$sno.'/'.$dsno]) && $_POST['aq/'.$sno.'/'.$dsno]!=0) {
          $c++;
        } 
        else {
          $aq = $_POST['aq/'.$sno.'/'.$dsno];
          $pq;
          if(empty($_POST['date']))
            $date = date("Y-m-d");
          else
            $date=$_POST['date'];
          $query="SELECT * FROM report WHERE disc_id='".$sno."' AND date='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
          $res=mysqli_query($conn, $query);
          if($res && mysqli_num_rows($res)>0){
            $record = mysqli_fetch_assoc($res);
            if(empty($record['tar_ach']) && $record['tar_ach']!=0){
              $a=0;
            }
            else{
              $a=$record['tar_ach'];
            }
            if(empty($record['tar_set'])){
              if($access==1){
                $k++;
                $pq=$aq;
                $p=0;
              }
              else{
                $pq=$aq;
                $p=0;
                $j++;
              }
            }
            else{
              $pq=$record['tar_set'];
              $p=$record['tar_set'];
            }
            if($aq>$p && $p!=0)
              $flag++;
            $rsql="UPDATE report SET tar_ach='".$aq."',tar_set='".$pq."', user_id='".$user_id."' WHERE rep_id='".$record['rep_id']."'";
          }
          else{
            $rsql="INSERT INTO `report` (`pr_id`, `disc_id`, `cat_id`, `tar_ach` ,`tar_set` ,`user_id`,`date`) VALUES ( '$pr_id','$sno','$dsno','$aq','$aq','$user_id','$date')";
            $a=0;
            if($access==1){
              $k++;              
              $pq=$aq;
              $p=0;
            }
            else{              
              $pq=$aq;
              $p=0;
              $j++;
            }
          }
            $rresult = mysqli_query($conn, $rsql);
            $s1="SELECT SUM(tar_ach) AS tara FROM report WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $s2="SELECT SUM(tar_set) AS tars FROM report WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $res1=mysqli_query($conn, $s1);
            $res2=mysqli_query($conn, $s2);
            $record1 = mysqli_fetch_assoc($res1);
            $record2 = mysqli_fetch_assoc($res2);
            $rsql1="UPDATE report SET till_date='".$record1['tara']."', user_id='".$user_id."' WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $rsql2="UPDATE report SET total='".($record2['tars']-$record1['tara'])."', user_id='".$user_id."' WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $rresult1 = mysqli_query($conn, $rsql1);
            $rresult2 = mysqli_query($conn, $rsql2); 
            if($rresult && $rresult1 && $rresult2){
              $f++;
            }
            $sq="SELECT * FROM report WHERE disc_id='".$sno."' AND date>'".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $r=mysqli_query($conn, $sq);
            if($r && mysqli_num_rows($r)>0){
              while($re = mysqli_fetch_assoc($r)){
                $td=$re['till_date']+$aq-$a;
                $scope=$re['total']+$pq-$aq+$a-$p;
                $s="UPDATE report SET till_date='".$td."' , total='".$scope."' WHERE rep_id='".$re['rep_id']."'";
                $rr=mysqli_query($conn, $s);
              } 
            }
          }
        }
      }
      if($k>0){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
              <strong>Success!</strong>The planned quantity has not been entered into the database. You have the authorisation to enter. Kindly fill it.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>';
      }
      else if($j>0){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
              <strong>Success!</strong>The planned quantity has not been entered into the database. Please ask the authorised body to enter the details. Till then the planned quantity it taken to be equal to the achieved quantity.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>';
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
        if($flag!=0){
          echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
          <strong>Sorry!</strong> The actual quantity cannot be greater than the planned quantity. Kindly correct if there was an error in entering the data.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';
      }
            }        
          
}
echo '<section class="container">
      <header>Project Details</header>

      <form action="/tatasteel/display.php'.$queryString.'" class="form" method="POST">
      <div class="box">
           <label><b>Date</b></label>
            <input type="date" placeholder="Enter date" name="date" id="date" required/>
          </div>


          
          
        <button>Submit</button>
      </form>
    </section>';



?>

<script>
  document.getElementById("submitBtn").addEventListener("click", function (event) {
    const form = document.getElementById("form");

    if (!form.checkValidity()) {
      event.preventDefault(); // Prevent form submission

      // Find the first invalid input field and focus on it (optional)
      const invalidInput = document.querySelector(":invalid");
      if (invalidInput) {
        invalidInput.focus();
      }

      alert("PLEASE ENTER THE REQUIRED FIELD");
    }
  });

</script>
 


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