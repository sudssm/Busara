For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-3 delims=/:/ " %%a in ('time /t') do (set mytime=%%a-%%b-%%c)
set mytime=%mytime: =% 
set "ex=.sql"
echo %ex%
set filename=busara_db_export_%mydate%-%mytime%-%ex%
echo %filename%
--mysqldump -uroot > %filename%
pause