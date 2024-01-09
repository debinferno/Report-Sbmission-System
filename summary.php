<!doctype html>
<html>
<head>
<!--<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">-->
<title>iReport-Project Summary</title>
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
<!--<link rel="stylesheet" href="/tatasteel/css/bootstrap-table-expandable.css">
<script src="/tatasteel/js/bootstrap-table-expandable.js"></script>-->

</head>
<body>
<?php include 'partials/_dbconnect.php';?>
<?php include 'partials/_header.php';?>
<?php include 'header3.php';?>

<?php
if(isset($_GET['row_id'])){
    $pr_id=$_GET['row_id'];
    $sql="SELECT * FROM projects WHERE pr_id='".$pr_id."'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
      echo '<div class="container">
            <div class="column">
              <div class="label">Project:</div>
              <div class="value">'.$row['pr_name'].'</div>

              <div class="label">Description:</div>
              <div class="value">'.$row['description'].'</div>

              <div class="label">Sub Area:</div>
              <div class="value">'.$row['sub_area'].'</div>

              <div class="label">DU:</div>
              <div class="value">'.$row['du'].'</div>

              <div class="label">Effectivity:</div>
              <div class="value">'.date("d-m-Y", strtotime($row['startdate'])).'</div>';

    if ($row['enddate'] === NULL) {
      echo '<div class="label">Deadline:</div>
            <div class="value">NONE</div>';
    } else {
      echo '<div class="label">Deadline:</div>
            <div class="value">'.date("d-m-Y", strtotime($row['enddate'])).'</div>';
    }

    echo '</div></div>';


    }
  }
?>

<style>
  /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
/*
body {
  margin: 0;
  font-family: "Poppins", sans-serif;
  font-size: 24px; /* Adjust the font size as needed 
  color: #333;
}*/

.container {
  position: absolute;
  top: 120px;
  left: 0;
  width: 100%;
  min-height: calc(100vh - 120px); 
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 18px; /* Add padding for some spacing */
  box-sizing: border-box; /* Include padding in the width */
}

.column {
  display: grid;
  grid-template-columns: auto auto; /* This will create a two-column layout */
  grid-gap: 10px; 
  max-width: 1200px; 
  width: 100%; 
  padding: 25px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  font-family: "Poppins", sans-serif;
  font-size: 20px;
}

/*
.column {
  display: grid;
  grid-template-columns: auto auto; /* This will create a two-column layout 
  grid-gap: 10px; /* Add some gap between the label and value 
  font-size: 16px;
}*/

.label {
  font-weight: bold;
}

/* Optional: Adjust the width of the labels */
.label {
  min-width: 150px; /* Adjust the width as needed */
}
/*
.container label {
  font-weight: bold;
  margin-bottom: 8px;
}*/




  </style>



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