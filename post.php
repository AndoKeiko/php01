<!DOCTYPE html>
<html lang="js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<?php
$filename = './data/kadai.json';
$jsonContent = file_get_contents($filename);
$array = json_encode(json_decode($jsonContent));
// var_dump($array);
?>

<body class="">
  <main class="main">
    <h1 class="h1">性格診断</h1>
    <p class="mb2">50項目ありますが、あまり考えないで2～3分ぐらいで解いてください。</p>
    <form action="write.php" method="post" class="">
      <fieldset>
        <div class="input_text_box">
        <label class="input_text_lbl">名前：</label>
        <div class="w25">
          <input type="text" name="name" class="input_text">
          <p class="error"></p>
        </div>
        </div>
      </fieldset>
      <fieldset class="mb2">
      <div class="input_text_box">
        <label class="input_text_lbl">Email：</label>
        <div class="w25">
          <input type="text" name="email" class="input_text">
          <p class="error"></p>
        </div>
        </div>
      </fieldset>
      <button type="submit">送信</button>
    </form>
  </main>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(".input_text").on("blur keyup",  function() {
      text_check($(this));
    });
    $("button[type='submit']").on("click",function() {
      text_check($("input[name='name']"));
      text_check($("input[name='email']"));
    });
    function scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
    function text_check(e) {
      if(e.val() === "") {
        e.css("margin-bottom",".1rem");
        e.next(".error").addClass("active");
        e.next(".error").html("入力は必須です");
        event.preventDefault();
        scrollToTop();
      }
    }
    const data = JSON.parse('<?php echo $array ?>'); //JSON文字列→配列に変換
    let data02 = [];
    // console.log(data);
    const arr = $.map(data, function(value, key) {
      return {
        key: key,
        value: value
      };
    });
    let html;
    for (let i = 0; i < arr.length; i++) {
      // console.log(arr[i].value);
      for (let j = 0; j < arr[i].value.length; j++) {
        // console.log(arr[i].value[j].record);
        data02 = arr[i].value[j].record;
        // console.log(data02.id);
        html = "<fieldset><div class='question_box'>";
        html += "<p><span>Q" + data02.id + "</span>";
        html += data02.question + "</p><div class='chk_box'>";
        for (let k = 0; k < 3; k++) {
          html += `<input type='radio' id='qa${data02.id}-${k}' name='qa${data02.id}'`;
          if (k == 0) {
            html += ` value='${data02.point1}'>`;
            html += `<label for=qa${data02.id}-${k}>`;
            html += "あてはまらない";
          } else if (k == 1) {
            html += ` value='${data02.point2}' checked>`;
            html += `<label for=qa${data02.id}-${k}>`;
            html += "ふつう";
          } else if (k == 2) {
            html += ` value='${data02.point3}'>`;
            html += `<label for=qa${data02.id}-${k}>`;
            html += "よくあてはまる";
          }
          html += "</label>";
        }
        html += "</div></div></fieldset>";
        $("button[type='submit']").before(html);

      }
      // $("form").append('<button type="submit">送信</button>');
    }
  </script>
</body>

</html>