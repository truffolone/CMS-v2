<?php

namespace App\Form\Requests;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

class CreateRoleRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     * @TruffoloneAssert\IsRoleNameUnique()
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=64)
     * @TruffoloneAssert\IsRoleSlugUnique()
     * @var string
     */
    public $slug;

    /**
     * @var string $description
     */
    public $description;
}
