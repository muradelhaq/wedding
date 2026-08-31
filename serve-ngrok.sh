#!/bin/bash

# Script to run Laravel with Ngrok Tunneling
echo "🚀 Menyiapkan asset dan server Laravel untuk Ngrok..."

PORT=${1:-8000}

# 1. Hapus file hot Vite jika ada (agar asset selalu mengambil dari public/build)
if [ -f public/hot ]; then
    echo "🧹 Membersihkan file public/hot..."
    rm -f public/hot
fi

# 2. Pastikan build production asset up to date
echo "🔨 Membangun asset frontend (Vite build)..."
npm run build

# 3. Clear cache Laravel
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 4. Restart php artisan serve jika sudah berjalan lama
echo "🔄 Memastikan server Laravel aktif dengan konfigurasi proxy terbaru..."
pkill -f "artisan serve" 2>/dev/null || true
sleep 1

php artisan serve --port=$PORT > /dev/null 2>&1 &
SERVE_PID=$!
echo "✅ Laravel server berjalan di background (PID: $SERVE_PID) di port $PORT"

echo "🌐 Menghubungkan Ngrok ke port $PORT..."
echo "---------------------------------------------------------"
echo "💡 Tekan Ctrl+C untuk menghentikan Ngrok."
echo "---------------------------------------------------------"

ngrok http $PORT --host-header=rewrite
