<?php

namespace App\Controller;

use App\Repository\BindingFeatureRepository;
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
use App\Entity\BindingFeature;
use App\Form\BindingFeatureType;

/**
 * BindingFeature controller.
 *
 * @Route("/binding_feature")
 */
class BindingFeatureController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all BindingFeature entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="binding_feature_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(BindingFeature::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $bindingFeatures = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'bindingFeatures' => $bindingFeatures,
        );
    }

    /**
     * Typeahead API endpoint for BindingFeature entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="binding_feature_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, BindingFeatureRepository $repo) {
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
     * Creates a new BindingFeature entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="binding_feature_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $bindingFeature = new BindingFeature();
        $form = $this->createForm(BindingFeatureType::class, $bindingFeature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($bindingFeature);
            $em->flush();

            $this->addFlash('success', 'The new bindingFeature was created.');
            return $this->redirectToRoute('binding_feature_show', array('id' => $bindingFeature->getId()));
        }

        return array(
            'bindingFeature' => $bindingFeature,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new BindingFeature entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="binding_feature_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a BindingFeature entity.
     *
     * @param BindingFeature $bindingFeature
     *
     * @return array
     *
     * @Route("/{id}", name="binding_feature_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(BindingFeature $bindingFeature) {

        return array(
            'bindingFeature' => $bindingFeature,
        );
    }

    /**
     * Displays a form to edit an existing BindingFeature entity.
     *
     *
     * @param Request $request
     * @param BindingFeature $bindingFeature
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="binding_feature_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, BindingFeature $bindingFeature, EntityManagerInterface $em) {
        $editForm = $this->createForm(BindingFeatureType::class, $bindingFeature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The bindingFeature has been updated.');
            return $this->redirectToRoute('binding_feature_show', array('id' => $bindingFeature->getId()));
        }

        return array(
            'bindingFeature' => $bindingFeature,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a BindingFeature entity.
     *
     *
     * @param Request $request
     * @param BindingFeature $bindingFeature
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="binding_feature_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, BindingFeature $bindingFeature, EntityManagerInterface $em) {

        $em->remove($bindingFeature);
        $em->flush();
        $this->addFlash('success', 'The bindingFeature was deleted.');

        return $this->redirectToRoute('binding_feature_index');
    }

}
