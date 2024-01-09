
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

   $query = $_SERVER['QUERY_STRING'];
   $queryString="?".$query;

	echo '<div class="navbar navbar_2">
    <div class="navbar_left">
		<ul class="menu">
			<li><a href="/tatasteel/summary.php'.$queryString.'">Summary</a></li>
			<li><a href="/tatasteel/date2.php'.$queryString.'">Monthly Plan</a></li>
			<li><a href="/tatasteel/report.php'.$queryString.'">Submit Report</a></li>
			<li><a href="/tatasteel/date.php'.$queryString.'">View Report</a></li>
		</ul>
    </div>
    </div>';
    ?>	
</body>
</html>