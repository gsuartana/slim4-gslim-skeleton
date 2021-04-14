<?php
namespace Gslim\App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Gslim\App\Repository\ErrorRecorderRepository")
 * @ORM\Table(name="error_recorder")
 */
class ErrorRecorder
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
    * @ORM\Column(name="type", type="string", length=255, nullable=true)
    */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;
    /**
     * @var string
     *
     * @ORM\Column(name="source", type="text")
     */
    private $source; 
    /**
     * @var string
     *
     * @ORM\Column(name="userAgent", type="text")
     */
    private $userAgent;
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="text")
     */
    private $location;
    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created;
    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
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
     * Provide error type
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set error type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Provide error message
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->type;
    }

    /**
     * Set error message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Provide error source
     *
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * Set error message
     *
     * @param string $source
     * @return $this
     */
    public function setSource(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Provide error user agent
     *
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * Set error user agent
     *
     * @param string $userAgent
     * @return $this
     */
    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Provide error location
     *
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * Set error location
     *
     * @param string $location
     * @return $this
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Set created datetime
     *
     * @param $created
     * @return $this
     */
    public function setCreated($created): self
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Provide created datetime
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated date
     *
     * @param $updated
     * @return $this
     */
    public function setUpdated($updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Provide updated datetime
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
