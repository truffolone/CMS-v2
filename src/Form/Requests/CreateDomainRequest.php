<?php

namespace App\Form\Requests;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

class CreateDomainRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     * @TruffoloneAssert\IsDomainDomainUnique()
     * @var string
     */
    public $domain;

    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var \DateTime $expireDate
     */
    public $expireDate;
}
