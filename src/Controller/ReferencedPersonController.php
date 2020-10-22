<?php

namespace App\Controller;

use App\Repository\ReferencedPersonRepository;
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
use App\Entity\ReferencedPerson;
use App\Form\ReferencedPersonType;

/**
 * ReferencedPerson controller.
 *
 * @Route("/referenced_person")
 */
class ReferencedPersonController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all ReferencedPerson entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="referenced_person_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(ReferencedPerson::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $referencedPeople = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'referencedPeople' => $referencedPeople,
        );
    }

    /**
     * Typeahead API endpoint for ReferencedPerson entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="referenced_person_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, ReferencedPersonRepository $repo) {
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
     * Search for ReferencedPerson entities.
     *
     * @param Request $request
     *
     * @Route("/search", name="referenced_person_search", methods={"GET"})")
     *
     * @Template()
     */
    public function searchAction(Request $request, ReferencedPersonRepository $repo) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $referencedPeople = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $referencedPeople = array();
        }

        return array(
            'referencedPeople' => $referencedPeople,
            'q' => $q,
        );
    }

    /**
     * Creates a new ReferencedPerson entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="referenced_person_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $referencedPerson = new ReferencedPerson();
        $form = $this->createForm(ReferencedPersonType::class, $referencedPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($referencedPerson);
            $em->flush();

            $this->addFlash('success', 'The new referencedPerson was created.');
            return $this->redirectToRoute('referenced_person_show', array('id' => $referencedPerson->getId()));
        }

        return array(
            'referencedPerson' => $referencedPerson,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new ReferencedPerson entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="referenced_person_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a ReferencedPerson entity.
     *
     * @param ReferencedPerson $referencedPerson
     *
     * @return array
     *
     * @Route("/{id}", name="referenced_person_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(ReferencedPerson $referencedPerson) {

        return array(
            'referencedPerson' => $referencedPerson,
        );
    }

    /**
     * Displays a form to edit an existing ReferencedPerson entity.
     *
     *
     * @param Request $request
     * @param ReferencedPerson $referencedPerson
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="referenced_person_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, ReferencedPerson $referencedPerson, EntityManagerInterface $em) {
        $editForm = $this->createForm(ReferencedPersonType::class, $referencedPerson);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The referencedPerson has been updated.');
            return $this->redirectToRoute('referenced_person_show', array('id' => $referencedPerson->getId()));
        }

        return array(
            'referencedPerson' => $referencedPerson,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a ReferencedPerson entity.
     *
     *
     * @param Request $request
     * @param ReferencedPerson $referencedPerson
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="referenced_person_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, ReferencedPerson $referencedPerson, EntityManagerInterface $em) {

        $em->remove($referencedPerson);
        $em->flush();
        $this->addFlash('success', 'The referencedPerson was deleted.');

        return $this->redirectToRoute('referenced_person_index');
    }

}
