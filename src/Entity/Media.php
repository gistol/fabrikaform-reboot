<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 * @ORM\Table(name="medias")
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $legend;

    /**
     * @ORM\Column(type="string")
     */
    protected $image_url;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLegend()
    {
        return $this->legend;
    }

    public function getImage_url()
    {
        return $this->image_url;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setLegend($legend)
    {
        $this->legend = $legend;
        return $this;
    }

    public function setImage_url($image_url)
    {
        $this->image_url = $image_url;
        return $this;
    }
}
