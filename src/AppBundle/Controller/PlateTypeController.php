<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PlateType;
use AppBundle\Form\PlateTypeType;

/**
 * PlateType controller.
 *
 * @Route("/plate_type")
 */
class PlateTypeController extends Controller
{
    /**
     * Lists all PlateType entities.
     *
     * @Route("/", name="plate_type_index")
     * @Method("GET")
     * @Template()
	 * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql = 'SELECT e FROM AppBundle:PlateType e ORDER BY e.id';
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $plateTypes = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'plateTypes' => $plateTypes,
        );
    }
    /**
     * Search for PlateType entities.
	 *
	 * To make this work, add a method like this one to the 
	 * AppBundle:PlateType repository. Replace the fieldName with
	 * something appropriate, and adjust the generated search.html.twig
	 * template.
	 * 
     //    public function searchQuery($q) {
     //        $qb = $this->createQueryBuilder('e');
     //        $qb->where("e.fieldName like '%$q%'");
     //        return $qb->getQuery();
     //    }
	 *
     *
     * @Route("/search", name="plate_type_search")
     * @Method("GET")
     * @Template()
	 * @param Request $request
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('AppBundle:PlateType');
		$q = $request->query->get('q');
		if($q) {
	        $query = $repo->searchQuery($q);
			$paginator = $this->get('knp_paginator');
			$plateTypes = $paginator->paginate($query, $request->query->getInt('page', 1), 25);
		} else {
			$plateTypes = array();
		}

        return array(
            'plateTypes' => $plateTypes,
			'q' => $q,
        );
    }
    /**
     * Full text search for PlateType entities.
	 *
	 * To make this work, add a method like this one to the 
	 * AppBundle:PlateType repository. Replace the fieldName with
	 * something appropriate, and adjust the generated fulltext.html.twig
	 * template.
	 * 
	//    public function fulltextQuery($q) {
	//        $qb = $this->createQueryBuilder('e');
	//        $qb->addSelect("MATCH_AGAINST (e.name, :q 'IN BOOLEAN MODE') as score");
	//        $qb->add('where', "MATCH_AGAINST (e.name, :q 'IN BOOLEAN MODE') > 0.5");
	//        $qb->orderBy('score', 'desc');
	//        $qb->setParameter('q', $q);
	//        return $qb->getQuery();
	//    }	 
	 * 
	 * Requires a MatchAgainst function be added to doctrine, and appropriate
	 * fulltext indexes on your PlateType entity.
	 *     ORM\Index(name="alias_name_idx",columns="name", flags={"fulltext"})
	 *
     *
     * @Route("/fulltext", name="plate_type_fulltext")
     * @Method("GET")
     * @Template()
	 * @param Request $request
	 * @return array
     */
    public function fulltextAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('AppBundle:PlateType');
		$q = $request->query->get('q');
		if($q) {
	        $query = $repo->fulltextQuery($q);
			$paginator = $this->get('knp_paginator');
			$plateTypes = $paginator->paginate($query, $request->query->getInt('page', 1), 25);
		} else {
			$plateTypes = array();
		}

        return array(
            'plateTypes' => $plateTypes,
			'q' => $q,
        );
    }

    /**
     * Creates a new PlateType entity.
     *
     * @Route("/new", name="plate_type_new")
     * @Method({"GET", "POST"})
     * @Template()
	 * @param Request $request
     */
    public function newAction(Request $request)
    {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $plateType = new PlateType();
        $form = $this->createForm('AppBundle\Form\PlateTypeType', $plateType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plateType);
            $em->flush();

            $this->addFlash('success', 'The new plateType was created.');
            return $this->redirectToRoute('plate_type_show', array('id' => $plateType->getId()));
        }

        return array(
            'plateType' => $plateType,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a PlateType entity.
     *
     * @Route("/{id}", name="plate_type_show")
     * @Method("GET")
     * @Template()
	 * @param PlateType $plateType
     */
    public function showAction(PlateType $plateType)
    {

        return array(
            'plateType' => $plateType,
        );
    }

    /**
     * Displays a form to edit an existing PlateType entity.
     *
     * @Route("/{id}/edit", name="plate_type_edit")
     * @Method({"GET", "POST"})
     * @Template()
	 * @param Request $request
	 * @param PlateType $plateType
     */
    public function editAction(Request $request, PlateType $plateType)
    {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $editForm = $this->createForm('AppBundle\Form\PlateTypeType', $plateType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'The plateType has been updated.');
            return $this->redirectToRoute('plate_type_show', array('id' => $plateType->getId()));
        }

        return array(
            'plateType' => $plateType,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a PlateType entity.
     *
     * @Route("/{id}/delete", name="plate_type_delete")
     * @Method("GET")
	 * @param Request $request
	 * @param PlateType $plateType
     */
    public function deleteAction(Request $request, PlateType $plateType)
    {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($plateType);
        $em->flush();
        $this->addFlash('success', 'The plateType was deleted.');

        return $this->redirectToRoute('plate_type_index');
    }
}