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
$ports = array(21, 22, 23, 25, 53, 69, 80, 81, 110, 123, 143, 389, 443, 587, 2525, 3306, 4444, 8080);

foreach ($ports as $port)
{
    $connection = @fsockopen($user_ip, $port, $errno, $errstr, 2);
    if (is_resource($connection))
    {
       
	echo '<li type="1"><font color="green"> ' . $user_ip . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</font> </li>' . "\n";
        fclose($connection);
    }
}

?>
