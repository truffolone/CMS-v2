<?php

namespace App\Controller\Admin;

use App\Form\Requests\CreateRoleRequest;
use App\Form\Requests\UpdateRoleRequest;
use App\Form\Type\RoleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Roles;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/roles", name="admin_roles")
 */
class RolesController extends Controller
{
    /**
     * @Route("/", name="_list")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function index(Request $request) :Response
    {
        $rolesRepository = $this->getDoctrine()->getRepository(Roles::class);
        $pagination = $rolesRepository->loadList($request->query->getInt('page', 1), $this->get('knp_paginator'));

        return $this->render('admin/roles/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     * @param Roles $role
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function edit(Roles $role, Request $request) :Response
    {
        /** checking if the role actually exists */
        if (!$role) {
            /** redirecting the user */
            $this->addFlash(
                'error',
                'Role does not exists'
            );

            return $this->redirectToRoute('admin_roles_list');
        }

        /** Loading the request */
        $roleRequest = new UpdateRoleRequest();
        $compiledRoleRequest = $roleRequest->fromRole($role);

        /** Loading the Form */
        $form = $this->createForm(RoleType::class, $compiledRoleRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('role');

            /** Setting up the new role */
            $role->setName($data['name']);
            $role->setSlug($data['slug']);

            /** Checking if we have a description */
            $description = \array_key_exists('description', $data) ? $data['description'] : '';
            $role->setDescription($description);

            /** Persisting the new role */
            $em->persist($role);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Role ' . $role->getName() . ' has been successfully edited'
            );

            return $this->redirectToRoute('admin_roles_list');
        }

        /** Showing the form */
        return $this->render('admin/roles/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new", name="_create")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function create(Request $request) :Response
    {
        /** Creating the role request for the form */
        $roleRequest = new CreateRoleRequest();

        /** Instantiating the form */
        $form = $this->createForm(RoleType::class, $roleRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('role');

            /** Setting up the new role */
            $newRole = new Roles();
            $newRole->setName($data['name']);
            $newRole->setSlug($data['slug']);

            /** Checking if we have a description */
            $description = \array_key_exists('description', $data) ? $data['description'] : '';
            $newRole->setDescription($description);

            /** Persisting the new role */
            $em->persist($newRole);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Role ' . $newRole->getName() . ' has been successfully created'
            );

            return $this->redirectToRoute('admin_roles_list');
        }

        /** Showing the form */
        return $this->render('admin/roles/create.html.twig', ['form' => $form->createView()]);
    }
}
