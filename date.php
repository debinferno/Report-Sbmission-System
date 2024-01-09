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

<?php

if(isset($_GET['row_id']) && isset($_GET['sno'])){
    //global $pr_id,$user_id;
    $pr_id = $_GET['row_id'];
    $user_id = $_GET['sno'];
    $query = $_SERVER['QUERY_STRING'];
   $queryString="?".$query;
echo '<div class="container">
  <h3>REPORT</h3>
  <div class="box">
    <form id="myForm" action="/tatasteel/reportview.php'.$queryString.'" method="POST">
    <input type="hidden" name="pr_id" id="pr_id" value="'.$pr_id.'">
    <input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">
           <label><b>From*</b></label> <input type="date" placeholder="Enter date" name="startdate" id="startdate" required/>  <label><b>To</b></label> <input type="date" placeholder="Enter date" name="enddate" id="enddate" /> <button id="submitBtn">GO</button>
          </div>
</form >
</div>';
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



  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0; /* Remove default body margin */
      padding: 0;
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;     
      background-color: #fff;
      padding: top -100px;
      padding-bottom:20px;
      margin-top: 0px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }


    
    h3 {
      margin:0px;
      text-align: center;
      padding:2px;
    }
    
    .box {
      background-color: #f5f5f5;
      padding:10px;
      border-radius: 5px;
      margin-top: 0px;
    }
    
    form {
      text-align: center;
      margin-top: 20px;
    }
    
    label {
      margin-right: 10px;
    }
    
    input[type="date"] {
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-right: 10px;
    }
    
    #submitBtn {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    
    #submitBtn:hover {
      background-color: #0056b3;
    }
  </style>




<!--
<script>
  document.getElementById("myForm").addEventListener("submit", function (event) {
    const formElements = event.target.elements;
    let emptyFields = [];

    for (let i = 0; i < formElements.length; i++) {
      const input = formElements[i];

      if (input.required && input.value.trim() === "") {
        emptyFields.push(input.name);
      }
    }

    if (emptyFields.length > 0) {
      event.preventDefault(); // Prevent form submission
      alert("Please fill out all required fields: " + emptyFields.join(", "));
    }
  });
</script>-->


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