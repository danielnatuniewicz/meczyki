<?php
namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;

class ArticleHelper
{
    private function validateString($string)
    {
        if(!isset($string)){
            return false;
        }

        if(empty($string)){
            return false;
        }

        return true;
    }

    public function validateTitleOrFail($title)
    {
        if(!$this->validateString($title)){
            throw new \Exception('Nie wprowadzono tytułu', Response::HTTP_CONFLICT);
        }

        return $title;
    }

    public function validateTextOrFail($text)
    {
        if(!$this->validateString($text)){
            throw new \Exception('Nie wprowadzono treści artykułu', Response::HTTP_CONFLICT);   
        }

        return $text;
    }
}