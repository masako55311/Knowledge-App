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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/base.js"></script>
  <title>knowledge hub</title>
</head>
<body>
  <!--contents-->

  <?php
    if(!isset($_SESSION["visited"])){
      print('初回の訪問です。セッションを開始します。');
      $_SESSION["visited"] = 1;
      $_SESSION["date"] = date('c');
    }else{
      $visited = $_SESSION["visited"];
      $visited = $visited + 1;

      print('訪問回数は'.$visited.'回です。<br>');
      if(isset($_SESSION["date"])){
        print('前回の訪問日時は'.$_SESSION["date"].'です。<br>');
      }
      $_SESSION["date"] = date('c');
      $_SESSION["visited"] = $visited;
    }
  ?>
  <div class="container-md">
      <!-- As a link -->
    <div class="row">
      <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Knowledge Hub</a>
        </div>
      </nav>
    </div>
    <!-- search window-->
    <div class="row">
      <div class="search_form my-2" id="search_form">
        <form  role="search">
          <div class = "row">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="検索ワード" aria-label="searchform" aria-describedby="searchform">
                <button class="btn btn-secondary" type="button" id="btn-search">検索</button>
                <button class="btn" type="button" id="btn-close" onclick="closeSearch()"><span aria-hidden="true">&times;</span></button> 
            </div>
          </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
              <label class="form-check-label" for="inlineRadio1">ワード検索</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
              <label class="form-check-label" for="inlineRadio2">タグ検索</label>
            </div>
          
        </form>
      </div>  
    </div>
    <?php
      for($i = 0; $i < 11 ; $i++){
    ?>
          <div id = block_<?= $i ?> class="row dammy my-2"></div>
    <?php  }
    ?>
    

  </div>
  <div class="container-md menu-bar fixed-bottom">
  <!-- footer menu -->
      <div class="row">
          <div class="col-sm-3 text-center">
            <button id="search-btn" class="w-100 h-100" onclick="openSearch()">Search</button>
          </div>
        <div class="col-sm-3 text-center">
          <a href="#" class="w-100 h-100">Home</a>
        </div>
        <div class="col-sm-3 text-center">
          <a href="./new.php"  class="w-100 h-100">New</a>
        </div>
        <div class="col-sm-3 text-center">
          <button  id="scroll-to-top-btn" class="w-100 h-100">Top</button>
        </div>
      </div> 
</div>

</body>
</html>