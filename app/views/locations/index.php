<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia - Locations</title>
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

        .location-list {
        }

        .location-list li {
            margin-bottom: 10px;
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
    </style>
</head>
<body>
    <div class="content-box">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <h1>Locations</h1>
        <ul class="location-list">
            <?php foreach ($locations['results'] as $location): ?>
                <li>
                    <a href="/locations/show/<?= $location['id']; ?>">
                        <?= $location['name']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagination">
            <a id="prev-page-button" href="<?= $locations['info']['prev']; ?>">Previous</a>
            <a id="next-page-button" href="<?= $locations['info']['next']; ?>">Next</a>
        </div>
    </div>
    <script src="/public/js/script.js"></script>
    <script>
        const nextPageButton = document.getElementById('next-page-button');
        const prevPageButton = document.getElementById('prev-page-button');
        const locationList = document.querySelector('.location-list');

        // Scroll to top when the page loads
        locationList.scrollTop = 0;

        function loadLocations(url) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const locationList = document.querySelector('.location-list');
                    locationList.innerHTML = '';

                    data.results.forEach(location => {
                        const locationItem = document.createElement('li');

                        const locationLink = document.createElement('a');
                        locationLink.href = `/locations/show/${location.id}`;
                        locationLink.textContent = location.name;

                        locationItem.appendChild(locationLink);
                        locationList.appendChild(locationItem);
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
                loadLocations(nextUrl);
            });
        }

        if (prevPageButton) {
            prevPageButton.addEventListener('click', event => {
                event.preventDefault();
                const prevUrl = prevPageButton.getAttribute('href');
                loadLocations(prevUrl);
            });
        }
    </script>
</body>
</html>
