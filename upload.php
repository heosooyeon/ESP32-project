<?php
   date_default_timezone_set('Asia/Seoul');
   $led = $_GET['led'];
   $light = $_GET['light'];
   $motion = $_GET['motion'];
   $date = date("Y-m-d H:i:s", time());

   //mysql에 접속한다.
    $conn = mysqli_connect('localhost', 'root', '','project');
   //sql쿼리를 작성한다
    $query = "insert into home_data(led,light, motion, date) values('".$led."', '".$light."', '".$motion."', '".$date."')";
    //sql쿼리를 실행한다
    $result = mysqli_query($conn, $query);
	if($result){
         echo "저장 성공"; //DB에 값이 들어갔다면 성공을 띄움
     }else{
         echo "저장 실패"; //DB에 값이 들어가지 않았다면 실패를 띄움
     }
?>