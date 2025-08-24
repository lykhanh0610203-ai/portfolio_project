#!/bin/bash
# Script để chạy WP-CLI trong Docker Compose

# Thư mục hiện tại của docker-compose.yml
PROJECT_DIR="$(cd "$(dirname "$0")"; pwd)"

# Chạy wp-cli với docker-compose
docker compose -f "$PROJECT_DIR/docker-compose.yml" run --rm wpcli "$@"
