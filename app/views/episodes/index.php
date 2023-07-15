<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia - Episodes</title>
    <link rel="stylesheet" type="text/css" href="/public/css/styles.css">
    <style>
        /* Additional CSS styles for the layout */
        #content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .content-box {
            background-color: #fff;
            max-width: 800px;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-top: -50px;
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
    </style>
</head>
<body>
<div id="content">
    <div class="content-box">
        <a href="javascript:history.back()" class="back-button">Back</a>
        <h1>Episodes</h1>
        <ul id="episode-list">
            <?php foreach ($episodes['results'] as $episode): ?>
                <li>
                    <a href="/episodes/show/<?= $episode['id']; ?>">
                        <?= $episode['name']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagination">
            <a id="prev-page-button" href="<?= $episodes['info']['prev']; ?>">Previous</a>
            <a id="next-page-button" href="<?= $episodes['info']['next']; ?>">Next</a>
        </div>
    </div>
</div>
<script src="/public/js/script.js"></script>
<script>
// JavaScript code to handle the Next page button click
const nextPageButton = document.getElementById('next-page-button');
const prevPageButton = document.getElementById('prev-page-button');

function loadEpisodes(url) {
  fetch(url)
    .then(response => response.json())
    .then(data => {
      const episodeList = document.getElementById('episode-list');
      episodeList.innerHTML = '';

      // Update the episode list with the new episodes
      data.results.forEach(episode => {
        const listItem = document.createElement('li');
        const link = document.createElement('a');
        link.href = `/episodes/show/${episode.id}`;
        link.textContent = episode.name;
        listItem.appendChild(link);
        episodeList.appendChild(listItem);
      });

      // Update the pagination buttons with the new URLs
      prevPageButton.setAttribute('href', data.info.prev);
      nextPageButton.setAttribute('href', data.info.next);

      // Show/hide pagination buttons based on availability
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
    loadEpisodes(nextUrl);
  });
}

if (prevPageButton) {
  prevPageButton.style.display = 'none';
  prevPageButton.addEventListener('click', event => {
    event.preventDefault();
    const prevUrl = prevPageButton.getAttribute('href');
    loadEpisodes(prevUrl);
  });
}
</script>
</body>
</html>
