<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ArticleService;
use App\Helper\ArticleHelper;
use App\Helper\JsonHelper;

class ApiArticleController extends AbstractController
{
    public function __construct(ArticleService $articleService, JsonHelper $jsonHelper, ArticleHelper $articleHelper)
    {
        $this->articleS = $articleService;
        $this->articleH = $articleHelper;
        $this->jsonH = $jsonHelper;
    }

    public function addArticle(Request $request)
    {
        try{
            $user = $this->getUser();
            
            $jsonData = $request->getContent();

            $jsonSchema = [
                'title' => 'string',
                'text' => 'string'
            ];

            $data = $this->jsonH->decodeAndValidate($jsonData, $jsonSchema);

            $this->articleH->validateTitleOrFail($data['title']);
            $this->articleH->validateTextOrFail($data['text']);
            
            $this->articleS->createArticle($this->getUser(), $data);

            return new JsonResponse([
                'status' => Response::HTTP_OK,
                'message' => 'Pomyślnie dodano artykuł'
            ]);
        }catch(\Exception $e){
            return new JsonResponse([
                'status' => Response::HTTP_CONFLICT,
                'message' => $e->getMessage() //In a production environment, I would verify the server output
            ]);
        }
    }

    public function editArticle($id, Request $request)
    {
        try{
            $article = $this->articleS->getArticleByIdOrFail($id);

            $user = $this->getUser();
            
            $jsonData = $request->getContent();

            $jsonSchema = [
                'title' => 'string',
                'text' => 'string'
            ];

            $data = $this->jsonH->decodeAndValidate($jsonData, $jsonSchema);

            $this->articleH->validateTitleOrFail($data['title']);
            $this->articleH->validateTextOrFail($data['text']);
            
            $this->articleS->editArticle($this->getUser(), $article, $data);

            return new JsonResponse([
                'status' => Response::HTTP_OK,
                'message' => 'Pomyślnie zeedytowano artykuł'
            ]);
        }catch(\Exception $e){
            return new JsonResponse([
                'status' => Response::HTTP_CONFLICT,
                'message' => $e->getMessage() //In a production environment, I would verify the server output
            ]);
        }
    }

    public function getAuthorArticles($id, Request $request)
    {
        $articles = $this->articleS->getAuthorArticlesById($id);
    
        $array = array();

        foreach($articles as $article)
        {
            $userArray = array();
            foreach($article->getUsers() as $author){
                $userArray[] = ['username' => $author->getUsername()];
            }
            
            $array[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(), 
                'text' => $article->getText(),
                'authors' => $userArray];
        }
        
        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'message' => 'Pomyślnie pobrano listę artykułów',
            'articles' => $array,
        ]);
    }
    
    public function getTopAuthors()
    {
        $authors = $this->articleS->getTopAuthorsList();

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'message' => 'Pomyślnie pobrano listę artykułów',
            'topAuthors' => $authors,
        ]);
    }

    public function getArticle($id)
    {
        try{
            $article = $this->articleS->getArticleByIdOrFail($id);

            $userArray = array();

            foreach ($article->getUsers() as $author) {
                $userArray[] = ['id' => $author->getId(), 'username' => $author->getUsername()];
            }

            return new JsonResponse([
                'status' => Response::HTTP_OK,
                'message' => 'Pomyślnie pobrano artykuł',
                'article' => [
                    'id' => $article->getId(),
                    'title' => $article->getTitle(),
                    'text' => $article->getText(),
                    'authors' => $userArray
                ]
            ]);
        }catch (\Exception $e) {
            return new JsonResponse([
                'status' => Response::HTTP_CONFLICT,
                'message' => $e->getMessage()
            ]);
        }
    }
}
