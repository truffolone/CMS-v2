<?php

namespace App\Form\Requests;

use App\Entity\ContractType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

/**
 * Class UpdateRoleRequest
 * @TruffoloneAssert\IsContractTypeNameUniqueUpdate()
 * @package App\Form\Requests
 */
class UpdateContractTypeRequest
{
    /**
     * Create for name and slug check reference
     * @var int $id
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     * @var string
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
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
     * @param ContractType $contractType
     * @return UpdateContractTypeRequest
     */
    public function fromRole(ContractType $contractType) :self
    {
        $contractTypeRequest = new self();
        $contractTypeRequest->id = $contractType->getId();
        $contractTypeRequest->name = $contractType->getName();
        $contractTypeRequest->description = $contractType->getDescription();

        return $contractTypeRequest;
    }
}
