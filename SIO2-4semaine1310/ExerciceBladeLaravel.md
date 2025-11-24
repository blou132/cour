### **Exercice : Mécanisme d'utilisation des Blades dans Laravel**


### **Contexte**
Vous allez créer un mini-site pour une bibliothèque en ligne. Le site aura :

    - Une page d'accueil (`index.blade.php`)

    - Une page de liste des livres (`books.blade.php`)

    - Une page de détail d'un livre (`book.blade.php`)

    - Un layout de base (`layout.blade.php`)


### **Structure des Fichiers**
Créez les fichiers suivants dans le dossier `resources/views/` :

```
/resources/views/
|__layout.blade.php
|__ index.blade.php
|__ books.blade.php
|__ book.blade.php
```


### **1. Fichier `layout.blade.php`**
Ce fichier servira de template de base pour toutes les pages.

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
     initial-scale=1.0">
    <title>@yield('title') - Ma Bibliothèque</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0;
         padding: 0; }
```

---

```php
        header { background: #333; color: #fff;
         padding: 1rem; }
        nav a { color: #fff; margin-right: 1rem; }
        main { padding: 2rem; }
        footer { background: #333; color: #fff;
         padding: 1rem;
         text-align: center; }
    </style>
</head>
```

---

```php
<body>
    <header>
        <h1>Ma Bibliothèque</h1>
        <nav>
            <a href="/">Accueil</a>
            <a href="/books">Livres</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        &copy; {{ date('Y') }} - Ma Bibliothèque        
    </footer>
</body>
</html>
```


### **2. Fichier `index.blade.php`**
Page d'accueil du site. 

```php
@extends('layout')

@section('title', 'Accueil')

@section('content')
    <h2>Bienvenue sur Ma Bibliothèque</h2>
    <p>Découvrez notre collection de livres.</p>
    <a href="/books">Voir tous les livres</a>
@endsection
```


### **3. Fichier `books.blade.php`**
Page listant tous les livres. 

```php
@extends('layout')
@section('title', 'Liste des Livres')
@section('content')
    <h2>Liste des Livres</h2>
    <ul>
        @foreach($books as $book)
            <li>
                <a href="/book?id={{ $book['id'] }}">
                    {{ $book['title'] }} 
                    ({{ $book['author'] }})
                </a>
            </li>
        @endforeach
    </ul>
@endsection
```


### **4. Fichier `book.blade.php`**
Page de détail d'un livre.

```php
@extends('layout')

@section('title', $book['title'])

@section('content')
   <h2>{{ $book['title'] }}</h2>
   <p><strong>Auteur :</strong> {{ $book['author'] }}</p>
   <p><strong>Année :</strong> {{ $book['year'] }}</p>
   <p><strong>Résumé :</strong> {{ $book['summary'] }}</p>
   <a href="/books">Retour à la liste</a>
@endsection
```


### **5. Création des données avec seeder/Tinker/le CRUD ...**

```php
// Exemple de données pour les livres
$books = [
    ['id' => 1,
     'title' => 'Le Petit Prince',
     'author' => 'Antoine de Saint-Exupéry',
     'year' => 1943,
     'summary' => 'Un conte poétique et philosophique...'],
    ['id' => 2,
     'title' => '1984',
     'author' => 'George Orwell',
     'year' => 1949,
     'summary' => 'Une dystopie sur la surveillance 
        et le totalitarisme...'],
];
```


### Travaux pratiques:

- Ajouter le jour et le mois dans le footer
- Tâcher de le "Franciser"
- Dans le contenu, créer une condition qui affiche le jour tel que "Aujourd'hui, c'est Mercredi!"
- Ajouter dans le footer la version de framework Laravel et la version de PHP
- Grâce à la  commande bash "date +%s" et à ```php"Illuminate\Support\Carbon::now()->timestamp"```, utiliser une condition qui affiche un composant avec pour message "Ceci est un message d'erreur." dans un certain lapse de temps


