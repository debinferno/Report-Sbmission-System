<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="st.css" />
    <title>iRecord-Month&Year</title>
  </head>
  <body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php include 'header3.php';?>
    <?php

if(isset($_GET['row_id']) && isset($_GET['sno']) && isset($_GET['access'])){
    //global $pr_id,$user_id;
    $pr_id = $_GET['row_id'];
    $user_id = $_GET['sno'];
    $access= $_GET['access'];
    $query = $_SERVER['QUERY_STRING'];
    $queryString="?".$query;
 if($access==0){
  echo '<div class="alert alert-primary alert-dismissible fade show my-0" role="alert">
            <strong>Sorry!</strong>You are not authorised to add the daily plan to the database
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
 }
 else{
echo '<div class="container">
  <div class="box">
    <form id="myForm" action="/tatasteel/plan.php'.$queryString.'" method="POST">
    <input type="hidden" name="pr_id" id="pr_id" value="'.$pr_id.'">
    <label>Select Month</label>
            <select name="m" id="m" class="form-control" required/>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <label>Select Year</label>
            <input type="number" name="y" id="y" class="form-control" required/>
            <button id="submitBtn">Submit</button>
          </div>
</form >
</div>';
}
}
?>
<script>
  document.getElementById("submitBtn").addEventListener("click", function (event) {
    const form = document.getElementById("myForm");

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









    

                

