<?php
/**
 * Created by PhpStorm.
 * User: muhammadtaqi
 * Date: 3/24/19
 * Time: 1:55 PM
 */

namespace App\Traits;


/**
 * Trait TimeTrackerTrait
 * @package App\Traits
 */
trait TimeTrackerTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", length=255, nullable=true)
     */
    private $dateCreated;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", length=255, nullable=true)
     */
    private $dateUpdated;

    ######################################
    ######     Getters Setters      ######
    ######################################
    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated(): \DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTime $dateUpdated
     */
    public function setDateUpdated(\DateTime $dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    ######################################
    ######     Callback Methods     ######
    ######################################

    abstract public function prePersist();

    abstract public function preUpdate();
}