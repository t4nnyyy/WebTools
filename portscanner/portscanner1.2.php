<?php
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
   
}    
$user_ip= get_client_ip();
echo "Your IP: " . $user_ip;
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
 
  width: 280px;
}

.form-popup {
  display: none;
  position: fixed;
  top: 122px;
  right: 850px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}


.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

.form-container .cancel {
  background-color: red;
}

.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
</head>
<body>
<br><br><br>
<button class="open-button" onclick="openCustForm()">Check Custom Port</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="open-button" onclick="openAllPortForm()">Check All Ports</button>


<div class="form-popup" id="CustPort">
  <form method ="post" action="port1.1.php" class="form-container">
    
    <h2>Check Custom Port</h2>

    <label for="host"><b>Host Name or IP</b></label>
    <input type="text" placeholder="Enter Host" name="host" required>

    <label for="port"><b>Port Number</b></label>
    <input type="text" placeholder="Enter Port" name="port" required>

    <button type="submit" class="btn" name="CustPort">Check</button>
    <button type="button" class="btn cancel" onclick="closeCustForm()">Close</button>
  </form>
</div>


<div class="form-popup" id="AllPorts">
    <form method ="post" action="port1.1.php" class="form-container">
      
      <h2>Check All Ports</h2>
  
      <label for="host"><b>Host Name or IP</b></label>
      <input type="text" placeholder="Enter Host" name="host" required>
      <p id="note"><font color="red" size="5">Please Be Patient! It Will Take Alteast 30 Seconds</font></p>
      <button type="subm" class="btn" onclick="ShowNote()" name="AllPorts">Check</button>
      <button type="button" class="btn cancel" onclick="closeAllPortForm()">Close</button>
    </form>
  </div>

  <?php

if(array_key_exists('AllPorts', $_POST)) { 
    check_all_ports(); 
} 
elseif(array_key_exists('CustPort', $_POST)){
    check_cust_port();
}
elseif(array_key_exists('MyPort', $_POST)){
    MyPort($user_ip);
}

function check_all_ports()
{
    $host = htmlentities($_POST['host']);

    ini_set('max_execution_time', 0);
    ini_set('memory_limit', -1);

    
    $ports = array(20, 21, 22, 23, 25, 53, 80, 110, 115, 123, 143, 161, 194, 443, 445, 465, 554, 873, 993, 995, 3389, 5631, 8080);
    $i=0;
    foreach ($ports as $port)
    {
        
        $connection = @fsockopen($host, $port, $errno, $errstr, 2);
        if (is_resource($connection))
        {
            echo '<h4><br><font color="green">' . $host . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is Open.</font> </h4>' . "\n";
            fclose($connection);
        }
        
        else
        {
            $i++;
            if($i==count($ports))
            {
            echo '<h4><br><font color="red">All Ports Are Closed.</font> </h4>' . "\n";
            //fclose($connection);
            }
        }
        // else{
            
        //     echo $i;
        // }
    }
}


function check_cust_port()
    {
        $host = htmlentities($_POST['host']);
        $port = htmlentities($_POST['port']);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);
    
        $connection = @fsockopen($host, $port, $errno, $errstr, 2);
        if (is_resource($connection))
        {
            echo '<h2><br><font color="green"> ' . $host . ' : ' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</font> </h2>' . "\n";
            fclose($connection);
    
        }
       else
       {
            echo '<h2><br><font color="red"> ' . $host . ':' . $port . ' is Closed.</font</h2>' . "\n";
    
            //fclose($connection);
       }
    }
?>


<script>

   function ShowNote(){
    document.getElementById("note").style.display = "block";     
   }

function openCustForm() {
  document.getElementById("CustPort").style.display = "block";
  closeAllPortForm()
}

function closeCustForm() {
  document.getElementById("CustPort").style.display = "none";
}


function openAllPortForm() {
    document.getElementById("note").style.display = "none";     
  document.getElementById("AllPorts").style.display = "block";
  closeCustForm()
}

function closeAllPortForm() {
  document.getElementById("AllPorts").style.display = "none";
}
</script>

</body>
</html>