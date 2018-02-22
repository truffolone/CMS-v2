<?php

namespace App\Form\Requests;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

class CreateUserRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     * @Assert\Regex(
     *     pattern = "/^[a-z0-9]+$/i",
     *     htmlPattern = "^[a-zA-Z0-9]+$"
     * )
     * @TruffoloneAssert\IsUsernameUnique()
     * @var string
     */
    public $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     strict = true,
     *     checkMX = true,
     *     checkHost = true
     * )
     * @TruffoloneAssert\IsEmailUnique()
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=128)
     * @TruffoloneAssert\IsPasswordValid()
     * @var string
     */
    public $plainPassword;

    /**
     * @Assert\NotBlank()
     * @var int
     */
    public $role;
}
