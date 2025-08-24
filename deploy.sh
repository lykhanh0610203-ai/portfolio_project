#!/bin/bash

# Portfolio WordPress Deployment Script
# Tên miền: portfolio.ducdatphat.id.vn

set -e

echo "=== Portfolio WordPress Deployment ==="
echo "Domain: portfolio.ducdatphat.id.vn"
echo "======================================="

# Kiểm tra Docker và Docker Compose
if ! command -v docker &> /dev/null; then
    echo "❌ Docker not found. Please install Docker first."
    exit 1
fi

if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose not found. Please install Docker Compose first."
    exit 1
fi

# Tạo thư mục SSL nếu chưa có
mkdir -p ssl

# Kiểm tra SSL certificates
if [ ! -f "ssl/portfolio.ducdatphat.id.vn.crt" ] || [ ! -f "ssl/portfolio.ducdatphat.id.vn.key" ]; then
    echo "⚠️  SSL certificates not found!"
    echo "Please add your SSL certificates:"
    echo "  - ssl/portfolio.ducdatphat.id.vn.crt"
    echo "  - ssl/portfolio.ducdatphat.id.vn.key"
    echo ""
    echo "You can get free SSL from Let's Encrypt or your domain provider."
    echo "For now, deploying without SSL (HTTP only)..."
    
    # Sử dụng cấu hình HTTP only
    cp nginx/conf.d/default.conf nginx/conf.d/active.conf
else
    echo "✅ SSL certificates found"
    # Sử dụng cấu hình HTTPS
    cp nginx/conf.d/production.conf nginx/conf.d/active.conf
fi

# Backup database nếu có
if [ -f "portfolio.sql" ]; then
    echo "📦 Backing up existing database..."
    cp portfolio.sql "portfolio.sql.backup.$(date +%Y%m%d_%H%M%S)"
fi

# Deploy với Docker Compose
echo "🚀 Starting deployment..."

# Stop existing containers
echo "🛑 Stopping existing containers..."
docker-compose down 2>/dev/null || true

# Pull latest images
echo "📥 Pulling latest Docker images..."
docker-compose pull

# Start services
echo "🎯 Starting services..."
docker-compose up -d

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 30

# Check if services are running
echo "🔍 Checking service status..."
if docker-compose ps | grep -q "Up"; then
    echo "✅ Services are running!"
    echo ""
    echo "🌐 Your WordPress site should be available at:"
    echo "   http://portfolio.ducdatphat.id.vn"
    if [ -f "ssl/portfolio.ducdatphat.id.vn.crt" ]; then
        echo "   https://portfolio.ducdatphat.id.vn"
    fi
    echo ""
    echo "🔧 PhpMyAdmin available at:"
    echo "   http://portfolio.ducdatphat.id.vn:8080"
    echo ""
    echo "📋 To view logs: docker-compose logs -f"
    echo "📋 To stop: docker-compose down"
else
    echo "❌ Some services failed to start!"
    echo "Check logs with: docker-compose logs"
    exit 1
fi

echo "🎉 Deployment completed successfully!"
