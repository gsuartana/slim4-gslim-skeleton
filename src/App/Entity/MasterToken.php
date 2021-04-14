<?php
namespace Gslim\App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Gslim\App\Repository\MasterTokenRepository")
 * @ORM\Table(name="master_token")
 */
class MasterToken
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash_key", type="string", length=255, nullable=true, options={"fixed"=true})
     */
    private $hashKey;

    /**
     * @var $expireDateTime
     *
     * @ORM\Column(name="expire_date_time")
     */
    private $expireDateTime;
    /**
     * @var $expireDateTime
     *
     * @ORM\Column(name="expire_unix_time")
     */
    private $expireUnixTim;
    /**
     * @var $expireDateTime
     *
     * @ORM\Column(name="status")
     */
    private $status;
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
     * Get Hash Key.
     *
     * @return string|null
     */
    public function getHashKey()
    {
        return $this->hashKey;
    }

    /**
     * Set Hash Key.
     *
     * @param string $hashKey
     *
     * @return Post
     */
    public function setHashKey($hashKey)
    {
        $this->hashKey = $hashKey;

        return $this;
    }
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
