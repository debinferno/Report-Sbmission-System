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
