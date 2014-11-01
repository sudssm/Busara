del httpd.conf
type httpd.conf-start >> httpd.conf
echo DocumentRoot "%CD%" >> httpd.conf
echo ^<Directory "%CD%"^> >> httpd.conf
type httpd.conf-end >> httpd.conf

copy httpd.conf C:\xampp\apache\conf\httpd.conf
C:/xampp/xampp_start.exe

:IMPORT
mysql -u root < setup.sql
IF %ERRORLEVEL%==1 GOTO IMPORT
start http://localhost