<?php

namespace App\Form\Requests;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

class CreateClientRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     * @TruffoloneAssert\IsClientNameUnique()
     * @var string $name
     */
    public $name;

    /**
     * @var string $reference
     */
    public $reference;

    /**
     * @Assert\Email(
     *     strict = true,
     *     checkMX = true,
     *     checkHost = true
     * )
     * @var string $email
     */
    public $email;
}
