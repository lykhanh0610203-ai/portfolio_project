#!/bin/bash

# Simple Portfolio WordPress Deployment Script
# Tên miền: portfolio.ducdatphat.id.vn (HTTP only)

set -e

echo "=== Portfolio WordPress Deployment (HTTP) ==="
echo "Domain: portfolio.ducdatphat.id.vn"
echo "============================================="

# Kiểm tra Docker và Docker Compose
if ! command -v docker &> /dev/null; then
    echo "❌ Docker not found. Please install Docker first."
    exit 1
fi

if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose not found. Please install Docker Compose first."
    exit 1
fi

# Backup database nếu có
if [ -f "portfolio.sql" ]; then
    echo "📦 Backing up existing database..."
    cp portfolio.sql "portfolio.sql.backup.$(date +%Y%m%d_%H%M%S)" 2>/dev/null || true
fi

# Deploy với Docker Compose
echo "🚀 Starting deployment..."

# Stop existing containers
echo "🛑 Stopping existing containers..."
docker compose down 2>/dev/null || true

# Pull latest images
echo "📥 Pulling latest Docker images..."
docker compose pull

# Start services
echo "🎯 Starting services..."
docker compose up -d

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 30

# Check if services are running
echo "🔍 Checking service status..."
if docker compose ps | grep -q "Up"; then
    echo "✅ Services are running!"
    echo ""
    echo "🌐 Your WordPress site should be available at:"
    echo "   https://portfolio.ducdatphat.id.vn (through host Nginx reverse proxy)"
    echo "   http://localhost:8081 (direct access to container)"
    echo ""
    echo "🔧 PhpMyAdmin available at:"
    echo "   http://localhost:8082 (direct access)"
    echo ""
    echo "📋 Useful commands:"
    echo "   View logs: docker compose logs -f"
    echo "   Stop: docker compose down"
    echo "   Restart: docker compose restart"
else
    echo "❌ Some services failed to start!"
    echo "📋 Check logs with: docker compose logs"
    echo "📋 Check status with: docker compose ps"
    exit 1
fi

echo "🎉 Deployment completed successfully!"
echo "🌐 Access your site at: http://portfolio.ducdatphat.id.vn"
