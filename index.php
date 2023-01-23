<?php

date_default_timezone_set('Africa/Lagos');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
    <meta charset=utf-8>
    <meta name=description>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel=stylesheet type="text/css">
    <link href="style/style.css" rel="stylesheet" type="text/css">



  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" media="screen" href="calendar.css">
</head>

<body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">

            <div class="navbar-header">

            </div>

            <div id="navbar" class="collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                </ul>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
        <br />
            <hr />
			<div class="">

<?php
$lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
if (file_exists(realpath("calendar_$lang.php"))) {
    include "calendar_$lang.php";
} else {
    echo "No Calendar to View";
}
?>

            </div>
        </div>
    </div>




<footer>
	<div class="container">
        <hr>
        <p class="text-center" style="color: #eeeeee;">
            <small>developed by rilwan</small>
        </p>
    </div>
    <script src="js/bootstrap.min.js"></script>
    </footer>
</body>

</html>
