<?php

function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
   else
        $ipaddress = 'UNKNOWN';
   return $ipaddress;

}
$user_ip = get_client_ip_server();

echo "This is Your IP: " . $user_ip;

echo '<h2>Open Ports in Your System</h2>';
ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);
$ports = array(21, 22, 23, 25, 53, 80, 123, 143, 443, 8080);

foreach ($ports as $port)
{
    $connection = @fsockopen($user_ip, $port, $errno, $errstr, 2);
    if (is_resource($connection))
    {
        echo '<li type="1">&nbsp;' . $user_ip . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</li>' . "\n";
        fclose($connection);

echo '<li type="1"><font color="green"> ' . $user_ip . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</font> </li>' . "\n";
        fclose($connection);
    }
}

?>

<html>
<head>
<meta charset="UTF-8"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
</head>



<form action="port.php" method="post" novalidate>
    <br>    	
<h1>Find All Open Ports</h1>
<br><br>
&nbsp;&nbsp;&nbsp;<label>Enter Host:</label>
<input type="text" name="host" id="host" placeholder="Enter Host" required="">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="port" id="port" placeholder="Enter Port" required="">

<br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" type="subm" name="subm">Check All Open Ports</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" type="sub" name="sub">Check Specific Port</button>
</form>

<?php

if(array_key_exists('subm', $_POST)) { 
    check_all_ports(); 
} 
elseif(array_key_exists('sub', $_POST)){
    check_spec_port();
}


//if(isset($_POST['submit'])){
//check_all_ports();
//}

function check_all_ports()
{
    $host = htmlentities($_POST['host']);

    ini_set('max_execution_time', 0);
    ini_set('memory_limit', -1);

    $ports = array(21, 22, 23, 25, 53, 80, 123, 143, 443, 8080);

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


function check_spec_port()
    {
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