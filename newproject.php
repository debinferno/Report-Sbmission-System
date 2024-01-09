<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $project = $_POST['project'];
    $subarea = $_POST['subarea'];
    $du = $_POST['du'];
    $desc=$_POST['desc'];
    $startdate= $_POST['startdate'];
    $enddate= $_POST['enddate'];

    // Check whether this email exists
    $existSql = "SELECT * FROM `projects` WHERE pr_name = '$project' AND sub_area='$subarea'AND du='$du'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Oops!</strong>Project with the same name and specifications already exicts
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    }
    else{
    $sql = "INSERT INTO `projects` (`pr_name`, `description`, `sub_area`, `du`, `startdate`, `enddate`) VALUES ( '$project','$desc', '$subarea','$du','$startdate', '$enddate')";
    $result = mysqli_query($conn, $sql);
            
    if($result){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success!</strong>New project details entered into the database
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>';

    }
    else{
        echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong>Error!</strong>Could not insert data into database
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
 
    }
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
    <link rel="stylesheet" href="styl.css">
    <title>iRecord-Add Project</title>
  </head>
  <body>
  <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php include 'header2.php';?>   
    
    
<?php
 if(isset($_GET['access']) && $_GET['access']==0){
  echo '<div class="alert alert-primary alert-dismissible fade show my-0" role="alert">
            <strong>Sorry!</strong>You are not authorised to add a new project to the database
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
 }
elseif(isset($_GET['access']) && $_GET['access']==1){
  $query = $_SERVER['QUERY_STRING'];
  $queryString="?".$query;
    echo '<section class="container">
      <header>Project Details</header>
      <form action="/tatasteel/newproject.php'.$queryString.'" class="form" method="POST">
        <div class="input-box">
          <label>Project Name*</label>
          <input type="text" placeholder="Enter project name" name="project" id="project" required />
        </div>

        <div class="input-box">
          <label>Description</label>
        </div>
        <textarea class="form-control" placeholder="Enter" id="desc" name="desc" rows="3"></textarea>
            

        <div class="input-box">
          <label>Sub Area*</label>
          <input type="text" placeholder="Enter sub area" name="subarea" id="subarea" required />
        </div>        

        
        
        <div class="input-box address">
          <label>DU*</label>
          <div class="column">
            <div class="select-box">
              <select name="du" required/>
                <option hidden>Choose an option</option>
                <option value="IMEE">IMEE</option>
                <option value="SM">SM</option>
                <option value="PS">PS</option>
              </select>
            </div>
          </div>
        </div>


        <div class="input-box">
            <label>Effectivity*</label>
            <input type="date" placeholder="Enter date" name="startdate" id="startdate" required/>
          </div>
          <div class="input-box">
            <label>Deadline</label>
            <input type="date" placeholder="Enter date" name="enddate" id="enddate" />
          </div>




        <button>Submit</button>
      </form>
    </section>';
 }
 ?>


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