-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mer. 31 juil. 2024 à 10:49
-- Version du serveur : 8.0.38
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `GetflixDB`
--

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id` int NOT NULL,
  `titre` varchar(500) NOT NULL,
  `description` int NOT NULL,
  `image` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `newfilms`
--

CREATE TABLE `newfilms` (
  `id` int NOT NULL,
  `titre` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `newfilms`
--

INSERT INTO `newfilms` (`id`, `titre`, `description`, `image`) VALUES
(521, 'Deadpool & Wolverine', 'Le Tribunal des Variations Anachroniques (TVA) est une organisation bureaucratique qui préserve la chronologie sacrée et surveille les anomalies du multivers. Cependant, même avec son pouvoir de manipuler l’espace et le temps, la TVA sait-elle dans quoi elle s’embarque en recrutant Wade Wilson, alias Deadpool ? Après une longue relation avec Wolverine (Hugh Jackman), Deadpool (Ryan Reynolds), va faire équipe avec l’homme adamantium. Ensemble, ils combattront des méchants de l’univers Marvel et bouleverseront la franchise MCU, apportant leur style R-rated à la 20th Century Fox et revisitant certains moments des phases 1 à 4 !', '/5DM2wMt9nZUDnbE0zuGt2joigYd.jpg'),
(522, 'Vice-versa 2', 'Fraichement diplômée, Riley est désormais une adolescente, ce qui n\'est pas sans déclencher un chamboulement majeur au sein du quartier général qui doit faire face à quelque chose d\'inattendu : l\'arrivée de nouvelles émotions ! Joie, Tristesse, Colère, Peur et Dégoût - qui ont longtemps fonctionné avec succès - ne savent pas trop comment réagir lorsqu\'Anxiété débarque. Et il semble qu\'elle ne soit pas la seule…', '/eHUWo4AiomQwG8EpWhvNNA1RMYz.jpg'),
(523, 'Moi, moche et méchant 4', 'Gru, Lucy, Margo, Edith et Agnès accueillent un nouveau membre de la famille, Gru Jr, qui est déterminé à tourmenter son père. Gru a un nouvel ennemi, Maxime Le Mal, et sa petite amie Valentina, et la famille est obligée de fuir.', '/vFbafXs0OYPGW1Vj2VGAHFKpAsW.jpg'),
(524, 'Justice League : Crisis on Infinite Earths Partie 3', 'Maintenant qu’il s’est révélé être la plus grande menace contre l’existence, l’ANTI-MONITOR lance une attaque incessante contre les terres survivantes qui se battent pour leur survie. Les mondes et leurs habitants sont anéantis l’un à la suite de l’autre! Sur les dernières planètes, le temps lui-même est pulvérisé, et les héros du passé s’unissent à la ligue des justiciers et à leurs alliés disparates contre le mal à l’état pur. Mais, à l’heure où le dernier combat s’amorce, le sacrifice des superhéros suffira-t-il pour tous nous sauver?', '/5sCXXUhEVoJWKzuiRA1kEwRl1ue.jpg'),
(525, 'Garfield : Héros malgré lui', 'Garfield, le célèbre chat d\'intérieur, amateur de lasagnes et qui déteste les lundis, est sur le point d\'être embarqué dans une folle aventure ! Après avoir retrouvé son père disparu, Vic, un chat des rues mal peigné, Garfield et son ami le chien Odie sont forcés de quitter leur vie faite de confort pour aider Vic à accomplir un cambriolage aussi risqué qu\'hilarant.', '/9vLxWpo0yfPnNrBvqZA30SGRW18.jpg'),
(526, 'Mon espion : La Cité éternelle', 'Sophie, désormais adolescente, convainc J.J. de chaperonner son voyage scolaire en Italie. Ils se retrouvent involontairement au milieu d\'un complot terroriste international visant le chef de la CIA, David Kim, et son fils, Collin - également le meilleur ami de Sophie.', '/ybtAclsqaSYYWWHu3lFfxwiYAyc.jpg'),
(527, 'Sans Un Bruit: Jour 1', 'Alors que Samira rentre à New York, son simple voyage se transforme en cauchemar suite à l’attaque de mystérieuses créatures attirées par le son. Accompagnée de son chat Frodo et d\'un allié inattendu, Samira se lance dans un voyage périlleux à travers une ville où règne le silence. Pour rester en vie, sa seule solution est de ne faire aucun bruit.', '/ymMaqwKN3Ovy9nlIRmk5GsnxEkx.jpg'),
(528, 'Descendants : L’Ascension de Red', 'Alors que la Reine de Cœur incite Auradon au coup d\'état, sa fille rebelle, Red, et Chloe, la fille de Cendrillon, décident d\'unir leurs forces. Elles remontent le temps pour essayer d\'empêcher l\'évènement traumatisant qui a conduit la mère de Red sur la voie du mal.', '/dMi80nBfxVBj7EfoixdabEOHxqj.jpg'),
(529, 'Les Intrus', 'Un jeune couple traverse le pays pour commencer une nouvelle vie ensemble dans le Pacifique Nord-Ouest. En chemin, leur voiture tombe en panne et ils sont forcés de passer la nuit dans une maison AirBnb isolée en Oregon. Tout au long de la nuit, ils sont terrorisés par trois inconnus masqués.', '/qMk6oRD4C7YPlGIaurYCrmsgE9b.jpg'),
(530, 'The Exorcism', 'Un acteur récemment sevré tourne dans un film d\'horreur. Il plonge de plus en plus dans une psychose. Sa fille se demande s’il est retombé dans ses addictions passées ou si son père est possédé...', '/ar2h87jlTfMlrDZefR3VFz1SfgH.jpg'),
(531, '从21世纪安全撤离', '', '/nZQPbD7IEKWiUDK7s9GKHwqP88g.jpg'),
(532, 'Twisters', 'Ancienne chasseuse de tornades, Kate est encore traumatisée par sa confrontation avec une tornade lorsqu’elle était étudiante. Désormais, elle préfère étudier le comportement des tempêtes en toute sécurité depuis New York. Mais lorsque son ami Javi lui demande de tester un nouveau détecteur de tornades, elle accepte de retourner au cœur de l’action. Elle rencontre alors le charmant et téméraire Tyler Owens, célèbre pour ses vidéos de chasse aux tornades postées sur les réseaux sociaux. Alors que la saison des tempêtes atteint son paroxysme, des tornades d’une ampleur sans précédent mettent leurs vies en péril.', '/2aqc5S3dMvJZRMY3CJhB74h0xy7.jpg'),
(533, 'In a Violent Nature', 'Au cours d\'un séjour en forêt, un groupe de jeunes plaisanciers ranime sans le savoir la dépouille d\'un homme enterré dans les bois non loin de leur chalet. Le fou furieux masqué est sorti des entrailles de la Terre pour venger son existence passée.', '/hPfWHgq07nXbeldwEGxWB4JqwtE.jpg'),
(534, 'Boneyard', 'Inspiré de faits réels, ce thriller policier glaçant suit l\'enquête lancée par plusieurs agences lorsque les restes de onze femmes sont découverts dans le désert du Nouveau-Mexique.', '/shG4s430NWq7NKVB8ZtluudRUtX.jpg'),
(535, 'Le Dernier Jaguar', 'Autumn grandit dans la forêt amazonienne aux côtés de Hope, un adorable bébé jaguar femelle qu\'elle a recueilli. L\'année de ses six ans, un drame familial contraint Autumn et son père à retourner vivre à New York. Huit années passent, et Autumn, devenue adolescente, n\'a jamais oublié son amie jaguar. Quand elle apprend que Hope est en danger de mort, Autumn décide de retourner dans la jungle pour la sauver.', '/x5z1J5P7MugMtpPLSBa9SBJMMZV.jpg'),
(536, 'Goyo', 'Goyo, un fan autiste de Van Gogh, est guide au musée national des Beaux-Arts de Buenos Aires. Sa routine immuable est perturbée quand il tombe amoureux d\'Eva, nouvelle agente de sécurité du musée. Déçue par sa vie de femme mariée, elle ne croit plus à l\'amour et perd parfois confiance en elle. Cette rencontre que rien ne laissait prévoir va permettre à Goyo et Eva de découvrir une nouvelle façon d\'aimer et d\'être aimés.', '/fCjC1RRbEJUpDjM55RNUMXQen0b.jpg'),
(537, 'The Inheritance', '', '/3qQok7BPKVcM0DA9Zu5OeMzzmk6.jpg'),
(538, 'Immaculée', 'Cecilia, une jeune femme de foi américaine, est chaleureusement accueillie dans un illustre couvent isolé de la campagne italienne, où elle se voit offrir un nouveau rôle. L\'accueil est chaleureux, mais Cecilia comprend rapidement que sa nouvelle demeure abrite un sinistre secret et que des choses terribles s\'y produisent.', '/aRhtHbgFGVKI5LJHcbSqQ0WbNib.jpg'),
(539, 'Si je tombe', 'Après un come-back raté, une star du rock s\'installe dans une maison en bordure de falaise à Chypre, mais des visiteurs, et une ex, perturbent la quiétude de sa retraite.', '/7eLOW06jgzJThoNsJgIaPlPmLRY.jpg'),
(540, 'The Convert', 'Lorsque le prédicateur laïc Thomas Munro arrive dans une colonie britannique de la Nouvelle-Zélande des années 1830, son passé violent est rapidement remis en question et sa foi mise à l\'épreuve, car il se retrouve pris au milieu d\'une guerre sanglante entre tribus Māori.', '/e5ZqqPlhKstzB4geibpZh38w7Pq.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `popularfilms`
--

CREATE TABLE `popularfilms` (
  `id` int NOT NULL,
  `titre` varchar(500) NOT NULL,
  `description` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `popularfilms`
--

INSERT INTO `popularfilms` (`id`, `titre`, `description`, `image`) VALUES
(41, 'Deadpool & Wolverine', 'Le Tribunal des Variations Anachroniques (TVA) est une organisation bureaucratique qui préserve la chronologie sacrée et surveille les anomalies du multivers. Cependant, même avec son pouvoir de manipuler l’espace et le temps, la TVA sait-elle dans quoi elle s’embarque en recrutant Wade Wilson, alias Deadpool ? Après une longue relation avec Wolverine (Hugh Jackman), Deadpool (Ryan Reynolds), va faire équipe avec l’homme adamantium. Ensemble, ils combattront des méchants de l’univers Marvel et bouleverseront la franchise MCU, apportant leur style R-rated à la 20th Century Fox et revisitant certains moments des phases 1 à 4 !', '/5DM2wMt9nZUDnbE0zuGt2joigYd.jpg'),
(42, 'Bad Boys : Ride or Die', 'Le détective de Miami Mike Lowrey apprend que son ex-supérieur à l\'escouade anti-drogue, le défunt capitaine Howard, aurait reçu des centaines de millions de dollars de la part des cartels mexicains. Avec son coéquipier et ami Marcus Burnett, Mike entreprend de blanchir la réputation de Howard. Or, le meurtrier du capitaine, le trafiquant Armando Aretas, est le seul à pouvoir identifier le véritable traître au sein des forces de police de Miami. Et puisque le repenti Armando est également le fils de Mike, ce dernier obtient qu\'il soit temporairement libéré de prison pour participer à l\'enquête. Mais ce faisant, Marcus, Mike et son fils se retrouvent à leur tour compromis par le chef des conspirateurs, qui lance des chasseurs de primes à leurs trousses.', '/zCZJXSDPZKGml4I5zvxNpdx8jra.jpg'),
(43, 'Vice-versa 2', 'Fraichement diplômée, Riley est désormais une adolescente, ce qui n\'est pas sans déclencher un chamboulement majeur au sein du quartier général qui doit faire face à quelque chose d\'inattendu : l\'arrivée de nouvelles émotions ! Joie, Tristesse, Colère, Peur et Dégoût - qui ont longtemps fonctionné avec succès - ne savent pas trop comment réagir lorsqu\'Anxiété débarque. Et il semble qu\'elle ne soit pas la seule…', '/eHUWo4AiomQwG8EpWhvNNA1RMYz.jpg'),
(44, 'Moi, moche et méchant 4', 'Gru, Lucy, Margo, Edith et Agnès accueillent un nouveau membre de la famille, Gru Jr, qui est déterminé à tourmenter son père. Gru a un nouvel ennemi, Maxime Le Mal, et sa petite amie Valentina, et la famille est obligée de fuir.', '/vFbafXs0OYPGW1Vj2VGAHFKpAsW.jpg'),
(45, 'Justice League : Crisis on Infinite Earths Partie 3', 'Maintenant qu’il s’est révélé être la plus grande menace contre l’existence, l’ANTI-MONITOR lance une attaque incessante contre les terres survivantes qui se battent pour leur survie. Les mondes et leurs habitants sont anéantis l’un à la suite de l’autre! Sur les dernières planètes, le temps lui-même est pulvérisé, et les héros du passé s’unissent à la ligue des justiciers et à leurs alliés disparates contre le mal à l’état pur. Mais, à l’heure où le dernier combat s’amorce, le sacrifice des superhéros suffira-t-il pour tous nous sauver?', '/5sCXXUhEVoJWKzuiRA1kEwRl1ue.jpg'),
(46, 'Garfield : Héros malgré lui', 'Garfield, le célèbre chat d\'intérieur, amateur de lasagnes et qui déteste les lundis, est sur le point d\'être embarqué dans une folle aventure ! Après avoir retrouvé son père disparu, Vic, un chat des rues mal peigné, Garfield et son ami le chien Odie sont forcés de quitter leur vie faite de confort pour aider Vic à accomplir un cambriolage aussi risqué qu\'hilarant.', '/9vLxWpo0yfPnNrBvqZA30SGRW18.jpg'),
(47, 'Deadpool', 'Deadpool, est l\'anti-héros le plus atypique de l\'univers Marvel. À l\'origine, il s\'appelle Wade Wilson : un ancien militaire des Forces Spéciales devenu mercenaire. Après avoir subi une expérimentation hors norme qui va accélérer ses pouvoirs de guérison, il va devenir Deadpool. Armé de ses nouvelles capacités et d\'un humour noir survolté, Deadpool va traquer l\'homme qui a bien failli anéantir sa vie.', '/z5VjcCEioj2c2dvxmoqBW0Rj8Xj.jpg'),
(48, 'Mon espion : La Cité éternelle', 'Sophie, désormais adolescente, convainc J.J. de chaperonner son voyage scolaire en Italie. Ils se retrouvent involontairement au milieu d\'un complot terroriste international visant le chef de la CIA, David Kim, et son fils, Collin - également le meilleur ami de Sophie.', '/ybtAclsqaSYYWWHu3lFfxwiYAyc.jpg'),
(49, 'La Planète des singes : Le Nouveau Royaume', 'Plusieurs générations après le règne de César, les singes ont définitivement pris le pouvoir. Les humains, quant à eux, ont régressé à l\'état sauvage et vivent en retrait. Alors qu\'un nouveau chef tyrannique construit peu à peu son empire, un jeune singe entreprend un périlleux voyage qui l\'amènera à questionner tout ce qu\'il sait du passé et à faire des choix qui définiront l\'avenir des singes et des humains...', '/4925wPllJdQmHd1RxbZ62ZekaW3.jpg'),
(50, 'Sans Un Bruit: Jour 1', 'Alors que Samira rentre à New York, son simple voyage se transforme en cauchemar suite à l’attaque de mystérieuses créatures attirées par le son. Accompagnée de son chat Frodo et d\'un allié inattendu, Samira se lance dans un voyage périlleux à travers une ville où règne le silence. Pour rester en vie, sa seule solution est de ne faire aucun bruit.', '/ymMaqwKN3Ovy9nlIRmk5GsnxEkx.jpg'),
(51, 'Furiosa: Une saga Mad Max', 'Alors que le monde s\'écroule, la jeune Furiosa tombe entre les mains d\'une horde de motards dirigée par le seigneur de la guerre Dementus. En traversant le Wasteland, ils tombent sur la Citadelle présidée par l\'Immortan Joe. Alors que les deux tyrans se battent pour la domination, Furiosa doit survivre à de nombreuses épreuves pour trouver le moyen de rentrer chez elle.', '/hbxqFdWXHeLIJfagMMhVG5SV5tb.jpg'),
(52, 'Descendants : L’Ascension de Red', 'Alors que la Reine de Cœur incite Auradon au coup d\'état, sa fille rebelle, Red, et Chloe, la fille de Cendrillon, décident d\'unir leurs forces. Elles remontent le temps pour essayer d\'empêcher l\'évènement traumatisant qui a conduit la mère de Red sur la voie du mal.', '/dMi80nBfxVBj7EfoixdabEOHxqj.jpg'),
(53, 'Deadpool 2', 'Deadpool se voit contraint de rejoindre les X-Men : après une tentative ratée de sauver un jeune mutant au pouvoir destructeur, il est jeté en prison anti-mutants. Arrive Cable, un soldat venant du futur et ayant pour cible le jeune mutant, en quête de vengeance. Deadpool décide de le combattre. Peu convaincu par les règles des X-Men, il crée sa propre équipe, la « X-Force ». Mais cette mission lui réservera de grosses surprises, des ennemis de taille et des alliés indispensables.', '/ybjooZMNlRBaFNfs52XqONc4Xyw.jpg'),
(54, 'Out of Exile', 'Gabe Russell, un voleur récemment libéré sur parole, est de retour. Après avoir raté le vol d\'un véhicule blindé, il se retrouve sous la pression du FBI et doit tenter une dernière fois de s\'échapper et de créer une nouvelle vie pour lui et sa fille, dont il s\'est éloigné.', '/jgF5XaXnJmOgMxulhy2k1f9LNNc.jpg'),
(55, 'Sous le feu ennemi', 'Pendant la Seconde Guerre mondiale, des marines stationnés sur un aérodrome en Malaisie apprennent l\'imminence d\'un raid de l\'armée japonaise. S\'étant vu refuser l\'envoi de renforts, ils s\'engagent dans une bataille éprouvante de trois jours contre les forces ennemies qui se comptent en milliers d\'hommes...', '/xgoBgh4OVLM4i3xc7C2q6PawTpC.jpg'),
(56, 'Les Intrus', 'Un jeune couple traverse le pays pour commencer une nouvelle vie ensemble dans le Pacifique Nord-Ouest. En chemin, leur voiture tombe en panne et ils sont forcés de passer la nuit dans une maison AirBnb isolée en Oregon. Tout au long de la nuit, ils sont terrorisés par trois inconnus masqués.', '/qMk6oRD4C7YPlGIaurYCrmsgE9b.jpg'),
(57, 'Godzilla x Kong : Le Nouvel Empire', 'Le surpuissant Kong et le redoutable Godzilla sont opposés à une force colossale terrée dans notre monde, qui menace leur existence et la nôtre. \"Godzilla x Kong : Le nouvel empire\" approfondit l\'histoire de ces titans et leurs origines, ainsi que les mystères de Skull Island et au-delà, tout en levant le voile sur la bataille mythique qui a forgé ces êtres extraordinaires et les a liés à l\'humanité à jamais.', '/nKnWr062zhRvk48NtK27zz3oLgS.jpg'),
(58, 'Civil War', 'Dans un futur proche où les États-Unis sont au bord de l\'effondrement et où des journalistes embarqués courent pour raconter la plus grande histoire de leur vie : La fin de l\'Amérique telle que nous la connaissons. Une course effrénée à travers une Amérique fracturée qui, dans un futur proche, est plus que jamais sur le fil du rasoir.', '/4V06xpCUesnzXvkQav1q3RRlwxh.jpg'),
(59, 'The Exorcism', 'Un acteur récemment sevré tourne dans un film d\'horreur. Il plonge de plus en plus dans une psychose. Sa fille se demande s’il est retombé dans ses addictions passées ou si son père est possédé...', '/ar2h87jlTfMlrDZefR3VFz1SfgH.jpg'),
(60, 'Alice in Terrorland', '', '/5XJGvr8g9jkmN6KUIOQOj2iE6K4.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `newfilms`
--
ALTER TABLE `newfilms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `popularfilms`
--
ALTER TABLE `popularfilms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `newfilms`
--
ALTER TABLE `newfilms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541;

--
-- AUTO_INCREMENT pour la table `popularfilms`
--
ALTER TABLE `popularfilms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
