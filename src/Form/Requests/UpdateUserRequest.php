<?php

namespace App\Form\Requests;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

/**
 * Class UpdateUserRequest
 * @TruffoloneAssert\IsUsernameUniqueUpdate()
 * @TruffoloneAssert\IsEmailUniqueUpdate()
 * @package App\Form\Requests
 */
class UpdateUserRequest
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     * @Assert\Regex(
     *     pattern = "/^[a-z0-9]+$/i",
     *     htmlPattern = "^[a-zA-Z0-9]+$"
     * )
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
     * @var string
     */
    public $email;

    /**
     * @TruffoloneAssert\IsPasswordValidUpdate()
     * @var string
     */
    public $plainPassword;

    /**
     * @Assert\NotBlank()
     * @var int
     */
    public $role;

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
    public function getUsername() :string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail() :string
    {
        return $this->email;
    }

    /**
     * Static function to set the user to edit
     * @param User $user
     * @return UpdateUserRequest
     */
    public static function fromUser(User $user) :self
    {
        $userRequest = new self();
        $userRequest->id = $user->getId();
        $userRequest->username = $user->getUsername();
        $userRequest->email = $user->getEmail();
        $userRequest->plainPassword = '';
        $userRequest->role = $user->getRoleObject();

        return $userRequest;
    }
}
