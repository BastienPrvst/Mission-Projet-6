<?php

/**
 * Système d'autoload. 
 * A chaque fois que PHP va avoir besoin d'une classe, il va appeler cette fonction 
 * et chercher dnas les divers dossiers (ici models, controllers, views, services) s'il trouve 
 * un fichier avec le bon nom. Si c'est le cas, il l'inclut avec require_once.
 */
spl_autoload_register(function($className) {
    // On va voir dans le dossier Service si la classe existe.
    if (file_exists('services/' . $className . '.php')) {
        require_once 'services/' . $className . '.php';
    }

    // On va voir dans le dossier Model si la classe existe.
    if (file_exists('models/' . $className . '.php')) {
        require_once 'models/' . $className . '.php';
    }

    //J'ajoute ceci pour trouver mes repository
    if (file_exists('src/repository/' . $className . '.php' )){
        require_once 'src/repository/' . $className . '.php';
    }

    //Et pour les entités
    if (file_exists('src/entity/' . $className . '.php' )){
        require_once 'src/entity/' . $className . '.php';
    }

    // On va voir dans le dossier Controller si la classe existe.
    if (file_exists('src/controllers/' . $className . '.php')) {
        require_once 'src/controllers/' . $className . '.php';
    }

    // On va voir dans le dossier View si la classe existe.
    if (file_exists('views/' . $className . '.php')) {
        require_once 'views/' . $className . '.php';
    }
});