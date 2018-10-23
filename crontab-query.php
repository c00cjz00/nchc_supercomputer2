<?php
// 發送主機會此檔案將送至peta主機, 有另一隻程式會建立crotab流程,來執行此程式, 
// 並產生 $whoami.".Query" whoami.".List" $whoami.".Scan" 然後回傳至發送主機
include("000-config.php");
$whoami=get_current_user();
$cmd="/opt/pbs/bin/qstat -Q"; $remoteFile="/tmp/".$whoami.".Query"; curlFile($cmd,$remoteFile);
$cmd="/opt/pbs/bin/qstat"; $remoteFile="/tmp/".$whoami.".List"; curlFile($cmd,$remoteFile);
$cmd="/usr/bin/find '".$personalDir."'"; $remoteFile="/tmp/".$whoami.".Scan"; curlFile($cmd,$remoteFile);

function curlFile($cmd,$remoteFile){
 unlink($remoteFile); sleep(1);
 $cmdExec=$cmd." > ".$remoteFile; 
 exec($cmdExec); sleep(1);
 $cmdCurl="/usr/bin/curl -F 'fileToUpload=@".$remoteFile."' ".$dataUploadSite; 
 exec($cmdCurl); sleep(1);
} 
?>