<?php
/***
Edit config.php
Example: php  php 3-autoSSH_sftp.php /home/c00cjz00/9000 lib/  # argv[1]=remote dir, argv[2]=upload file
***/
define('MODULE_FILE', true);
include("config.php");
if (!isset($argv[1]) || !isset($argv[2])) {echo "Please enter the remote dir and  upload local file list\n"; exit(); }
if (!isset($passwd) || ($passwd=="")) $passwd=prompt_silent();
$remoteDir=trim($argv[1]);
$localFiles="";
for($i=2;$i<$argc;$i++){
 if (isset($argv[$i])) {
  $file=trim($argv[$i]);
  if (is_dir($file)){
  $localFiles.=" mkdir ".$remoteDir."/".basename($file)."\\n put -r ".$file."\\n";
  }elseif (is_file($file)){
   $localFiles.=" put -r ".$file."\\n";    
  }
 }
}  
if (($passwd!="") && ($otpKey!="") && ($localFiles!="")){
 $sendCmd="mkdir ".$remoteDir."\\n cd ".$remoteDir."\\n ";
 $localFiles= trim($sendCmd)." ".trim($localFiles);
 $cmd=createSFTPConnection($sshpassBin,$ip,$user,$passwd,$otpKey);
 $cmd=$cmd."'".$localFiles."'";
// echo $cmd."\n";
 passthru($cmd,$status1);
 if ($status1!=0) {
  $time=30-(gmdate("s", time())%30);
  echo "Please wait for ".$time." secnods!\n";
  for($i=0;$i<=$time;$i++){
   echo $i." "; sleep(1);
  }
  $cmd=createSFTPConnection($sshpassBin,$ip,$user,$passwd,$otpKey);
  $cmd=$cmd."'".$localFiles."'"; 
  echo $cmd."\n";
  passthru($cmd,$status2);
  if ($status2!=0) {
   echo "\nSomething error\nTry to send your command again\n\n";
  }else{
   $message=1;
  }
 }else{
  $message=1;
 }
}else{
 echo "Please type password and otpKey\n\n";
}


echo $message."\n";





function createSSHConnection($sshpassBin,$ip,$user,$passwd,$otpKey){
 include_once("lib/GoogleAuthenticator.php");
 $g = new GoogleAuthenticator(); $googleKey = $g->getCode($otpKey); $passwd=$passwd.$googleKey;
 $cmd=$sshpassBin." -p ".$passwd." ssh -o StrictHostKeyChecking=no -l ".$user." ".$ip;
 return $cmd;
}
   
function createSFTPConnection($sshpassBin,$ip,$user,$passwd,$otpKey){
 include_once("lib/GoogleAuthenticator.php");
 $g = new GoogleAuthenticator(); $googleKey = $g->getCode($otpKey); $passwd=$passwd.$googleKey;
 $cmd=$sshpassBin." -p ".$passwd." sftp -o StrictHostKeyChecking=no ".$user."@".$ip." <<< \$";
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
