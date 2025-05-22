



--
-- Base de données : `stock_produit`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` datetime DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `password`, `date_inscription`, `token`, `type`) VALUES
(2, 'assia', 'aa', 'essai@gmail.com', '0699309912', 'azerty', '$2y$10$diahNDQo/P2LImTy21iZ7.1SSGbe4tRSVLZMof5VVWhYapovAUNVu', '2025-05-14 10:51:33', '3d458f62513f03ba581a370a8bb5e79e', 'client'),
(3, 'khadija', 'dija', 'dija@gmail.com', '0666789430', 'aaa Num 20', '$2y$10$4ztltH8OA3XJmpJ4hyD/M.1792BWQ6cefG02WjTTuyVfleW9lD2/S', '2025-05-14 22:03:36', NULL, 'client'),
(4, 'Admin', 'Admin', 'admin@gmail.com', '0788923829', 'Lot A5 Num 1', '$2y$10$qv7rK4q.5TtjgJSZY7wW.OLlQP3NtinQOj1f4deqtnkQFC8ieIL8a', '2025-05-15 10:51:50', NULL, 'admin'),
(5, 'dija', 'khadija', 'khadija@gmail.com', '0748990420', 'lotissement roudani rue wifak N29', '$2y$10$em2cyTUi83gNlL/7Gd5GyOw35zYUvzksGoWkSR/7z0jBFaCbk2Sf6', '2025-05-15 22:42:18', NULL, 'client'),
(6, 'ss', 'ss', 'ss@gmail.com', '0983084904', 'ssss', '$2y$10$b7b8keUQXiJOQrrTZ4Wj8.R7yy1ClDLaWB0WZOTqfOiiL5/V6F4xK', '2025-05-16 20:31:52', NULL, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `statut`, `total`, `user_id`) VALUES
(5, 'Commande annulée', 150.00, 3),
(6, 'en cours', 265.00, 2),
(7, 'En cours de livraison', 1030.00, 3),
(8, 'En cours de livraison', 765.00, 5),
(9, 'en cours', 250.00, 3);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id_ligne` int(11) NOT NULL,
  `id_commande` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id_ligne`, `id_commande`, `id_produit`, `quantite`) VALUES
(5, 6, 4, 1),
(6, 6, 3, 1),
(7, 7, 4, 4),
(8, 7, 3, 2),
(9, 8, 4, 3),
(10, 8, 3, 1),
(11, 9, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `id_ligne` int(11) NOT NULL,
  `lieu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`id`, `id_ligne`, `lieu`) VALUES
(1, 11, 'essaie');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `prix` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `quantite`, `date_ajout`, `prix`, `image_path`) VALUES
(3, 'Paracétamol', 'Mylan Conseil Paracétamol 1000mg 8 Comprimés Sécables', 200, '2025-05-14 20:25:19', 15.00, 'uploads/6825098d538a7.jpg'),
(4, 'capsule bio', 'Pour soutenir la production d&#039;énergie par l&#039;organisme et pour combattre la fatigue et l&#039;épuisement', 100, '2025-05-14 21:25:55', 250.00, 'uploads/68250a632dd75.jpg'),
(5, 'vitamin B', 'vitamin B pour cheveux anti chutte', 120, '2025-05-15 20:46:50', 150.00, 'uploads/682652ba74ad9.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ligne` (`id_ligne`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `ligne_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligne_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`id_ligne`) REFERENCES `ligne_commande` (`id_ligne`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


{
  id_client        int        [pk, increment]
  nom              varchar(100)
  prenom           varchar(100)
  email            varchar(255) [unique]
  telephone        varchar(20)
  adresse          text
  
}
@]¤}}~#{}