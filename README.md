#Multi-Auth sample

## 導入
### Laravelインストール
`composer install`

### .env作成
.env.sampleをコピー
設定の修正

### テーブル生成
`php artisan migrate`

### Key作成
`php artisan key:generate`

## 機能
* 新規会員登録
* ログイン
* ログアウト
* 会員退会
* 会員情報編集
* パスワードリセット
