<?php
    $num = $_POST['delete'];
    $conn = mysqli_connect('localhost', 'root', '','project');
    for($i=0; $i<30; $i++){
        $num = $num + $i;
        $query = "delete from home_data where num = ".$num.";";
        $result = mysqli_query($conn, $query);
    }

    include "list.php";
?>