rm *~
rm */*~
rm */*/*~
rm  */*/*/*~
#git cloen ...
#cd r1
#echo 1 > README.md
git config --global user.name "c00cjz00"
git config --global user.email summerhill001@gmail.com
#git pull
git checkout master
git rm 0-autoSSH.php
git rm 1-autoSSH_sendCmd.php
git rm 2-autoSSH_scp.php
git rm 3-autoSSH_sftp.php

git add *
git commit -m "init"
# 上傳至遠端
git push origin master

