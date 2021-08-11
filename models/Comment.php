<?php
    // モデル(M)
    require_once 'models/Model.php';
    // コメントの設計図を作成
    class Comment extends Model{
        // プロパティ
        public $id; // 投稿番号
        public $user_id; // コメント者のユーザー番号
        public $post_id; // 投稿番号
        public $content; // コメント本文
        public $created_at; // 投稿日時
        // コンストラクタ
        public function __construct($user_id="", $post_id="", $content=""){
            $this->user_id = $user_id;
            $this->post_id = $post_id;
            $this->content = $content;
        }
        
        // 入力チェックをするメソッド
        public function validate(){
            // 空のエラー配列作成
            $errors = array();
            // 内容が入力されていなければ
            if($this->content === ''){
                $errors[] = '内容が入力されていません';
            }
            // ユーザーidが入力されていなければ
            if($this->user_id === '' || $this->user_id === null){
                $errors[] = 'ユーザーIDを入力してください';
            }
            // 投稿idが入力されていなければ
            if($this->post_id === '' || $this->post_id === null){
                $errors[] = '投稿IDを入力してください';
            }
            // post番号を指定しなかった際の処理: 追記
            
            // 完成したエラー配列はいあげる
            return $errors;
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
                    $stmt = $pdo -> prepare("INSERT INTO comments (user_id, post_id, content) VALUES (:user_id, :post_id, :content)");
                    // バインド処理
                    $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':post_id', $this->post_id, PDO::PARAM_INT);
                    $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                    // 実行
                    $stmt->execute();
                    
                }else{ // 更新の時
                    $stmt = $pdo -> prepare("UPDATE posts SET title=:title, content=:content, image=:image WHERE id=:id");
                    // バインド処理
                    $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
                    $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                    // 実行
                    $stmt->execute();
                    
                }
                
                self::close_connection($pdo, $stmp);
                if($this->id === null){
                    return "新規コメント投稿が成功しました。";
                }else{
                    return $this->id. 'の投稿情報を更新しました';
                }
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // 投稿番号を指定してDBから投稿インスタンスを取得するメソッド
        public static function find($id){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT posts.user_id, posts.id, posts.title, posts.content, posts.image, posts.created_at, users.name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
                // フェッチの結果を、Postクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Post');
                $post = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $post;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // 投稿を削除するメソッド
        public static function destroy($id){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("DELETE FROM posts WHERE id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
