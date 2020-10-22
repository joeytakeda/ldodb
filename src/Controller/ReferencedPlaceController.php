<?php

namespace App\Controller;

use App\Repository\ReferencedPlaceRepository;
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
use App\Entity\ReferencedPlace;
use App\Form\ReferencedPlaceType;

/**
 * ReferencedPlace controller.
 *
 * @Route("/referenced_place")
 */
class ReferencedPlaceController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all ReferencedPlace entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="referenced_place_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(ReferencedPlace::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $referencedPlaces = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'referencedPlaces' => $referencedPlaces,
        );
    }

    /**
     * Typeahead API endpoint for ReferencedPlace entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="referenced_place_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, ReferencedPlaceRepository $repo) {
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
     * Creates a new ReferencedPlace entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="referenced_place_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $referencedPlace = new ReferencedPlace();
        $form = $this->createForm(ReferencedPlaceType::class, $referencedPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($referencedPlace);
            $em->flush();

            $this->addFlash('success', 'The new referencedPlace was created.');
            return $this->redirectToRoute('referenced_place_show', array('id' => $referencedPlace->getId()));
        }

        return array(
            'referencedPlace' => $referencedPlace,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new ReferencedPlace entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="referenced_place_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a ReferencedPlace entity.
     *
     * @param ReferencedPlace $referencedPlace
     *
     * @return array
     *
     * @Route("/{id}", name="referenced_place_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(ReferencedPlace $referencedPlace) {

        return array(
            'referencedPlace' => $referencedPlace,
        );
    }

    /**
     * Displays a form to edit an existing ReferencedPlace entity.
     *
     *
     * @param Request $request
     * @param ReferencedPlace $referencedPlace
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="referenced_place_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, ReferencedPlace $referencedPlace, EntityManagerInterface $em) {
        $editForm = $this->createForm(ReferencedPlaceType::class, $referencedPlace);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The referencedPlace has been updated.');
            return $this->redirectToRoute('referenced_place_show', array('id' => $referencedPlace->getId()));
        }

        return array(
            'referencedPlace' => $referencedPlace,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a ReferencedPlace entity.
     *
     *
     * @param Request $request
     * @param ReferencedPlace $referencedPlace
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="referenced_place_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, ReferencedPlace $referencedPlace, EntityManagerInterface $em) {

        $em->remove($referencedPlace);
        $em->flush();
        $this->addFlash('success', 'The referencedPlace was deleted.');

        return $this->redirectToRoute('referenced_place_index');
    }

}
