<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/detail.css">
  <!--font inport-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
<!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/base.js"></script>
  <title>knowledge hub -DetailPage-</title>
</head>
<body>
  <!--contents-->
  <?php
    $dbconn_info = 'mysql:dbname=devdb;host=devdb-1.cj02a84cgeld.ap-northeast-3.rds.amazonaws.com';
    $user = 'admin';
    $pw = 'ctl-db1234!';
    $entryid = $_GET["id"];

    //db接続
   try{
      $dbh = new PDO($dbconn_info,$user,$pw);

      $query = "SELECT * FROM T_TIMELINE WHERE Entry_id = '".$entryid."'";
      $stmt = $dbh->query($query);
      $data = $stmt->fetch(PDO::FETCH_BOTH);
    }
    catch(PDOException $e){
        print("データベースの接続に失敗しました".$e->getTraceAsString());
        die();
    }
      //DB切断
      $dbh = null;

  ?>
  <div class="container-md noto-sans-jp-400">
      <!-- As a link -->
    <div class="row">
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.php">Knowledge Hub</a>
        </div>
      </nav>
    </div>
    <div class="row my-2">
      <div class="col-6 justify-content-start">
        <button class="btn btn-secondary" onclick="location.href='./index.php'">戻る</button>
      </div>
      <div class="col-6 d-grid gap-3 d-md-flex justify-content-end">
        <button type="button" class="btn-submit">編集</button>
        <button type="button" class="btn btn-light">削除</button>
      </div>
    </div>
    <!-- contents detail-->
    <div class="card" style="width: auto; height:600px;">
     <div class="card-body">
        <h5 class="card-title"><?php echo $data["Title"] ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $data["Content"] ?></h6>
        <p class="card-text"><?php echo $data["Detail"] ?></p>
      </div>
      <ul class="list-group list-group-flush text-end">
        <li class="list-group-item">#タグ #タグ</li>
        <li class="list-group-item">by.<?php echo $data["User"] ?></li>
      </ul>
    </div>
  </div>

</body>
</html>