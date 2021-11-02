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

.speed-chart-title {
    text-align:center;
    color: #A48F20;
    font-size: 30px;
}

.speed-x-axis {
    font-size: 20px;
    color: #A48F20;
    transform: rotate(-90deg);
    position: absolute;
    top: 2070px; 
    left: 50px
}

.y-axis {
    font-size: 20px;
    color: #A48F20;
    margin-left: 50%
}

.combinations-chart-title {
    color: #A48F20;
    font-size: 50px;
    text-align:center;
}

.combinations-x-axis {
    font-size: 20px;
    color: #A48F20;
    transform: rotate(-90deg);
    position: absolute;
    top: 1170px; 
    left: 50px
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
    top: 370px; 
    left: 50px
}

.chart {
    margin-left: auto;
    margin-right: auto;
    width: 80%;
}

.data {
    margin-left: auto;
    margin-right: auto;
    color: #A48F20;
    font-size: 30px;
    margin-top:10vh;
    width: 90vw;
    text-align: center
}

.data, th, td {
  border: 1px solid #A48F20;
  border-collapse: collapse;
  padding: 15px;
}

.table-title {
    color: #A48F20;
    font-size: 40px;
    text-align:center;
    margin-top: 100px;
    margin-bottom: -50px
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
<
   <!-- Graph to display score progress -->
   <div>
    <h1 class="score-x-axis">Points</h1>
    <h1 class="score-chart-title"><u>Score</u></h1>
        <canvas id="scoreChart" class="chart"></canvas>
        <h1 class="y-axis">Session</h1>
    </div>

    <h1><br><br><br></h1>

    <!-- Graph to display amount of combinations thrown progress -->
    <div>
    <h1 class="combinations-x-axis">Combinations</h1>
    <h1 class="speed-chart-title"><u>Total Combinations</u></h1>
        <canvas id="totalCombinationsChart" class="chart"></canvas>
        <h1 class="y-axis">Session</h1>
    </div>

    <h1><br><br><br></h1>

    <!-- Graph to display speed progress -->
    <div>
        <h1 class="speed-x-axis">Combinations/min</h1>
        <h1 class="speed-chart-title"><u>Speed</u></h1>
        <canvas id="speedChart" class="chart"></canvas>
        <h1 class="y-axis">Session</h1>
    </div>

    <!-- Title for data table -->
    <h1 class="table-title"><u>Results</u></h1>

<script>

    // Variables to store retrieved database data into arrays so the data can be used on the graph
    var speedArray = [];
    var totalCombinationsArray = [];
    var scoreArray = [];
    var session = 0;
    var sessionArray = [];       

</script>

<?php

    // Connect to database
    $conn = new mysqli('localhost', 'shaunH', 'test12', 'boxing_app_db');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Retrieve all the data from database
    $mysqli = "SELECT * FROM shaun_kickboxing_table";

    // Display all results from db on table
    $result = $conn->query($mysqli);
    if ($result->num_rows > 0) {
        echo "<table id='dataTable' class='data'><tr><th>Speed</th><th>Combinations</th><th>Power Shots</th><th>Rounds</th><th>Score</th><th>Session Date</th></tr>";
    // output data of each row and push to arrays for graphs
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["speed"]."</td><td>".$row["totalCombinations"]."</td><td>".$row["powerShots"]."</td><td>".$row["noOfRounds"]."</td><td>".$row["score"]."</td><td>".$row["sessionDate"]."</td></tr>";
        echo "<script>speedArray.push(".$row['speed'].");</script>";
        echo "<script>totalCombinationsArray.push(".$row['totalCombinations'].");</script>";
        echo "<script>scoreArray.push(".$row['score'].");</script>";
        echo "<script>session++; sessionArray.push(session);</script>";
    }
        echo "</table>";
    } else {
        echo "0 results";
    }

?>

<script>

     // Array for x-axis
    const labels = sessionArray;

    // Data for speed y-axis    
    const speedData = {
        labels: labels,
        datasets: [{
            label: 'Speed',
            backgroundColor: '#A48F20',
            borderColor: '#A48F20',
            data: speedArray,
        }],
    };

    // Put data on speed graph
    var speedChart = new Chart(
        document.getElementById('speedChart'),
        {
            type: 'line',
            data: speedData,
        }
    );

    // Data for total combinations y-axis 
    const totalCombinationsData = {
        labels: labels,
        datasets: [{
            label: 'Total Combinations',
            backgroundColor: '#A48F20',
            borderColor: '#A48F20',
            data: totalCombinationsArray,
        }]
    };

    // Put data on total combinations graph
    var totalCombinationsChart = new Chart(
        document.getElementById('totalCombinationsChart'),
        {
            type: 'line',
            data: totalCombinationsData,
        }
    );

    // Data for score y-axis 
    const scoreData = {
        labels: labels,
        datasets: [{
            label: 'Points',
            backgroundColor: '#A48F20',
            borderColor: '#A48F20',
            data: scoreArray,
        }]
    };

    // Put data on score graph
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