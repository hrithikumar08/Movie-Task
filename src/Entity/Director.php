<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="director_details")
 */
class Director
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $director_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $director_name;

    public function getDirectorId()
    {
        return $this->director_id;
    }

    public function setDirectorName($director_name): void
    {
        $this->director_name = $director_name;
    }

    public function getDirectorName()
    {
        return $this->director_name;

    }

}

?>
