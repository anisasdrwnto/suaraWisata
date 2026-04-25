<?php
echo "PHP version: " . phpversion() . "<br>";
echo "mysqli loaded: " . (extension_loaded('mysqli') ? 'YES' : 'NO') . "<br>";
echo "pdo_mysql loaded: " . (extension_loaded('pdo_mysql') ? 'YES' : 'NO') . "<br>";