<?php

namespace App\Controller;

use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Organization;
use App\Form\OrganizationType;

/**
 * Organization controller.
 *
 * @Route("/organization")
 */
class OrganizationController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all Organization entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="organization_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Organization::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $organizations = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'organizations' => $organizations,
        );
    }

    /**
     * Typeahead API endpoint for Organization entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="organization_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, OrganizationRepository $repo) {
        $q = $request->query->get('q');
        if (!$q) {
            return new JsonResponse([]);
        }

        $data = [];
        foreach ($repo->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }
        return new JsonResponse($data);
    }

    /**
     * Search for Organization entities.
     *
     * @param Request $request
     *
     * @Route("/search", name="organization_search", methods={"GET"})")
     *
     * @Template()
     */
    public function searchAction(Request $request, OrganizationRepository $repo) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $organizations = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $organizations = array();
        }

        return array(
            'organizations' => $organizations,
            'q' => $q,
        );
    }

    /**
     * Creates a new Organization entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="organization_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $organization = new Organization();
        $form = $this->createForm(OrganizationType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($organization);
            $em->flush();

            $this->addFlash('success', 'The new organization was created.');
            return $this->redirectToRoute('organization_show', array('id' => $organization->getId()));
        }

        return array(
            'organization' => $organization,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Organization entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="organization_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a Organization entity.
     *
     * @param Organization $organization
     *
     * @return array
     *
     * @Route("/{id}", name="organization_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(Organization $organization) {

        return array(
            'organization' => $organization,
        );
    }

    /**
     * Displays a form to edit an existing Organization entity.
     *
     *
     * @param Request $request
     * @param Organization $organization
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="organization_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, Organization $organization, EntityManagerInterface $em) {
        $editForm = $this->createForm(OrganizationType::class, $organization);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The organization has been updated.');
            return $this->redirectToRoute('organization_show', array('id' => $organization->getId()));
        }

        return array(
            'organization' => $organization,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Organization entity.
     *
     *
     * @param Request $request
     * @param Organization $organization
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="organization_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, Organization $organization, EntityManagerInterface $em) {

        $em->remove($organization);
        $em->flush();
        $this->addFlash('success', 'The organization was deleted.');

        return $this->redirectToRoute('organization_index');
    }

}
