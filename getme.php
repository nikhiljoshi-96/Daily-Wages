<?php
if(isset($_GET['num'])){
	if(strlen($_GET['num'])>=12){
	$myObj->number = substr($_GET['num'], strlen($_GET['num'])-10);
	}
	else{
	$myObj->number =$_GET['num'];
	}
	$myObj->times =strtotime("now");
	//$myJSON = json_encode($myObj);
	$toeditfile="buffer/call-".date('dmY', time()).".json";
	$file=readfile($toeditfile);
	if(empty($file)){
		$file=array($myObj);
		$myfile = fopen($toeditfile, "w") or die("Unable to open file!");
		$json=json_encode($file);	
		fwrite($myfile, $json);
		fclose($myfile);
		try{
		writetodb($myObj->number);
		}
		finally
		{
			echo 1;
		}
	}
	else{
		$my = fopen($toeditfile, "r") or die("Unable to open file!");
		$file=fread($my,filesize($toeditfile));
		$temp = json_decode($file);
		array_push($temp,$myObj);
		$myfile = fopen($toeditfile, "w") or die("Unable to open file!");
		$temp=json_encode($temp);
		fwrite($myfile,$temp);
		fclose($myfile);
		try{
		writetodb($myObj->number);
		}
		finally
		{
			echo 1;
		}
}
echo 1;}
else
{
	echo 0;

}
function writetodb($mobile)
{
$uid="";	
$server="localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "major";
$conn = new mysqli($server, $dbuser, $dbpass, $dbname);
$q3="SELECT `uid` FROM `kyc` WHERE `mobile` =".$mobile;
$result = $conn->query($q3);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$uid =  $row["uid"];
	}
}
$q1="INSERT INTO `open`(`uid`, `date`, `status`) VALUES (?,?,?)";//run all insert query and return true or false
$stmt = $conn->prepare($q1);
$status="open";
$date=date('Y-m-d', time());
$stmt->bind_param("sss",$uid,$date,$status);
$stmt->execute();
$stmt->close();
$conn->close();
}
?>