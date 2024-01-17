<?php

namespace App\File;

class Image
{
    /**
     * Resource de imagem da bib. GD
     * @var resource
     */
    private $image;

    private $name;

    private $type;

    private $width;

    private $height;

    public function __construct($file)
    {
        //DADOS DA IMAGEM
        $this->name = $file['name'];
        $this->type = $file['type'];

        //RESOURCE DA BIBLIOTECA GD
        $this->image = imagecreatefromstring(file_get_contents($file['tmp_name']));

        //ALTURA E LARGURA
        list($this->width,$this->height) = getimagesize($file['tmp_name']);


    }
}