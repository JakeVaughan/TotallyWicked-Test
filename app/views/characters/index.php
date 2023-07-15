<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia - Characters</title>
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
            max-height: 300px; /* Add max-height to limit height */
            overflow-y: auto; /* Enable vertical scrolling */
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

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 10px; /* Add margin-bottom for spacing */
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            padding: 5px 10px; /* Add padding for button size */
            border-radius: 5px;
            background-color: #fff; /* Set background color */
            border: 1px solid #333; /* Add border */
            transition: background-color 0.3s ease;
        }

        .pagination a.active {
            color: #fff;
            background-color: #333;
        }

        .pagination a:hover {
            background-color: #555;
        }        
        
        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            flex-grow: 1;
            margin-right: 10px;
        }

        .search-button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: #555;
        }

    </style>
</head>
<body>
    <div class="content-box">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <h1>Characters</h1>
        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Search characters...">
            <button id="search-button" class="search-button">Search</button>
        </div>
        <div class="character-grid">
            <?php foreach ($characters['results'] as $character): ?>
                <div class="character-container">
                    <a href="/characters/show/<?= $character['id']; ?>">
                        <img class="character-image" src="<?= $character['image']; ?>" alt="<?= $character['name']; ?>">
                    </a>
                    <a href="/characters/show/<?= $character['id']; ?>">
                        <p class="character-name"><?= $character['name']; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <a id="prev-page-button" href="<?= $characters['info']['prev']; ?>">Previous</a>
            <a id="next-page-button" href="<?= $characters['info']['next']; ?>">Next</a>
        </div>
    </div>
    <script src="/public/js/script.js"></script>
    <script>
        const nextPageButton = document.getElementById('next-page-button');
        const prevPageButton = document.getElementById('prev-page-button');
        const characterGrid = document.querySelector('.character-grid');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');

        // Scroll to top when the page loads
        characterGrid.scrollTop = 0;

        function loadCharacters(url) {
            // Sanitize the URL to prevent XSS attacks
            const sanitizedUrl = encodeURI(url);

            fetch(sanitizedUrl)
                .then(response => response.json())
                .then(data => {
                    const characterGrid = document.querySelector('.character-grid');
                    characterGrid.innerHTML = '';

                    data.results.forEach(character => {
                        const characterContainer = document.createElement('div');
                        characterContainer.className = 'character-container';

                        const characterLink = document.createElement('a');
                        characterLink.href = `/characters/show/${character.id}`;

                        const characterImage = document.createElement('img');
                        characterImage.className = 'character-image';
                        characterImage.src = character.image;
                        characterImage.alt = character.name;

                        const characterName = document.createElement('p');
                        characterName.className = 'character-name';
                        characterName.textContent = character.name;

                        characterLink.appendChild(characterImage);
                        characterLink.appendChild(characterName);

                        characterContainer.appendChild(characterLink);
                        characterGrid.appendChild(characterContainer);
                    });

                    prevPageButton.setAttribute('href', data.info.prev);
                    nextPageButton.setAttribute('href', data.info.next);

                    prevPageButton.style.display = data.info.prev ? 'inline-block' : 'none';
                    nextPageButton.style.display = data.info.next ? 'inline-block' : 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function handleSearch() {
            const searchValue = searchInput.value.trim();

            // Check if search value is empty or contains invalid characters
            if (searchValue === '' || !/^[\w\s-]+$/.test(searchValue)) {
                alert('Invalid search input. Please enter a valid search term.');
                return;
            }

            // Construct search URL with the search value
            const searchUrl = `https://rickandmortyapi.com/api/character/?name=${searchValue}`;

            // Load characters based on search URL
            loadCharacters(searchUrl);
        }

        searchButton.addEventListener('click', handleSearch);
        searchInput.addEventListener('keypress', event => {
            if (event.key === 'Enter') {
                handleSearch();
            }
        });

        if (nextPageButton) {
            nextPageButton.addEventListener('click', event => {
                event.preventDefault();
                const nextUrl = nextPageButton.getAttribute('href');
                loadCharacters(nextUrl);
            });
        }

        if (prevPageButton) {
            prevPageButton.style.display = 'none';
            prevPageButton.addEventListener('click', event => {
                event.preventDefault();
                const prevUrl = prevPageButton.getAttribute('href');
                loadCharacters(prevUrl);
            });
        }
    </script>
</body>
</html>
