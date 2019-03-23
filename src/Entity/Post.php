<?php
/**
 * Created by PhpStorm.
 * User: muhammadtaqi
 * Date: 3/22/19
 * Time: 10:02 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Post
 * @package App\Entity
 * @ORM\Table(name="tbl_posts")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=1024, nullable=true)
     */
    private $slug;
    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    private $published = false;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", length=255, nullable=true)
     */
    private $createdAt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", length=255, nullable=true)
     */
    private $updatedAt;
    ######################################
    ######     Getters Setters      ######
    ######################################

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    ##############################################################################################
    ############################### Callback Methods #############################################
    ##############################################################################################

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedDatetime()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    ######################################
    ###  Constructor and Other Methods ###
    ######################################

    /**
     *Result of this function is shown in Sonata Admin.
     *
     * @return string
     */
    public function __toString()
    {
        return  (string) $this->getTitle();
    }
}