<?php
    // モデル(M)

    // 投稿の設計図を作成
    class Post{
        // プロパティ
        public $id; // 投稿番号
        public $user_id; // 投稿者のユーザー番号
        public $title; // タイトル
        public $content; // 本文
        public $image; // 画像ファイル名
        public $created_at; // 投稿日時
        // コンストラクタ
        public function __construct($user_id="", $title="", $content="", $image=""){
            $this->user_id = $user_id;
            $this->title = $title;
            $this->content = $content;
            $this->image = $image;
        }
        
        // 入力チェックをするメソッド
        public function validate(){
            // 空のエラー配列作成
            $errors = array();
            // タイトルが入力されていなければ
            if($this->title === ''){
                $errors[] = 'タイトルが入力されていません';
            }
            // 本文が入力されていなければ
            if($this->content === ''){
                $errors[] = '本文を入力してください';
            }
            // 画像が選択されていなければ
            if($this->image === ''){
                $errors[] = '画像を選択してください';
            }
            
            // 完成したエラー配列はいあげる
            return $errors;
        }
        
        private static function get_connection(){
            try {
                // オプション設定
                $options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
                  );
                $pdo = new PDO('mysql:host=localhost;dbname=bbs_app', 'root', '', $options);
                return $pdo;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // データベースとの切断を行うメソッド
        private static function close_connection($pdo, $stmp){
            try {
                $pdo = null;
                $stmp = null;
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // 全テーブル情報を取得するメソッド
        public static function all(){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo->query('SELECT posts.id, users.name, posts.title, posts.content, posts.image, posts.created_at FROM posts JOIN users ON posts.
user_id = users.id ORDER BY posts.id DESC');
                // フェッチの結果を、Postクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Post');
                $posts = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                // Postクラスのインスタンスの配列を返す
                return $posts;
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // データを1件登録するメソッド
        public function save(){
            try {
                $pdo = self::get_connection();
                
                // 新規登録の時
                if($this->id === null){
                    $stmt = $pdo -> prepare("INSERT INTO posts (user_id, title, content, image) VALUES (:user_id, :title, :content, :image)");
                    // バインド処理
                    $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
                    $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                    // 実行
                    $stmt->execute();
                    
                }else{ // 更新の時
                    $stmt = $pdo -> prepare("UPDATE users SET name=:name, age=:age WHERE id=:id");
                    // バインド処理
                    $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                    $stmt->bindParam(':age', $this->age, PDO::PARAM_INT);
                    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                    // 実行
                    $stmt->execute();
                    
                }
                
                self::close_connection($pdo, $stmp);
                if($this->id === null){
                    return "新規写真投稿が成功しました。";
                }else{
                    return $this->name . 'さんの情報を更新しました';
                }
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // ユーザー番号を指定してDBからユーザーインスタンスを取得するメソッド
        public static function find($id){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT * FROM users WHERE id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
                // フェッチの結果を、Userクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
                $user = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $user;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // ユーザーを削除するメソッド
        public function destroy(){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("DELETE FROM users WHERE id=:id");
                // バインド処理
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // メールアドレスとパスワードを与えられてユーザーを取得
        public static function login($email, $password){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT * FROM users WHERE email=:email AND password=:password");
                // バインド処理
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                // 実行
                $stmt->execute();
                // フェッチの結果を、Userクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
                $user = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $user;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
    }
