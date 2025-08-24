# SSL Certificates Directory

Đặt SSL certificates cho domain `portfolio.ducdatphat.id.vn` vào thư mục này:

## Required files:
- `portfolio.ducdatphat.id.vn.crt` - SSL certificate
- `portfolio.ducdatphat.id.vn.key` - Private key

## Lấy SSL certificate:

### Option 1: Let's Encrypt (Free)
```bash
sudo certbot certonly --standalone -d portfolio.ducdatphat.id.vn
```

### Option 2: From Domain Provider
- Download SSL files từ control panel của nhà cung cấp domain
- Rename files theo đúng tên trên

### Option 3: Self-signed (Testing only)
```bash
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout portfolio.ducdatphat.id.vn.key \
  -out portfolio.ducdatphat.id.vn.crt \
  -subj "/C=VN/ST=HCM/L=HCM/O=Portfolio/CN=portfolio.ducdatphat.id.vn"
```

**Note:** Nếu không có SSL, website sẽ chạy HTTP only.
