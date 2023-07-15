<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia - Location Details</title>
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

        .resident-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
            max-height: 300px; /* Add max-height to limit height */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .resident-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        .resident-image {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .resident-name {
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content-box">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <h1>Location Details</h1>

        <h2><?= $location['name']; ?></h2>
        <p><strong>Type:</strong> <?= $location['type']; ?></p>
        <p><strong>Dimension:</strong> <?= $location['dimension']; ?></p>

        <h3>Residents:</h3>
        <div class="resident-grid" id="resident-grid">
            <!-- Residents will be dynamically loaded here -->
        </div>
    </div>

    <script src="/public/js/script.js"></script>
    <script>
        const residentGrid = document.getElementById('resident-grid');
        const residents = <?= json_encode($location['residents']); ?>;

        const extractCharacterId = (url) => {
            const urlParts = url.split('/');
            return urlParts[urlParts.length - 1];
        };

        const fetchCharacter = async (id) => {
            try {
                const response = await fetch(`https://rickandmortyapi.com/api/character/${id}`);
                const character = await response.json();
                return character;
            } catch (error) {
                console.error('Error:', error);
                return null;
            }
        };

        const createResidentElement = (character) => {
            const residentContainer = document.createElement('div');
            residentContainer.className = 'resident-container';

            const characterLink = document.createElement('a');
            characterLink.href = `/characters/show/${character.id}`;

            const residentImageElem = document.createElement('img');
            residentImageElem.className = 'resident-image';
            residentImageElem.src = character.image;
            residentImageElem.alt = character.name;

            const residentNameElem = document.createElement('p');
            residentNameElem.className = 'resident-name';
            residentNameElem.textContent = character.name;

            characterLink.appendChild(residentImageElem);
            characterLink.appendChild(residentNameElem);

            residentContainer.appendChild(characterLink);

            return residentContainer;
        };

        const loadResidents = async () => {
            for (const residentUrl of residents) {
                const characterId = extractCharacterId(residentUrl);
                const characterData = await fetchCharacter(characterId);

                if (characterData) {
                    const residentElement = createResidentElement(characterData);
                    residentGrid.appendChild(residentElement);
                }
            }
        };

        loadResidents();
    </script>
</body>
</html>
