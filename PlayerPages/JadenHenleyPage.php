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

// Function to fetch player data
function fetch_player_data($pdo, $playerId) {
    $playerQuery = $pdo->prepare("SELECT * FROM players WHERE id = :id");
    $playerQuery->bindParam(':id', $playerId);
    $playerQuery->execute();
    return $playerQuery->fetch(PDO::FETCH_ASSOC);
}

// Function to calculate PAAP score
function calculate_paap($pdo, $playerId, &$position, &$averagePlayer) {
    $player = fetch_player_data($pdo, $playerId);

    if (!$player) {
        die("Error: Player not found.");
    }

    // Determine player position from playerId
    if ($playerId[3] == 'C') {
        $position = 'Center';
    } elseif ($playerId[3] == 'F') {
        $position = 'Forward';
    } elseif ($playerId[3] == 'G') {
        $position = 'Guard';
    } else {
        die("Error: Invalid position in player ID.");
    }

    // Fetch the corresponding average player data based on the position
    $averagePlayerId = 'AVG' . $playerId[3] . '01'; // For example, 'AVGF01' for Forward
    $averagePlayer = fetch_player_data($pdo, $averagePlayerId);

    if (!$averagePlayer) {
        die("Error: Average player for position $position not found.");
    }

    // Define weights for different positions
    $weights = [
        'Forward' => ['field_goal_percentage' => 0.30, 'three_point_percentage' => 0.20, 'free_throw_percentage' => 0.15, 'rebounds_per_game' => 0.20, 'assists_per_game' => 0.10, 'blocks_per_game' => 0.10, 'steals_per_game' => 0.05],
        'Center' => ['field_goal_percentage' => 0.40, 'three_point_percentage' => 0.05, 'free_throw_percentage' => 0.10, 'rebounds_per_game' => 0.25, 'assists_per_game' => 0.05, 'blocks_per_game' => 0.20, 'steals_per_game' => 0.05],
        'Guard' => ['field_goal_percentage' => 0.25, 'three_point_percentage' => 0.25, 'free_throw_percentage' => 0.20, 'rebounds_per_game' => 0.15, 'assists_per_game' => 0.20, 'blocks_per_game' => 0.05, 'steals_per_game' => 0.10],
    ];

    $weight = $weights[$position];

    // Calculate PAAP
    $paap = 0;
    foreach ($weight as $stat => $w) {
        $paap += ($player[$stat] - $averagePlayer[$stat]) * $w;
    }

    return number_format($paap, 3);
}

// Player data
$playerId = 'DEPG04';
$player = fetch_player_data($pdo, $playerId);
if (!$player) {
    die("Player not found.");
}

// Variables to store position and average player data
$position = '';
$averagePlayer = null;

// Calculate PAAP score
$paapScore = calculate_paap($pdo, $playerId, $position, $averagePlayer);

// Determine productivity message
if ($paapScore >= 0.01 && $paapScore <= 0.5) {
    $message = "$player[first_name] $player[last_name] is slightly more productive than the average $position in the Big East.";
} elseif ($paapScore > 0.5) {
    $message = "$player[first_name] $player[last_name] is more productive than the average $position in the Big East.";
} elseif ($paapScore < 0.0 && $paapScore >= -0.5) {
    $message = "$player[first_name] $player[last_name] is slightly less productive than the average $position in the Big East.";
} elseif ($paapScore < -0.5) {
    $message = "$player[first_name] $player[last_name] is less productive than the average $position in the Big East.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?> Stats Comparison</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #000000; 
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
            border-bottom: 2px solid #007ac3;
            padding-bottom: 10px;
        }
        .player-info {
            font-size: 1.2em;
            color: #333;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border-bottom: 2px solid #007ac3;
            padding-bottom: 10px;
        }
        .player-info .stat-name {
            font-weight: bold;
        }
        .comparison-line {
            width: 100%;
            height: 2px;
            background-color: #000000;
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
        <h1><?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?> Stats Comparison</h1>
    </header>
    <div class="button-banner">
        <div class="header-buttons">
            <a href="DePaul.php">DePaul Players</a>
            <a href="Home.php">Home</a>
        </div>
    </div>
    <div class="container">
        <!-- Column 1: Player -->
        <div class="player-column">
            <img src="PlayerPictures/<?php echo htmlspecialchars($player['first_name'] . $player['last_name']); ?>.png" alt="<?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?>" class="player-image">
            <div class="player-name">
                <?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?>
            </div>
            <div class="player-info">
                <!-- Player Stats -->
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

        <!-- Column 2: Average Player -->
        <div class="player-column">
            <img src="PlayerPictures/BigEastAvg.jpg" alt="Average <?php echo htmlspecialchars($position); ?>" class="player-image">
            <div class="player-name">
                Average <?php echo htmlspecialchars($position); ?>
            </div>
            <div class="player-info">
                <!-- Average Player Stats -->
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

    <div class="comparison-line"></div>

    <div class="results">
        <h2>PAAP Score for <?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?>: <?php echo htmlspecialchars(number_format($paapScore, 3)); ?></h2>
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
</body>
</html>