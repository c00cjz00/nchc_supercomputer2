<?php
/*** 
Get secret address: 
https://iservice.nchc.org.tw/module_page.php?module=nchc_service#nchc_service/nchc_service.php?action=nchc_unix_account_edit
***/
if (!defined('MODULE_FILE')) {
 die ("You can't access this file directly...\n\n");
}
## 請先安裝 sshpass
$sshpassBin="/usr/bin/sshpass";
$ip="clogin1.twnia.nchc.org.tw"; // or clogin2.twnia.nchc.org.tw , glogin1.twnia.nchc.org.tw
$user="";
$otpKey = '';
?>