<?php

namespace App\Entity;
use App\Entity\Director;
use App\Entity\Category;
use App\Entity\MovieMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie")
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $movie_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $director_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addeddate;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descript;

    
    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;

    }

    public function setDirectorId($director_id): void
    {
        $this->director_id = $director_id;
    }

    public function getDirectorId()
    {
        return $this->director_id;
    }

    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
    }

    public function getCategoryId()
    {
        return $this->category_id;

    }

    // public function setDirectorId(Director $director_id = null): void
    // {
    //     $this->director_id = $director_id;
    // }
    
    // public function getDirectorId(): ?Director
    // {
    //     return $this->director_id;
    // }
    
    // public function setCategoryId(Category $category_id = null): void
    // {
    //     $this->category_id = $category_id;
    // }
    
    // public function getCategoryId(): ?Category
    // {
    //     return $this->category_id;
    // }
    
    public function setBudget(int $budget): void
    {
        $this->budget = $budget;
    }

    public function getBudget(): int
    {
        return $this->budget;

    }

    public function setAddedDate(\DateTimeInterface $addeddate): self
    {
        $this->addeddate = $addeddate;
        return $this;
    }

    public function getAddedDate(): ?\DateTimeInterface
    {
        return $this->addeddate;
    }

    public function setDescript(string $descript): void
    {
        $this->descript = $descript;
    }

    public function getDescript(): string
    {
        return $this->descript;
        return $this;

    }


}

?>
