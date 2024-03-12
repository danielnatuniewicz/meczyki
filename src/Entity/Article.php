<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\ManyToMany(targetEntity: ArticleAuthor::class, mappedBy: 'article', cascade: ['persist'])]
    private Collection $articleAuthors;

    public function __construct()
    {
        $this->author = new ArrayCollection();
        $this->articleAuthors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection<int, ArticleAuthor>
     */
    public function getArticleAuthors(): Collection
    {
        return $this->articleAuthors;
    }

    public function addArticleAuthor(ArticleAuthor $articleAuthor): static
    {
        if (!$this->articleAuthors->contains($articleAuthor)) {
            $this->articleAuthors->add($articleAuthor);
            $articleAuthor->addArticle($this);
        }

        return $this;
    }

    public function removeArticleAuthor(ArticleAuthor $articleAuthor): static
    {
        if ($this->articleAuthors->removeElement($articleAuthor)) {
            $articleAuthor->removeArticle($this);
        }

        return $this;
    }
}
