<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Encyclopedia</title>
    <link rel="stylesheet" type="text/css" href="/public/css/styles.css">
</head>
<body>
<div id="content">
    <img id="logo" src="public/img/logo.png" alt="Rick and Morty Logo">
	<div class="button button-characters" onclick="redirectToCharacters()">
		<span>Characters</span>
	</div>
    <div class="button button-locations" onclick="redirectToLocations()">
        <span>Locations</span>
    </div>
    <div class="button button-episodes" onclick="redirectToEpisodes()">
        <span>Episodes</span>
    </div>
</div>
</body>
</html>

<script>
    function redirectToCharacters() {
        window.location.href += 'characters';
    }
    function redirectToLocations() {
        window.location.href += 'locations';
    }
    function redirectToEpisodes() {
        window.location.href += 'episodes';
    }
</script>