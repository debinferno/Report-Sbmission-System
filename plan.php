<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/tatasteel/sty.css"/>
    <!--<script src="http://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
    <script src="/tatasteel/js/expand.js"></script>
    <title>iRecord-Monthly Plan</title>
  </head>
  <body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php include 'header3.php';?>
<?php
$pr_id;
$firstDayOfMonth;
$lastDayOfMonth;
$currentDay;

//if(isset($_GET['row_id']) && isset($_GET['sno'])){
  //global $pr_id,$user_id;
  //$pr_id = $_GET['row_id'];
  //$user_id = $_GET['sno'];
  //}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['m']) && isset($_POST['y']) && isset($_POST['pr_id'])){
        $firstDayOfMonth = new DateTime($_POST['y'].'-'.$_POST['m'].'-01');
        $lastDayOfMonth = new DateTime($firstDayOfMonth->format('Y-m-t'));
        $pr_id=$_POST['pr_id'];
    }
    else if(isset($_POST['firstDay']) && isset($_POST['lastDay']) && isset($_POST['pr_id'])){
        $firstDayOfMonth=new DateTime($_POST['firstDay']);
        $lastDayOfMonth=new DateTime($_POST['lastDay']);
        $pr_id=$_POST['pr_id'];
        $currentDay = clone $firstDayOfMonth;
        $k=0;
        $c=0;
        $f=0;
        $n=0;
        $flag=0;
        while ($currentDay <= $lastDayOfMonth) {
            $date=$currentDay->format('Y-m-d');
            include 'partials/_dbconnect.php';
            //global $pr_id,$user_id;****
            //echo $pr_id;
            //echo $user_id;
            $sql = "SELECT * FROM `discipline`";            
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $sno =$row['disc_id'] ;
                $dsql = "SELECT * FROM `".$row['disc_name']."`";
                $dresult = mysqli_query($conn, $dsql);
                while($drow = mysqli_fetch_assoc($dresult)){
                    $n++;
                    $dsno=$drow['cat_id'] ;
                    if (isset($_POST['0/'.$date.'/'.$sno.'/'.$dsno])){
                        if(empty($_POST['0/'.$date.'/'.$sno.'/'.$dsno]) && $_POST['0/'.$date.'/'.$sno.'/'.$dsno]!=0) {
                            $c++;    
                        }
                        else{
                            $pq = $_POST['0/'.$date.'/'.$sno.'/'.$dsno];
                            $aq=0;
                            $q="SELECT * FROM report WHERE disc_id='".$sno."' AND date='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                            $ro=mysqli_query($conn, $q);
                            if($ro && mysqli_num_rows($ro)==0)
                                $rsql="INSERT INTO `report` (`pr_id`, `disc_id`, `cat_id`, `tar_set`,`tar_ach`,`date`) VALUES ( '$pr_id','$sno','$dsno','$pq','$aq','$date')";
                            else
                                $rsql="UPDATE report SET tar_set='".$pq."' WHERE disc_id='".$sno."' AND date='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                            $rresult = mysqli_query($conn, $rsql); 
                            $p=0;
            $s1="SELECT SUM(tar_ach) AS tara FROM report WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $s2="SELECT SUM(tar_set) AS tars FROM report WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $res1=mysqli_query($conn, $s1);
            $res2=mysqli_query($conn, $s2);
            $record1 = mysqli_fetch_assoc($res1);
            $record2 = mysqli_fetch_assoc($res2);
            $rsql1="UPDATE report SET till_date='".$record1['tara']."' WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $rsql2="UPDATE report SET total='".($record2['tars']-$record1['tara'])."' WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $rresult1 = mysqli_query($conn, $rsql1);
            $rresult2 = mysqli_query($conn, $rsql2); 
            if($rresult && $rresult1 && $rresult2){
              $f++;
            }
            $sq="SELECT * FROM report WHERE disc_id='".$sno."' AND date>'".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
            $r=mysqli_query($conn, $sq);
            if($r && mysqli_num_rows($r)>0){
              while($re = mysqli_fetch_assoc($r)){
                $scope=$re['total']+$pq-$p;
                $s="UPDATE report SET total='".$scope."' WHERE rep_id='".$re['rep_id']."'";
                $rr=mysqli_query($conn, $s);
              } 
            }
                        }
                    }
                    else if(isset($_POST['1/'.$date.'/'.$sno.'/'.$dsno]) && isset($_POST[$k.'/rep_id'])){
                        $rep_id=$_POST[$k.'/rep_id'];
                        if(empty($_POST['1/'.$date.'/'.$sno.'/'.$dsno]) && $_POST['1/'.$date.'/'.$sno.'/'.$dsno]!=0) {
                            $c++;
                            $pq=0;
                        }
                        else{
                            $pq = $_POST['1/'.$date.'/'.$sno.'/'.$dsno];
                            $rsql="UPDATE report SET tar_set='".$pq."' WHERE rep_id='".$rep_id."'";
                            $rresult = mysqli_query($conn, $rsql); 
                            $q="SELECT * FROM report WHERE rep_id='".$rep_id."'";
                            $ro=mysqli_query($conn, $q);
                            $rec=mysqli_fetch_assoc($ro);
                            if(empty($rec['tar_set']))
                                $p=0;
                            else
                                $p=$rec['tar_set'];
                            if(empty($rec['tar_ach']))
                                $aq=0;
                            else
                                $aq=$rec['tar_set'];
                            if($aq>$pq)
                                $flag++;
                                $s1="SELECT SUM(tar_ach) AS tara FROM report WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                                $s2="SELECT SUM(tar_set) AS tars FROM report WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                                $res1=mysqli_query($conn, $s1);
                                $res2=mysqli_query($conn, $s2);
                                $record1 = mysqli_fetch_assoc($res1);
                                $record2 = mysqli_fetch_assoc($res2);
                                $rsql1="UPDATE report SET till_date='".$record1['tara']."' WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                                $rsql2="UPDATE report SET total='".($record2['tars']-$record1['tara'])."' WHERE disc_id='".$sno."' AND date<='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                                $rresult1 = mysqli_query($conn, $rsql1);
                                $rresult2 = mysqli_query($conn, $rsql2); 
                                if($rresult && $rresult1 && $rresult2){
                                  $f++;
                                }
                                $sq="SELECT * FROM report WHERE disc_id='".$sno."' AND date>'".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                                $r=mysqli_query($conn, $sq);
                                if($r && mysqli_num_rows($r)>0){
                                  while($re = mysqli_fetch_assoc($r)){
                                    $scope=$re['total']+$pq-$p;
                                    $s="UPDATE report SET total='".$scope."' WHERE rep_id='".$re['rep_id']."'";
                                    $rr=mysqli_query($conn, $s);
                                  } 
                                }        
                        }
                        $k++;
                    }
                }
            }
            $currentDay->modify('+1 day');
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
      <header>Monthly Plan</header>

      <form action="'. $_SERVER['REQUEST_URI'] . '" class="form" method="POST">
      
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
          <label>Plan Quantity</label>
        </div></th>
         
        </tr>';

?>
<!--

        <header>Project Details</header>
        <table class="table table-hover table-expandable">
        <thead>
          <tr>
            <th>Area/Work Item</th>
            <th>UOM</th>
            <th>Plan Quantity</th>
            <th>Actual Quantity</th>
          </tr>
        </thead>
        <tbody>
         
                $currentDay = clone $firstDayOfMonth;
                while ($currentDay <= $lastDayOfMonth) {
                $date=$currentDay->format('Y-m-d');
                echo '<tr id="expand"><th colspan="4">'.$date.'</th></tr>';
                $currentDay->modify('+1 day');
            }
              
    
        </tbody>
        </table>

        -->


<?php
        $currentDay = clone $firstDayOfMonth;
        $k=0;
        echo '<input type="hidden" name="firstDay" id="firstDay" value="'.$firstDayOfMonth->format('Y-m-d').'">
        <input type="hidden" name="lastDay" id="lastDay" value="'.$lastDayOfMonth->format('Y-m-d').'">
        <input type="hidden" name="pr_id" id="pr_id" value="'.$pr_id.'">';
        $qq="SELECT * FROM projects WHERE pr_id='".$pr_id."'";
        $rr=mysqli_query($conn, $qq);
        $rs=mysqli_fetch_assoc($rr);
        while ($currentDay <= $lastDayOfMonth) {
            $date=$currentDay->format('Y-m-d');
            //$date=date("d-m-Y", strtotime($currentDay));
            if($date<$rs['startdate'])
                echo '<tr id="expand"><th colspan="4">'.$currentDay->format('d-m-Y').'(Project yet to begin)</th></tr>';
            else if($date==$rs['startdate']) 
                echo '<tr id="expand"><th colspan="4">'.$currentDay->format('d-m-Y').'(Project starts)</th></tr>';
            else if($date>$rs['enddate'])
                echo '<tr id="expand"><th colspan="4">'.$currentDay->format('d-m-Y').'(Deadline exceeded)</th></tr>';
            else
                echo '<tr id="expand"><th colspan="4">'.$currentDay->format('d-m-Y').'</th></tr>';
            $sql = "SELECT * FROM `discipline`";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $dsql = "SELECT * FROM `".$row['disc_name']."`";
                $sno =$row['disc_id'] ;
                $dresult = mysqli_query($conn, $dsql);
                $numRows = mysqli_num_rows($dresult);
                if($numRows!=0){
                    echo '<tr id="'.$date.'"><th colspan="4"><div class="input-box"><label>'.$row['disc_name'].'</label></div></th></tr>';
                }
                while($drow = mysqli_fetch_assoc($dresult)){
                    $dsno=$drow['cat_id'] ;
                    $query="SELECT * FROM report WHERE disc_id='".$sno."' AND date='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
                    $res=mysqli_query($conn, $query);
                    if($res && mysqli_num_rows($res)>0){
                        $record = mysqli_fetch_assoc($res);                        
                        echo '<tr id="'.$date.'"><td><div class="input-box"><label>'.$drow['cat_name'].'</label></div></td>
                        <td><div class="input-box"><label>'.$drow['uom'].'</label></div></td>
                        <input type="hidden" name="'.$k.'/rep_id" value='.$record['rep_id'].'>
                        <td><div class="input-box">
                        <input type="text" placeholder="Enter Plan Quantity" name="1/'.$date.'/'.$sno.'/'.$dsno.'" id="1/'.$date.'/'.$sno.'/'.$dsno.'" value='.$record['tar_set'].' />
                        </div></td>';
                        if(isset($record['tar_ach']) && !empty($record['tar_ach']))
                            echo'<td><div class="input-box"><label>'.$record['tar_ach'].'</label></div></td>';
                        else
                            echo'<td><div class="input-box"><label>0</label></div></td>';
                        echo'</tr>';
                        $k=$k+1;                        
                    }
                    else{
                        echo '<tr id="'.$date.'"><td><div class="input-box"><label>'.$drow['cat_name'].'</label></div></td>
                        <td><div class="input-box"><label>'.$drow['uom'].'</label></div></td>
                        <td><div class="input-box">
                        <input type="text" placeholder="Enter Plan Quantity" name="0/'.$date.'/'.$sno.'/'.$dsno.'" id="0/'.$date.'/'.$sno.'/'.$dsno.'" />
                        </div></td>
                        <td><div class="input-box"><label>0</label></div></td>           
                        </tr>'; 
                    }                   
                }
            }
            $currentDay->modify('+1 day'); 
        }
?>

        </table>
        </div>
        <button>Submit</button>
      </form>
    </section>
 
    

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
