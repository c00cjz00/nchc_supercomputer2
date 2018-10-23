<?php
/*** 
Get secret address: 
https://iservice.nchc.org.tw/module_page.php?module=nchc_service#nchc_service/nchc_service.php?action=nchc_unix_account_edit
***/
if (!defined('MODULE_FILE')) {
// die ("You can't access this file directly...\n\n");
}
## 請先安裝 sshpass
$sshpassBin="/usr/bin/sshpass";
$ip="clogin1.twnia.nchc.org.tw"; // or clogin2.twnia.nchc.org.tw , glogin1.twni
$user="c00cjz00";
$otpKey = '';


## crontab 使用設定 ## 
$whoami=get_current_user();
$dirBin=dirname(__FILE__);
echo $dirBin;
$personalDir="/home/".$whoami;
$dataUploadSite="http://140.110.17.247/github/curl/index.php";

?>
