#!/bin/bash

# Script setup Nginx reverse proxy trên host Linux
# Domain: portfolio.ducdatphat.id.vn

set -e

echo "=== Setup Nginx Reverse Proxy cho Portfolio ==="
echo "Domain: portfolio.ducdatphat.id.vn"
echo "=============================================="

# Kiểm tra quyền root
if [[ $EUID -ne 0 ]]; then
   echo "❌ Script này cần chạy với quyền root (sudo)"
   exit 1
fi

# Cài đặt Nginx nếu chưa có
if ! command -v nginx &> /dev/null; then
    echo "📦 Installing Nginx..."
    apt update
    apt install -y nginx
fi

# Cài đặt Certbot cho Let's Encrypt
if ! command -v certbot &> /dev/null; then
    echo "📦 Installing Certbot..."
    apt install -y certbot python3-certbot-nginx
fi

echo "✅ Nginx và Certbot đã được cài đặt"

# Tạo thư mục backup
mkdir -p /etc/nginx/sites-backup

# Backup cấu hình mặc định nếu có
if [ -f "/etc/nginx/sites-enabled/default" ]; then
    echo "📦 Backing up default Nginx config..."
    cp /etc/nginx/sites-enabled/default /etc/nginx/sites-backup/default.backup.$(date +%Y%m%d_%H%M%S)
    rm -f /etc/nginx/sites-enabled/default
fi

echo "🔧 Copying Nginx configuration..."

# Copy cấu hình portfolio
cp nginx-host-config/portfolio.ducdatphat.id.vn.conf /etc/nginx/sites-available/

# Enable site
ln -sf /etc/nginx/sites-available/portfolio.ducdatphat.id.vn.conf /etc/nginx/sites-enabled/

# Test cấu hình Nginx
echo "🧪 Testing Nginx configuration..."
nginx -t

if [ $? -eq 0 ]; then
    echo "✅ Nginx configuration is valid"
else
    echo "❌ Nginx configuration error!"
    exit 1
fi

# Lấy SSL certificate từ Let's Encrypt
echo "🔐 Getting SSL certificate from Let's Encrypt..."
certbot --nginx -d portfolio.ducdatphat.id.vn --non-interactive --agree-tos -m admin@ducdatphat.id.vn

# Reload Nginx
echo "🔄 Reloading Nginx..."
systemctl reload nginx

# Enable auto-start
systemctl enable nginx

echo "🎉 Setup completed successfully!"
echo ""
echo "📋 Thông tin:"
echo "   - Domain: https://portfolio.ducdatphat.id.vn"
echo "   - Nginx config: /etc/nginx/sites-available/portfolio.ducdatphat.id.vn.conf"
echo "   - SSL certificate: Let's Encrypt (auto-renewal enabled)"
echo "   - Container port: 127.0.0.1:8081"
echo ""
echo "📋 Tiếp theo:"
echo "   1. Chạy Docker containers: ./deploy-simple.sh"
echo "   2. Kiểm tra website: https://portfolio.ducdatphat.id.vn"
echo ""
echo "📋 Useful commands:"
echo "   - Check Nginx status: systemctl status nginx"
echo "   - Check SSL: certbot certificates"
echo "   - Renew SSL: certbot renew"
echo "   - Nginx logs: tail -f /var/log/nginx/portfolio.ducdatphat.id.vn.*.log"
