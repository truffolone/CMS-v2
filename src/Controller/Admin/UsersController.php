<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Roles;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Requests\CreateUserRequest;
use App\Form\Requests\UpdateUserRequest;
use App\Form\Type\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/users", name="admin_users")
 * @Security("has_role('ROLE_ADMIN')")
 * Class UsersController
 * @package App\Controller\Admin
 */
class UsersController extends Controller
{
    /**
     * @Route("/", name="_list")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function index(Request $request) :Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $pagination = $userRepository->loadList($request->query->getInt('page', 1), $this->get('knp_paginator'));

        return $this->render('admin/users/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     * @param User $user (based on $id)
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @throws \LogicException
     * @return Response
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $encoder) :Response
    {
        /** checking if the user actually exists */
        if (!$user) {
            /** redirecting the user */
            $this->addFlash(
                'error',
                'User does not exists'
            );

            return $this->redirectToRoute('admin_users_list');
        }

        /** Loading the request */
        $userRequest = new UpdateUserRequest();
        $compiledUserRequest = $userRequest::fromUser($user);

        /** Loading the Form */
        $form = $this->createForm(UserType::class, $compiledUserRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('user');

            /** Setting up the new role */
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);

            /** Checking if we are changing the password */
            if (\array_key_exists('plainPassword', $data) && $data['plainPassword'] !== '') {
                $user->setPassword($encoder->encodePassword($user, $data['plainPassword']));
            }

            /** Loading role */
            $roleRepository = $em->getRepository(Roles::class);
            if ($role = $roleRepository->find($data['role'])) {
                $user->setRoles($role);
            }

            /** Persisting the new user */
            $em->persist($user);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'User ' . $user->getUsername() . ' has been successfully edited'
            );

            return $this->redirectToRoute('admin_users_list');
        }

        /** Showing the form */
        return $this->render('admin/users/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/create", name="_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @throws \LogicException
     * @throws ORMInvalidArgumentException
     * @throws LogicException
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder) :Response
    {
        $userRequest = new CreateUserRequest();

        $form = $this->createForm(UserType::class, $userRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Finally Creating the User */
            $allUserArray = $request->request->get('user');
            $user = new User();
            $user->setUsername($allUserArray['username']);
            $user->setEmail($allUserArray['email']);
            $user->setPassword($encoder->encodePassword($user, $allUserArray['plainPassword']));
            $user->setIsActive(true);

            /** Loading role */
            $roleRepository = $em->getRepository(Roles::class);
            if ($role = $roleRepository->find($allUserArray['role'])) {
                $user->setRoles($role);
            }

            /** saving the user */
            $em->persist($user);
            $em->flush();

            /** redirecting the user */
            $this->addFlash(
                'success',
                'User ' . $user->getUsername() . ' has been successfully created'
            );

            return $this->redirectToRoute('admin_users_list');
        }

        /** rendering the form */
        return $this->render(
            'admin/users/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
