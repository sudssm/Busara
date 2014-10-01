For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-3 delims=/:/ " %%a in ('time /t') do (set mytime=%%a-%%b-%%c)
set mytime=%mytime:~0,-1%
set "ex=.sql"
set filename=busara_db_export_%mydate%-%mytime%%ex%
mysqldump -uroot busara > %filename%
pause