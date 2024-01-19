<?php

require __DIR__. '/vendor/autoload.php';

use \App\File\Image;

if(isset($_POST['esconder']))
{
    var_dump($_POST);
    $obImage = new Image($_FILES['imagem']);
    $obImage->setText($_POST['texto']);
    $obImage->download();
}

$text = '';
if(isset($_POST['ler'])){
    $obImage = new Image($_FILES['imagem']);
    $text = $obImage->getText();
}

include __DIR__.'/includes/header.php';

include strlen($text) ?  __DIR__.'/includes/resultado.php' : __DIR__.'/includes/form.php';

include __DIR__.'/includes/footer.php';
