<?php

namespace App\Form\Requests;


class CreateUserInfoRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=80)
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=80)
     * @var string
     */
    public $surname;

    /**
     * @var string
     */
    public $companyName;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $moreInfo;

    /**
     * @var string
     */
    public $telephone;

    /**
     * @var string
     */
    public $cellphone;

    /**
     * @var string
     */
    public $fax;
}
