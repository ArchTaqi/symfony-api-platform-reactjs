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
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Interfaces\AuthoredEntityInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Post
 * @package App\Entity
 * @ApiResource(routePrefix="/v1",
 *     itemOperations={
 *          "get"={"method"="GET", "path"="/posts/{id}", "requirements"={"id"="\d+"}, "defaults"={"color"="brown"}, "options"={"my_option"="my_option_value"}, "access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *         "put"={"method"="PUT", "path"="/posts/{id}/update", "hydra_context"={"foo"="bar"}, "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getAuthor() === user"},
 *      },
 *      collectionOperations={
 *          "get"={"method"="GET", "path"="/posts"},
 *          "post"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}
 *     },
 *     normalizationContext={"groups"={"read", "post-user"}},
 *     denormalizationContext={"post"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}, "read"}
 * )
 * @ORM\Table(name="tbl_posts")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Post implements AuthoredEntityInterface
{
    use TimeTrackerTrait;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"read"})
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $title;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Groups({"read"})
     */
    private $content;
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=1024, nullable=true)
     * @Groups({"read"})
     */
    private $slug;
    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     * @Groups({"read"})
     */
    private $published = false;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource()
     * @Groups("post-user")
     */
    private $author;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post")
     * @ApiSubresource()
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
     * @return User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param UserInterface $author
     * @return AuthoredEntityInterface
     */
    public function setAuthor(UserInterface $author): AuthoredEntityInterface
    {
        $this->author = $author;
        return $this;
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