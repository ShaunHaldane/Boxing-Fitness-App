<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Boxing App Results</title>

</head>

<style>

body {
    background-color: #242424;
}

.results-title {
    color: #A48F20;
    font-size: 40px;
    text-align:center;
    margin-top: 20px;
}

.session-info {
    color: #A48F20;
    font-size: 20px;
    text-align:center;
    margin-top: 40px;
}

.score-chart-title {
    text-align:center;
    color: #A48F20;
    font-size: 30px;
}

.score-x-axis {
    font-size: 20px;
    color: #A48F20;
    transform: rotate(-90deg);
    position: absolute;
    top: 1270px; 
    left: 50px
}

.y-axis {
    font-size: 20px;
    color: #A48F20;
    margin-left: 50%
}

.chart {
    margin-left: auto;
    margin-right: auto;
    width: 80%;
}

.return-link {
    font-size: 30px;
    color: #A48F20;
    position: absolute;
    top: 0px; 
    left: 0px
}
    
</style>

<body>

    <!-- link to go back to index.html -->
    <a class="return-link" href="index.html">Click here to go back to main screen</a>

    <!-- Session information -->
    <h1 class="results-title"><u>Session Results</u></h1>
    <div class="session-info">
        <h1>Combinations landed: <h1 id="combinations"> </h1><h1>Power shots: </h1><h1 id="powerShots"> </h1></h1><h1>Your score for this session is: </h1><h1 id="score"></h1><h1>Points</h1>
        <h1><br>Scroll down to see your fitness improvements<br><br><br></h1>
    </div>

   <!-- Graph to display progress -->
   <div>
   <h1 class="score-x-axis">Points</h1>
    <h1 class="score-chart-title"><u>Results</u></h1>
        <canvas id="scoreChart" class="chart"></canvas>
        <h1 class="y-axis">Session</h1>
    </div>
    <h1><br><br><br></h1>

    <?php 
    
    // Convert JS variables to PHP
    $speed = $_POST["speed"]; 
    $totalCombinations = $_POST["totalCombinations"];
    $powerShots = $_POST["powerShots"];
    $noOfRounds = $_POST["noOfRounds"];
    $sessionDate = $_POST["sessionDate"];
    $score = $_POST["score"];

    // Php script to display session variiables
    echo "<script>document.getElementById('combinations').innerHTML =".$totalCombinations.";</script>";
    echo "<script>document.getElementById('powerShots').innerHTML =".$powerShots.";</script>";
    echo "<script>document.getElementById('score').innerHTML =".$score.";</script>";

    // Connect to database
    $conn = new mysqli('localhost', 'shaunH', 'test12', 'boxing_app_db');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Insert data into database
    $sql = "INSERT INTO shaun_kickboxing_table (speed, totalCombinations, powerShots, noOfRounds, sessionDate, score)
    VALUES ('$speed', '$totalCombinations', '$powerShots', '$noOfRounds', '$sessionDate', '$score')";

    // Confirm that the data was inserted in the console
    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('New record created successfully');</script>";
    } else {
         echo "Error: " . $sql . "<br>" . $conn->error;
    }

    ?>

<script>

    // Variables to store retrieved database data into arrays so the data can be used on the graph
    var scoreArray = [];
    var session = 0;
    var sessionArray = [];       

</script>

<?php

    // Retrieve all the data from database
    $mysqli = "SELECT * FROM shaun_kickboxing_table";

    // Push retrieved data to arrays for graph
    $result = $conn->query($mysqli);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<script>scoreArray.push(".$row['score'].");</script>";
            echo "<script>session++; sessionArray.push(session);</script>";
        }
    } else {
        echo "0 results";
    }

?>

<script>
         
    // Array for x-axis
    const labels = sessionArray;

    // Data for y-axis
    const scoreData = {
        labels: labels,
        datasets: [{
            label: 'Score',
            backgroundColor: '#A48F20',
            borderColor: '#A48F20',
            data: scoreArray,
        }],
    };

    // Put data on graph
    var scoreChart = new Chart(
        document.getElementById('scoreChart'),
        {
            type: 'line',
            data: scoreData,
        }
    );

</script>

</body>
</html>