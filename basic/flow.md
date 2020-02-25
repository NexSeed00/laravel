# 開発の流れ

## 事前準備
基本的にはプロジェクトの開始時に1度だけ実行する作業です。  
1. DBへテーブルの作成
2. 1で作成したテーブルへのテストデータの挿入

### テーブルの作成
DBへのテーブルの作成は、以下の通りです。  
1. マイグレーションファイルの作成
2. マイグレーションファイルの編集
3. マイグレーションの実行  

マイグレーションとは、簡単にいうと、テーブルの作成やカラムの追加など、  
DBへのテーブル追加や、変更を簡単に行える機能です。  

この機能を使用することで、  
自分でSQLを書くことなく、テーブルの作成が行えます。  
また、例えば新たに開発メンバーが加わった場合も、  
マイグレーションファイルを使用することで簡単に同じDBの環境を準備できます。  

設計を元に必要なテーブルを作成します。  

#### マイグレーションファイルの作成  
テーブルの設計図となるファイルの作成です。  
テーブルごとに1つ作成します。これが各テーブルの **設計図** だと思ってください。  
以下のコマンドを実行します。  
`php artisan make:migration create_tasks_table`  

`database`ディレクトリに`yyyy_mm_dd_hhmmii_create_tasks_table.php`というファイルが作成されます。  

今回は、tasksテーブルを作成するファイルのため、 `create_tasks_table` という名前にしています。   


#### マイグレーションファイルの編集  
作成したマイグレーションファイルの `up` メソッドを編集します。  
createメソッドの第2引数に `作成するカラム` の名前とデータ側の情報を追記します。  
```
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->increments('id'); 
        $table->string('title', 30); //追加
        $table->text('contents'); //追加
        $table->timestamps();
    });
}
```


#### マイグレーションの実行
最後に編集したマイグレーションの実行ですが、これもコマンド1つです。 
データベースにテーブルを作成します。   
`php artisan migrate`

#### 参考リンク
[マイグレーション](https://readouble.com/laravel/6.x/ja/migrations.html)  

### テストデータの作成
マイグレーションで作成したテーブルにテストデータを投入します。  
必須ではありませんが、テストデータが存在すると開発がスムーズになります。  
例えばタスクの一覧表示機能を作成する場合、  
テストデータがDBに登録されていると、表示の確認が簡単です。  
テストデータが存在しない場合、
データが存在しないから表示されないのか、 コードが間違っているから表示されないのか、  
確認が難しくなります。  

テストデータの作成手順は以下の通りです。  
1. テストデータ作成用ファイルを作成
2. テストデータ作成用ファイルを編集
3. テストデータ作成用ファイルの実行

#### テストデータ作成用ファイルの作成
#### テストデータ作成用ファイルの編集
#### テストデータ作成用ファイルの実行

#### 参考リンク
[シーディング](https://readouble.com/laravel/6.x/ja/seeding.html)

## 機能開発
- 新たな機能を作成する都度行う作業です。  
- 何から実施しても問題ないですが、以下の手順が最初はわかりやすいと思います。  
- 機能によっては必要ない作業もあります。
  - 例: タスクの一覧表示などユーザーの入力がない作業にはバリデーションは不要 etc

1. ルーティング
2. コントローラー
3. モデル
4. ビュー
5. バリデーション
6. エラーハンドリング

### ルーティング
- `routes/web.php` に記述
- **①どのURL(メソッドも含む)の時に**、**②どのコントローラーの**、**③どのメソッドを使用するか**  
を決めます。 
  
以下のコードは、①URL`/`に`GET`メソッドでアクセスされた場合、②`TasksController`の③`index`メソッドを使用する例です。   
※`/`はルートディレクトのことで、今回の場合は`localhost:8000`です。  

```php
Route::get('/', 'TasksController@index')->name('diary.index');
```

#### 参考リンク
[ルーティング](https://readouble.com/laravel/6.x/ja/routing.html)


### コントローラー
- モデルから必要なデータを受け取り、受け取ったデータをビューに渡します。    
- `app/Http/Controllers` にファイルを追加します。  
- ファイルは以下のコマンドで作成します。
  - `php artisan make:controller TasksController`
    - `TasksController` の箇所にファイル名を記述
      - ファイル名は対応するテーブルの単数形、パスケルケース + Controllerにします。  
- コントローラーは1つのテーブルに対して1つのコントローラーになることが多いです。  

#### 参考リンク
[コントローラー](https://readouble.com/laravel/6.x/ja/controllers.html)


### モデル
- DBとのやりとりを行います。  
  - DBからデータを取得する
  - DBへデータを保存する
  - etc
- `app/` にファイルを追加します。  
- ファイルは以下のコマンドで作成します。
  - `php artisan make:model Task`
    - `Task` の箇所にファイル名を記述
    - ファイル名は対応するテーブルの単数形、パスケルケースにします。 
- モデルは1つのテーブルに対して1つのモデルになることが多いです。  
  - 対応するテーブルは自動的に `Class名の複数形、スネークケース` になります
    - 例: 
      - モデル名 => テーブル名
      - Task => tasks
      - Comment => comments
      - BookHistory => order_histories
    - 対応するテーブルを変更したい場合は、`protected $table` にテーブル名を代入します。

#### 参考リンク
[クエリビルダ](https://readouble.com/laravel/6.x/ja/queries.html)


### ビュー
#### 参考リンク
[Bladeテンプレート](https://readouble.com/laravel/6.x/ja/blade.html)


### バリデーション
#### 参考リンク
[バリデーション](https://readouble.com/laravel/6.x/ja/validation.html)


### エラーハンドリング
#### 参考リンク
[エラー処理](https://readouble.com/laravel/6.x/ja/errors.html)
[認可](https://readouble.com/laravel/6.x/ja/authorization.html)