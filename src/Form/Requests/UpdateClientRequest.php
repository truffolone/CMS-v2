<?php

namespace App\Form\Requests;

use App\Entity\Client;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as TruffoloneAssert;

/**
 * Class UpdateRoleRequest
 * @TruffoloneAssert\IsClientNameUniqueUpdate()
 * @package App\Form\Requests
 */
class UpdateClientRequest
{
    /**
     * Create for domain check reference
     * @var int $id
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
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
     * @param Client $client
     * @return UpdateClientRequest
     */
    public function fromClient(Client $client) :self
    {
        $clientRequest = new self();
        $clientRequest->id = $client->getId();
        $clientRequest->name = $client->getName();
        $clientRequest->reference = $client->getReference();
        $clientRequest->email = $client->getEmail();

        return $clientRequest;
    }
}
