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
$query;
$queryString;

if(isset($_GET['row_id']) && isset($_GET['sno'])){
  //global $pr_id,$user_id;
  $pr_id = $_GET['row_id'];
  $user_id = $_GET['sno'];
  $query = $_SERVER['QUERY_STRING'];
  $queryString="?".$query;
  }

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['date'])){
    $date=$_POST['date'];
    include 'partials/_dbconnect.php';
    global $pr_id,$user_id,$query,$queryString;
    echo '<section class="container">
      <header>Achieved Quantity</header>

      <form action="/tatasteel/submit_report.php'.$queryString.'" class="form" id="form" method="POST">
      <div class="box">
           <label><b>Date</b></label>   <label><b>'.$date.'</b></label>
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


        </tr>



        <input type="hidden" name="date" value='.$date.'>';
          $sql = "SELECT * FROM `discipline`";
          $result = mysqli_query($conn, $sql);
          $k=0; 
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
              $query="SELECT * FROM report WHERE disc_id='".$sno."' AND date='".$date."' AND cat_id='".$dsno."' AND pr_id='".$pr_id."'";
              $res=mysqli_query($conn, $query);
              if($res && mysqli_num_rows($res)>0){
                $record = mysqli_fetch_assoc($res);  
              echo '<tr><td><div class="input-box"><label>'.$drow['cat_name'].'</label></div></td>
              <td><div class="input-box"><label>'.$drow['uom'].'</label></div></td>';
              if(isset($record['tar_set']) && !empty($record['tar_set']))
                echo'<td><div class="input-box"><label>'.$record['tar_set'].'</label></div></td>';
              else
                echo'<td><div class="input-box"><label>0</label></div></td>';        
              echo'<td><div class="input-box">
              <input type="text" placeholder="Enter Actual Quantity" name="aq/'.$sno.'/'.$dsno.'" id="aq/'.$sno.'/'.$dsno.'" value='.$record['tar_ach'].' />
              </div></td> 
              </tr>';
              $k=$k+1;
              }
              else{
                echo '<tr><td><div class="input-box"><label>'.$drow['cat_name'].'</label></div></td>
              <td><div class="input-box"><label>'.$drow['uom'].'</label></div></td>
              <td><div class="input-box"><label>0</label></div></td>         
              <td><div class="input-box">
              <input type="text" placeholder="Enter Actual Quantity" name="aq/'.$sno.'/'.$dsno.'" id="aq/'.$sno.'/'.$dsno.'"/>
              </div></td> 
              </tr>';
              }
            }
          }
          echo '<input type="hidden" name="count" id="count" value='.$k.'>
          </table>
          </div>
          <button type="button" onclick="confirmSubmission()">Submit</button>
        </form>
      </section>';
        }
      }



?>
<script>
function confirmSubmission() {
            // Get the value from a specific input field in the form
            var userInput = document.getElementById('count').value;

            // Construct a dynamic confirmation message
            if (parseInt(userInput)>0){
            var confirmationMessage = "Submitting the form will update the existing records. Are you sure you want to submit the form ?";
            }
            else{
              var confirmationMessage = "Are you sure you want to submit the form ?";
            }

            // Display the dynamic confirmation dialog
            var confirmation = confirm(confirmationMessage);

            // If the user confirms, proceed with the form submission
            if (confirmation) {
                document.getElementById('form').submit();
            } else {
                // If the user cancels, prevent the form submission
                console.log('Form submission canceled.');
            }
        }

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
