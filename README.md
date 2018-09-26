# nchc_supercomputer
# 請修改 0-autoSSH.php內的
# $ip="140.110.148.11"; // 台灣杉IP
# $user="c00cjz00"; //  台灣杉帳號
# $otpKey = ''; // 台灣杉otp key, 
# OTPKEY取得網址: https://iservice.nchc.org.tw/module_page.php?module=nchc_service#nchc_service/nchc_service.php?action=nchc_unix_account_edit
# 
# 執行 
# php 0-autoSSH.php 即可自動連線
# php 1-autoSSH_sendCmd.php 'date;date;date;' 即可自動連線,並執行命令date;date;date;
# php 2-autoSSH_scp.php /home/c00cjz00/tmp init.sh  即可自動連線,並建立遠端目錄/home/c00cjz00/tmp, 並上傳檔案init.sh
# php 3-autoSSH_sftp.php /home/c00cjz00/tmp lib/  即可自動連線,並建立遠端目錄/home/c00cjz00/tmp, 並上傳檔案目錄lib

