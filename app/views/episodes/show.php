<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia - Episode Details</title>
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

        .character-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .character-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        .character-image {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .character-name {
            font-weight: bold;
            text-align: center;
        }
        
        /* Lazy loading placeholder */
        .character-placeholder {
            width: 150px;
            height: 150px;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="content-box">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <h1>Episode Details</h1>

        <h2><?= $episode['name']; ?></h2>
        <p><strong>Episode:</strong> <?= $episode['episode']; ?></p>
        <p><strong>Air Date:</strong> <?= $episode['air_date']; ?></p>
        <p><strong>Characters:</strong></p>
        <div class="character-grid" id="character-grid">
            <!-- Characters will be dynamically loaded here -->
        </div>
        <button id="load-more-button" style="display: none;">Load More</button>
    </div>

    <script src="/public/js/script.js"></script>
    <script>
        const characterGrid = document.getElementById('character-grid');
        const loadMoreButton = document.getElementById('load-more-button');
        const characters = <?= json_encode($characters); ?>;
        const charactersPerPage = 20;
        let currentPage = 1;

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

        const createCharacterElement = (character) => {
            const characterContainer = document.createElement('div');
            characterContainer.className = 'character-container';

            const characterLink = document.createElement('a');
            characterLink.href = `/characters/show/${character.id}`;

            const characterImageElem = document.createElement('img');
            characterImageElem.className = 'character-image';
            characterImageElem.src = character.image;
            characterImageElem.alt = character.name;

            const characterNameElem = document.createElement('p');
            characterNameElem.className = 'character-name';
            characterNameElem.textContent = character.name;

            characterLink.appendChild(characterImageElem);
            characterLink.appendChild(characterNameElem);

            characterContainer.appendChild(characterLink);

            return characterContainer;
        };

        const loadCharacters = async () => {
            const startIndex = (currentPage - 1) * charactersPerPage;
            const endIndex = startIndex + charactersPerPage;
            const charactersToLoad = characters.slice(startIndex, endIndex);
            const characterPromises = charactersToLoad.map(character => fetchCharacter(character.id));
            const characterDataArray = await Promise.all(characterPromises);

            characterDataArray.forEach(characterData => {
                if (characterData) {
                    const characterElement = createCharacterElement(characterData);
                    characterGrid.appendChild(characterElement);
                }
            });

            currentPage++;
            if (currentPage <= Math.ceil(characters.length / charactersPerPage)) {
                loadMoreButton.style.display = 'block';
            }
        };

        loadCharacters();

        loadMoreButton.addEventListener('click', () => {
            loadCharacters();
        });

        window.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

            if (scrollTop + clientHeight >= scrollHeight - 100) {
                loadCharacters();
            }
        });
    </script>
</body>
</html>
