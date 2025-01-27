# App Setup Guide

## 環境構築手順

### 1. Laravelプロジェクトの作成
まず、開発用ディレクトリに移動し、以下のコマンドを実行してプロジェクトを作成

```bash
composer create-project laravel/laravel invoice_compatible_app
```

### 2. .envファイルの編集
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_compatible
DB_USERNAME=root
DB_PASSWORD=root
```

### 3. マイグレーションの実行
```bash
php artisan migrate
```

### 4. Laravel Breezeのインストール
Laravel Breezeをインストールし、Vue.jsを設定
```bash
composer require laravel/breeze --dev 
php artisan breeze:install vue
```
### 5. フロントエンドの依存関係をインストール
以下のコマンドを実行して、必要な依存関係をインストール
```bash
npm install
npm i @fortawesome/fontawesome-free
```

### 6. FontAwesomeの設定
resources/js/app.js ファイルを開き、以下の内容を追加
```bash
npm install
npm i @fortawesome/fontawesome-free
```

### 7. ローカルサーバーの起動
```bash
php artisan serve
```

### 8. ビルドと開発サーバーの起動
フロントエンドのビルドを行い、開発サーバーを起動する
```bash
npm run build
npm run dev
```

## 便利コマンド
```bash
php artisan make:model モデル名 -rfms
```

-rは「resource」で、生成されたコントローラをリソースコントローラにする
-fは「factory」で。モデルの新しいファクトリを作成します。
-mは「migration」で、モデルの新しいマイグレーションファイルを作成
-sは「seed」で、モデルの新しいシーダを作成
