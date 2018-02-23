<?php

namespace App\Controller\Admin;

use App\Form\Requests\UpdateDomainRequest;
use App\Form\Requests\CreateDomainRequest;
use App\Form\Type\DomainType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Domain;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/domains", name="admin_domains")
 */
class DomainController extends Controller
{
    /**
     * @Route("/", name="_list")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function index(Request $request) :Response
    {
        $rolesRepository = $this->getDoctrine()->getRepository(Domain::class);
        $pagination = $rolesRepository->loadList($request->query->getInt('page', 1), $this->get('knp_paginator'));

        return $this->render('admin/domains/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     * @param Domain $domain
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function edit(Domain $domain, Request $request) :Response
    {
        /** checking if the role actually exists */
        if (!$domain) {
            /** redirecting the user */
            $this->addFlash(
                'error',
                'Contract Type does not exists'
            );

            return $this->redirectToRoute('admin_contract_types_list');
        }

        /** Loading the request */
        $domainRequest = new UpdateDomainRequest();
        $compiledDomainRequest = $domainRequest->fromRole($domain);

        /** Loading the Form */
        $form = $this->createForm(DomainType::class, $compiledDomainRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('domain');

            /** Setting up the new role */
            $domain->setDomain($data['domain']);
            $domain->setExpireDate(\DateTime::createFromFormat('Y-m-d', $data['expireDate']));

            /** Persisting the new role */
            $em->persist($domain);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Domain ' . $domain->getDomain() . ' has been successfully edited'
            );

            return $this->redirectToRoute('admin_contract_types_list');
        }

        /** Showing the form */
        return $this->render('admin/domains/edit.html.twig', ['form' => $form->createView()]);
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
        $domainRequest = new CreateDomainRequest();

        /** Instantiating the form */
        $form = $this->createForm(DomainType::class, $domainRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('domain');

            /** Setting up the new role */
            $newDomain = new Domain();
            $newDomain->setDomain($data['domain']);
            $newDomain->setExpireDate(\DateTime::createFromFormat('Y-m-d', $data['expireDate']));

            /** Persisting the new role */
            $em->persist($newDomain);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Domain ' . $newDomain->getDomain() . ' has been successfully created'
            );

            return $this->redirectToRoute('admin_domains_list');
        }

        /** Showing the form */
        return $this->render('admin/domains/create.html.twig', ['form' => $form->createView()]);
    }
}
