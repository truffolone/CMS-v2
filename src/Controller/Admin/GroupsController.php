<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GroupsController
 * @package App\Controller\Admin
 * @Route("/admin/groups", name="admin_groups")
 */
class GroupsController extends Controller
{
    /**
     * @Route("/", name="_list")
     * @throws \InvalidArgumentException
     * @return Response
     */
    public function index() :Response
    {
        return new Response();
    }
}
