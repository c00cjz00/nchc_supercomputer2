<?php
/***
Edit config.php
Example: php ssh-autoSSH_sendCmd.php  'date;date;date;'
***/
define('MODULE_FILE', true);
include("config.php");
if (!isset($passwd) || ($passwd=="")) $passwd=prompt_silent();
$sendCmd=""; if (isset($argv[1])) $sendCmd=trim($argv[1]);
if (($passwd!="") && ($otpKey!="")){

 $cmd=createSSHConnection($sshpassBin,$ip,$user,$passwd,$otpKey); 
 if ($sendCmd!="") $cmd=$cmd." '".$sendCmd."'";
 //echo $cmd."\n";
 passthru($cmd,$status1);
 if ($status1!=0) {
  $time=30-(gmdate("s", time())%30);
  echo "Please wait for ".$time." secnods!\n"; 
  for($i=0;$i<=$time;$i++){
   echo $i." "; sleep(1);
  }
  $cmd=createSSHConnection($sshpassBin,$ip,$user,$passwd,$otpKey); 
  if ($sendCmd!="") $cmd=$cmd." '".$sendCmd."'"; 
  //echo $cmd."\n";
  passthru($cmd,$status2);   
  if ($status2!=0) {
   echo "\nSomething error\nTry to send your command again\n\n";
  }
 }
}else{
 echo "Please type password and otpKey\n\n";
}

function createSSHConnection($sshpassBin,$ip,$user,$passwd,$otpKey){
 include_once("lib/GoogleAuthenticator.php");
 $g = new GoogleAuthenticator(); $googleKey = $g->getCode($otpKey); $passwd=$passwd.$googleKey;
 $cmd=$sshpassBin." -p ".$passwd." ssh -o StrictHostKeyChecking=no -l ".$user." ".$ip;
 return $cmd;
}
   
   
function prompt_silent($prompt = "Enter Password:") {
  if (preg_match('/^win/i', PHP_OS)) {
    $vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
    file_put_contents(
      $vbscript, 'wscript.echo(InputBox("'
      . addslashes($prompt)
      . '", "", "password here"))');
    $command = "cscript //nologo " . escapeshellarg($vbscript);
    $password = rtrim(shell_exec($command));
    unlink($vbscript);
    return $password;
  } else {
    $command = "/usr/bin/env bash -c 'echo OK'";
    if (rtrim(shell_exec($command)) !== 'OK') {
      trigger_error("Can't invoke bash");
      return;
    }
    $command = "/usr/bin/env bash -c 'read -s -p \""
      . addslashes($prompt)
      . "\" mypassword && echo \$mypassword'";
    $password = rtrim(shell_exec($command));
    echo "\n";
    return $password;
  }
}
?>
