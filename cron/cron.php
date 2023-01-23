<?php



//$m_bday = date('Y-m-d');

$m_bdaym = date('m');
$m_bdayd = date('d');

//
$servername = "localhost";
$username = "mydemosuser";
$password = "akELd4oRiL9k";
$database = "my_demos";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

$heroes = array();

//SELECT * FROM record WHERE (DATEPART(yy, reg_date) = 2009 AND DATEPART(mm, register_date) = 10 AND DATEPART(dd, register_date) = 10)
$sql = "SELECT Reg_Firstname, Reg_Lastname, Reg_Phone, Reg_Email FROM civil_reg_table WHERE (DATEPART(mm, Reg_Birthday) = '" . $m_bdaym . "' AND (DATEPART(dd, register_date) = '". $m_bdayd ."';";

$stmt = $conn->prepare($sql);
$stmt->execute();

$stmt->bind_result($fna, $lna, $pho, $ema);
while ($stmt->fetch()) {
    $temp = [
        'Firstname' => $fna,
        'Lastname' => $lna,
        'Phone' => $pho,
        'Email' => $ema,
    ];
    array_push($heroes, $temp);
}

//if ((!isset($_POST['qname'])) && (!isset($_POST['qemail']))) 
//header("Location: index.php");

for ($i = 0; $i < count($heroes); $i++) 
{
	

$to = "rilwan.at@gmail.com";
$subject = "Happy Birthday " . $heroes[$i]['Firstname'] . " " . $heroes[$i]['Lastname'];
$message = "Happy Birthday Again!!" . " Phone: " . $heroes[$i]['Phone'] . "Email: " . $heroes[$i]['Email'];
$headers = "To: $to\r\n";
$headers = "From: rilobas.birthday.bot\r\n";

//$file = file_get_contents("image.png");
//$message.=chunk_split(base64_encode($file))."--1a2a3a\r\n";


$retval = mail ($to, $subject, $message, $headers);
         
if ($retval == true ) 
{
	//echo "<p>..</p>";	
	//header("Location: idexm.php");
	
	} else {
	//echo "Message could not be sent...";
	
	}
}
?>