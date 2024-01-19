<?php

namespace App\File;

use \App\Utils\Converter;

class Image
{
    
    private $image;

    private $name;

    private $type;

    private $width;

    private $height;

    public function __construct($file)
    {
        //DADOS DA IMAGEM
        var_dump($file);
        $this->name = $file['name'];
        $this->type = $file['type'];

        //RESOURCE DA BIBLIOTECA GD
        $this->image = imagecreatefromstring(file_get_contents($file['tmp_name']));

        //ALTURA E LARGURA
        list($this->width,$this->height) = getimagesize($file['tmp_name']);
        


    }

    private function getPixel($x,$y)
    {
        $index = imagecolorat($this->image,$x,$y);
        return imagecolorsforindex($this->image,$index);
    }

    private function setPixel($x,$y,$red,$green,$blue)
    {
        $color = imagecolorallocate($this->image,$red,$green,$blue);
        return imagesetpixel($this->image,$x,$y,$color);
    }

    //Método responsável por esconder um texto na imagem
    public function setText($text) 
    {
        
        //TEXTO A SER ESCONDIDO
        $text = '>'.$text.'<';
        
        $position = 0;
        //NAVEGANDO POR TODOS OS PIXELS DA IMAGEM
        for($x = 0; $x < $this->width; $x++)
        {
            for($y = 0; $y < $this->height; $y++)
            {

                //VALIDA O TEXTO
                if(!isset($text[$position]))
                {
                    return true;
                }

                //CORES DO PIXELS
                $pixel = $this->getPixel($x, $y);
                $redBin = Converter::getDecBin($pixel['red']);
                $greenBin = Converter::getDecBin($pixel['green']);
                $blueBin = Converter::getDecBin($pixel['blue']);

                //TEXTO
                $char = $text[$position];
                $charBin = Converter::getCharBin($char);

                //SUBSTITUIÇÕES BINARIAS
                $redBin = substr($redBin, 0,5).substr($charBin,0,3);
                $greenBin = substr($greenBin, 0,6).substr($charBin,3,2);
                $blueBin = substr($blueBin, 0,5).substr($charBin,5,3);

                //CONVERÇÕES PARA DECIMAL
                $red = Converter::getBinDec($redBin);
                $green = Converter::getBinDec($greenBin);
                $blue = Converter::getBinDec($blueBin);

                //DEFINE A NOVA COR DO PIXEL
                $this->setPixel($x,$y,$red,$green,$blue);


                $position++;
            }
        }
        
    }

    public function getText()
    {
        $text = '';
        for($x = 0; $x < $this->width; $x++)
        {
            for($y = 0; $y < $this->height; $y++)
            {
                //CORES DO PIXELS
                $pixel = $this->getPixel($x, $y);
                $redBin = Converter::getDecBin($pixel['red']);
                $greenBin = Converter::getDecBin($pixel['green']);
                $blueBin = Converter::getDecBin($pixel['blue']);

                //CHAR
                $charBin = substr($redBin,5,3).substr($greenBin,6,2).substr($blueBin,5,3);

                $char = Converter::getBinChar($charBin);

                if($x == 0 && $y == 0 && $char != '>')
                {
                    die('none text');
                }

                if($char == '<')
                {
                    return $text;
                }

                $text .= $char != '>' ? $char : '';
            }
        }

        die('none text');
    } 

    public function download() 
    {
        header('Content-Type: image/png');
        header('Content-Length: ' . filesize($this->image));
        header('Content-Disposition: attachment; filename=imagem.png');
        imagepng($this->image);
        exit;
    }
}