<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DomainRepository")
 * @ORM\Table(name="domains")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks
 */
class Domain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"unique":TRUE})
     */
    private $domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expireDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contract", mappedBy="domain")
     */
    private $contracts;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Domain constructor.
     */
    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();
        $this->contracts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDomain() :string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return void
     */
    public function setDomain($domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param mixed $expireDate
     */
    public function setExpireDate($expireDate): void
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @return Collection/Contract[]
     */
    public function getContracts() :Collection
    {
        return $this->contracts;
    }

    /**
     * @param mixed $contracts
     */
    public function setContracts($contracts): void
    {
        $this->contracts = $contracts;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
