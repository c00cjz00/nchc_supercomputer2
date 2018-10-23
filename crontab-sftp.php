<?php
// 主機端程式
// 發送主機會此檔案將送至peta主機, 有另一隻程式會建立crotab流程,來執行此程式, 
// 並產生 $whoami.".Query" whoami.".List" $whoami.".Scan" 然後回傳至發送主機
// configure //
$personalDir="/home/c00cjz00";
$scanDir="/home/c00cjz00/";
$dataUploadSite="http://140.110.17.247/github/curl/index.php";
$record='<?php
$personalDir="'.$personalDir.'";
$scanDir="'.$scanDir.'";
$dataUploadSite="'.$dataUploadSite.'";
?>';
$rand=rand(); exec("mkdir /tmp/".$rand);
$prgfile_hx =  "/tmp/".$rand."/crontab_config.php"; $fp = fopen($prgfile_hx, "w"); fwrite($fp, $record); fclose($fp);


$dirBin=dirname(__FILE__);
$cmd="php ".$dirBin."/ssh-autoSSH_sftp.php ".$personalDir."/myCrontab ".$dirBin."/crontab-query.php ".$dirBin."/crontab-execCrontab.php ".$prgfile_hx;
echo "\n".$cmd."\n"; exec($cmd); sleep(1); unlink($prgfile_hx); rmdir("/tmp/".$rand);
$cmd="php ssh-autoSSH_sendCmd.php 'php ".$personalDir."/myCrontab/crontab-execCrontab.php'";
echo "\n".$cmd."\n"; exec($cmd);


 
?>