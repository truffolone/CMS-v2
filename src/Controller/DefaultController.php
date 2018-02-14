<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    /**
     * @Route("/prova", name="prova")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function prova(Request $request, UserPasswordEncoderInterface $encoder)
    {
        /** calling user repository */
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = new User();

        $user->setUsername('truffolone');
        $user->setPassword($encoder->encodePassword($user, '50dc2592'));
        $user->setEmail('daniele.verra@echocreative.it');

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return $this->render('prova.html.twig', [ 'var' => $user]);
    }
}
