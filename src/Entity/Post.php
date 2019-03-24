<?php
/**
 * Created by PhpStorm.
 * User: muhammadtaqi
 * Date: 3/22/19
 * Time: 10:02 PM
 */

namespace App\Entity;

use App\Traits\TimeTrackerTrait;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class Post
 * @package App\Entity
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"},
 *     denormalizationContext={"groups"={"post", "read"}}
 * )
 * @ORM\Table(name="tbl_posts")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    use TimeTrackerTrait;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post")
     */
    private $comments;
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
    public function getTitle(): ?string
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
    public function getContent(): ?string
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
    public function getSlug(): ?string
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
    public function isPublished(): ?bool
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
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    ##############################################################################################
    ############################### Callback Methods #############################################
    ##############################################################################################

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->setDateCreated(new \DateTime());
        $this->preUpdate();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setDateUpdated(new \DateTime());
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