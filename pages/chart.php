<?php
// 데이터베이스 연결 설정
$conn = mysqli_connect('localhost', 'root', '','project');

// 데이터베이스에서 데이터 가져오기
$query = "SELECT * FROM home_data order by num desc limit 20";
$result = mysqli_query($conn, $query);

// 데이터 배열 초기화
$data = array();

// 결과를 배열로 변환
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Line Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="chart_style.css">
</head>
<body>
    <h1>최근 LED 데이터 차트</h1>
    <br><br>
    <canvas id="lineChart" width="60" height="20"></canvas>
    <script>
        // 데이터 배열 가져오기
        var data = <?php echo json_encode($data); ?>;

        // console.log(data["days"]);
        // 시간을 담을 배열

        var timeArray = [];
        var ledData = [];
        var motionData = [];
        data.forEach(function(e) {
            console.log(e)
            timeArray.push(e.date)
            ledData.push(e.led)
            motionData.push(e.motion)
        })
        console.log(timeArray);

        // 그래프 그리기
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timeArray.reverse(),
                datasets: [
                {
                    label: 'LED',
                    data: ledData.reverse(),
                    fill: false,
                    borderColor: 'rgb(242, 102, 171)',
                },
                {
                    label: '모션',
                    data: motionData.reverse(),
                    fill: false,
                    borderColor: 'rgb(44, 211, 225)',
                }
            ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: '날짜'
                        }
                    },
                    y: {
                        display: true,
                        max : 20,
                        title: {
                            display: true,
                            text: '센서값'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>