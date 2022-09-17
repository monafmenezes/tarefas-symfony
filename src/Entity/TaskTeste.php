<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class TaskTeste
{
    /**
     * @ORM\Id
     * @ORM\GenerateValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", Length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", Length=500)
     */
    private $description;

    /**
     * Get value id
     * @return int
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Get value title
     * @return string
     */

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Setter value title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get value description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Setter value description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
}