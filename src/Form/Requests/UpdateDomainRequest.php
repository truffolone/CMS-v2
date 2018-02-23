<?php

namespace App\Form\Requests;

use App\Entity\ContractType;
use App\Entity\Domain;
use App\Form\Type\DomainType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

/**
 * Class UpdateRoleRequest
 * @TruffoloneAssert\IsDomainDomainUniqueUpdate()
 * @package App\Form\Requests
 */
class UpdateDomainRequest
{
    /**
     * Create for domain check reference
     * @var int $id
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     * @var string
     */
    public $domain;

    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var \DateTime $expireDate
     */
    public $expireDate;

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return \DateTime
     */
    public function getExpireDate(): \DateTime
    {
        return $this->expireDate;
    }

    /**
     * @return int
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * Static function to set the user to edit
     * @param Domain $domain
     * @return UpdateDomainRequest
     */
    public function fromRole(Domain $domain) :self
    {
        $domainTypeRequest = new self();
        $domainTypeRequest->id = $domain->getId();
        $domainTypeRequest->domain = $domain->getDomain();
        $domainTypeRequest->expireDate = $domain->getExpireDate();

        return $domainTypeRequest;
    }
}
