<?php

/* @var $this yii\web\View */
$this->title = 'My Yii Application';

?>

<div id="app"></div>

<?php
$dist = '/web/static/js/';
$dir = Yii::getAlias('@app') . $dist;
$files = scandir($dir);
$js = [
    'manifest',
    'vendor',
    'app'
];
foreach ($js as $a) {
    $this->registerJsFile($dist . implode('', preg_grep('~^' . $a . '.*\.(js)$~', $files)));
}
