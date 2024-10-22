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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #013E7D;
            color: #333;
        }
        .header {
            background-color: #EC1B3A;
            padding: 20px 0;
            color: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header .info-button {
            background-color: #FFFFFF;
            color: black;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .header .info-button:hover {
            background-color: #013E7D;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .description h1 {
            font-size: 2.5em;
            color: #333;
        }
        .description p {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 40px;
        }
        .school-logos {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .school-logos a {
            display: inline-block;
            width: 180px; /* Fixed width for buttons */
            height: 180px; /* Fixed height for buttons */
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .school-logos a:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .school-logos img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures image fills the entire button */
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="info.php" class="info-button">Information</a>
    </div>
    <div class="container">
        <div class="description">
            <h1>Player Against Average Position</h1>
            <p>Compare the stats of Big East Basketball players against the league average at their position. All stats are sourced from ESPN's statistics page. Qualified players average at least 10 minutes per game. For calculation information visit the information page.</p>
        </div>
        <div class="school-logos">
            <a href="Providence.php"><img src="PlayerPictures/ProvidenceLogo.png" alt="Providence Logo"></a>
            <a href="Georgetown.php"><img src="PlayerPictures/GeorgetownLogo.png" alt="Georgetown Logo"></a>
            <a href="UConn.php"><img src="PlayerPictures/UConnLogo.png" alt="UConn Logo"></a>
            <a href="Villanova.php"><img src="PlayerPictures/VillanovaLogo.png" alt="Villanova Logo"></a>
            <a href="DePaul.php"><img src="PlayerPictures/DePaulLogo.png" alt="DePaul Logo"></a>
            <a href="Creighton.php"><img src="PlayerPictures/CreightonLogo.png" alt="Creighton Logo"></a>
            <a href="Butler.php"><img src="PlayerPictures/ButlerLogo.png" alt="Butler Logo"></a>
            <a href="Xavier.php"><img src="PlayerPictures/XavierLogo.png" alt="Xavier Logo"></a>
            <a href="StJohns.php"><img src="PlayerPictures/StJohnsLogo.png" alt="St. Johns Logo"></a>
            <a href="Marquette.php"><img src="PlayerPictures/MarquetteLogo.png" alt="Marquette Logo"></a>
            <a href="SetonHall.php"><img src="PlayerPictures/SetonHallLogo.png" alt="Seton Hall Logo"></a>
        </div>
    </div>
</body>
</html>
