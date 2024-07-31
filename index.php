<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Website</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">GetFlix</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="séries.php">Séries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Ma Liste.php">Ma Liste</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href= "profil.php">Profil</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="featured">
            <h1>Sélectionnés pour vous</h1>
        </div>

        <h2>Populaires</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
        </div>

        <h2 class="mt-5">Nouveaux</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="https://via.placeholder.com/300x450" alt="Movie/Series Title">
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
