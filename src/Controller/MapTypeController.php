<?php

namespace App\Controller;

use App\Repository\MapTypeRepository;
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
use App\Entity\MapType;
use App\Form\MapTypeType;

/**
 * MapType controller.
 *
 * @Route("/map_type")
 */
class MapTypeController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all MapType entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="map_type_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(MapType::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $mapTypes = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'mapTypes' => $mapTypes,
        );
    }

    /**
     * Typeahead API endpoint for MapType entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="map_type_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, MapTypeRepository $repo) {
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
     * Creates a new MapType entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="map_type_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $mapType = new MapType();
        $form = $this->createForm(MapTypeType::class, $mapType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($mapType);
            $em->flush();

            $this->addFlash('success', 'The new mapType was created.');
            return $this->redirectToRoute('map_type_show', array('id' => $mapType->getId()));
        }

        return array(
            'mapType' => $mapType,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new MapType entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="map_type_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a MapType entity.
     *
     * @param MapType $mapType
     *
     * @return array
     *
     * @Route("/{id}", name="map_type_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(MapType $mapType) {

        return array(
            'mapType' => $mapType,
        );
    }

    /**
     * Displays a form to edit an existing MapType entity.
     *
     *
     * @param Request $request
     * @param MapType $mapType
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="map_type_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, MapType $mapType, EntityManagerInterface $em) {
        $editForm = $this->createForm(MapTypeType::class, $mapType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The mapType has been updated.');
            return $this->redirectToRoute('map_type_show', array('id' => $mapType->getId()));
        }

        return array(
            'mapType' => $mapType,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a MapType entity.
     *
     *
     * @param Request $request
     * @param MapType $mapType
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="map_type_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, MapType $mapType, EntityManagerInterface $em) {

        $em->remove($mapType);
        $em->flush();
        $this->addFlash('success', 'The mapType was deleted.');

        return $this->redirectToRoute('map_type_index');
    }

}
