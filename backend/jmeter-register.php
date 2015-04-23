<?php

function check_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$cluster_id=check_input($_POST["cluster_id"]);
$slave_ip=check_input($_POST["slave_ip"]);
$list=check_input($_POST["list"]);

$cluster_id=check_input($_GET["cluster_id"]);
$slave_ip=check_input($_GET["slave_ip"]);
$list=check_input($_GET["list"]);

if( preg_match("/^\d+$/",$cluster_id) )
{
    if ($list=='true')
    {
        $filename='/tmp/register_'.$cluster_id.'.log';
        $list=file_get_contents($filename);

        $convert = explode("\n", $list);

        echo "remote_hosts=";
        foreach($convert as $ip){
                if ( $ip!='' ){
                        echo $ip.':1099, ';
                }
        }
   }
   else {
        if (filter_var($slave_ip, FILTER_VALIDATE_IP)){
                $file = "/tmp/register_$cluster_id.log";
                file_put_contents($file,$slave_ip.PHP_EOL,FILE_APPEND | LOCK_EX);
        }
   }
}
