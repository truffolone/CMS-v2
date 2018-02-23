<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @ORM\Table(name="clients")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, options={"unique":TRUE})
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contract", mappedBy="client")
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
     * Client constructor.
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
    public function getName() :string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getReference() :string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return void
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getEmail() :string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
