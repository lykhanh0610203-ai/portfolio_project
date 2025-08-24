#!/bin/bash

echo "=== Portfolio Debug - Network & DNS ==="
echo "======================================"

echo "1. Checking current server IP:"
curl -s ifconfig.me || echo "Cannot get public IP"

echo -e "\n2. DNS Resolution check:"
echo "Checking portfolio.ducdatphat.id.vn..."
nslookup portfolio.ducdatphat.id.vn || echo "❌ DNS resolution failed"

echo -e "\n3. Ping test:"
ping -c 3 portfolio.ducdatphat.id.vn || echo "❌ Ping failed"

echo -e "\n4. Docker containers status:"
docker compose ps

echo -e "\n5. Port binding check:"
docker port portfolio_nginx 2>/dev/null || echo "❌ Container not running"

echo -e "\n6. Local container test:"
echo "Testing http://localhost:8081..."
curl -I http://localhost:8081 2>/dev/null || echo "❌ Local container not responding"

echo -e "\n7. Network connectivity:"
netstat -tlnp | grep :8081 || echo "❌ Port 8081 not listening"

echo -e "\n8. Nginx host status (if exists):"
if command -v nginx &> /dev/null; then
    sudo systemctl status nginx --no-pager -l
    echo "Nginx config test:"
    sudo nginx -t
else
    echo "Nginx not installed on host"
fi

echo -e "\n9. Hosts file check:"
grep portfolio.ducdatphat.id.vn /etc/hosts || echo "No local hosts entry"

echo -e "\n=== Debug completed ==="
