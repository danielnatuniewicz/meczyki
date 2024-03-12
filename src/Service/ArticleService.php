<?php 
namespace App\Service;

use App\Entity\Article;
use App\Entity\ArticleAuthor;
use App\Entity\User;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;

class ArticleService
{
    private $articleRepository;
    private $userRepository;
    private $date;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;

        $this->em = $entityManager;

        $this->date = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
    }

    public function getArticleList()
    {
        return $this->articleRepository->findAll();
    }

    public function getArticleByIdOrFail(int $id)
    {   
        $article = $this->articleRepository->findOneById($id);
    
        if(!$article){
            throw new \Exception('Nie znaleziono artykułu o podanym id', Response::HTTP_CONFLICT);
        }

        return $article;
    }

    public function getTopAuthorsList()
    {
        return $this->articleRepository->findTopAuthorsLastWeek();
    }

    public function createArticle(User $user, $data): Article
    {
        $article = new Article();
        $article->setTitle($data['title']);
        $article->setText($data['text']);
        $article->setCreationDate($this->date);
        
        $articleAuthor = new ArticleAuthor();
        $articleAuthor->addAuthor($user);

        $article->addArticleAuthor($articleAuthor);

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    public function editArticle(User $user, Article $article, $data): Article
    {
        $article->setTitle($data['title']);
        $article->setText($data['text']);

        $authorExist = false;

        foreach($article->getArticleAuthors() as $articleAuthor){
            foreach ($articleAuthor->getAuthor() as $author) {
                if($author->getId() == $user->getId()){
                    $authorExist = true;
                    break 2;
                }
            }
        }
        
        if(!$authorExist){
            $articleAuthor = new ArticleAuthor();
            $articleAuthor->addAuthor($user);
            
            $article->addArticleAuthor($articleAuthor);
        }

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    public function getAuthorArticlesById($userId)
    {
        $user = $this->userRepository->findOneById($userId);
        
        return $user->getArticleAuthors();
    }
}