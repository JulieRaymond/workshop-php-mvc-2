<?php

require_once 'config.php';
require __DIR__ . '/src/models/recipe-model.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $recipe = array_map('trim', $_POST);

    // Validate data
    if (empty($recipe['title'])) {
        $errors[] = 'The title is required';
    }
    if (empty($recipe['description'])) {
        $errors[] = 'The description is required';
    }
    if (!empty($recipe['title']) && strlen($recipe['title']) > 255) {
        $errors[] = 'The title should be less than 255 characters';
    }

    // Save the recipe
    if (empty($errors)) {
        saveRecipe($recipe);
        header('Location: /');
    }
}

// Generate the web page
require __DIR__ . '/src/views/form.php';

