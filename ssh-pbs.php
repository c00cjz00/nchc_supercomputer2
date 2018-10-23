<?php
/***1
Example: 
php 4-pbs.php $email $projectID $core $walltime $queue $messageOutput $messageError $cmd

php 4-pbs.php \
'user@example.com' \
'TRI654321' \
'select=1:ncpus=8:ngpus=4' \
'00:01:00' \
'cf160' \
'pyrazine.out' \
'pyrazine.error' \
'ls -al'

$email="user@example.com";
$projectID="TRI654321";
$core="select=1:ncpus=8:ngpus=4";
$walltime="00:01:00";
$queue="cf160";
$messageOutput="pyrazine.out";
$messageError="pyrazine.error";
$cmd="ls -al";
*/
$email=$argv[1];
$projectID=$argv[2];
$core=$argv[3];
$walltime=$argv[4];
$queue=$argv[5];
$messageOutput=$argv[6];
$messageError=$argv[7];
$cmd=$argv[8];
if (!isset($argv[1]) ||  !isset($argv[2]) || !isset($argv[3]) || !isset($argv[4]) || !isset($argv[5]) || !isset($argv[6]) || !isset($argv[7]) || !isset($argv[8])){
 echo "error\n";
 exit();
}
$pbsScript="
#!/bin/bash 
# -> 寄信
#PBS –M $email
# -> b: job開始執行時發送E-mail, e: job 結束時發送E-mail
#PBS –m be  
# -> 計畫名稱 ProjectID
#PBS -P $projectID
# -> 計算名稱
#PBS -N pyrazine 
# -> select 選擇計算結點數目、ncpus 設 定 CPU 使用數目，ngpus 設定 GPU 使用數目
# -> 參考
# -> PBS -l select=1:ncpus=1   -> sequential job (1 core) 
# -> PBS -l select=2:ncpus=8:mpiprocs=8 -> MPI job (Select 2 nodes with 8 CPUs each for a total of 16 MPI processes)
# -> PBS -l select=2:ncpus=8:mpiprocs=1:ompthreads=8 -> MPI/OpenMP Hybrid job  (Request two nodes, each with 1 MPI tasks and 8 threads per task)
# -> PBS -l select=2:ncpus=4:ngpus=4:mpiprocs=4 -> MPI/CUDA Hybrid job (Request 2 nodes,each node with 4 MPI processes,4 gpus per node) 
#PBS -l $core 
# -> processing wall time is one minutes 
#PBS -l walltime=$walltime
# -> 指定要送入計算排程區域，這裡 cf160 是運算結點
#PBS -q $queue
# -> 參考指令
# -> qstat -Q 查詢可用狀況
# -> qstat  |grep u00cwh00 |grep job name
# -> fusermount -u /work1/c00cjz00/s3DISK/ ; cat ~/.passwd-s3fs
# -> ./s3fs c00cjz00  s3DISK/  -o  url=http://s3-cloud.nchc.org.tw -o uid=10183,gid=3254,umask=000
# -> Merging standard output and error files
#PBS -j oe
# -> 定義輸出檔名稱
#PBS -o $messageOutput
# -> 定義錯誤紀錄檔
#PBS -e $messageError 
# -> 執行指令
$cmd
";
$prgfile_hx = tempnam("/tmp", "pbs_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $pbsScript); fclose($fp);
echo $prgfile_hx;
