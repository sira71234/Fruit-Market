
-- Table des produits
CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `remise` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertion de quelques produits
INSERT INTO `produits` (`id`, `nom`, `detail`, `categorie`, `photo`, `prix`, `remise`) VALUES
(1, 'Orange', 'Orange juteuse et vitaminée', 'Fruit', 'images/orange.jpg', 2.50, 5),
(2, 'Raisin', 'Raisin sucré et naturel', 'Fruit', 'images/raisin.jpg', 3.80, 0),
(3, 'Poire', 'Poire délicieuse et sucrée', 'Fruit', 'images/poire.jpg', 2.70, 10),
(4, 'Fraise', 'Fraises fraîches et savoureuses', 'Fruit', 'images/fraise.jpg', 4.50, 15),
(5, 'Banane', 'Banane mûre et énergétique', 'Fruit', 'images/banane.jpg', 1.80, 0),
(6, 'Mangue', 'Mangue exotique et sucrée', 'Fruit', 'images/mangue.jpg', 3.20, 10),
(7, 'Ananas', 'Ananas frais et désaltérant', 'Fruit', 'images/ananas.jpg', 2.90, 5),
(8, 'Chou', 'Chou vert croquant ', 'Légumes', 'images/chou.jpg', 3.00, 8),
(9, 'Pastèque', 'Pastèque rafraîchissante', 'Fruit', 'images/pastèque.jpg', 1.50, 0),
(10, 'Papaye', 'Papaye tropicale savoureuse', 'Fruit', 'images/papaye.jpg', 3.80, 5),
(11, 'Pomme', 'Pomme croquante et juteuse', 'Fruit', 'images/pomme.jpg', 2.50, 0),
(12, 'Concombre', 'Concombre bio', 'Légumes', 'images/concombre.jpg', 1.80, 4),
(13, 'Carotte', 'Carotte fraîche', 'Légumes', 'images/carotte.jpg', 2.00, 0),
(14, 'Tomate', 'Tomate fraîche', 'Légumes', 'images/tomate.jpg', 2.20, 15),
(15, 'Poivron', 'Poivron rouge frais', 'Légumes', 'images/poivron.jpg', 2.30, 7),
(16, 'Citron', 'Citron riche en vitamine C', 'Fruit', 'images/citron.jpg', 1.80, 0),
(17, 'Oignon', 'Oignon jaune doux', 'Légumes', 'images/oignon.jpg', 1.60, 5),
(18, 'Abricot', 'Abricot savoureux et sucré', 'Fruit', 'images/abricot.jpg', 2.90, 5),
(19, 'Cerise', 'Cerises fraîches et sucrées', 'Fruit', 'images/cerise.jpg', 4.80, 15),
(20, 'Aubergine', 'Aubergine fraîche', 'Légumes', 'images/aubergine.jpg', 2.50, 6);