<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ArticleService;

class ArticleController extends AbstractController
{
    private $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleS = $articleService;
    }

    public function index(): Response
    {
        $articles = $this->articleS->getArticleList();

        return $this->render('article/index.html.twig', ['articles' => $articles]);
    }
    
    public function addArticle()
    {
        return $this->render('article/add.html.twig');
    }

    public function viewArticle($id)
    {
        try{
            $article = $this->articleS->getArticleByIdOrFail($id);

            return $this->render('article/view.html.twig', ['article' => $article]);
        }catch (\Exception $e) {
            return new Response('Nie znaleziono artykułu o podanym id' . $e->getMessage());
        }
    }

    public function viewTopAuthors()
    {
        try{
            $authors = $this->articleS->getTopAuthorsList();

            return $this->render('article/top-authors.html.twig', ['authors' => $authors]);
        }catch (\Exception $e) {
            return new Response('Wystąpił błąd' . $e->getMessage());
        }
    }

    public function editArticle($id)
    {
        try{
            $article = $this->articleS->getArticleByIdOrFail($id);

            return $this->render('article/edit.html.twig', ['article' => $article]);
        }catch (\Exception $e) {
            return new Response('Nie znaleziono artykułu o podanym id' . $e->getMessage());
        }
    }
}
