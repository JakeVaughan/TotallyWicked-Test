// Your custom JavaScript code goes here
// This is just an example template

// Function to handle click events on character links
function handleCharacterClick(event) {
    event.preventDefault();
  
    var characterId = this.getAttribute('data-character-id');
  
    // Perform any desired action with the character ID
    // For example, you can make an AJAX request to fetch additional character details
  
    // Redirect to the character details page
    window.location.href = '/characters/show/' + characterId;
}

// Add event listeners to character links
var characterLinks = document.querySelectorAll('.character-link');
characterLinks.forEach(function (link) {
    link.addEventListener('click', handleCharacterClick);
});

        const nextPageButton = document.getElementById('next-page-button');
        const prevPageButton = document.getElementById('prev-page-button');
		const characterGrid = document.querySelector('.character-grid');

		// Scroll to top when the page loads
		characterGrid.scrollTop = 0;

        function loadCharacters(url) {
            fetch(url)
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
		

        // Function to handle search button click event
        function handleSearchButtonClick() {
            const searchInput = document.getElementById('search-input');
            const searchValue = searchInput.value.trim();

            // Check if search value is empty
            if (searchValue === '') {
                // Reload all characters if search value is empty
                loadCharacters('https://rickandmortyapi.com/api/character');
                return;
            }

            // Construct search URL with the search value
            const searchUrl = `https://rickandmortyapi.com/api/character/?name=${searchValue}`;

            // Load characters based on search URL
            loadCharacters(searchUrl);
        }

        // Add event listener to search button
        const searchButton = document.getElementById('search-button');
        searchButton.addEventListener('click', handleSearchButtonClick);