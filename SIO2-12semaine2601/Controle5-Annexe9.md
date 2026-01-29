# TP Évaluation - Administration Système et Réseau

     - Durée : 1 semaine
     - Environnement : 2 VMs (Client + Serveur Apache/PHP/MySQL)
     - Contexte : Contrôle 5 - Annexe 9

---

## 📌 Objectifs Pédagogiques
Ce TP permet d'évaluer les compétences suivantes dans un environnement virtualisé :

- **Déploiement d'une pile LAMP** avec authentification HTTP
- **Gestion d'un outil de ticketing** (GLPI)
- **Automatisation des sauvegardes** avec scripts shell
- **Planification de tâches** via crontab
- **Chiffrement asymétrique** avec GPG
- **Analyse de trafic réseau** (Wireshark/tcpdump)
- **Sécurisation proactive** avec Fail2ban (3 jails personnalisées)

---

## 🛠️ Prérequis Techniques

### Infrastructure Virtualisée

- **2 Machines Virtuelles** (VirtualBox/VMware) :

  - **Serveur** : Ubuntu Server
    - IP Statique : `192.168.56.111/24`
    - Services : Apache2, PHP 8.x, MySQL, GLPI, Fail2ban
  - **Client** : Linux Mint Desktop
    - IP Dynamique : `192.168.56.XXX/24`
    - Outils : Navigateur, Wireshark, GPG, OpenSSH-Server


## 📋 Partie 1 : Pile LAMP avec Authentification

- Installation des Composants

- Configuration d'Apache et de MySQL pour core PHP (80) et GLPI (8080)


## 📋 Partie 2 : Core PHP POO pour Authentification

### 2.1 Structure du Projet
```bash
# Sur le serveur
cd /var/www/html
sudo mkdir auth_system
sudo chown -R www-data:www-data auth_system
cd auth_system
```

### 2.2 Base de Données pour l'Authentification
```bash
sudo mysql -u root -p
```
```sql
CREATE DATABASE auth_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'auth-user'@'localhost' IDENTIFIED BY 'AuthP@ss2026!';
GRANT ALL PRIVILEGES ON auth_db.* TO 'auth-user'@'localhost';
FLUSH PRIVILEGES;

USE auth_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(50),
    ip_address VARCHAR(45),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 2.3 Structure des Fichiers PHP
```bash
# Créer la structure
sudo mkdir -p /var/www/html/auth_system/{app,public,config}
sudo touch /var/www/html/auth_system/app/{Database.php,Auth.php,User.php}
sudo touch /var/www/html/auth_system/public/{index.php,register.php,login.php,home.php,logout.php}
sudo touch /var/www/html/auth_system/config/config.php
```

### 2.4 Fichier de Configuration
Éditer `/var/www/html/auth_system/config/config.php` :
```php
<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'auth-user');
define('DB_PASS', 'AuthP@ss2026!');
define('DB_NAME', 'auth_db');

// Chemins
define('APP_ROOT', dirname(__DIR__));
define('URL_ROOT', 'https://192.168.1.10/auth_system/public');

// Clé de chiffrement (pour les tokens)
define('APP_KEY', bin2hex(random_bytes(32)));

// Paramètres de sécurité
define('SESSION_TIMEOUT', 1800); // 30 minutes
```

### 2.5 Classe Database (POO)
Éditer `/var/www/html/auth_system/app/Database.php` :
```php
<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $error;
    private $stmt;

    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Log database actions
    public function logAction($userId, $action, $ip) {
        $this->query('INSERT INTO logs (user_id, action, ip_address) VALUES (:user_id, :action, :ip)');
        $this->bind(':user_id', $userId);
        $this->bind(':action', $action);
        $this->bind(':ip', $ip);
        $this->execute();
    }
}
```

### 2.6 Classe User (POO)
Éditer `/var/www/html/auth_system/app/User.php` :
```php
<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)');
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_BCRYPT));
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role'] ?? 'user');

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($row && password_verify($password, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }

    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    // Get all users
    public function getAllUsers() {
        $this->db->query('SELECT * FROM users');
        return $this->db->resultSet();
    }
}
```

### 2.7 Classe Auth (Gestion des Sessions)
Éditer `/var/www/html/auth_system/app/Auth.php` :
```php
<?php
class Auth {
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check() {
        self::startSession();
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function user() {
        self::startSession();
        if (isset($_SESSION['user_id'])) {
            $user = new User();
            return $user->getUserById($_SESSION['user_id']);
        }
        return null;
    }

    public static function attempt($username, $password) {
        $user = new User();
        $loggedInUser = $user->login($username, $password);

        if ($loggedInUser) {
            self::startSession();
            $_SESSION['user_id'] = $loggedInUser->id;
            $_SESSION['username'] = $loggedInUser->username;
            $_SESSION['role'] = $loggedInUser->role;
            $_SESSION['last_activity'] = time();

            // Log the login action
            $db = new Database();
            $db->logAction($loggedInUser->id, 'login', $_SERVER['REMOTE_ADDR']);

            return true;
        }
        return false;
    }

    public static function logout() {
        self::startSession();
        
        // Log the logout action
        if (isset($_SESSION['user_id'])) {
            $db = new Database();
            $db->logAction($_SESSION['user_id'], 'logout', $_SERVER['REMOTE_ADDR']);
        }

        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();
    }

    public static function checkSessionTimeout() {
        self::startSession();
        if (isset($_SESSION['last_activity'])) {
            $inactive = time() - $_SESSION['last_activity'];
            if ($inactive > SESSION_TIMEOUT) {
                self::logout();
                return true;
            }
        }
        $_SESSION['last_activity'] = time();
        return false;
    }

    public static function isAdmin() {
        self::startSession();
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}
```

### 2.8 Fichier d'Initialisation
Créer `/var/www/html/auth_system/public/init.php` :
```php
<?php
// Load config
require_once '../config/config.php';

// Autoload classes
spl_autoload_register(function ($className) {
    require_once '../app/' . $className . '.php';
});

// Start session
Auth::startSession();

// Check session timeout
if (Auth::check()) {
    Auth::checkSessionTimeout();
}
```

### 2.9 Page d'Accueil (Index)
Éditer `/var/www/html/auth_system/public/index.php` :
```php
<?php
require_once 'init.php';

// Redirect to login if not authenticated
if (!Auth::check()) {
    header('Location: login.php');
    exit;
}

// Redirect to homepage if authenticated
header('Location: home.php');
exit;
```

### 2.10 Page de Connexion
Éditer `/var/www/html/auth_system/public/login.php` :
```php
<?php
require_once 'init.php';

// Redirect if already logged in
if (Auth::check()) {
    header('Location: home.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';
    } else {
        if (Auth::attempt($username, $password)) {
            header('Location: home.php');
            exit;
        } else {
            $error = 'Identifiants incorrects';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système d'Authentification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 300px; margin: 100px auto; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-bottom: 15px; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Se connecter</button>
        </form>
        
        <div class="link">
            <a href="register.php">Créer un compte</a>
        </div>
    </div>
</body>
</html>
```

### 2.11 Page d'Inscription
Éditer `/var/www/html/auth_system/public/register.php` :
```php
<?php
require_once 'init.php';

// Redirect if already logged in
if (Auth::check()) {
    header('Location: home.php');
    exit;
}

$error = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Veuillez remplir tous les champs';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères';
    } else {
        $user = new User();
        
        // Check if username or email already exists
        if ($user->findUserByUsername($username)) {
            $error = 'Ce nom d\'utilisateur est déjà pris';
        } elseif ($user->findUserByEmail($email)) {
            $error = 'Cet email est déjà utilisé';
        } else {
            // Register user
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => 'user'
            ];
            
            if ($user->register($data)) {
                header('Location: login.php?registered=1');
                exit;
            } else {
                $error = 'Erreur lors de l\'inscription';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Système d'Authentification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 300px; margin: 100px auto; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; margin-bottom: 15px; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">S'inscrire</button>
        </form>
        
        <div class="link">
            <a href="login.php">Déjà un compte ? Se connecter</a>
        </div>
    </div>
</body>
</html>
```

### 2.12 Page d'Accueil (Home)
Éditer `/var/www/html/auth_system/public/home.php` :
```php
<?php
require_once 'init.php';

// Redirect to login if not authenticated
if (!Auth::check()) {
    header('Location: login.php');
    exit;
}

$user = Auth::user();
$users = (new User())->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Système d'Authentification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .header { background: #343a40; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 20px; }
        .welcome { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .users-table { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .btn { padding: 8px 15px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #c82333; }
        .admin-badge { background: #28a745; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
        .user-badge { background: #007bff; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Système d'Authentification</h1>
        <div>
            <span>Connecté en tant que <?php echo htmlspecialchars($user->username); ?> 
                (<?php echo htmlspecialchars($user->role); ?>)</span>
            <a href="logout.php" class="btn" style="margin-left: 15px;">Déconnexion</a>
        </div>
    </div>
    
    <div class="content">
        <div class="welcome">
            <h2>Bienvenue, <?php echo htmlspecialchars($user->username); ?> !</h2>
            <p>Vous êtes connecté avec succès au système d'authentification.</p>
            <p>Email : <?php echo htmlspecialchars($user->email); ?></p>
            <p>Compte créé le : <?php echo date('d/m/Y H:i', strtotime($user->created_at)); ?></p>
        </div>
        
        <?php if (Auth::isAdmin()): ?>
        <div class="users-table">
            <h2>Liste des utilisateurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->id; ?></td>
                        <td><?php echo htmlspecialchars($user->username); ?></td>
                        <td><?php echo htmlspecialchars($user->email); ?></td>
                        <td>
                            <span class="<?php echo $user->role; ?>-badge">
                                <?php echo htmlspecialchars($user->role); ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($user->created_at)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
```

### 2.13 Page de Déconnexion
Éditer `/var/www/html/auth_system/public/logout.php` :
```php
<?php
require_once 'init.php';

Auth::logout();

header('Location: login.php?logout=1');
exit;
```

### 2.14 Configuration d'Apache pour le Core PHP et Test du Système

**Accéder à l'application** :

    - Depuis le client : `https://192.168.1.111/login.php`
    - S'inscrire avec un nouvel utilisateur
    - Se connecter avec cet utilisateur
    - Se déconnecter
---


## 📋 Partie 3 : Sauvegarde et Planification

### 3.1 Script de Sauvegarde Adapté au Core PHP dans la VM client (Serveur SSH/GPG)

### 3.2 Planification avec Cron

### 3.3 Vérification des Sauvegardes


## 📋 Partie 4 : Chiffrement avec GPG

### 4.1 Chiffrement des Sauvegardes

### 4.2 Script de Chiffrement Automatisé

Ajouter au script de sauvegarde (avant la fin) :


## 📋 Partie 5 : Analyse Réseau avec Wireshark/tcpdump

### 5.1 Capture du Trafic vers le Core PHP

- Capture spécifique aux requêtes vers le système d'authentification

- Capture des requêtes POST (connexions)


### 5.2 Analyse des Requêtes d'Authentification
Dans Wireshark :

1. Filtrer les requêtes POST : `http.request.method == POST`
2. Identifier les requêtes vers `/login.php` et `/register.php`
3. Analyser les headers et payloads
4. Exporter les paquets pertinents


## 📋 Partie 6 : Fail2ban avec 3 Jails pour le Core PHP

### 6.1 Configuration des Jails pour le Core PHP

Éditer `/etc/fail2ban/jail.local`

# ============================================
# JAIL 1 : Protection SSH (Standard)
# ============================================

# ============================================
# JAIL 2 : Protection des tentatives de connexion
# ============================================
 - maxretry = 3
 - findtime = 1m
 - bantime = 1m

# ============================================
# JAIL 3 : Protection contre les scans de vulnérabilités
# ============================================
[auth-scan]
enabled = true
port = http,https
filter = auth-scan
logpath = /var/log/apache2/auth_access.log
maxretry = 5
bantime = 1h


### 6.2 Création des Filtres Personnalisés

    - Filtre pour les échecs de connexion

    - Filtre pour les scans 

### 6.3 Test des Jails

    - Simuler des attaques

    - Vérifier les bannissements


## 📌 Livrables à Rendre (Mis à Jour)

  1. Introduction (objectifs, environnement)
  2. Schéma d'architecture réseau
  3. Architecture du core PHP (diagramme de classes)
  4. Procédures détaillées pour chaque partie (git commit)
  5. Captures d'écran :
     - Page de login/register
     - Tableau de bord admin
     - Logs Fail2ban
     - Analyse Wireshark
     - Capture d'écran de la base de données (`SELECT * FROM users;`)
     - Sortie de `sudo fail2ban-client status` (3 jails actives)
     - Preuve de bannissement après attaque simulée
     - Liste des backups (dans le serveur SSH/GPG - côté client)
     - Fichier GPG chiffré (avec passphrase de déchiffrage)

### Ressources Externes

- [Documentation officielle GLPI](https://glpi-install.readthedocs.io/)
- [Guide Fail2ban](https://www.fail2ban.org/wiki/index.php/Main_Page)
- [Tutoriel GPG](https://www.gnupg.org/gph/fr/manual.html)
- [Wireshark Display Filters](https://wiki.wireshark.org/DisplayFilters)

---

## 📝 Notes Pédagogiques

- **Sauvegardes régulières** des VMs (git recommandé)
- **Respect des bonnes pratiques** : pas de mots de passe en clair dans les scripts
- **Créativité encouragée** : personnalisation des jails Fail2ban, scripts avancés

---

**Fin du TP - Bonne chance !** 🚀
