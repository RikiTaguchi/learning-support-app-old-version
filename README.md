# 環境構築
### XAMPPをインストール
- https://www.apachefriends.org/jp/index.html
- PCの設定でアクセスを許可しないとソフトを開けないので注意

### 以下の手順を実行
#### エイリアスを削除し、本物のフォルダを任意の場所にコピー(今回はdesktopに配置する)
- Finder(Macの場合)から、/Applicationsを開く
- Applications内のXAMPPディレクトリ全体を、desktopにドラック&ドロップ
#### エイリアスを正しいシンボリックリンクに変更
エイリアスを削除
```
rm ~/Desktop/XAMPP
```
シンボリックリンクを作成
```
ln -s /Applications/XAMPP ~/Desktop/XAMPP
```
シンボリックリンクを使ってXAMPPディレクトリに移動
```
cd ~/Desktop/XAMPP
```
※これ以降は、`cd ~/Desktop/XAMPP`で移動できる

### GitHubリポジトリを、XAMPP/htdocsにclone
- XAMPP/htdocsに移動
- cloneする
- XAMPP/htdocs/learning-support-appという構成になっていれば成功

### Git LFSを設定(100MBを超えるファイルを扱うため)
インストール(Macの場合)
```
brew install git-lfs
```
リポジトリに移動し、LFSを有効化
```
git lfs install
```
LFSで管理するファイル(stanford-parser-4.2.0-models.jar)を指定
```
git lfs track "parser/stanford-parser/stanford-parser-4.2.0-models.jar"
```
- `.gitattributes`ファイルが自動生成されれば成功

pullと同時にLFSファイルを自動取得するように設定
```
git config lfs.fetchinclude "*"
git config lfs.fetchexclude ""
```

### サーバーとDBの起動
- XAMPPディレクトリ内のmanager-osx.app(Macの場合)を起動
- Manage Serversタブをクリック
- Start Allボタンをクリック
- Status欄３つが、Runningになっていれば成功

### Webアプリの動作確認
- サーバーとDBを起動した状態で、以下のリンクにアクセス
- http://localhost/learning-support-app/login.html
- ブラウザでログイン画面が開けば成功
- アカウントの作成やログインには、DBの初期設定(次の項目)が必要

# DBの初期設定
### セットアップ手順
- XAMPPからWebサーバーとDBを起動後、下記リンクにアクセス
- http://localhost/phpmyadmin
- wordsystemdbというDBを作成
- DB内にテーブルを作成する
- 作成後、アカウントの作成やログインなどができるようになるので確認する

### テーブル作成時の注意点
- 文字列(varchar)の長さは255
- int, dateの長さは未指定でOK

#### info_account: 生徒アカウントの情報
- user_name(varchar): ユーザー名
- login_id(varchar): ログインID
- user_pass(varchar): パスワード
- table_id(int): ユーザー識別番号
- memo(varchar): メモ帳内容
- countdown_title(varchar): カウントダウン(タイトル)
- countdown_date(date): カウントダウン(yyyy-MM-dd)

#### info_director: 管理者アカウントの情報
- director_id(varchar): 管理者ID
- director_name(varchar): 管理者名
- director_pass(varchar): パスワード
- table_id(int): 管理者識別番号

#### info_feedback: 復習リストの情報
- table_id(int): ユーザー識別番号
- book_id(varchar): テキストID
- question_number(int): 問題番号

#### info_my_book_index: My単語帳の情報(基本データ)
- table_id(int): ユーザー識別番号
- book_id(varchar): テキストID
- book_name(varchar): テキスト名
- memo(varchar): 目次内容

#### info_my_book_data: My単語帳の情報(単語データ)
- table_id(int): ユーザー識別番号
- book_id(varchar): テキストID
- word(varchar): 問題
- answer(varchar): 解答
- question_number(int): 問題番号

#### info_notice: お知らせの情報
- id(int): お知らせ番号
- title(varchar): タイトル
- date(date): 通知日(yyyy-MM-dd)
- detail(varchar): お知らせ詳細

#### info_image: 管理者が登録したスタンプの情報
- table_id(int): 管理者識別番号
- img_id(int): スタンプID(QRコードの識別用)
- stamp_id(varchar): スタンプID(スタンプ画像の識別用)
- stamp_prob(varchar): 獲得率(%)
- img_extention(varchar): スタンプ画像の拡張子
- img_title(varchar): スタンプのタイトル
- date_limit(date): 有効期限
- stamp_state(varchar): スタンプ取得の可否

#### info_stamp: ユーザーが獲得したスタンプの情報
- id(int): スタンプ番号
- user_table_id(int): 獲得した生徒の識別番号
- director_table_id(int): 作成した管理者の識別番号
- img_id(int): スタンプの識別番号
- stamp_id(varchar): スタンプ画像の識別番号
- get_date(date): スタンプ獲得日時(yyyy-MM-dd)

# 通知コード
### バナー通知の内容は、以下の通知コードで管理する
- 0: 未登録アカウント（ログイン画面）
- 1: パスワード不一致（ログイン画面）
- 2: データベース接続エラー → 再ログイン要請（ログイン画面）
- 3: 復習リストが空（ホーム画面）
- 4: アカウント情報更新完了（アカウント情報更新画面）
- 5: アカウント情報更新失敗（アカウント情報更新画面）
- 6: ログアウト（ログイン画面）
- 7: My単語帳作成エラー → 既存の単語帳がある（My単語帳編集画面）
- 8: スタンプ取得（スタンプカード画面）
- 9: API接続エラー（ホーム画面）
- 10: アカウント作成エラー → 既存アカウントがある（アカウント作成画面）
- 11: My単語帳作成エラー → 既存の単語帳がある（My単語帳作成画面）
- 12: データベース接続エラー → 入力内容の確認要請（ホーム画面）
- 13: 原因不明のエラー（ログイン画面）
- 14: アカウント登録完了（ログイン画面）
- 15: アカウント削除完了（ログイン画面）
- 16: フォーム入力エラー（参考書）（form.php）
- 17: フォーム入力エラー（数値）（form.php）
- 18: フォーム入力エラー（参考書）（form2.php）
- 19: フォーム入力エラー（数値）（form2.php）
- 20: フォーム入力エラー（参考書）（form3.php）
- 21: スタンプ有効期限切れ（スタンプカード画面）
- 22: 未登録アカウント（管理者ログイン画面）
- 23: パスワード不一致（管理者ログイン画面）
- 24: データベース接続エラー → 再ログイン要請（管理者ログイン画面）
- 25: 管理者ログイン完了（管理者ホーム画面）
- 26: アカウント作成エラー → 既存アカウントがある（管理者アカウント作成画面）
- 27: アカウント作成完了（管理者ログイン画面）
- 28: ログアウト（管理者ログイン画面）
- 29: スタンプ登録完了（スタンプ一覧画面）
- 30: 管理者アカウント情報更新完了（管理者アカウント情報更新画面）
- 31: 管理者アカウント情報更新失敗（管理者アカウント情報更新画面）
- 32: 管理者アカウント情報削除完了（管理者ログイン画面）
- 33: ユーザースタンプ削除完了（スタンプカード画面）
- 34: 管理者スタンプ更新完了（スタンプ一覧画面）
- 35: 管理者スタンプ削除完了（スタンプ一覧画面）
- 36: フォーム入力エラー（参考書）（form9.php）
- 37: フォーム入力エラー（数値）（form9.php）
- 38: フォーム入力エラー（単元）（form10.php）
- 39: フォーム入力エラー（難易度）（form10.php）
- 40: フォーム入力エラー（数値）（form10.php）
- 41: QR読み取りエラー（未ログイン）(ログイン画面)
