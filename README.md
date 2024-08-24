# Getflix Project Contribution Overview

### Team Members and Their Roles

- **Sanjay (git: Kendrak90)**

Sanjay developed the front-end user interface using HTML, CSS, and JavaScript. Collaborating with Sarah, he focused on key features aimed at providing an engaging and efficient user experience with well-integrated front-end components.

- **Sarah (git: sabbels)**

Sarah functioned as both a Front-end and Back-end Developer, expertly managing the project using Trello to ensure streamlined progress and effective task delegation. She was instrumental in designing the front-end user interface with HTML, CSS, and JavaScript, and specifically crafted the first page users encounter upon landing on the website, ensuring a captivating initial experience.

See "populaires" movies displayed for the home page:

```php

        <h2>Populaires</h2>
            <?php 
                $sql = "SELECT * FROM films LIMIT 8";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '<div class="row">';
                foreach ($films as $film) {
                    echo '<div class="col-md-3 mt-3">';
                    echo '<div class="thumbnail">';
                    echo '<a href="filmsdetails.php?id=' . $film['id'] . '"><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $film['image'] . '" alt="' . $film['titre'] . '"></a>';
                    echo '</div>';
                    echo '</div>';  
                }
                echo '</div>';
            ?>
```

Sarah developed functionalities using JavaScript that enabled users to add movies to their profiles, enhancing user engagement and personalization. She collaborated closely with Steven to achieve seamless integration between front-end and back-end components, focusing on features such as movie and series details, filters, and user dashboard functionalities.

Add to list function:

```javascript

document.addEventListener("DOMContentLoaded", function() {
    function addItemToList(type) {
        // Récupérer les informations du film ou de la série
        var title = document.querySelector('.seriestitle h2, .filmtitle h2').textContent.replace('Titre:', '').trim();
        var year = document.querySelector('.year h5').textContent.replace('Date de sortie:', '').trim();
        var language = document.querySelector('.language h5').textContent.replace('Langue originale:', '').trim();
        var note = document.querySelector('.note h5').textContent.replace('Note (/10) :', '').trim();

        var item = {
            type: type,
            title: title,
            year: year,
            language: language,
            note: note
        };

        var items = JSON.parse(localStorage.getItem('myList')) || [];

        // Vérifier si l'élément existe déjà dans la liste
        var existingItem = items.find(i => i.title === item.title && i.type === item.type);
        if (existingItem) {
            alert("Cet élément est déjà dans votre liste !");
            return;
        }

        items.push(item);

        localStorage.setItem('myList', JSON.stringify(items));

        alert("Bien ajouté à votre liste !");
        updateTable();
    }

```



Additionally, Sarah designed custom icons and images to enhance the platform's visual appeal and maintained clear, consistent communication to meet project deadlines effectively. She leveraged modern frameworks and libraries to optimize both development efficiency and user experience.

- **Steven (git: stevenmottiaux)**

Steven played a crucial role as the primary Back-end Developer, designing and implementing key systems that enhance user interaction and application functionality. He developed a robust Session Management System to maintain user sessions by tracking activity and preferences, ensuring a seamless user experience. In addition, he implemented User Authentication mechanisms to verify user identities, granting access to authorized users only.

Create user:

```php

<?php
session_start();
include 'configdb.php';

// Vérification que le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);


    // Vérification longeur et complexité du mot de passe + vérification des deux mots de passe
    switch (!empty($password)) {
        case strlen($password) < 8: // Vérification de la longueur du mot de passe
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins 8 caractères.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case !preg_match('/[A-Z]/', $password): // Vérification de la présence d'une lettre majuscule
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case !preg_match('/[0-9]/', $password): // Vérification de la présence d'un chiffre
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins un chiffre.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case !preg_match("/^[a-zA-Z0-9_\-!@#$%^&*()+=[\]{};:,.<>\/?|%\\\\]+$/", $password):
            $_SESSION['error'] = 'Le mot de passe contient des caractères non autorisés.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case $password !== $confirm_password: // Vérification des deux mots de passe
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
            header("Location: formulaireinscription.php");
            exit();
            break;
    }


    // Vérification de l'existence de l'email dans la base de données
    if (!empty($email)) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['error'] = "L'adresse email est déjà utilisée.";
            header("Location: formulaireinscription.php");
            exit();
        }
    }
    // Vérification de l'existence de l'username dans la base de données
    if (!empty($username)) {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['error'] = "Le nom d'utilisateur est déjà utilisé.";
            header("Location: formulaireinscription.php");
            exit();
        }
        // Validation de l'username pour autoriser les lettres, les chiffres, les tirets, les underscores et certains caractères spéciaux
        if (!preg_match("/^[a-zA-Z0-9@_\-]+$/", $password)) {
            $_SESSION['error'] = "Le nom d'utilisateur contient des caractères non autorisés.";
            header("Location: formulaireinscription.php");
            exit();
        }
    }

    // Hachage du mot de passe pour la sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête pour éviter les injections SQL
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // Exécuter la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Inscription réussie ! Bienvenue, $username.";
        $_SESSION['user_id'] = $db->lastInsertId(); // ID de l'utilisateur nouvellement créé
        $_SESSION['username'] = $username; // Stocker le nom d'utilisateur dans la session
        header("Location: profil.php?welcome=1");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
        header("Location: formulaireinscripton.php");
        exit();
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
} else {
    // Si la méthode de la requête n'est pas POST, redirigez vers la page d'inscription
    header("Location: formulaireinscription.php");
    exit();
}
```

Steven also crafted a sophisticated Roles Management system, providing various permissions and access levels tailored to different user roles, such as admin, member, or guest. He enhanced the interactive component with Comment Handling features, enabling users to post, display, edit, and delete comments smoothly within the application.

His work on Search Algorithms with Dynamic Filtering brought advanced search functionalities to the forefront, allowing users to discover content based on multiple dynamic criteria, thereby improving navigation and content discovery. To support a consistent development environment, Steven utilized Docker, ensuring applications could run reliably across different systems.

Search movies:

```php

const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

const debouncedSearch = debounce(function() {
    const searchTerm = searchInput.value.toLowerCase();

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchfilmsdb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const results = JSON.parse(xhr.responseText);
            displayFilmsResults(results);
        }
    };

    xhr.send('query=' + encodeURIComponent(searchTerm));
}, 300); // 300ms de délai

searchInput.addEventListener('input', debouncedSearch);

function displayFilmsResults(results) {
    searchResults.innerHTML = '';
    const table = document.createElement('table');

    if (results.length > 0) {
        results.forEach(function(result) {
            const tr = document.createElement('tr');
            const link = document.createElement('a');
            link.textContent = result.titre;
            link.href = 'filmsdetails.php?id=' + encodeURIComponent(result.id);
            tr.appendChild(link);
            table.appendChild(tr);
        });
    } else {
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResults.appendChild(p);
    }

    console.log(table);
    searchResults.appendChild(table);
}
```

Leveraging PHP, Steven built secure and scalable server-side applications, adeptly processing user requests and managing data connections. He employed MySQL for efficient database operations like data storage and retrieval. His dedication to quality was reflected in the comprehensive Unit Testing and Integration Testing he conducted, verifying that each part of the application worked correctly both individually and together.

Furthermore, Steven produced thorough documentation for the application's APIs and systems, providing essential guidance for maintenance and future upgrades. This contributed significantly to the project's sustainability and clarity, demonstrating his commitment to high-quality software development.

- **Nate (git: NateGithub9)**

As the Back-end Developer and Git Master, Nate played a pivotal role in overseeing version control and deployments with meticulous attention to detail. He personally reviewed every commit, ensuring code quality and consistency across the project. Nate formulated a robust deployment strategy using Heroku and was instrumental in the migration of data to the ClearDB SQL database, maintaining data consistency and enhancing security.

Beyond oversight, Nate conducted thorough testing on all implemented features, guaranteeing functionality and reliability before merging branches. His careful handling of branch merges minimized conflicts and streamlined development processes. Nate was also vigilant in managing secure database connections, expertly concealing all sensitive information to bolster data security. His diligent management of Git workflows optimized team collaboration and significantly enhanced productivity.

### Getflix Features

1. **Home Page**

The "Accueil" page welcomes users with an overview of popular movies and features a search bar for easy navigation. It includes navigation options for exploring "Movies," "Shows," and the user profile section.

2. **Profile Page**

Visitors can explore the Getflix library without an account. Upon signing up, users can access a personalized dashboard to:

- Users may sign up to comment and manage their profiles, including editing username, password, email, and uploading a custom profile picture.
- Add comments, viewable in the "Comments" section. Comments can be sorted and filtered by rating, publication date, or alphabetically.
- Change user password.
- Note that only admin users can moderate comments, ensuring quality and listing reasons for refusals in the moderation dashboard.

3. **Movies Pages and Shows Page**

- Users can search the Getflix database for movies and shows, utilizing a sophisticated filtering system to sort videos by title, date, rating, language, and release date. Video covers link to pages with descriptions and trailers, enhancing user engagement. Logged-in users can add comments, which appear instantly.
- Allows users to search for movies and shows by keyword in distinct search bars on the home page, movies page, and shows page.
- Users can load additional movies and shows, displaying an additional 12 entries each time a button is clicked, with filters applied consistently.
- Offers sorting by title, release date, and rating, in ascending or descending order.

### Potential New Features

1. **Newsletter Integration with Mailchimp**
   - Enable users to sign up for newsletters.

2. **Optimize Performance**
   - Improve performance based on testing outcomes.
