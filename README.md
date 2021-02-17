## 1. 下載代碼
> git clone https://github.com/game8130/lumen-shopping.git

## 2. 安裝擴展依賴包
> composer install
## 3. 生成配置文件
> cp .env.example .env

##### 你可以根據情況修改 .env 文件里的内容，如數據庫連接、緩存、郵件設置等：

```
APP_URL=http://lumen_shopping.test
...
DB_HOST=localhost
DB_DATABASE=lumen_shopping
DB_USERNAME=homestead
DB_PASSWORD=secret

DOMAIN=.bos-erp.test
```

## 4. 生成數據表

> php artisan migrate
## 5. 生成測試數據

> php artisan db:seed

## 6. 生成秘鑰
> php artisan key:generate
> php artisan jwt:secret


## run localhost

php -S 0.0.0.0:8090 -d public/index.php -t public

## 在公共區域下開圖片路徑

在public路徑下輸入:

ln -s ../storage/app/public storage
