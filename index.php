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
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="logo" title="logo" width="180" height="39">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="form-inline mx-auto">
                <input class="form-control mr-2" type="search" placeholder="Recherchez votre film, série,...">
                <button class="btn btn-primary" type="submit">Recherche</button>
            </form>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="series.php">Séries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="maliste.php">Ma Liste</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profil</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div id="featuredCarousel" class="carousel slide featured" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/1500x500" class="d-block w-100" alt="First slide">
                    <div class="carousel-caption d-flex flex-column justify-content-end align-items-center">
                        <h1>Sélectionnés pour vous</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/1500x500" class="d-block w-100" alt="Second slide">
                    <div class="carousel-caption d-flex flex-column justify-content-end align-items-center">
                        <h1>Sélectionnés pour vous</h1>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#featuredCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#featuredCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <h2>Populaires</h2>
        <div class="row">
            <div class="col-md-3">
                <div id="carouselPopular1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselPopular1" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselPopular1" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div id="carouselPopular2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselPopular2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselPopular2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div id="carouselPopular3" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselPopular3" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselPopular3" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div id="carouselPopular4" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselPopular4" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselPopular4" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Nouveaux</h2>
        <div class="row">
            <div class="col-md-3">
                <div id="carouselNew1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselNew1" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselNew1" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div id="carouselNew2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselNew2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselNew2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div id="carouselNew3" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselNew3" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselNew3" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div id="carouselNew4" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/300x450" class="d-block w-100" alt="Movie/Series Title">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselNew4" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselNew4" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
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