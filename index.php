<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/base.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/base.js"></script>
  <title>knowledge hub</title>
</head>
<body>
  <!--contents-->
  <?php
    $dbconn_info = 'mysql:host=172.17.0.2; dbname=KNOWLEDGE';
    $user = 'webappdev';
    $pw = 'ctlwa@1234';

      //変数初期化
   $query = '';  //SQL文字列
   $query_2 = '';  //SQL文字列（条件あり）
   $search_word = ''; // 検索テキスト
   $search_type ='';
   $condition_flg = 0;

   // リクエスト文字列取得
   if(!empty($_POST['submit'])){
    $condition_flg = 1;
    $search_word = '%'.$_POST['search_word'].'%'; // 検索テキスト
    $search_type = $_POST['search_type']; // 検索タイプ
      if($search_type == 0){
        $query_2 .= "  WHERE tl.Title  LIKE :search_word  ";
      }else{
        $query_2 .= "  WHERE tg.Tag_name  LIKE :search_word  ";
      }
   }
   //SQLクエリ生成（投稿データ）
   $query = "SELECT tl.Entry_id,tl.Title,tl.Content,tl.User,GROUP_CONCAT(tg.`Tag_name`) AS Tags";
   $query .= " FROM T_TIMELINE tl LEFT OUTER JOIN T_TAGMAP tm ON tl.Entry_id = tm.Entry_id LEFT OUTER JOIN T_TAG tg ON tm.Tag_id = tg.Tag_id GROUP BY tl.`Entry_id`";
   $query .= $query_2;
   $query .= " ORDER BY Update_date DESC";

    //db接続
    try{
      $dbh = new PDO($dbconn_info,$user,$pw);
      if($condition_flg == 1){
        $stmt = $dbh->prepare($query);
        $stmt -> bindValue(":search_word",$search_word,PDO::PARAM_STR);
        $stmt -> execute();
      }else{
        $stmt = $dbh->query($query);
      }
      $data = $stmt->fetchAll(PDO::FETCH_BOTH);

    }
    catch(PDOException $e){
        print("データベースの接続に失敗しました".$e->getTraceAsString());
        die();
    }
    //DB切断
    $dbh = null;

  ?>
  <div class="container-md noto-sans-jp-400  sticky-top">
      <!-- As a link -->
      <div class="row noto-sans-jp-600">
      <nav class="navbar  navbar-expand-lg">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Knowledge Hub</a>
        </div>
      </nav>
    </div>
    <!-- search window-->
    <div class="row collapse" id="collapseSearch">
      <div class="search-window" id="search_window">
      <form action="./index.php" method="post" role="search">
          <div class = "row">
            <div class="input-group mb-3">
            <input type="text" class="form-control" name="search_word" placeholder="検索ワード" aria-label="searchform" aria-describedby="searchform">
            <button class="btn-submit" type="submit" id="btn-search" name="submit" value="1">検索</button>
                <button class="btn" type="button" 
                  id="btn-close" onclick="closeSearch()">&times;</span></button> 
            </div>
          </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="search_type" id="searchRadioWord" value="0" checked>
            <label class="form-check-label" for="searchRadioWord">ワード検索</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="search_type" id="searchRadioTag" value="1">
            <label class="form-check-label" for="searchRadioTag">タグ検索</label>
            </div>
          
        </form>
      </div>  
    </div>
    </div>
    <div class="container-md noto-sans-jp-400 main-area">
    <hr>   
    <?php
      for($i = 0; $i < count($data) ; $i++){
        $data[$i]["Entry_id"];
        $tags_arr = [];
        if(isset($data[$i]["Tags"])){
          $tags_arr = explode(",",$data[$i]["Tags"]);
        }
    ?>
         
         <a href="./detail.php?id=<?= $data[$i]["Entry_id"]?>">
        <div class="contents-box" id = block_<?= $i ?> >
        
        <div class="row contents-header mb-2 justify-content-between">
            <div class="col-3">
              <p class="noto-sans-jp-600 contents-title"><?php echo $data[$i]["Title"]?> </p>
            </div>
            <div class="col-3 bookmark">
              <button><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/></svg>
              </button>
            </div>   
          </div>
          <div class="contents-body">
            <p class="card-text"><?php echo $data[$i]["Content"]?></p>
           
          </div>
          <div class="contents-footer">
          <p class="card-text">
              <?php
                if(!empty($tags_arr)){
                  foreach($tags_arr as $tag){
                    echo "#".$tag." ";
                  }
                }
              ?>
            </p>
          </div>
        </div>
        </a>

    <hr aligh="center">    
  
 <?php  }
    ?>
  </div>
  <div class="container-md menu-bar noto-sans-jp-400 fixed-bottom">
  <!-- footer menu -->
      <div class="row">
          <div class="col-sm-3 text-center">
          <button id="search-btn" class="w-100 h-100 btn" type="button"
          data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
          </button>
          </div>
        <div class="col-sm-3 text-center">
        <a href="./index.php" class="w-100 h-100">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
          </svg>
          </a>
        </div>
        <div class="col-sm-3 text-center">
        <a href="./newpost.php"  class="w-100 h-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
          </a>
        </div>
        <div class="col-sm-3 text-center">
        <button  id="scroll-to-top-btn" class="w-100 h-100">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"  fill="currentColor" class="bi bi-arrow-bar-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5zm-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z"/>
          </svg>
          </button>
        </div>
      </div> 
</div>
<?php

?>

</body>
</html>