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

### PBS 教學 ###
#!/bin/bash 
###### -> 寄信
# PBS –M user@example.com

###### -> b: job開始執行時發送E-mail, e: job 結束時發送E-mail
# PBS –m be  

###### -> 計畫名稱 ProjectID，XXXXX 為一組數字
#PBS -P TRI654321 

###### -> 計算名稱，可以不需要
#PBS -N pyrazine 

###### -> select 選擇計算結點數目、ncpus 設 定 CPU 使用數目，ngpus 設定 GPU 使用數目
###### -> 參考
###### PBS -l select=1:ncpus=1   -> sequential job (1 core) 
###### PBS -l select=2:ncpus=8:mpiprocs=8 -> MPI job (Select 2 nodes with 8 CPUs each for a total of 16 MPI processes)
###### PBS -l select=2:ncpus=8:mpiprocs=1:ompthreads=8 -> MPI/OpenMP Hybrid job  (Request two nodes, each with 1 MPI tasks and 8 threads per task)
###### PBS -l select=2:ncpus=4:ngpus=4:mpiprocs=4 -> MPI/CUDA Hybrid job (Request 2 nodes,each node with 4 MPI processes,4 gpus per node) 
#PBS -l select=1:ncpus=8:ngpus=4 

###### -> processing wall time is one minutes 
#PBS -l walltime=00:01:00

###### -> 指定要送入計算排程區域，這裡 cf160 是運算結點
#PBS -q cf160 

###### ->Merging standard output and error files
#PBS -j oe

###### -> 定義輸出檔名稱
#PBS -o pyrazine.out

###### -> 定義錯誤紀錄檔
#PBS -e pyrazine.err 

####### 執行指令
ls -al

###### 以上存檔為　example01.sh
###### 送出工作 qsub example01.sh


