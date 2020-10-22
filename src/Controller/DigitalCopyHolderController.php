<?php

namespace App\Controller;

use App\Repository\DigitalCopyHolderRepository;
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
use App\Entity\DigitalCopyHolder;
use App\Form\DigitalCopyHolderType;

/**
 * DigitalCopyHolder controller.
 *
 * @Route("/digital_copy_holder")
 */
class DigitalCopyHolderController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all DigitalCopyHolder entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="digital_copy_holder_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(DigitalCopyHolder::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $digitalCopyHolders = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'digitalCopyHolders' => $digitalCopyHolders,
        );
    }

    /**
     * Typeahead API endpoint for DigitalCopyHolder entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="digital_copy_holder_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, DigitalCopyHolderRepository $repo) {
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
     * Creates a new DigitalCopyHolder entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="digital_copy_holder_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $digitalCopyHolder = new DigitalCopyHolder();
        $form = $this->createForm(DigitalCopyHolderType::class, $digitalCopyHolder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($digitalCopyHolder);
            $em->flush();

            $this->addFlash('success', 'The new digitalCopyHolder was created.');
            return $this->redirectToRoute('digital_copy_holder_show', array('id' => $digitalCopyHolder->getId()));
        }

        return array(
            'digitalCopyHolder' => $digitalCopyHolder,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new DigitalCopyHolder entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="digital_copy_holder_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a DigitalCopyHolder entity.
     *
     * @param DigitalCopyHolder $digitalCopyHolder
     *
     * @return array
     *
     * @Route("/{id}", name="digital_copy_holder_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(DigitalCopyHolder $digitalCopyHolder) {

        return array(
            'digitalCopyHolder' => $digitalCopyHolder,
        );
    }

    /**
     * Displays a form to edit an existing DigitalCopyHolder entity.
     *
     *
     * @param Request $request
     * @param DigitalCopyHolder $digitalCopyHolder
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="digital_copy_holder_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, DigitalCopyHolder $digitalCopyHolder, EntityManagerInterface $em) {
        $editForm = $this->createForm(DigitalCopyHolderType::class, $digitalCopyHolder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The digitalCopyHolder has been updated.');
            return $this->redirectToRoute('digital_copy_holder_show', array('id' => $digitalCopyHolder->getId()));
        }

        return array(
            'digitalCopyHolder' => $digitalCopyHolder,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a DigitalCopyHolder entity.
     *
     *
     * @param Request $request
     * @param DigitalCopyHolder $digitalCopyHolder
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="digital_copy_holder_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, DigitalCopyHolder $digitalCopyHolder, EntityManagerInterface $em) {

        $em->remove($digitalCopyHolder);
        $em->flush();
        $this->addFlash('success', 'The digitalCopyHolder was deleted.');

        return $this->redirectToRoute('digital_copy_holder_index');
    }

}
