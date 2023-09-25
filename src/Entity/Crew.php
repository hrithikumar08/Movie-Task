<?php

namespace App\Entity;
use App\Entity\Movie;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="crew")
 */
class Crew
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $crew_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $crew_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $crew_role;
   
    /**
     * @ORM\Column(type="integer")
     */
    private $movie_id;

    public function getCrewId(): int
    {
        return $this->crew_id;
    }

    public function setMovieId($movie_id): void
    {
        $this->movie_id = $movie_id;
    }

    public function getMovieId()
    {
        return $this->movie_id;
    }

    public function setCrewName(string $crew_name): void
    {
        $this->crew_name = $crew_name;
    }

    public function getCrewName(): string
    {
        return $this->crew_name;

    }

    public function setCrewRole(string $crew_role): void
    {
        $this->crew_role = $crew_role;
    }

    public function getCrewRole(): string
    {
        return $this->crew_role;

    }
  

}

?>
