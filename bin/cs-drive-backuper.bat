::
:: CloudSigma Drive Backuper
::
:: Licensed under the MIT license.
:: For full copyright and license information, please see the LICENSE.
::
:: @copyright ORCA Services AG
:: @link https://github.com/orca-services/cloudsigma-drive-backuper
:: @license http://www.opensource.org/licenses/mit-license.php MIT License
:: @author ORCA Services AG <development@orca-services.ch>
::

@echo.
@echo off
echo %~dp0
php -q "%~dp0\cs-drive-backuper" %*
echo.
exit /B %ERRORLEVEL%