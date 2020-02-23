<html>
<head>
<meta charset="UTF-8"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
</head>



<form action="allport.php" method="post">
    <br>    	
<h1>Find All Open Ports</h1>
<br><br>
&nbsp;&nbsp;&nbsp;<label>Enter Host:</label>
<input type="text" name="host" id="host" placeholder="Enter Host" required="">
<br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" type="submit" name="submit">Check All Open Ports</button>
</form>

<?php

if(isset($_POST['submit'])){

check_all_ports();

}

function check_all_ports(){
$host = htmlentities($_POST['host']);

ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);

$ports = array(21, 22, 23, 25, 53, 69, 80, 81, 110, 123, 143, 389, 443, 587, 2525, 3306, 4444, 8080);

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port, $errno, $errstr, 2);
    if (is_resource($connection))
    {
        echo '<h2><font color="green">' . $host . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</font> </h2>' . "\n";
        fclose($connection);


    }
}
}

?>

</body>
</html> 
