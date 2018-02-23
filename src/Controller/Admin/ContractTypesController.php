<?php

namespace App\Controller\Admin;

use App\Form\Requests\CreateContractTypeRequest;
use App\Form\Requests\UpdateContractTypeRequest;
use App\Form\Type\ContractTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\ContractType;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/contractTypes", name="admin_contract_types")
 */
class ContractTypesController extends Controller
{
    /**
     * @Route("/", name="_list")
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function index(Request $request) :Response
    {
        $rolesRepository = $this->getDoctrine()->getRepository(ContractType::class);
        $pagination = $rolesRepository->loadList($request->query->getInt('page', 1), $this->get('knp_paginator'));

        return $this->render('admin/contract_types/list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     * @param ContractType $contractType
     * @param Request $request
     * @throws \LogicException
     * @return Response
     */
    public function edit(ContractType $contractType, Request $request) :Response
    {
        /** checking if the role actually exists */
        if (!$contractType) {
            /** redirecting the user */
            $this->addFlash(
                'error',
                'Contract Type does not exists'
            );

            return $this->redirectToRoute('admin_contract_types_list');
        }

        /** Loading the request */
        $contractTypeRequest = new UpdateContractTypeRequest();
        $compiledContractTypeRequest = $contractTypeRequest->fromRole($contractType);

        /** Loading the Form */
        $form = $this->createForm(ContractTypeType::class, $compiledContractTypeRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('contract_type');

            /** Setting up the new role */
            $contractType->setName($data['name']);

            /** Checking if we have a description */
            $description = \array_key_exists('description', $data) ? $data['description'] : '';
            $contractType->setDescription($description);

            /** Persisting the new role */
            $em->persist($contractType);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Contract Type ' . $contractType->getName() . ' has been successfully edited'
            );

            return $this->redirectToRoute('admin_contract_types_list');
        }

        /** Showing the form */
        return $this->render('admin/contract_types/edit.html.twig', ['form' => $form->createView()]);
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
        $contractTypeRequest = new CreateContractTypeRequest();

        /** Instantiating the form */
        $form = $this->createForm(ContractTypeType::class, $contractTypeRequest);
        $form->handleRequest($request);

        /** Checking if form was submitted and is valid */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Calling Entity Manager */
            $em = $this->getDoctrine()->getManager();

            /** Loading the request data */
            $data = $request->request->get('contract_type');

            /** Setting up the new role */
            $newContractType = new ContractType();
            $newContractType->setName($data['name']);

            /** Checking if we have a description */
            $description = \array_key_exists('description', $data) ? $data['description'] : '';
            $newContractType->setDescription($description);

            /** Persisting the new role */
            $em->persist($newContractType);
            $em->flush();

            /** Redirecting the user with success message */
            $this->addFlash(
                'success',
                'Contract Type ' . $newContractType->getName() . ' has been successfully created'
            );

            return $this->redirectToRoute('admin_contract_types_list');
        }

        /** Showing the form */
        return $this->render('admin/contract_types/create.html.twig', ['form' => $form->createView()]);
    }
}
