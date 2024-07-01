<?php
    
    // En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
    session_start();

    // Ici on met les constantes utiles, 
    // les données de connexions à la bdd
    // et tout ce qui sert à configurer. 

const TEMPLATE_VIEW_PATH = './views/templates/'; // Le chemin vers les templates de vues.
const MAIN_VIEW_PATH = TEMPLATE_VIEW_PATH . 'main.php'; // Le chemin vers le template principal.

const DB_HOST = 'localhost';
const DB_NAME = 'tomtroc';
const DB_USER = 'root';
const DB_PASS = '';

