<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie_rating")
 */
class MovieRating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $rating_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $rating;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $movie_id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $comment_date;

    public function getRatingId(): int
    {
        return $this->rating_id;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getComment(): string
    {
        return $this->comment;

    }

    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;

    }

    public function setMovieId($movie_id): void
    {
        $this->movie_id = $movie_id;
    }

    public function getMovieId()
    {
        return $this->movie_id;

    }

    public function setCommentDate(\DateTimeInterface $comment_date): self
    {
        $this->comment_date = $comment_date;
        return $this;
    }

    public function getCommentDate(): ?\DateTimeInterface
    {
        return $this->comment_date;
    }

}

?>



