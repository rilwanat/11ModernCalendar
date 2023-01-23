<?php

//$m_key = $_GET["key"];
$m_bday = $_GET["bdate"];

//
$servername = "localhost";
$username = "croot";
$password = "sroot";
$database = "my_demos";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

$heroes = array();

$sql = "SELECT Fname, Phone, Email FROM civil_table WHERE Birthday = '" . $m_bday . "';";
$stmt = $conn->prepare($sql);
$stmt->execute();

$stmt->bind_result($fna, $pho, $ema);
while ($stmt->fetch()) {
    $temp = [
        'Firstname' => $fna,
        //'Lastname' => $lna,
        'Phone' => $pho,
        'Email' => $ema,
    ];
    array_push($heroes, $temp);
}
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
  <title>Civil Birthdays</title>
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
			<div class="col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-4">
				<br />
				<hr />
				<h3 class="text-center">Demo Birthday Database</h3>

<?php
echo 'Birthday here is "' . $m_bday . '" with ' . count($heroes) . ' person(s)<br>' . '<br>';

echo json_encode($heroes);

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