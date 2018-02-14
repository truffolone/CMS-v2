<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table(name="gruppi")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $sutterAcademy;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $editSutter;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $prodotti;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $wizard;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $piani;

    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    private $users;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSutterAcademy()
    {
        return $this->sutterAcademy;
    }

    /**
     * @param mixed $sutterAcademy
     */
    public function setSutterAcademy($sutterAcademy): void
    {
        $this->sutterAcademy = $sutterAcademy;
    }

    /**
     * @return mixed
     */
    public function getEditSutter()
    {
        return $this->editSutter;
    }

    /**
     * @param mixed $editSutter
     */
    public function setEditSutter($editSutter): void
    {
        $this->editSutter = $editSutter;
    }

    /**
     * @return mixed
     */
    public function getProdotti()
    {
        return $this->prodotti;
    }

    /**
     * @param mixed $prodotti
     */
    public function setProdotti($prodotti): void
    {
        $this->prodotti = $prodotti;
    }

    /**
     * @return mixed
     */
    public function getWizard()
    {
        return $this->wizard;
    }

    /**
     * @param mixed $wizard
     */
    public function setWizard($wizard): void
    {
        $this->wizard = $wizard;
    }

    /**
     * @return mixed
     */
    public function getPiani()
    {
        return $this->piani;
    }

    /**
     * @param mixed $piani
     */
    public function setPiani($piani): void
    {
        $this->piani = $piani;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
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
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }


}
