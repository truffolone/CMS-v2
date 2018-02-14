<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin", name="admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="_dashboard")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/user/create", name="_user_create")
     */
    public function createUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $sentUser = $form->getData();
            $sentUser->setPassword($encoder->encodePassword($sentUser, $sentUser->getPlainPassword()));

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($sentUser);
            $em->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/users/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
