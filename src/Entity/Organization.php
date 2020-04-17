<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Traits\TimeTrackerTrait;

//* @ApiResource(routePrefix="/v1",
// *     itemOperations={
//    *          "get"={"method"="GET", "path"="/posts/{id}", "requirements"={"id"="\d+"}, "defaults"={"color"="brown"}, "options"={"my_option"="my_option_value"}, "access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
// *         "put"={"method"="PUT", "path"="/posts/{id}/update", "hydra_context"={"foo"="bar"}, "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getAuthor() === user"},
// *      },
// *      collectionOperations={
//    *          "get"={"method"="GET", "path"="/posts"},
// *          "post"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}
// *     },
// *     normalizationContext={"groups"={"read", "post-user"}},
// *     denormalizationContext={"post"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}, "read"}
// * )
// * @ORM\Table(name="tbl_posts")


/**
 * Class Organization
 * @package App\Entity
 * @ApiResource()
 * @ORM\Table(name="tbl_organizations")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Organization
{
    use TimeTrackerTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"read"})
     */
    private $id;
    /**
     * @ORM\Column(name="title", type="string", length=50 , nullable=true)
     * @Groups({"read"})
     */
    private $title;
    /**
     * @ORM\Column(name="description", type="string", length=150 , nullable=true)
     * @Groups({"read"})
     */
    private $description;
    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="organization", cascade={"persist"})
     * @ApiSubresource()
     */
    private $offices;

    ######################################
    ######     Getters Setters      ######
    ######################################

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getOffices()
    {
        return $this->offices;
    }

    public function addOffices(Office $offices){
        $this->offices[] = $offices;
        $offices->setOrganization($this);
    }

    /*
     *
     */
    public function setOffice(Office $offices){
        $this->offices = $offices;
        foreach ($offices as $office){
            $office->setOrganization($this);
        }
    }
    public function addOffice(Office $offices){
        $this->offices[] = $offices;
        return $this;
    }
    public function removeOffice(Office $offices){
        $this->offices->removeElement($offices);
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
     * Organization constructor.
     */
    public function __construct(){
        $this->offices = new ArrayCollection();
    }

    /**
     * Result of this function is shown in Sonata Admin.
     * @return string
     */
    public function __toString()
    {
        return  (string) $this->getTitle();
    }
}