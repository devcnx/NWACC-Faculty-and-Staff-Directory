<?php

$root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');

global $url;
$url = filter_input(INPUT_SERVER, 'REQUEST_URI') ? filter_input(INPUT_SERVER, 'REQUEST_URI') : '/';
$dirs = explode('/', $url);

global $appPath;
$appPath = $dirs[1] . '/';

global $cssPath;
$cssPath = "{$appPath}public/css/";

global $jsPath;
$jsPath = "{$appPath}public/js/";

global $imgPath;
$imgPath = "{$appPath}public/img/";
