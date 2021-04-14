<?php
namespace Gslim\App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Gslim\App\Repository\PregReplaceRepository")
 * @ORM\Table(name="Tablename")
 */
class PregReplace 
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var $created
     *
     * @ORM\Column(name="created_at")
     */
    private $created;
    /**
     * @var $updated
     *
     * @ORM\Column(name="updated_at")
     */
    private $updated;
    /*
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true, options={"fixed"=true})
     private $name;
    */
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Name.
     *
     * @return string|null
     */
   /* public function getName()
    {
        return $this->name;
    }*/

    /**
     * Set Name.
     *
     * @param string $name
     *
     * @return Post
     */
    /*public function setName($name)
    {
        $this->name = $name;

        return $this;
    }*/

    /**
     * @param $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->created;
    }
}
