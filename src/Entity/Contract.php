<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 * @ORM\Table(name="contracts")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @@ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expireDate;

    /**
     * @ORM\Column(type="float", options={"default":0.00})
     */
    private $importo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContractType", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contractType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Domain", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $domain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

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
    public function getNote() :?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     * @return void
     */
    public function setNote($note): void
    {
        $this->note = $note;
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
     * @return void
     */
    public function setExpireDate($expireDate): void
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @return float
     */
    public function getImporto() :float
    {
        return $this->importo;
    }

    /**
     * @param float $importo
     * @return void
     */
    public function setImporto($importo): void
    {
        $this->importo = $importo;
    }

    /**
     * @return ContractType
     */
    public function getContractType() :ContractType
    {
        return $this->contractType;
    }

    /**
     * @param mixed $contractType
     */
    public function setContractType(ContractType $contractType): void
    {
        $this->contractType = $contractType;
    }

    /**
     * @return Domain
     */
    public function getDomain() :Domain
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     * @return void
     */
    public function setDomain(Domain $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return Client
     */
    public function getClient() :Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
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
