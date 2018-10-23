<?php
$whoami=get_current_user();
$dirBin=dirname(__FILE__);
echo $dirBin;
$personalDir="/home/".$whoami;
$dataUploadSite="http://140.110.17.247/github/curl/index.php";
?>