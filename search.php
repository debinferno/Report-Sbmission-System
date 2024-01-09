<!doctype html>
<html>
<head>
<!--<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">-->
<title>iRecord-Search Project</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--<link rel="stylesheet" href="/tatasteel/stylesearch.css">-->
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="http://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!-- INCLUDES -->

<!--<script src="/tatasteel/js/bootstrap-table-expandable.js"></script>-->
</head>
<body>
<?php include 'partials/_dbconnect.php';?>
<?php include 'partials/_header.php';?>
<?php include 'header2.php';?>   
<?php

echo '<div class="container"><form class="form-inline my-2 my-lg-0" action="'.$_SERVER['REQUEST_URI'].'" method="POST">
    <label>Project  </label>  <input class="form-control mr-sm-2" type="search" placeholder="Project" name="project" id="project" aria-label="Search">  <label>Sub-Area  </label>  <input class="form-control mr-sm-2" type="search" placeholder="Sub_Area" name="subarea" id="subarea" aria-label="Search">  
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form></div>';

    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(empty($_POST['project'])) || !(empty($_POST['subarea']))){
        include 'partials/_dbconnect.php';
        $count=0;
        
       echo '<div class="heading"><h3>SELECT A PROJECT TO VIEW DETAILS</h3></div>
       <table id="myTable">
       <tr>
       <th>Project Name</th>
       <th>Sub-Area</th>
       <th>DU</th>
       </tr>';
       if(!(empty($_POST['project'])) && !(empty($_POST['subarea']))){
        $sql="SELECT * FROM projects WHERE pr_name LIKE '%".$_POST['project']."%' OR sub_area LIKE '%".$_POST['subarea']."%'";
       }
       elseif(!(empty($_POST['project']))){
        $sql="SELECT * FROM projects WHERE pr_name LIKE '%".$_POST['project']."%'";
       }
       elseif(!(empty($_POST['subarea']))){
        $sql="SELECT * FROM projects WHERE sub_area LIKE '%".$_POST['subarea']."%'";
       }

        $result = mysqli_query($conn, $sql);        
        while($row = mysqli_fetch_assoc($result)){
            $count++;
            echo '<tr id="'.$row['pr_id'].'">
            <td>'.$row['pr_name'].'</td>
            <td>'.$row['sub_area'].'</td>
            <td>'.$row['du'].'</td>
            </tr>';

        }
        if($count==0)
        {
            echo '<tr><td colspan="3">No results found</td></tr>';
        }
    }
    else{
        echo '<div class="alert alert-primary alert-dismissible fade show my-0" role="alert">
        Please enter either of the fields to be searched
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>       
    </div>';
    
    }
}
?>


<script>
  // Add a click event listener to the table rows
  var table = document.getElementById("myTable");
  var rows = table.getElementsByTagName("tr");
  for (var i = 0; i < rows.length; i++) {
    rows[i].addEventListener("click", function (e) {
      // Get the ID of the clicked row
      var selectedRowId = e.currentTarget.getAttribute("id");

      // Check if the row ID is not null before further processing
      if (selectedRowId !== null) {
        // Check if the row is non-empty before sending the request
        if (e.currentTarget.innerText.trim() !== "") {
          // Redirect the user to a new URL with the selected ID as a query parameter
          const queryString = window.location.search;
          window.location.href = "/tatasteel/summary.php"+queryString+"&row_id=" + selectedRowId;
        } 
      } 
    });
  }
</script>
<style>
  
    /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

/* Apply general styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}



/* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

/* Apply general styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
/*
body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: rgb(130, 106, 251);
}

/* Style the container */
.container {
  position: relative;
  max-width: 700px;
  width: 100%;
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.heading{
    position: relative;
    max-width: 700px;
    width: 100%;
    font-size: 26px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin-top: 30px;
    margin-left: 330px
}

.container header {
  font-size: 1.5rem;
  color: #333;
  font-weight: 500;
  text-align: center;
}

/* Style the form */
.form-inline {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  flex-wrap: wrap;
}

.form-inline label {
  color: #333;
}

.form-inline input[type="search"] {
  position: relative;
  height: 40px;
  font-size: 1rem;
  color: #707070;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0 15px;
}

.form-inline input[type="search"]:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}

.form-inline .btn {
  height: 40px;
  width: 200px;
  margin-top:10px;
  margin-bottom:10px;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  background: rgb(130, 106, 251);
}

.form-inline .btn:hover {
  background: rgb(88, 56, 250);
}

/* Responsive styles */
@media screen and (max-width: 500px) {
  .form-inline {
    flex-direction: column;
  }
}

/* Style the table */
#myTable {
  width: 95%;
  border-collapse: collapse;
  margin-top: 20px;
  margin-left:35px;
  margin-right:10px;
}

#myTable th,
#myTable td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: left;
}

#myTable th {
  background-color: #f2f2f2;
}

#myTable tr {
  background-color: #fff;
}

#myTable tr:hover {
  background-color: #ddd;
}





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