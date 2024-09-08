<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/base.css">
      <link rel="stylesheet" href="css/newpost.css">
<!--font inport-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
<!--jquery -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/base.js"></script>
      <script src="js/newpost.js"></script>
      <title>knowledge hub</title>
    </head>
    <body>
       <!-- Logic -->
  <?php
  if(isset($_POST['title'])){  
    //オートロードの読み込み
//    require_once __DIR__ .'/vendor/autoload.php';
    
    //.env読み込み
//    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//    $dotenv->load(); 
    //接続情報をセット
//    $host= $_ENV['DB_HOST'];
//    $dbname= $_ENV['DB_NAME'];
 //   $dbconn_info = 'mysql:dbname='.$dbname.';host='.$host;
 //   $user= $_ENV['DB_USER'];
 //   $pw= $_ENV['DB_PASS'];
    $dbconn_info = 'mysql:dbname=devdb;host=devdb-1.cj02a84cgeld.ap-northeast-3.rds.amazonaws.com';
    $user = 'admin';
    $pw = 'ctl-db1234!';

    // リクエスト文字列取得
    $title = $_POST['title'];
    $digest =$_POST['digest'];
    $detail =$_POST['detail'];
    $contributor =$_POST['contributor'];

    // クエリ生成
    $query = 'INSERT INTO T_TIMELINE(
                                Entry_id, 
                                Title, 
                                Content, 
                                Detail, 
                                User, 
                                Create_date, 
                                Create_user, 
                                Update_date, 
                                Update_user )';  
    $values .= 'VALUES( ';
    $values .= "null,:title,:digest,:detail,:contributor,NOW(),:contributor,NOW(),:contributor);";
    $query .= $values;
    echo $query;

    //db接続
     try{
      $dbh = new PDO($dbconn_info,$user,$pw);
    }
    catch(PDOException $e){
        print("データベースの接続に失敗しました".$e->getTraceAsString());
        die();
    }
      $stmt = $dbh->prepare($query);
      $stmt -> bindValue(":title",$title,PDO::PARAM_STR);
      $stmt -> bindValue(":digest",$digest,PDO::PARAM_STR);
      $stmt -> bindValue(":detail",$detail,PDO::PARAM_STR);
      $stmt -> bindValue(":contributor",$contributor,PDO::PARAM_STR);
      //SQL実行
      if($stmt -> execute()){
        $ins_success=1;
        header("Location :". $_SERVER['PHP_SELF']);
      }else{
        $ins_success=0;
      }
     //DB切断
     $dbh = null;
 }
?>
  <!--contents-->
  <div class="container-md noto-sans-jp-400  sticky-top">
      <!-- As a link -->
    <div class="row noto-sans-jp-600">
      <nav class="navbar  navbar-expand-lg">
       <div class="container-fluid">
          <a class="navbar-brand" href="./index.php">Knowledge Hub</a>
       </div>
      </nav>
    </div>
  </div>
  <div class="container-md noto-sans-jp-400 mt-3">
    <?php 
      if($ins_success == '1'){
    ?>
      <div class="alert alert-success alert-dismissible" role="alert">登録に成功しました</div>
    <?php  }elseif($ins_success == '0'){ ?>
      <div class="alert alert-danger" role="alert">登録に失敗しました</div>  
    <?php }

    ?>
   <div class="row justify-content-start my-3">
        <div class="col-10">
          <button class="btn btn-secondary" onclick="location.href='./index.php'">戻る</button>
        </div>
        </div>
        
        <form action="./new.php" method="post" class="needs-validation">
        <div class="row justify-content-center">
          <div class="col-9">
            <div class="row mb-3">
              <label for="colFormLabel" class="col-sm-2 col-form-label">タイトル</label>
                <div class="col-10">
                   <input type="text" class="form-control" placeholder="title" aria-label="title" aria-describedby="basic-addon1" name="title" required>
                </div>
            </div>
            <div class="row mb-3">
              <label for="colFormLabel" class="col-sm-2 col-form-label">概略</label>
              <div class="col-10">
                <input type="text" class="form-control" placeholder="簡単な説明を入力" aria-label="title" aria-describedby="basic-addon2" name="digest" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="colFormLabel" class="col-sm-2 col-form-label">詳細</label>
              <div class="col-10">
                <textarea class="form-control" aria-label="With textarea" name="detail"></textarea>
              </div>
            </div>
          </div>
          
          <div class="col-9">
            <div class="row mb-3">
              <label for="colFormLabel" class="col-sm-2 col-form-label">タグ</label>
              <div class="col-4">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Add Tag" aria-label="Recipient's username" aria-describedby="button-addon2">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon2">+</button>
                </div> 
              </div>
            </div>
            <div class="row mb-3 tag-area">
            </div>
          </div>
          <div class="col-9">
            <div class="row mb-3">
              <label for="colFormLabel" class="col-sm-2 col-form-label">投稿者</label>
              <div class="col-3">
                <input type="text" class="form-control" placeholder="name" aria-label="name" aria-describedby="basic-addon1" name="contributor" required>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-2 offset-md-10">
            <button type="submit" class="btn-submit mb-3" id="btn_submit" name="btn_submit">投稿</button>
            </div>
        </div>
        <input type="hidden" id="sub_flg" name="sub_flg" value="">
    </form>
  </div>
      
    </body>
</html>