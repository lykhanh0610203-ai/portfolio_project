# Hướng dẫn Deploy với Nginx Reverse Proxy

## Kiến trúc:
```
Internet → Nginx (Host) → Docker Container (Nginx+PHP+MySQL)
         HTTPS:443      →    HTTP:8081 (localhost only)
```

## Setup trên Server Linux:

### 1. Upload project lên server:
```bash
scp -r portfolio_project/ user@server:/home/user/
ssh user@server
cd /home/user/portfolio_project
```

### 2. Setup Nginx reverse proxy trên host:
```bash
# Chạy với quyền root
sudo bash setup-host-nginx.sh
```

### 3. Deploy Docker containers:
```bash
# Deploy WordPress containers
./deploy-simple.sh
```

### 4. Kiểm tra:
```bash
# Kiểm tra containers
docker compose ps

# Kiểm tra Nginx host
sudo systemctl status nginx

# Kiểm tra SSL
sudo certbot certificates

# Test website
curl -I https://portfolio.ducdatphat.id.vn
```

## Cấu trúc hoạt động:

1. **Host Nginx** (port 80/443):
   - Nhận request từ `https://portfolio.ducdatphat.id.vn`
   - Handle SSL termination
   - Forward request đến container qua `127.0.0.1:8081`

2. **Container Nginx** (port 8081):
   - Chỉ listen localhost:8081
   - Nhận traffic từ host Nginx
   - Forward PHP requests đến PHP-FPM container

3. **PHP Container**:
   - WordPress với PHP 8.2-FPM
   - Kết nối MySQL container

4. **MySQL Container**:
   - Database backend
   - Không expose port ra ngoài

## Logs & Monitoring:

```bash
# Host Nginx logs
sudo tail -f /var/log/nginx/portfolio.ducdatphat.id.vn.access.log
sudo tail -f /var/log/nginx/portfolio.ducdatphat.id.vn.error.log

# Container logs
docker compose logs -f nginx
docker compose logs -f php

# SSL certificate status
sudo certbot certificates
```

## Troubleshooting:

### Website không load:
1. Kiểm tra DNS trỏ đúng IP server
2. Kiểm tra host Nginx: `sudo nginx -t`
3. Kiểm tra containers: `docker compose ps`
4. Kiểm tra port 8081: `curl -I http://localhost:8081`

### SSL issues:
1. Renew certificate: `sudo certbot renew`
2. Check certificate: `sudo certbot certificates`
3. Test SSL: `openssl s_client -connect portfolio.ducdatphat.id.vn:443`

## Backup & Maintenance:

```bash
# Backup database
docker exec portfolio_db mysqldump -u root -p"Duc091203@" portfolio > backup.sql

# Update containers
docker compose pull
docker compose up -d

# SSL auto-renewal (already configured)
sudo certbot renew --dry-run
```
