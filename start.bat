C:/xampp/xampp_start.exe

:IMPORT
mysql -u root < setup.sql
IF %ERRORLEVEL%==1 GOTO IMPORT
start http://localhost