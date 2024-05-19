<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/base.css">
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
  <div class="container-md">
      <!-- As a link -->
    <div class="row">
      <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.php">Knowledge Hub</a>
        </div>
      </nav>
    </div>
    <!-- contents detail-->
    <div class="row">
         <h2>タイトル：<?php echo $data["Title"] ?></h2>
    </div>
    <div class="row">
      <h3>詳細：<?php echo $data["Detail"] ?></h3>
    </div>
    <div class="row">
      <h3>投稿者：<?php echo $data["User"] ?></h3>
    </div>

  </div>

</body>
</html>