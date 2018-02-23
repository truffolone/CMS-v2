<?php

namespace App\Form\Requests;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

class CreateContractTypeRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     * @TruffoloneAssert\IsContractTypeNameUnique()
     * @var string
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;
}
