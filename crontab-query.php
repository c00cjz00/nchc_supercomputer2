<?php
// peta端程式
// 發送主機會此檔案將送至peta主機, 有另一隻程式會建立crotab流程,來執行此程式, 
// 並產生 $whoami.".Query" whoami.".List" $whoami.".Scan" 然後回傳至發送主機
$dirBin=dirname(__FILE__);

include($dirBin."/crontab_config.php");

$whoami=get_current_user();

$cmd="/opt/pbs/bin/qstat -Q"; $remoteFile="/tmp/".$whoami.".Query"; curlFile($cmd,$remoteFile,$dataUploadSite);
$cmd="/opt/pbs/bin/qstat"; $remoteFile="/tmp/".$whoami.".List"; curlFile($cmd,$remoteFile,$dataUploadSite);
$cmd="/usr/bin/find ".$scanDir; $remoteFile="/tmp/".$whoami.".Scan"; curlFile($cmd,$remoteFile,$dataUploadSite);

function curlFile($cmd,$remoteFile,$dataUploadSite){
 unlink($remoteFile); sleep(1);
 $cmdExec=$cmd." > ".$remoteFile; 
 echo $cmdExec."\n";
 exec($cmdExec); sleep(1);
 $cmdCurl="/usr/bin/curl -F 'fileToUpload=@".$remoteFile."' ".$dataUploadSite; 
 exec($cmdCurl); sleep(1);
} 
?>