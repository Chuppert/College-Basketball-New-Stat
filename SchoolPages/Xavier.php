<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'be_player_stats';
$username = 'root';
$password = '';

// Establish PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch Xavier players
try {
    $query = $pdo->query("SELECT * FROM players WHERE id LIKE 'XAV%' ORDER BY last_name, first_name");
    $players = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xavier Basketball Players</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #0C2340;
            color: #fff;
            padding: 10px 0;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            text-align: center;
        }
		.header-left, .header-right {
            font-size: 24px;
            font-weight: bold;
            font-family: 'Impact', sans-serif;
		}
        .header-left {
            text-align: ;
            padding-left: 10px;
            font-size: 75px;
            font-weight: bold;
        }
        .header-center img {
            height: 110px;
        }
        .header-right {
            text-align: center;
            padding-right: 10px;
            font-size: 75px;
            font-weight: bold;
        }
        nav {
            text-align: center;
            background-color: #9EA2A2;
            padding: 15px;
        }
        nav a {
            text-decoration: none;
            color: #333;
            background: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            margin-left: 10px;
        }
        nav a:hover {
            background: #999;
        }
        .content {
            min-height: 100vh;
            background: #fff;
            position: relative;
        }
        .content::before {
            content: ''; 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('PlayerPictures/XavierCoach.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            opacity: .75;
        }
        .player-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            justify-items: center;
            padding-top: 20px;
            position: relative;
            z-index: 2;
        }
        .player-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            width: 275px;
            height: 185px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            text-decoration: none;
            color: black;
        }
        .player-button img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 15px;
            border: 2px solid #333;
        }
        .player-button span {
            margin-top: 8px;
            font-size: 1em;
            font-family: 'Comic Sans MS', cursive;
        }
        .player-button:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">XAVIER</div>
        <div class="header-center">
            <img src="PlayerPictures/XavierLogo.png" alt="Xavier Logo">
        </div>
        <div class="header-right">MUSKETEERS</div>
    </header>
    <nav>
        <a href="Home.php">Home</a>
    </nav>
    <div class="content">
        <div class="player-buttons">
            <?php if (!empty($players)): ?>
                <?php foreach ($players as $player): ?>
                    <?php
                    // Map player IDs to their respective pages and images for Xavier Players
                    $playerPages = [
                        'XAVC01' => ['KachiNzehPage.php', 'PlayerPictures/KachiNzeh.png'],
                        'XAVF01' => ['AbouOusmanePage.php', 'PlayerPictures/AbouOusmane.png'],
                        'XAVF02' => ['GytisNemeiksaPage.php', 'PlayerPictures/GytisNemeiksa.png'],
                        'XAVF03' => ['LazarDjokovicPage.php', 'PlayerPictures/LazarDjokovic.png'],
                        'XAVF04' => ['SasaCianiPage.php', 'PlayerPictures/SasaCiani.png'],
                        'XAVG01' => ['DayvionMcKnightPage.php', 'PlayerPictures/DayvionMcKnight.png'],
                        'XAVG02' => ['DesmondClaudePage.php', 'PlayerPictures/DesmondClaude.png'],
                        'XAVG03' => ['QuincyOlivariPage.php', 'PlayerPictures/QuincyOlivari.png'],
                        'XAVG04' => ['DailynSwainPage.php', 'PlayerPictures/DailynSwain.png'],
                        'XAVG05' => ['TreyGreenPage.php', 'PlayerPictures/TreyGreen.png']
                    ];

                    // Default to 'default-page.php' if player ID not in the list
                    $playerPage = $playerPages[$player['id']][0] ?? 'default-page.php';
                    $imagePath = $playerPages[$player['id']][1] ?? 'PlayerPictures/default-image.png';
                    ?>
                    <a href="<?php echo $playerPage; ?>" class="player-button">
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($player['first_name']); ?>">
                        <span><?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No players found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
