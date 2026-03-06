# Download MS SQL PHP Drivers 5.11 for PHP 8.2

Write-Host "Creating temporary folder on Desktop..." -ForegroundColor Cyan
$desktopPath = [Environment]::GetFolderPath("Desktop")
$extractFolder = Join-Path $desktopPath "SQL_Drivers_PHP82"

if (-Not (Test-Path $extractFolder)) {
    New-Item -ItemType Directory -Path $extractFolder | Out-Null
}

$downloadPath = Join-Path $desktopPath "SQLSRV511.exe"
$downloadUrl = "https://go.microsoft.com/fwlink/?linkid=2220464"

Write-Host "Downloading MS SQL Drivers 5.11 (This may take a minute)..." -ForegroundColor Yellow
Invoke-WebRequest -Uri $downloadUrl -OutFile $downloadPath

Write-Host "Extracting files to Desktop\SQL_Drivers_PHP82..." -ForegroundColor Yellow
Start-Process -FilePath $downloadPath -ArgumentList "/qn /x:`"$extractFolder`"" -Wait

Write-Host "Cleaning up the installer..." -ForegroundColor Yellow
Remove-Item $downloadPath -Force

Write-Host "Done! The extracted files are located in your Desktop\SQL_Drivers_PHP82 folder." -ForegroundColor Green
Write-Host "Please look for the '82' dll files and copy them to your PHP ext folder!" -ForegroundColor Green

Write-Host "`nPress any key to exit..."
$Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown") | Out-Null
