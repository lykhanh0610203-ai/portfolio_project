#!/bin/bash

echo "=== Portfolio Debug Script ==="
echo "=============================="

echo "1. Checking Docker containers status:"
docker compose ps

echo -e "\n2. Checking container logs:"
echo "--- Nginx logs ---"
docker compose logs --tail=20 nginx

echo -e "\n--- PHP logs ---"
docker compose logs --tail=20 php

echo -e "\n3. Testing internal network connectivity:"
echo "Testing ping from nginx to php..."
docker exec portfolio_nginx ping -c 3 php 2>/dev/null || echo "❌ Ping failed"

echo -e "\n4. Testing port connectivity:"
echo "Testing port 9000 on php container..."
docker exec portfolio_nginx nc -zv php 9000 2>/dev/null || echo "❌ Port 9000 not accessible"

echo -e "\n5. Testing HTTP response:"
echo "Testing localhost:8081..."
curl -I http://localhost:8081 2>/dev/null || echo "❌ HTTP request failed"

echo -e "\n6. Container resource usage:"
docker stats --no-stream

echo -e "\n=== Debug completed ===" 
