<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxing Trainer</title>
    
    <style>

        body {
            background-color: #242424;
        }

        .stop-btn {
            background-color: #A48F20;
            color: #242424;
            border-radius: 10%;
            border: 1px solid #A48F20;
            width: 3%;
        }

        .stop-btn:hover {
            width: 4%;
            cursor: pointer
        }

        .main-container {
            padding: 1%;
        }

        .time-display {
            color: #A48F20;
            font-size: 36pt;
            text-decoration: underline;
            display: inline-block;
            margin-left: 5%;
        }

        .punch-count-label-display {
            color: #A48F20;
            font-size: 36pt;
            text-decoration: underline;
            float: right;
            margin-right: 5%;
        }

        .time {
            color: #A48F20;
            font-size: 96pt;
            display: inline-block;
            margin-left: 5%;
        }

        .feedback-display {
            color: #FFA500;
            font-size: 36pt;
            position: absolute;
            top: 50px;
            left: 40%;
        }

        .feedback-display-blank {
            color: #242424;
            font-size: 36pt;
            position: absolute;
            top: 50px;
            left: 40%;
        }

        .combinations-display {
            color: #FFA500;
            font-size: 72pt;
            text-align: center;
            margin-top: 2%;
            margin-bottom: 3%;
        }

        .round-display {
            color: #A48F20;
            font-size: 36pt;
            text-decoration: underline;
            float: center;
            margin-left: 45%;
            margin-top: 18vh;
        }

        .punch-count-display {
            color: #A48F20;
            font-size: 90pt;
            float: right;
            margin-right: 5%;
        }

        .round {
            color: #A48F20;
            font-size: 96pt;
            float: center;
            margin-left: 47%;
        }

    </style>

</head>

<body>

    <!-- Form to post the session data to database and display on SessionResultsScreen.php -->
    <!-- <form action="SessionResultsScreen.php" method="post">
        <label id="info"></label> 
        <input id=totalCombinationsInput type="hidden" name="totalCombinations" value=" " />
        <input id=speedInput type="hidden" name="speed" value=" " />
        <input id=powerShotInput type="hidden" name="powerShots" value=" " />
        <input id=noOfRoundsInput type="hidden" name="noOfRounds" value=" " />
        <input id=sessionDateInput type="hidden" name="sessionDate" value=" " />
        <input id=scoreInput type="hidden" name="score" value=" " />
        <button id="stopSession" type="submit" name="save" onclick="sendData()" class="stop-btn">Stop</button>
    </form> -->

    <!-- Layout of the session screen -->
</div>
    <div class="main-container">
        <div class="time-display">Time</div>
        <div class="punch-count-label-display" id="total-punches">Total Combinations</div>
        <div>
            <div class="time" , id="timer">&nbsp&nbsp&nbsp&nbsp</div>
            <div class="punch-count-display" id="number-of-punches"> </div>
        </div>
        <div class="combinations-display" id="combinations">0</div>
        
        <div class="round-display">Rounds</div>
        <div>
            <div class="punches" id="number-of-punches"> </div>
            <div class="round" id="round"> </div>
        </div>
        <div class="feedback-display" id="feedback"> </div>
    </div>

    <!-- Audio files -->
    <audio id="combo1Sound">
        <source src="combo1.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo2Sound">
        <source src="combo2.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo3Sound">
        <source src="combo3.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo4Sound">
        <source src="combo4.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo5Sound">
        <source src="combo5.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo6Sound">
        <source src="combo6.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo7Sound">
        <source src="combo7.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo8Sound">
        <source src="combo8.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo9Sound">
        <source src="combo9.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo10Sound">
        <source src="combo10.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo11Sound">
        <source src="combo11.mp3" type="audio/mpeg">
    </audio>
    <audio id="combo12Sound">
        <source src="combo12.mp3" type="audio/mpeg">
    </audio>
    <audio id="clapping">
        <source src="clapping.mp3" type="audio/mpeg">
    </audio>

    <script>

        // Display to allow user to get prepared for the round
        document.getElementById("combinations").innerHTML = "Get Ready: 30";
        var noOfRoundsSelected = <?php $noOfRounds = $_POST["noOfRounds"]; echo $noOfRounds ?>;

        // Variable to store date of session for database
        var date = new Date();
        var sessionDate = date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();

        // Set time to get ready and display the number of rounds for this session
        GetReady(30);
        document.getElementById("round").innerHTML = noOfRoundsSelected;

        // Countdown timer to allow player to get ready for the round
        function GetReady(getReadyCountdown) {
            setTimeout(function () {
                if (getReadyCountdown >= 0) {
                    document.getElementById("combinations").innerHTML = "Get Ready: " + getReadyCountdown;
                    getReadyCountdown--;
                    GetReady(getReadyCountdown);
                } else {
                    Timer(2, 59);
                    Combinations();
                }
            }, 1000);
        }

        //Round timer
        function Timer(minutes, seconds) {
            setTimeout(function () {
                document.getElementById("timer").innerHTML = minutes + ":" + seconds;
                seconds--;
                if (seconds >= 0) {
                    if (seconds == 10 && minutes == 0) {
                        document.getElementById('clapping').play();
                    }
                    Timer(minutes, seconds);
                } else {
                    minutes--;
                    seconds = 59;
                    if (minutes >= 0 && seconds >= 0) {
                        Timer(minutes, seconds);
                    } else {
                        noOfRoundsSelected -= 1;
                        if (noOfRoundsSelected == 0){
                            document.getElementById('stopSession').click();
                        }
                        document.getElementById("round").innerHTML = noOfRoundsSelected;
                        Break(0, 29)
                    }
                }
            }, 1000);
        }

        // Break timer
        function Break(minutes, seconds) {
            setTimeout(function () {
                document.getElementById("combinations").innerHTML = "Break";
                document.getElementById("timer").innerHTML = minutes + ":" + seconds;
                seconds--;
                if (seconds >= 0) {
                    if (seconds == 10 && minutes == 0) {
                        document.getElementById('clapping').play();
                    }
                    Break(minutes, seconds);
                } else {
                    minutes--;
                    seconds = 29;
                    if (minutes >= 0 && seconds >= 0) {
                        Break(minutes, seconds);
                    } else {
                        Timer(2, 59);
                        Combinations();
                    }
                }
            }, 1000);
        }

        // Variables to measure progress
        var leftPunch = 0;
        var leftKick = 0;
        var rightPunch = 0;
        var rightKick = 0;
        var totalCombinations = 0;
        var powerShot = 0;

        // Variables to match the punches with the combinations
        var punchArray = "";
        var comboArrayIndex = 0;

        // Combinations for logic
        var combo1 = "Left Punch + Right Punch";
        var combo2 = "Left Punch + Right Punch + Left Punch";
        var combo3 = "Left Punch + Right Punch + Left Punch + Right Punch";
        var combo4 = "Left Punch + Right Punch + Left Punch + Right Punch";
        var combo5 = "Left Punch + Right Punch + Left Punch + Right Punch";
        var combo6 = "Right Punch + Left Punch";
        var combo7 = "Right Punch + Left Punch + Left Punch";
        var combo8 = "Left Punch + Right Punch + Left Kick";
        var combo9 = "Left Punch + Right Punch + Left Punch + Right Kick";
        var combo10 = "Left Punch + Right Punch + Left Punch + Right Kick";
        var combo11 = "Left Punch + Left Punch + Right Kick";
        var combo12 = "Left Punch + Left Punch + Right Punch";

        // Combinations for display
        var comboDisplay1 = "1-2";
        var comboDisplay2 = "1-2-3";
        var comboDisplay3 = "1-2-3-4";
        var comboDisplay4 = "1-2 Left Hook Straight Right";
        var comboDisplay5 = "1-2 Left Hook Right Hook";
        var comboDisplay6 = "Straight Right Left Hook";
        var comboDisplay7 = "Straight Right Double Left Hook";
        var comboDisplay8 = "1-2 Left Kick";
        var comboDisplay9 = "1-2-3 Right Kick";
        var comboDisplay10 = "1-2 Left Hook Right Kick";
        var comboDisplay11 = "Double Jab Right Kick";
        var comboDisplay12 = "Double Jab Right Hook";

        // Combinations audio
        var comboSound1 = document.getElementById("combo1Sound");
        var comboSound2 = document.getElementById("combo2Sound");
        var comboSound3 = document.getElementById("combo3Sound");
        var comboSound4 = document.getElementById("combo4Sound");
        var comboSound5 = document.getElementById("combo5Sound");
        var comboSound6 = document.getElementById("combo6Sound");
        var comboSound7 = document.getElementById("combo7Sound");
        var comboSound8 = document.getElementById("combo8Sound");
        var comboSound9 = document.getElementById("combo9Sound");
        var comboSound10 = document.getElementById("combo10Sound");
        var comboSound11 = document.getElementById("combo11Sound");
        var comboSound12 = document.getElementById("combo12Sound");

        function Combinations(comboArray) {
            var comboArray = [
                combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12,
            combo1, combo2, combo3, combo4, combo5, combo6, combo7, combo8, combo9, combo10, combo11, combo12
        ];

            var comboDisplayArray = [
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12,
                comboDisplay1, comboDisplay2, comboDisplay3, comboDisplay4, comboDisplay5, comboDisplay6, 
                comboDisplay7, comboDisplay8, comboDisplay9, comboDisplay10, comboDisplay11, comboDisplay12
            ];

            var comboSoundArray = [
                comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12,
            comboSound1, comboSound2, comboSound3, comboSound4, comboSound5, comboSound6, 
            comboSound7, comboSound8, comboSound9, comboSound10, comboSound11, comboSound12
        ];

            // Logic to call and display and count the combinations
            var combo = comboArray[comboArrayIndex];
            var comboDisplay = comboDisplayArray[comboArrayIndex];
            var comboSound = comboSoundArray[comboArrayIndex];
            if (comboArrayIndex == 0 ) {
                comboSound.play();
            }
            document.getElementById('combinations').innerHTML = comboDisplay;
            if (punchArray.includes(combo)) {
                punchArray = "";
                totalCombinations++;
                comboArrayIndex = comboArrayIndex + 1;
                document.getElementById('number-of-punches').innerHTML = totalCombinations;
                combo = comboArray[comboArrayIndex];
                comboDisplay = comboDisplayArray[comboArrayIndex];
                comboSound = comboSoundArray[comboArrayIndex];
                comboSound.play();
                document.getElementById('combinations').innerHTML = comboDisplay;
            }

            // Variables to allow for a small delay in keypress so one hit is recorded as one hit and not many
            var lastClick = 0;
            var delay = 50;

            // Functions to read which hand/leg is making contact with the bag 
            document.addEventListener("keydown", CONTROL);
            function CONTROL(event) {
                if (event.keyCode == 49) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Left Punch"
                    punchArray = punchArray + " + " + punch;
                    Feedback()
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Combinations()
                }
                if (event.keyCode == 50) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Left Punch"
                    powerShot++;
                    punchArray = punchArray + " + " + punch;
                    Feedback()
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Combinations()
                }
                else if (event.keyCode == 51) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Left Kick"
                    punchArray = punchArray + " + " + punch;
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Feedback()
                    Combinations()
                }
                if (event.keyCode == 52) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Left Kick"
                    powerShot++;
                    punchArray = punchArray + " + " + punch;
                    Feedback()
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Combinations()
                }
                else if (event.keyCode == 53) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Right Punch"
                    punchArray = punchArray + " + " + punch;
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Feedback()
                    Combinations()
                }
                if (event.keyCode == 54) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Right Punch"
                    powerShot++;
                    punchArray = punchArray + " + " + punch;
                    Feedback()
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Combinations()
                }
                else if (event.keyCode == 55) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Right Kick"
                    punchArray = punchArray + " + " + punch;
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Feedback()
                    Combinations()
                }
                if (event.keyCode == 56) {
                    if (lastClick >= (Date.now() - delay))
                        return;
                    lastClick = Date.now();
                    var punch = "Right Kick"
                    powerShot++;
                    punchArray = punchArray + " + " + punch;
                    Feedback()
                    document.getElementById("feedback").innerHTML = punch;
                    document.getElementById("feedback").classList.remove("feedback-display-blank");
                    document.getElementById("feedback").classList.add("feedback-display");
                    Combinations()
                }
            }
        }

        // Function to display what type of hit was thrown to the user
        function Feedback() {
            document.addEventListener("keyup", function () {
                // Remove the appropriate class to each element
                document.getElementById("feedback").classList.remove("feedback-display");
                document.getElementById("feedback").classList.add("feedback-display-blank");
            });
        }

        // Function to send session data to SessionResultsScreen.php
    function sendData() {
        var noOfRounds = <?php $noOfRounds = $_POST["noOfRounds"]; echo $noOfRounds ?>;
        var speed = Math.round(totalCombinations / (noOfRounds*3));
        var score = noOfRounds + speed + totalCombinations + powerShot;
        document.getElementById("totalCombinationsInput").value = totalCombinations;
        document.getElementById("speedInput").value = speed;
        document.getElementById("powerShotInput").value = powerShot;
        document.getElementById("noOfRoundsInput").value = noOfRounds;
        document.getElementById("sessionDateInput").value = sessionDate;
        document.getElementById("scoreInput").value = score;
    }


    </script>

</body>
</html>