<?php

require __DIR__ . '/vendor/autoload.php';

use \App\File\Image;

if(isset($_POST['esconder']))
{
    $obImage = new Image($_FILES['imagem']);
}

include_once __DIR__ . '/includes/header.php';
include_once __DIR__ . '/includes/form.php';
include_once __DIR__ . '/includes/footer.php';