<?php
require 'vendor/autoload.php';
use Phpml\ModelManager;
$filepath = 'retain_liner';
$modelManager = new ModelManager();
$restoredClassifier = $modelManager->restoreFromFile($filepath);
$ret = $restoredClassifier->predict([log(6)]);
echo exp($ret);
