<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Form\Requests\CreateClientRequest;
use App\Form\Requests\UpdateClientRequest;
use App\Form\Requests\UpdateDomainRequest;
use App\Form\Requests\CreateDomainRequest;
use App\Form\Type\ClientType;
use App\Form\Type\DomainType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Domain;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/clients", name="admin_clients")
 */
class ClientsController extends Controller
{
    /**
     * @Route("/", name="_list")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function index(Request $request) :Response
    {
        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        $pagination = $clientRepository->loadList($request->query->getInt('page', 1), $this->get('knp_paginator'));

        return $this->render('admin/clients/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     * @param Client $client
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function edit(Client $client, Request $request) :Response
    {
        /** checking if the role actually exists */
        if (!$client) {
            /** redirecting the user */
            $this->addFlash(
                'error',
                'Client does not exists'
            );

            return $this->redirectToRoute('admin_contract_types_list');
        }

        /** Loading the request */
        $clientRequest = new UpdateClientRequest();
        $compiledClientRequest = $clientRequest->fromClient($client);

        /** Loading the Form */
        $form = $this->createForm(ClientType::class, $compiledClientRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('client');

            /** Setting up the new role */
            $client->setName($data['name']);

            /** Checking if we have a reference */
            $reference = \array_key_exists('reference', $data) ? $data['reference'] : '';
            $client->setReference($reference);

            /** Checking if we have an email */
            $email = \array_key_exists('email', $data) ? $data['email'] : '';
            $client->setEmail($email);

            /** Persisting the new client */
            $em->persist($client);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Client ' . $client->getName() . ' has been successfully edited'
            );

            return $this->redirectToRoute('admin_clients_list');
        }

        /** Showing the form */
        return $this->render('admin/clients/edit.html.twig', ['form' => $form->createView()]);
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
        $clientRequest = new CreateClientRequest();

        /** Instantiating the form */
        $form = $this->createForm(ClientType::class, $clientRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('client');

            /** Setting up the new role */
            $newClient = new Client();
            $newClient->setName($data['name']);

            /** Checking if we have a reference */
            $reference = \array_key_exists('reference', $data) ? $data['reference'] : '';
            $newClient->setReference($reference);

            /** Checking if we have an email */
            $email = \array_key_exists('email', $data) ? $data['email'] : '';
            $newClient->setEmail($email);

            /** Persisting the new client */
            $em->persist($newClient);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Client ' . $newClient->getName() . ' has been successfully created'
            );

            return $this->redirectToRoute('admin_clients_list');
        }

        /** Showing the form */
        return $this->render('admin/clients/create.html.twig', ['form' => $form->createView()]);
    }
}
