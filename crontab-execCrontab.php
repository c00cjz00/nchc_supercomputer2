<?php
// peta端程式
// 發送主機會此檔案將送至peta主機, 建立crotab流程,執行001-query.php, 
// 001-query.php程式產生 $whoami.".Query" whoami.".List" $whoami.".Scan" 然後回傳至發送主機
include("crontab_config.php");
$dirBin=dirname(__FILE__);

$adminstrator="cjz";
$new_entry="### add by ".$adminstrator." ###";
$input="* * * * * /usr/bin/php ".$dirBin."/crontab-query.php ".$new_entry;

$tmp=shell_exec("/usr/bin/crontab -l | grep -v ".$adminstrator);
$tmpArr=explode("\n",$tmp);
$record="";
for($i=0;$i<count($tmpArr);$i++){
 $tmp=$tmpArr[$i];
 if ($tmp!="") $record.=$tmp."\n";
}
$record.=trim($input)."\n";
$prgfile_hx = tempnam("/tmp", "cron_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $record); fclose($fp);
$cmd="/usr/bin/crontab ".$prgfile_hx;
//echo $cmd."\n";
exec($cmd); sleep(1);
unlink($prgfile_hx);
?>
