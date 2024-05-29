<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Document</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
  <?php
  $filename = "./data/data.csv";
  $fp = fopen($filename, 'r');
  $txt = fgets($fp);
  $str = explode(",", $txt);
  $br = "<br>";
  // $str02 = array();
  // $json = json_encode($str);
  // var_dump($str);
  fclose($fp);
  ?>
  <?php
  $filename_json = "./data/question.json";
  $jsonContent = file_get_contents($filename_json);
  $str_json = json_decode($jsonContent, true);
  // var_dump($str_json);
  ?>
  <?php
  // var_dump($str);
  $np_num = 0;
  $cp_num = 0;
  $a_num = 0;
  $fc_num = 0;
  $ac_num = 0;
  for ($i = 2; $i < count($str); $i++) {
    $parts = explode('-', $str[$i]);
    $first_parts = trim($parts[0]);
    $second_parts = intval(trim($parts[1]));
    // var_dump($first_parts);
    // var_dump($second_parts);
    if ($first_parts === "np") {
      $np_num += $second_parts;
    }
    if ($first_parts === "cp") {
      $cp_num += $second_parts;
    }
    if ($first_parts === "a") {
      $a_num += $second_parts;
    }
    if ($first_parts === "fc") {
      $fc_num += $second_parts;
    }
    if ($first_parts === "ac") {
      $ac_num += $second_parts;
    }
  }
  // var_dump("np:". $np_num);
  // var_dump("cp:". $cp_num);
  // var_dump("a:" . $a_num);
  // var_dump("fc:". $fc_num);
  // var_dump("ac:". $ac_num);
  $array = [
    "np" => $np_num,
    "cp" => $cp_num,
    "a" => $a_num,
    "fc" => $fc_num,
    "ac" => $ac_num
  ];
  $maxValue = max($array);
  $minValue = min($array);
  $maxKey = array_search($maxValue, $array);
  $minKey = array_search($minValue, $array);
  // var_dump("maxValue:". $maxKey);
  // var_dump("minValue:". $minKey);
  for ($i = 0; $i < count($str_json['bunseki']); $i++) {
    // var_dump($str_json['bunseki'][$i]['type']);
    if ($str_json['bunseki'][$i]['type'] == $maxKey) {
      $type_content = $str_json['bunseki'][$i]['content'];
      $type_img = $str_json['bunseki'][$i]['img'];
    }
  }  
  ?>
  <main class="main">
    <div id="name"><?= $str[0] ?> さん</div>
    <div id="email"><?= $str[1] ?></div>
    <div>
      <h1 class="h1">あなたの診断は？</h1>
      <canvas id="myChart" class="mx-2"></canvas>
      <h2 class="h2">あなたのタイプは<?= strtoupper($maxKey) ?>優位型です</h2>
    </div>
    <div class="analysis_box">
      <p class="analysis_box_text"><?= $type_content ?></p>
      <p class="analysis_box_img"><img src="./img/<?= $type_img ?>" alt=""></p>
    </div>
  </main>
  <a href="./post.php" class="btn_back">元に戻る</a>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // function goBack() {
    //   window.history.back();
    // }
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'line',
      // data: data,
      data: {
        labels: ['CP', 'NP', 'A', 'FC', 'AC'],
        datasets: [{
          label: '# of Votes',
          data: [<?= $cp_num ?>, <?= $np_num ?>, <?= $a_num ?>, <?= $fc_num ?>, <?= $ac_num ?>],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>

</html>