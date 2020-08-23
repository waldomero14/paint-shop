/** console.php **/
#!/usr/bin/env php

<?php
require_once __DIR__ . '/vendor/autoload.php';

use Console\ColorMixerCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new ColorMixerCommand());
$app->run();