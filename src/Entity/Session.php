<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 * @ORM\Table(name="sessions")
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string", length=128)
     */
    private $sess_id;

    /**
     * @ORM\Column(type="blob", nullable=FALSE)
     */
    private $sess_data;

    /**
     * @ORM\Column(type="integer", nullable=FALSE)
     */
    private $sess_time;

    /**
     * @ORM\Column(type="integer", nullable=FALSE)
     */
    private $sess_lifetime;
}
