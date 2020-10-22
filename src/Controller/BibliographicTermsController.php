<?php

namespace App\Controller;

use App\Repository\BibliographicTermsRepository;
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
use App\Entity\BibliographicTerms;
use App\Form\BibliographicTermsType;

/**
 * BibliographicTerms controller.
 *
 * @Route("/bibliographic_terms")
 */
class BibliographicTermsController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * Lists all BibliographicTerms entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="bibliographic_terms_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(BibliographicTerms::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $bibliographicTerms = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'bibliographicTerms' => $bibliographicTerms,
        );
    }

    /**
     * Typeahead API endpoint for BibliographicTerms entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="bibliographic_terms_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, BibliographicTermsRepository $repo) {
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
     * Creates a new BibliographicTerms entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="bibliographic_terms_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $bibliographicTerm = new BibliographicTerms();
        $form = $this->createForm(BibliographicTermsType::class, $bibliographicTerm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($bibliographicTerm);
            $em->flush();

            $this->addFlash('success', 'The new bibliographicTerm was created.');
            return $this->redirectToRoute('bibliographic_terms_show', array('id' => $bibliographicTerm->getId()));
        }

        return array(
            'bibliographicTerm' => $bibliographicTerm,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new BibliographicTerms entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="bibliographic_terms_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a BibliographicTerms entity.
     *
     * @param BibliographicTerms $bibliographicTerm
     *
     * @return array
     *
     * @Route("/{id}", name="bibliographic_terms_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(BibliographicTerms $bibliographicTerm) {

        return array(
            'bibliographicTerm' => $bibliographicTerm,
        );
    }

    /**
     * Displays a form to edit an existing BibliographicTerms entity.
     *
     *
     * @param Request $request
     * @param BibliographicTerms $bibliographicTerm
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="bibliographic_terms_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, BibliographicTerms $bibliographicTerm, EntityManagerInterface $em) {
        $editForm = $this->createForm(BibliographicTermsType::class, $bibliographicTerm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The bibliographicTerm has been updated.');
            return $this->redirectToRoute('bibliographic_terms_show', array('id' => $bibliographicTerm->getId()));
        }

        return array(
            'bibliographicTerm' => $bibliographicTerm,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a BibliographicTerms entity.
     *
     *
     * @param Request $request
     * @param BibliographicTerms $bibliographicTerm
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="bibliographic_terms_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, BibliographicTerms $bibliographicTerm, EntityManagerInterface $em) {

        $em->remove($bibliographicTerm);
        $em->flush();
        $this->addFlash('success', 'The bibliographicTerm was deleted.');

        return $this->redirectToRoute('bibliographic_terms_index');
    }

}
