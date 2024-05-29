<?php
// エラーを出力する
ini_set( 'display_errors', 1 );
$name = $_POST["name"];
$email = $_POST["email"];
$c = ",";
// 連番の最大値を設定
$max_items = 50;
$str = $name.$c.$email;
// データをループで処理
for ($i = 0; $i < $max_items; $i++) {
    $key = 'qa' . $i+1;
   if (isset($_POST[$key])) {
        // 必要に応じてデータを処理する
         $qa[$i] = $_POST[$key];
         $str .= $c.$qa[$i];
  }
}

$file = fopen("./data/data.csv","w+");
fwrite($file, $str);
fclose($file);
header("Location: read.php");
exit;
?>