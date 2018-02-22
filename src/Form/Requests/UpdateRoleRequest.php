<?php

namespace App\Form\Requests;

use App\Entity\Roles;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

/**
 * Class UpdateRoleRequest
 * @TruffoloneAssert\IsRoleNameUniqueUpdate()
 * @TruffoloneAssert\IsRoleSlugUniqueUpdate()
 * @package App\Form\Requests
 */
class UpdateRoleRequest
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
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=64)
     * @var string
     */
    public $slug;

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
    public function getSlug(): string
    {
        return $this->slug;
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
     * @param Roles $role
     * @return UpdateRoleRequest
     */
    public function fromRole(Roles $role) :self
    {
        $roleRequest = new self();
        $roleRequest->id = $role->getId();
        $roleRequest->name = $role->getName();
        $roleRequest->slug = $role->getSlug();
        $roleRequest->description = $role->getDescription();

        return $roleRequest;
    }
}
