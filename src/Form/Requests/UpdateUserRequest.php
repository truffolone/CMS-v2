<?php

namespace App\Form\Requests;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

class UpdateUserRequest
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
     * Reference for the CreateUserInfoRequest Object
     */
    public $userInfo;

    /**
     * Reference for the CreateGroupRequest Object
     */
    public $groups;

    /**
     * Static function to set the user to edit
     * @param User $user
     * @return UpdateUserRequest
     */
    public static function fromUser(User $user) :self
    {
        $userRequest = new self();
        $userRequest->username = $user->getUsername();
        $userRequest->email = $user->getEmail();
        $userRequest->plainPassword = '';
        $userRequest->userInfo = $user->getUserInfo();

        return $userRequest;
    }
}
