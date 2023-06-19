<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index_style.css">
    <title>Energy</title>
</head>
<body>
    <h1> 에너지 절약 LED </h1>
    <div class="toggle-button">
        <label>
            <input role="switch" type="checkbox" />
            <span class="sticker">off / on</span>
        </label>
    </div>
    <nav class="page_button">
        <input type="button" id="button" class="list_page" value="LED 상태 List" onClick="location.href='list.php'"></input>&nbsp;&nbsp;
        <input type="button" id="button" class="data_page" value="차트 보러가기" onClick="location.href='chart.php'"></input>&nbsp;&nbsp;
        <input type="button" id="button" class="setting_page" value="LED 최대 밝기 설정" onClick="location.href='modepy.php'"></input>
    </nav>
</body>
</html>