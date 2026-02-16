<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$view = $app->make('view')->make('admin.pages.create')->render();
echo "rendered";
?>
