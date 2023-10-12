<?php
require_once __DIR__ . '/../../config.php';
require __DIR__ . '/../models/recipe-model.php';

function browseRecipes(): void
{
    $recipes = getAllRecipes();

    require __DIR__ . '/../views/indexRecipe.php';
}

function showRecipe($id)
{
    // Récupére l'ID de la recette depuis la requête
    if (empty($id)) {
        header("HTTP/1.1 404 Not Found");
        die("Paramètre d'entrée incorrect");
    }

    // Récupération d'une recette
    $recipe = getRecipeById($id);

    // Vérification des résultats de la base de données
    if (!isset($recipe['title']) || !isset($recipe['description'])) {
        header("HTTP/1.1 404 Not Found");
        die("Recette introuvable");
    }

    // Génére la page web
    require __DIR__ . '/../views/showRecipe.php';
}


function addRecipe()
{
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        // Récupére les données du formulaire
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Valide les données
        if (empty($title)) {
            $errors[] = 'Le titre est requis';
        }
        if (empty($description)) {
            $errors[] = 'La description est requise';
        }
        if (strlen($title) > 255) {
            $errors[] = 'Le titre doit comporter moins de 255 caractères';
        }

        // Si aucune erreur de validation, enregistre la recette
        if (empty($errors)) {
            // Appele la fonction de modèle pour enregistrer la recette
            $recipe = [
                'title' => $title,
                'description' => $description,
            ];
            saveRecipe($recipe);

            // Redirige vers la page d'accueil
            header('Location: /');
        }
    }

    // Charge la vue du formulaire avec les erreurs éventuelles
    require __DIR__ . '/../views/form.php';
}
