<?php

namespace App\Entity;

use App\Traits\TimeTrackerTrait;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * ORM\Table(name="tbl_likes", indexes={ORM\Index(name="user_post_udx", columns={"user_id, post_id"})})
 * Class Like
 * @package App\Entity
 * @ApiResource
 * @ORM\Table(name="tbl_likes")
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Like
{
    use TimeTrackerTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $post;
    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    ######################################
    ######     Getters Setters      ######
    ######################################

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    ######################################
    ######     Callback Methods     ######
    ######################################

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
}
