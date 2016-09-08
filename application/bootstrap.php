<?php

// Load settings
require_once 'core/settings.php';

// Connect core files
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/paginator.php';

// Connect to database
require_once 'core/database.php';

// Include and start the router
require_once 'core/route.php';

Route::start();
