<?php
/**
 * Created by PhpStorm.
 * User: muhammadtaqi
 * Date: 3/24/19
 * Time: 1:50 PM
 */

namespace App\Entity;

use App\Entity\User;
use App\Traits\TimeTrackerTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ApiSettings
 * @package App\Entity
 * @ORM\Table(name="tbl_api_settings")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ApiSettings
{
    const VISIBILITY_ALL = 'all';
    const VISIBILITY_ME = 'me';
    const VISIBILITY_MY_TEAM = 'my-team';
    /**
     * Contains table name for default ApiSettings
     */
    const TABLE_DEFAULT_SETTINGS = '_api_settings_default';

    use TimeTrackerTrait;


    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;
    /**
     * @var string
     * @ORM\Column(name="show_birthday", type="string")
     */
    private $showBirthday = self::VISIBILITY_ME;

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
     * @return \App\Entity\User
     */
    public function getUser(): \App\Entity\User
    {
        return $this->user;
    }

    /**
     * @param \App\Entity\User $user
     */
    public function setUser(\App\Entity\User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getShowBirthday(): string
    {
        return $this->showBirthday;
    }

    /**
     * @param string $showBirthday
     */
    public function setShowBirthday(string $showBirthday): void
    {
        $this->showBirthday = $showBirthday;
    } // fallback if for some reason value is not set

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