@echo off
REM Portfolio WordPress Deployment Script for Windows
REM Domain: portfolio.ducdatphat.id.vn

echo === Portfolio WordPress Deployment ===
echo Domain: portfolio.ducdatphat.id.vn
echo =======================================

REM Check if Docker is installed
docker --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker not found. Please install Docker Desktop first.
    pause
    exit /b 1
)

REM Check if Docker Compose is available
docker compose version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker Compose not found. Please install Docker Compose first.
    pause
    exit /b 1
)

REM Create SSL directory
if not exist "ssl" mkdir ssl

REM Check SSL certificates
if not exist "ssl\portfolio.ducdatphat.id.vn.crt" (
    echo ⚠️  SSL certificates not found!
    echo Please add your SSL certificates:
    echo   - ssl\portfolio.ducdatphat.id.vn.crt
    echo   - ssl\portfolio.ducdatphat.id.vn.key
    echo.
    echo You can get free SSL from Let's Encrypt or your domain provider.
    echo For now, deploying without SSL (HTTP only)...
    
    REM Use HTTP only configuration
    copy "nginx\conf.d\default.conf" "nginx\conf.d\active.conf" >nul
) else (
    echo ✅ SSL certificates found
    REM Use HTTPS configuration
    copy "nginx\conf.d\production.conf" "nginx\conf.d\active.conf" >nul
)

REM Backup database if exists
if exist "portfolio.sql" (
    echo 📦 Backing up existing database...
    copy "portfolio.sql" "portfolio.sql.backup.%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%" >nul
)

REM Deploy with Docker Compose
echo 🚀 Starting deployment...

REM Stop existing containers
echo 🛑 Stopping existing containers...
docker compose down 2>nul

REM Pull latest images
echo 📥 Pulling latest Docker images...
docker compose pull

REM Start services
echo 🎯 Starting services...
docker compose up -d

REM Wait for services to be ready
echo ⏳ Waiting for services to start...
timeout /t 30 /nobreak >nul

REM Check if services are running
echo 🔍 Checking service status...
docker compose ps | findstr "Up" >nul
if errorlevel 1 (
    echo ❌ Some services failed to start!
    echo Check logs with: docker compose logs
    pause
    exit /b 1
)

echo ✅ Services are running!
echo.
echo 🌐 Your WordPress site should be available at:
echo    http://portfolio.ducdatphat.id.vn
if exist "ssl\portfolio.ducdatphat.id.vn.crt" (
    echo    https://portfolio.ducdatphat.id.vn
)
echo.
echo 🔧 PhpMyAdmin available at:
echo    http://portfolio.ducdatphat.id.vn:8080
echo.
echo 📋 To view logs: docker compose logs -f
echo 📋 To stop: docker compose down
echo.
echo 🎉 Deployment completed successfully!
pause
