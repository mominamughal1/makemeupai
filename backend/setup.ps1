# MakemeupAI backend first-time setup (Windows PowerShell)
$ErrorActionPreference = "Stop"
Set-Location $PSScriptRoot

Write-Host "Installing Composer dependencies..."
composer install

if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "Created .env from .env.example"
}

Write-Host "Generating application key..."
php artisan key:generate

if (-not (Test-Path "database\database.sqlite")) {
    New-Item -ItemType File -Path "database\database.sqlite" -Force | Out-Null
    Write-Host "Created database/database.sqlite"
}

Write-Host "Running migrations..."
php artisan migrate --force

Write-Host ""
Write-Host "Setup complete. Start the API with:"
Write-Host "  php artisan serve"
