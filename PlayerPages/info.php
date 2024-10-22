<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Stats Analysis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2em;
            color: #333;
            text-align: center;
        }
        h2 {
            font-size: 1.2em;
            color: #555;
            text-align: center;
        }
        h3 {
            font-size: 1.0em;
            color: #555;
            text-align: left;
        }
        .weights {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .weights > div {
            flex: 1;
            margin: 0 10px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .weights .stat-list {
            display: flex;
            flex-direction: column;
        }
        .weights ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .weights li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1em;
        }
        .math {
            background-color: #e7f0ff;
            border-left: 5px solid #007bff;
            padding: 15px;
            margin-top: 20px;
        }
        .back-to-home {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #6c757d; /* Grey color */
            color: #fff;
            text-decoration: none;
            font-size: 1em;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Positioned at the top of the page content */
            position: relative;
            top: 0;
            left: 0;
        }
        .back-to-home:hover {
            background-color: #5a6268; /* Darker grey for hover effect */
        }
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <a href="Home.php" class="back-to-home">Home</a>

    <div class="container">
        <h1>PAAP - Player Against Average Position</h1>  
        <div class="weights">
            <div>
                <h2>Weights for Forwards</h2>
                <ul class="stat-list">
                    <li><span>FG%</span> <span>30%</span></li>
                    <li><span>3P%</span> <span>20%</span></li>
                    <li><span>FT%</span> <span>15%</span></li>
                    <li><span>RPG</span> <span>20%</span></li>
                    <li><span>APG</span> <span>10%</span></li>
                    <li><span>BPG</span> <span>10%</span></li>
                    <li><span>SPG</span> <span>5%</span></li>
                </ul>
            </div>
            <div>
                <h2>Weights for Guards</h2>
                <ul class="stat-list">
                    <li><span>FG%</span> <span>25%</span></li>
                    <li><span>3P%</span> <span>25%</span></li>
                    <li><span>FT%</span> <span>20%</span></li>
                    <li><span>RPG</span> <span>15%</span></li>
                    <li><span>APG</span> <span>20%</span></li>
                    <li><span>BPG</span> <span>5%</span></li>
                    <li><span>SPG</span> <span>10%</span></li>
                </ul>
            </div>
            <div>
                <h2>Weights for Centers</h2>
                <ul class="stat-list">
                    <li><span>FG%</span> <span>40%</span></li>
                    <li><span>3P%</span> <span>5%</span></li>
                    <li><span>FT%</span> <span>10%</span></li>
                    <li><span>RPG</span> <span>25%</span></li>
                    <li><span>APG</span> <span>5%</span></li>
                    <li><span>BPG</span> <span>20%</span></li>
                    <li><span>SPG</span> <span>5%</span></li>
                </ul>
            </div>
        </div>

        <h1>Calculation</h1>
        <div class="math">
            <h2>Find Each Score for Each Stat</h2>
            <h3>(FG% - Average FG%) / Average FG% = FG Score</h3>
            <h3>(3P% - Average 3P%) / Average 3P% = 3P Score</h3>
            <h3>(FT% - Average FT%) / Average FT% = FT Score</h3>
            <h3>(RPG - Average RPG) / Average RPG = RPG Score</h3>
            <h3>(APG - Average APG) / Average APG = APG Score</h3>
            <h3>(BPG - Average BPG) / Average BPG = BPG Score</h3>
            <h3>(SPG - Average SPG) / Average SPG = SPG Score</h3>
            <h2>_______________________________________________________________________</h2>
            <h2>Multiply Each Score With the Appropriate Weight</h2>
            <h2>Example: Find the Weighted Score of a Forward</h2>
            <h3>FG Score * 30% = FG Weighted</h3>
            <h3>3P Score * 20% = 3P Weighted</h3>
            <h3>FT Score * 15% = FT Weighted</h3>
            <h3>RPG Score * 20% = RPG Weighted</h3>
            <h3>APG Score * 10% = APG Weighted</h3>
            <h3>BPG Score * 10% = BPG Weighted</h3>
            <h3>SPG Score * 5% = SPG Weighted</h3>
            <h2>_______________________________________________________________________</h2>
            <h2>Add All Weighted Scores Together to Get Player Score</h2>
            <h2>_______________________________________________________________________</h2>
            <h2>Subtract Average Position Score from Player Score</h2>
        </div>

        <h2>Interpretation</h2>
        <p><strong>Positive Score:</strong> The player performs better than the average Forward, taking into account the specific weights for the stats.</p>
        <p><strong>Negative Score:</strong> The player performs below average based on the weighted importance of these stats.</p>
        <p>By adjusting the weights for each position, the performance of players can be more accurately assessed based on the role-specific importance of different statistics.</p>
    </div>
</body>
</html>


