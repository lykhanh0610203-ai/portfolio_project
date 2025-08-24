# Hướng dẫn Deploy WordPress Portfolio

## Tên miền: portfolio.ducdatphat.id.vn

### Các bước deploy:

## 1. Chuẩn bị Server/VPS

### Yêu cầu hệ thống:
- Ubuntu 20.04+ hoặc CentOS 7+
- RAM: tối thiểu 2GB
- CPU: 1 core
- Disk: 20GB
- Docker & Docker Compose đã cài đặt

### Cài đặt Docker (Ubuntu):
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Add user to docker group
sudo usermod -aG docker $USER

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Reboot to apply changes
sudo reboot
```

## 2. Cấu hình DNS

Trong DNS của domain `ducdatphat.id.vn`, thêm bản ghi:
```
Type: A
Name: portfolio
Value: [IP_ADDRESS_SERVER]
TTL: 300
```

## 3. Upload SSL Certificate

### Tùy chọn 1: Let's Encrypt (Miễn phí)
```bash
# Install certbot
sudo apt install certbot

# Get SSL certificate
sudo certbot certonly --standalone -d portfolio.ducdatphat.id.vn

# Copy certificates
sudo cp /etc/letsencrypt/live/portfolio.ducdatphat.id.vn/fullchain.pem ssl/portfolio.ducdatphat.id.vn.crt
sudo cp /etc/letsencrypt/live/portfolio.ducdatphat.id.vn/privkey.pem ssl/portfolio.ducdatphat.id.vn.key
```

### Tùy chọn 2: SSL từ nhà cung cấp domain
Đặt file SSL vào thư mục `ssl/`:
- `ssl/portfolio.ducdatphat.id.vn.crt`
- `ssl/portfolio.ducdatphat.id.vn.key`

## 4. Deploy WordPress

### Trên Server Linux:
```bash
# Upload project lên server
scp -r portfolio_project/ user@server_ip:/home/user/

# SSH vào server
ssh user@server_ip

# Chuyển vào thư mục project
cd /home/user/portfolio_project

# Chạy script deploy
chmod +x deploy.sh
./deploy.sh
```

### Trên Windows (local testing):
```cmd
# Mở Command Prompt/PowerShell trong thư mục project
cd e:\portfolio_project

# Chạy script deploy
deploy.bat
```

## 5. Cấu hình WordPress

Sau khi deploy thành công:

1. Truy cập: `https://portfolio.ducdatphat.id.vn`
2. Hoàn tất setup WordPress nếu cần
3. Update WordPress URLs trong Admin:
   - Settings > General
   - WordPress Address (URL): `https://portfolio.ducdatphat.id.vn`
   - Site Address (URL): `https://portfolio.ducdatphat.id.vn`

## 6. Backup & Monitoring

### Backup tự động:
```bash
# Tạo cron job backup database
crontab -e

# Thêm dòng này (backup mỗi ngày 2:00 AM)
0 2 * * * cd /home/user/portfolio_project && docker exec portfolio_db_prod mysqldump -u root -p"Duc091203@" portfolio > backup_$(date +\%Y\%m\%d).sql
```

### Monitoring:
```bash
# Xem trạng thái containers
docker compose ps

# Xem logs
docker compose logs -f

# Restart services
docker compose restart
```

## 7. Security Best Practices

1. **Firewall Configuration:**
```bash
sudo ufw allow 22    # SSH
sudo ufw allow 80    # HTTP
sudo ufw allow 443   # HTTPS
sudo ufw enable
```

2. **Regular Updates:**
```bash
# Update Docker images monthly
docker compose pull
docker compose up -d
```

3. **SSL Certificate Renewal:**
```bash
# Auto-renewal với Let's Encrypt
sudo crontab -e
# Add: 0 3 * * * certbot renew --quiet
```

## 8. Troubleshooting

### Nếu site không load:
1. Kiểm tra DNS: `nslookup portfolio.ducdatphat.id.vn`
2. Kiểm tra containers: `docker compose ps`
3. Xem logs: `docker compose logs nginx`

### Nếu SSL không hoạt động:
1. Kiểm tra file certificates trong `ssl/`
2. Restart nginx: `docker compose restart nginx`
3. Kiểm tra cấu hình nginx: `docker compose exec nginx nginx -t`

### Performance Issues:
1. Tăng memory cho PHP: chỉnh `php/php.ini`
2. Enable caching: cài plugin WP caching
3. Optimize images: sử dụng WebP format

## 9. Useful Commands

```bash
# Stop all services
docker compose down

# Start services
docker compose up -d

# Restart specific service
docker compose restart nginx

# View real-time logs
docker compose logs -f

# Backup database
docker exec portfolio_db_prod mysqldump -u root -p"Duc091203@" portfolio > backup.sql

# Restore database
docker exec -i portfolio_db_prod mysql -u root -p"Duc091203@" portfolio < backup.sql

# Access WordPress files
docker exec -it portfolio_php_prod bash

# Access database
docker exec -it portfolio_db_prod mysql -u root -p
```

---

**Contact:** Nếu có vấn đề, liên hệ admin để được hỗ trợ.
