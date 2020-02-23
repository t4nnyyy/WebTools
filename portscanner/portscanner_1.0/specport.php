<html>
<head>
<meta charset="UTF-8"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
</head>

<form action="specport.php" method="post">
    <br>    	
<h1>Find Specific Port</h1>
    <br><br>    	
&nbsp;&nbsp;&nbsp;<label>Enter Host:</label>
<input type="text" name="host" id="host" placeholder="Enter Host" required=""> <b>:</b> <input type="text" name="port" id="port" placeholder="Enter Port" required="">

    <br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" type="submit" name="submit">Check Open Port</button>
</form>


<?php

if(isset($_POST['submit'])){

check_spec_port();

}

function check_spec_port(){
$host = htmlentities($_POST['host']);
$port = htmlentities($_POST['port']);

ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);

    $connection = @fsockopen($host, $port, $errno, $errstr, 2);
    if (is_resource($connection))
    {
		echo '<h2><font color="green"> ' . $host . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</font> </h2>' . "\n";
        fclose($connection);

    }
   else
   {
        echo '<h2><font color="red"> ' . $host . ':' . $port . ' is Closed.</font</h2>' . "\n";

        fclose($connection);
    }
}

?>

</body>
</html> 
