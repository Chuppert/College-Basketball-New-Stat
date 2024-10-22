<?php
// Database connection parameters
$host = 'localhost'; // Change this if your database is hosted elsewhere
$dbname = 'be_player_stats';
$username = 'root';
$password = '';

// Establish PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch Hassan Diarra data
$playerId = 'UCOG04';
$playerQuery = $pdo->prepare("SELECT * FROM players WHERE id = :id");
$playerQuery->bindParam(':id', $playerId);
$playerQuery->execute();
$player = $playerQuery->fetch(PDO::FETCH_ASSOC);

if (!$player) {
    die("Player not found.");
}

// Fetch Average Guard data
$averagePlayerId = 'AVGG01';
$averagePlayerQuery = $pdo->prepare("SELECT * FROM players WHERE id = :id");
$averagePlayerQuery->bindParam(':id', $averagePlayerId);
$averagePlayerQuery->execute();
$averagePlayer = $averagePlayerQuery->fetch(PDO::FETCH_ASSOC);

if (!$averagePlayer) {
    die("Average Guard not found.");
}

// Define the URL to PAAP.php
$paap_url = "PAAP.php?player_id=$playerId&average_id=$averagePlayerId&position=Guard";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hassan Diarra Stats Comparison</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #0039A6; 
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .button-banner {
            margin: 20px 0;
            text-align: center;
        }
        .header-buttons {
            margin-top: 10px;
        }
        .header-buttons a {
            text-decoration: none;
            color: #333;
            background: #ddd; /* Grey button */
            padding: 10px 20px;
            border-radius: 5px;
            margin: 0 10px;
            font-size: 1em;
        }
        .header-buttons a:hover {
            background: #bbb; /* Slightly darker grey on hover */
        }
        .container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .player-column {
            flex: 1;
            padding: 10px;
            text-align: center;
        }
        .player-image {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
            border: 2px solid #333;
            margin-bottom: 10px;
        }
        .player-name {
            font-size: 1.5em;
            color: #333;
            margin: 10px 0;
            font-weight: bold;
            border-bottom: 2px solid #DA291C;
            padding-bottom: 10px;
        }
        .player-info {
            font-size: 1.2em;
            color: #333;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border-bottom: 2px solid #DA291C;
            padding-bottom: 10px;
        }
        .player-info .stat-name {
            font-weight: bold;
        }
        .comparison-line {
            width: 100%;
            height: 2px;
            background-color: #0033A0;
            margin: 20px 0;
        }
        .results {
            margin-top: 20px;
            text-align: center;
        }
        .results h2 {
            font-size: 1.5em;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <h1>Hassan Diarra Stats Comparison</h1>
    </header>
    <div class="button-banner">
        <div class="header-buttons">
            <a href="UConn.php">UConn Players</a>
            <a href="Home.php">Home</a>
        </div>
    </div>
    <div class="container">
        <!-- Column 1: Hassan Diarra -->
        <div class="player-column">
            <img src="PlayerPictures/HassanDiarra.png" alt="<?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?>" class="player-image">
            <div class="player-name">
                <?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?>
            </div>
            <div class="player-info">
                <div class="stat-name">3P%:</div>
                <div><?php echo htmlspecialchars(number_format($player['three_point_percentage'], 1)); ?>%</div>
                <div class="stat-name">FG%:</div>
                <div><?php echo htmlspecialchars(number_format($player['field_goal_percentage'], 1)); ?>%</div>
                <div class="stat-name">FT%:</div>
                <div><?php echo htmlspecialchars(number_format($player['free_throw_percentage'], 1)); ?>%</div>
                <div class="stat-name">Rebounds:</div>
                <div><?php echo htmlspecialchars(number_format($player['rebounds_per_game'], 1)); ?></div>
                <div class="stat-name">Assists:</div>
                <div><?php echo htmlspecialchars(number_format($player['assists_per_game'], 1)); ?></div>
                <div class="stat-name">Blocks:</div>
                <div><?php echo htmlspecialchars(number_format($player['blocks_per_game'], 1)); ?></div>
                <div class="stat-name">Steals:</div>
                <div><?php echo htmlspecialchars(number_format($player['steals_per_game'], 1)); ?></div>
            </div>
        </div>

        <!-- Column 2: Average Guard -->
        <div class="player-column">
            <img src="PlayerPictures/BigEastAvg.jpg" alt="Average Guard" class="player-image">
            <div class="player-name">
                Average Guard
            </div>
            <div class="player-info">
                <div class="stat-name">3P%:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['three_point_percentage'], 1)); ?>%</div>
                <div class="stat-name">FG%:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['field_goal_percentage'], 1)); ?>%</div>
                <div class="stat-name">FT%:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['free_throw_percentage'], 1)); ?>%</div>
                <div class="stat-name">Rebounds:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['rebounds_per_game'], 1)); ?></div>
                <div class="stat-name">Assists:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['assists_per_game'], 1)); ?></div>
                <div class="stat-name">Blocks:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['blocks_per_game'], 1)); ?></div>
                <div class="stat-name">Steals:</div>
                <div><?php echo htmlspecialchars(number_format($averagePlayer['steals_per_game'], 1)); ?></div>
            </div>
        </div>
    </div>

    <div class="results">
        <h2>Hassan Diarra PAAP: <span id="paap-score">Loading...</span></h2>
    </div>

    <script>
        fetch("<?php echo $paap_url; ?>")
            .then(response => response.text())
            .then(data => {
                document.getElementById('paap-score').innerHTML = data.match(/PAAP Score: ([\d\.\-]+)/)[1];
            })
            .catch(error => {
                console.error('Error fetching PAAP score:', error);
                document.getElementById('paap-score').innerHTML = 'Error fetching PAAP score';
            });
    </script>
</body>
</html>