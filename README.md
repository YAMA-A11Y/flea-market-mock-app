# flea-market-mock-app

## 環境構築

### Docker ビルド

```bash
docker-compose up -d --build
```

### Laravel 環境構築

1. PHP コンテナに入る。

```bash
docker-compose exec php bash
```

2. Laravel に必要なパッケージをインストールする。

```bash
composer install
```

3. 環境変数ファイルを作成する。

```bash
cp .env.example .env
```

※ `.env`ファイル内の環境変数（DB 接続情報など）は、環境に合わせて適宜変更してください。

4. アプリケーションキーを生成する。

```bash
php artisan key:generate
```

※ Laravel の暗号化機能を利用するために必要な設定です。

5. データベースのマイグレーション・シーディングを実行する。

```bash
php artisan migrate --seed
```

※ テーブル作成（migration）とダミーデータ作成（seeding）を同時に実行します。

## 使用技術(実行環境)

- Docker
- PHP 8.1.33
- Laravel 8.83.29
- MySQL 8.0.26
- nginx 1.21.1
- Laravel Fortify
- JavaScript（Plain JavaScript）

## ER 図

![ER図](src/docs/er-diagram.png)

## テスト

PHPUnitによる機能テストを実装済み。

```bash
docker-compose exec php vendor/bin/phpunit
```

## URL

- 商品一覧：http://localhost/
- 商品詳細：http://localhost/item/{item_id}
- 商品出品：http://localhost/sell
- マイページ：http://localhost/mypage
- プロフィール編集：http://localhost/mypage/profile
- プロフィール編集：http://localhost/mypage/profile
- 会員登録：http://localhost/register
- ログイン：http://localhost/login
- phpMyAdmin(DB確認用)：http://localhost:8080