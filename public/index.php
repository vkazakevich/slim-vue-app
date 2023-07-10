<?php

$app = (require __DIR__ . '/../bootstrap/app.php');

(require __DIR__ . '/../src/Routes/api.php')($app);

$app->setBasePath('/api');
$app->run();