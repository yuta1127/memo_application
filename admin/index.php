<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>トップ</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


  <header>

  </header>
  <main>
    <section id='top' class="contents_butan">
      <div class="contents"><img class='main_icon' src="img/icon_business_man01.png" alt="">
        <h1>todoメモ </h1>
        <p>メモを記録するアプリ</p>
        <div class="contents1">
          <a href="login.php">
            <p>ログイン</p>
         </a>
        <div class="contents2">
          <a href="memo_list.php">
            <p>記事管理</p>
          </a>
        </div>
      </div>
    </section>
  </main>
</body>

</html>
<style>
  * {
    margin: 0;
    padding: 0;
  }
main{
  height: 800px;
}
  #top {

    background-image: url('img/topimg.png');
    background-color: rgba(255, 255, 255, 0.6);
    background-blend-mode: lighten;
  }

  .contents1,
  .contents2 {
    margin: 0 auto;
    width: 180px;
    margin: 10px;
    margin-top: 30px;
  }

  .contents {
    padding-top: 150px;
    width: 600px;
    margin: 0 auto;
  }

  h1 {
    font-size: 75px;
    margin-bottom: 20px;
    margin-top: 140px;

  }

  .contents p {
    font-size: 25px;

  }

  a {
    display: block;
    text-decoration: none;
    border-radius: 15px;
    height: 40px;
    width: 180px;
    background-color: #fff;
    color: #4696e5;
    font-size: 20px;

  }

  .main_icon {
    height: 80px;
    width: 80px;
    float: right;
    margin-top: 155px;
    margin-right: 20px;
  }

  .contents1 p,
  .contents2 p {
    margin: 0px;
    text-align: center;
    padding: 1px;
  }

  .contents2 {
    float: left;
  }

  .contents1 {
    float: left;
    margin-left: 100px;
  }

  section {
    width: 100%;
    margin: 0 auto;
    height: 800px;
  }
</style>