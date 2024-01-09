<?php
session_start();
$params = $_GET;

// Variable name to exclude (replace 'unknown_variable' with the actual variable name)
$variableToRemove = 'row_id';

// Check if the variable exists in the query parameters
if (isset($params[$variableToRemove])) {
    // Unset the variable from the query parameters
    unset($params[$variableToRemove]);
}
//$queryString = $_SERVER['QUERY_STRING'];

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="logo"><img src="/tatasteel/tata_logo.png"></div>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>';


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  echo '
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="/tatasteel/welcome.php?'.http_build_query($params).'">HOME<span class="sr-only">(current)</span></a>
    </li>
  </ul>
  <div class="row ml-auto">
      <p class="text-light my-2 mx-2">Welcome '. $_SESSION['username']. ' </p>
      <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a></div>';
}
else{ 
  echo '<div class="row ml-auto">
    <button class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#loginModal">Login</button>
    <button class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupModal">Signup</button></div>';
  }


  echo '</div>
      </nav>'; 

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
$currentURL = $_SERVER['REQUEST_URI'];
$baseURL = strtok($currentURL, '?');
if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="true" && $baseURL=="/tatasteel/welcome.php"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You are logged in
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
elseif (isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="false"){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $_GET['error'].'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
}
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
elseif (isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $_GET['error'].'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
}
?>
