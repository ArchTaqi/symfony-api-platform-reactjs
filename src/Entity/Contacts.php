<?php

namespace App\Entity;

use App\Traits\TimeTrackerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

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
 * @ApiResource()
 * @ORM\Entity
 * @ORM\Table(name="tbl_contacts")
 */
class Contacts
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="contacts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"read"})
     * @Groups("post-user")
     */
    private $user;
    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=30)
     */
    private $phoneNumber;
    /**
     *
     * @ORM\Column(name="number_type", type="string", columnDefinition="ENUM('u','c', 'l', 'o', 'h')")
     */
    private $numberType;
    /**
     *
     * @ORM\Column(name="country_code", type="string", length=30 , nullable=true)
     */
    private $countryCode;
    /**
     *
     * @ORM\Column(name="office_extension", type="string", length=30 , nullable=true)
     */
    private $officeExtension;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Groups({"read"})
     */
    private $notes;
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
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getNumberType()
    {
        return $this->numberType;
    }

    /**
     * @param mixed $numberType
     */
    public function setNumberType($numberType): void
    {
        $this->numberType = $numberType;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getOfficeExtension()
    {
        return $this->officeExtension;
    }

    /**
     * @param mixed $officeExtension
     */
    public function setOfficeExtension($officeExtension): void
    {
        $this->officeExtension = $officeExtension;
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

    ######################################
    ###  Constructor and Other Methods ###
    ######################################

    /**
     * Result of this function is shown in Sonata Admin.
     * @return string
     */
    public function __toString()
    {
        return  (string) $this->getPhoneNumber();
    }
}