<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="list_style.css">
</head>
<body>
    <h1>LED 상태 List</h1>
<form method=post action=list.php>
   <?php
      $conn = mysqli_connect('localhost', 'root', '','project');

   ?>
   <div class=number>
    <br><br><br>
    <input type=radio name=limit value=10>10개&nbsp;
	<input type=radio name=limit value=20>20개&nbsp;
	<input type=radio name=limit value=30>30개<BR>
   <input type=submit value=확인 class=okay>
   <div>
</form>
<br>
<form method="post" action="delete.php">
    <?php
        $conn = mysqli_connect('localhost', 'root', '','project');
        $query = "select num from home_data order by num limit 1;";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            echo "<input type='hidden' name='delete' value=".$row['num'].">";
        }
    ?>
    <input type=submit value=삭제 class=delete_btn>
</form>
<div class="datatable">
<?php
    $query = "";
    if(empty($_POST['limit'])){
        $query = "select * from home_data order by num desc limit 10;";
    }
    else{
        $query = "select * from home_data limit ".$_POST['limit'].";";
    }
    //query 결과 값 받아오기
  $result = mysqli_query($conn, $query);              
  
  //table형식으로 DB값들을 보여줌
  echo "<br><br>";
  echo "<table border=1 width=500 class=table>";                 
  echo "<tr>";
  echo "<th>LED 밝기</th><th>조도센서값</th><th>모션</th><th>날짜 / 시간</th>";
  echo "</tr>";
  while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['led']."</td>";
    echo "<td>".$row['light']."</td>";
    echo "<td>".$row['motion']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "</tr>";
   }

  echo "</table>";
?>
</div>
</body>
</html>