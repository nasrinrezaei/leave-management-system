<?php
$servername="localhost";
$username="root";
$password="";
$dbname="mydb";
$dsn="mysql:host=$servername; dbname=$dbname;";
try{
	$Connect=new PDO($dsn,$username,$password);
	$Connect->exec("SET CHARACTER SET UTF8");
	$Connect->exec("set names utf8");
	$Connect= mysqli_connect('localhost','root','');
mysqli_select_db($Connect,'mydb');
	return $Connect;
}
catch(PDOException $Error){
	echo "Connet error in server".$Error->__toString();
	
}


$Connect= mysqli_connect('localhost','root','');
mysqli_select_db($Connect,'mydb');
?>