<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/App/';

    // Est-ce que la classe utilise notre namespace ?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // pas notre namespace
    }

    // Extrait le nom de la classe relative
    $relative_class = substr($class, $len);

    // Construit le chemin complet du fichier
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

