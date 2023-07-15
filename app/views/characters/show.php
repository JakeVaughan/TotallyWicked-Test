<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia - Character Details</title>
    <link rel="stylesheet" type="text/css" href="/public/css/styles.css">
    <style>
        /* Additional CSS styles for the layout */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .content-box {
            background-color: #fff;
            max-width: 800px;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #555;
        }

        .character-image {
            width: 200px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 10px;
            object-fit: cover;
        }

        .episode-list-container {
            margin-top: 20px;
            max-height: 200px;
            overflow-y: scroll;
        }

        .episode-list {
            list-style-type: none;
            padding: 0;
        }

        .episode-list li {
            margin-bottom: 5px;
        }

        .episode-list li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .episode-list li a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="content-box">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <h1>Character Details</h1>

        <h2><?= $character['name']; ?></h2>
        <img class="character-image" src="<?= $character['image']; ?>" alt="<?= $character['name']; ?>">

        <p><strong>Status:</strong> <?= $character['status']; ?></p>
        <p><strong>Species:</strong> <?= $character['species']; ?></p>
        <?php if ($character['type'] !== null): ?>
            <p><strong>Type:</strong> <?= $character['type']; ?></p>
        <?php endif; ?>
        <p><strong>Gender:</strong> <?= $character['gender']; ?></p>
        <p><strong>Origin:</strong> <?= $character['origin']['name']; ?></p>
        <p><strong>Location:</strong> <?= $character['location']['name']; ?></p>

        <h3>Episodes:</h3>
        <div class="episode-list-container">
            <ul class="episode-list" id="episode-list">
                <?php foreach ($episodes as $episode): ?>
                    <li><a href="/episodes/show/<?= $episode['id']; ?>"><?= $episode['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script src="/public/js/script.js"></script>
</body>
</html>
