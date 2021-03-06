# 一覧表示機能作成

## ルーティング
まずはルートの設定をします。  
ルートでは、**①どのURL(メソッドも含む)の時に**、**②どのコントローラーの**、**③どのメソッドを使用するか**  
を決めます。  

下の例は、  
①URL`/`に`GET`メソッドでアクセスされた場合、②`DiaryController`の③`index`メソッドを使用する   
ということになります。  

`/`はルートディレクトのことで、今回の場合は`localhost:8000`です。  

```php
// routes/web.php

Route::get('/', 'DiaryController@index')->name('diary.index'); //追加

//削除
Route::get('/', function () {
    return view('welcome');
});
```
※`->name('diary.index')`の部分は画面にリンクを作成する時に使用します。  
詳しくは後述します。  

※`//削除`とコメントがついてる箇所の下3行はサンプルページのため、削除します。  

`localhost:8000` にアクセスして以下のエラーが表示されればOKです。  
`Target class [App\Http\Controllers\DiaryController] does not exist.`  

このエラーは `DiaryControllerというclassは存在しない` という意味です。

### 参考リンク
[ルーティング](https://readouble.com/laravel/6.x/ja/routing.html)


## コントローラー
次にコントローラーを作成します。  
コントローラーの役割は以下の2つです。   
1. モデルに指示を出すこと
  - 指示 == データの作成、取得、更新、削除etc
2. ビューにデータを渡すこと

Laravelではコントローラーの作成もコマンド1つで行えます。    

`php artisan make:controller DiaryController`

`app/Http/Controllers`に`DiaryController.php`というファイルが作成されます。  

コマンド実行後にブラウザをリロードするとエラーの内容が以下の通りかわります。  
これは、`DiaryControllerにindexというメソッドは存在しない` というエラーです。  
`Method App\Http\Controllers\DiaryController::index does not exist.`
 
エラーを解消するために、 `DiaryController` にindexメソッドを追加しましょう。  

```php
// app/Http/Controllers/DiaryController

class DiaryController extends Controller
{
    // 追加
    public function index()
    {
        return 'Hello World';
    }
}
```

最後にブラウザから動作確認します。  
画面にHello Worldが表示されればOKです。  


URLを入力して画面が表示されるまでの流れは、    
1. web.phpで使用するコントローラーとメソッドの確認
2. 1で指定されたコントローラーのメソッドを実行
となります。

### 参考リンク
[コントローラー](https://readouble.com/laravel/5.7/ja/controllers.html)

## モデル
### モデルの作成
次にモデルを作成します。 
モデルの役割は(いくつかありますが、ここでは)DBとのやり取りを担当すると思ってください。   
Laravelではモデルの作成もコマンド1つで行えます。  

`php artisan make:model Diary`

`app`に`Diary.php`というファイルが作成されます。  

Laravelでは  
**「モデル」と、「モデル名を「複数形、スネークケース」にしたテーブル」が  
自動で対応するようになっています。**  
例: 
- Diary => diaries
- User => users
- PurchaseHistory => purchase_histories  

diariesテーブルを操作したいコードを書く場合は、  
Diaryモデルに書けば良いことになります。  

### データの取得  
先ほどはコントローラーの動作確認をするために`Hello world`を表示しましたが、  
一覧画面に表示するデータを取得するように変更します。  

追加するのは
1. `use App\Diary;`
2. `$diaries = Diary::all();`
3. `dd($diaries); `
の3つです。

### useについて
1で使用してる`use`ですが、  
これは他のクラスを使用するときに使います。  

今回の場合、`use App\Diary` とすることで、  
`DiaryController`で`Diary`と書いたときに、`app/Diary`クラスが使用できます。  

2は `Diaryクラスのallメソッド` を実行という意味です。  
`->` を使用しているわけではなく、 `::` を使用しているのは、  
`all` が `クラスメソッド` だからです。  

また、laravelでは同じ記法で `ファサード` が利用できます。  
この  `クラスメソッド` と  `ファサード` に関しては今は理解必要ないので、  
興味が出たときに調べてみましょう。  

```php
//app/Http/Controllers/DiaryController

use App\Diary; // App/Diaryクラスを使用する宣言
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index()
    {
        //diariesテーブルのデータを全件取得
        //useしてるDiaryのallメソッドを実施
        //all()はテーブルのデータを全て取得するメソッド
        $diaries = Diary::all(); 

        dd($diaries);  //var_dump()とdie()を合わせた関数。変数の確認 + 処理のストップ
    }
```

### 参考リンク
[モデル](https://readouble.com/laravel/6.x/ja/eloquent.html)

## ビュー
最後に画面の作成です。  
モデルで取得したデータを画面に表示します。  

ビューの作成はコマンドではなく自分で実施する必要があります。  
1. `resources/views`ディレクトリに`diaries`ディレクトリを作成
2. `diaries`に`index.blade.php`を作成
をしてください。  


いきなりデータの表示はせず以下の手順で順番に進めていきます。  
1. ビューが正しく表示されることの確認
2. モデルで取得したデータが表示されることの確認

### ビューが正しく表示されることの確認
```php
// resources/views/diaries/index.blade.php

Hello View
```
 
```php
// app/Http/Controllers/DiaryController

public function index()
{
    $diaries = Diary::all();

    // view/diaries/index.blade.phpを表示
    return view('diaries.index');
}
```  
`view()`は、`resources/views/`の中のファイルを返す関数です。  
引数の `diaries.index` は対象のファイルを表しています。  
今回の場合は、diariesディレクトリの中のindex.blade.phpを表しています。  


### モデルで取得したデータが表示されることの確認
画面が表示されることが確認できたら、
モデルから取得したデータをビューで表示します。

```php
//app/Http/Controllers/DiaryController

public function index()
{
    $diaries = Diary::all();

    return view('diaries.index', compact('diaries'));
}
```
`view()`メソッドの引数が2つに増えています。  
2つめの引数`compact('diaries')`では、変数`$diaries`を第1引数のページに渡しています。  
ここでは `compact` の詳しい説明は割愛しますが、  
compactの引数には、**渡したい変数から$マークを抜いた文字列を指定する** とだけ覚えてください。  


```php
// view/diaries/index.blade.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>一覧表示画面</title>
</head>
<body>
    @foreach ($diaries as $diary)
        <div class="m-4 p-4 border border-primary">
            <p>{{ $diary->title }}</p>
            <p>{{ $diary->body }}</p>
            <p>{{ $diary->created_at }}</p>
        </div>
        <hr>
    @endforeach
</body>
</html>
```

### 参考リンク
[Bladeテンプレート](https://readouble.com/laravel/6.x/ja/blade.html)

ここまでで、
URLを入力して画面が表示されるまでの流れは、    
1. web.phpで使用するコントローラーとメソッドの確認
2. 1で指定されたコントローラーのメソッドを実行
3. モデルのallメソッドを使用してデータを取得
4. 3で取得したデータをビューで表示する
となります。


## まとめ
これで一覧画面の表示処理は完了です。  

このカリキュラムでは一覧画面の表示を通して  
**ブラウザからURLを入力して、画面が表示されるまでの流れ**  
を学びました。  

URLを入力して画面が表示されるまでの流れは以下の通りです。  
1. web.phpで使用するコントローラーとメソッドを指定
2. コントローラーがモデルに対して命令をする(今回の場合はデータの取得)  
3. コントローラーが2で取得したデータをビューに渡す
4. ビューがユーザーに表示する画面(HTMLファイル)を作成
  
今後新しい機能を複数作成していきますが、基本的には今回の流れと近いものになります。

最初は複数のファイルを扱うためわかりにくく感じる部分もあるかもしれませんが、  
規模が大きくなってくると、ファイルの管理のしやすさなどメリットを感じる部分も出てきます。  

まずは深く考えるよりも、たくさん書いてなれていきましょう。