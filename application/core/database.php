<?php

try
{
    $GLOBALS['DB'] = new PDO('mysql:host=' . $GLOBALS['DB_HOST'] . ';dbname=' . $GLOBALS['DB_NAME'] . ';charset=utf8mb4', $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);
}
catch (Exception $ex)
{
    echo '<p>Error: Could not connect to database</p>';
    echo '<pre>' . $ex . '</pre>';
    die;
}
