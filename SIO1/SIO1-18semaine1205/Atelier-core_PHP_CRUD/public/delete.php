<?php

require_once __DIR__ . '/../autoload.php';

use App\User;

(new User())->delete($_GET['id']);
header("Location: index.php");

