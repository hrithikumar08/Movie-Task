<?php

namespace App\Entity;
use App\Entity\Movie;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie_media")
 */
class MovieMedia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $media_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_name;
   
    /**
     * @ORM\ManyToOne(targetEntity="Movie")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="movie_id", nullable=true)
     */
    private $movie_id;
    // : ?Movie
    public function getMovieId()
    {
    return $this->movie_id;
    }

    public function setMovieId($movie_id): void
    {
    $this->movie_id = $movie_id;
    }
    // ?Movie 

    public function getMediaId(): int
    {
        return $this->media_id;
    }
    
    public function getImageName(): string
    {
        return $this->image_name;

    }

    public function setImageName(string $image_name): void
    {
        $this->image_name = $image_name;
    }

  

    public function setVideoName(string $video_name): void
    {
        $this->video_name = $video_name;
    }

    public function getVideoName(): string
    {
        return $this->video_name;

    }
  

}

?>
