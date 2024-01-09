
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Navbar Designs</title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>
<body>
    <?php
    $params = $_GET;
    
    // Variable name to exclude (replace 'unknown_variable' with the actual variable name)
    $variableToRemove = 'row_id';
    
    // Check if the variable exists in the query parameters
    if (isset($params[$variableToRemove])) {
        // Unset the variable from the query parameters
        unset($params[$variableToRemove]);
    }

   //$query = $_SERVER['QUERY_STRING'];
   //$queryString="?".$query;

	echo '<div class="navbar navbar_2">
    <div class="navbar_left">
		<ul class="menu">
			<li><a href="/tatasteel/welcome.php?'.http_build_query($params).'">Home</a></li>
			<li><a href="/tatasteel/newproject.php?'.http_build_query($params).'">Add Project</a></li>
			<li><a href="/tatasteel/search.php?'.http_build_query($params).'">Search Project</a></li>
		</ul>
    </div>
    </div>';
    ?>	
</body>
</html>