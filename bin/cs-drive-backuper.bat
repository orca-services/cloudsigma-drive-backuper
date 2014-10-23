@echo.
@echo off
echo %~dp0
php -q "%~dp0\cs-drive-backuper" %*
REM -working "%CD% " %*
echo.
exit /B %ERRORLEVEL%