# Game-Server
大地遊戲後端

## 安裝

+ 安裝 PHP 套件
```
composer install
```

+ 複製 .env.example 到 .env
```
cp .env.example .env
```

+ 修改資料庫相關參數
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mopcon_gameserver
DB_USERNAME=user
DB_PASSWORD=pwd
```

+ 產生 JWT secret key
```
php artisan jwt:secret
```

+ 產生資料表與假資料，如果不想產生假資料，請移掉 `--seed` 參數。
```
php artisan migrate --seed
```

+ 執行內建的開發用伺服器
```
php -S localhost:8000 -t public
```

