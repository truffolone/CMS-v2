<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Requests\CreateUserRequest;
use App\Form\Type\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/users", name="admin_users")
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
     * @throws \LogicException
     * @return Response
     */
    public function edit(User $user) :Response
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

        /** binding group */
        $group = $user->getGroups()->first();

        /** binding userInfo */
        $userInfo = $user->getUserInfo();

        return $this->render('admin/users/edit.html.twig', ['data' => $group]);
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

            /** saving the user */
            $em->persist($user);

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