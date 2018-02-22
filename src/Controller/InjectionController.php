<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Roles;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InjectionController extends Controller
{
    /**
     * @Route("/injection", name="injection")
     * @param UserPasswordEncoderInterface $encoder
     * @throws \LogicException
     * @return Response
     */
    public function index(UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        /*
                $role = new Roles();
                $role->setName('Admin');
                $role->setSlug('_ADMIN');
                $role->setDescription('Roles for Administrators');
                $em->persist($role);
                $em->flush();

                $user = new User();
                $user->setUsername('truffolone');
                $user->setEmail('daniele.verra@echocreative.it');
                $user->setRoles($role);
                $user->setPassword($encoder->encodePassword($user, '50dc2592'));
                $em->persist($user);
                $em->flush();
        */

        if (!$user = $em->getRepository(User::class)->find(1)) {
            $user = new User();
        }

        return $this->render('injector.html.twig', ['dump' => $user->getRoles()]);
    }
}
