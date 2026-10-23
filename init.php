<?php

    // start session
    session_start();

    // Include the main configuration file
    require_once "config/config.php";

    // Load database
    require_once "classes/Database.php";

    // Include helper function
    require_once "helpers.php";

    // Define global constants
    define("APP_NAME", "CMS PDO System");

?>