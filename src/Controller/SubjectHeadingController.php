<?php

namespace App\Controller;

use App\Repository\SubjectHeadingRepository;
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
use App\Entity\SubjectHeading;
use App\Form\SubjectHeadingType;

/**
 * SubjectHeading controller.
 *
 * @Route("/subject_heading")
 */
class SubjectHeadingController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all SubjectHeading entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="subject_heading_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(SubjectHeading::class, 'e')->orderBy('e.subjectHeading', 'ASC');
        $query = $qb->getQuery();

        $subjectHeadings = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'subjectHeadings' => $subjectHeadings,
        );
    }

    /**
     * Typeahead API endpoint for SubjectHeading entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="subject_heading_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, SubjectHeadingRepository $repo) {
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
     * Search for SubjectHeading entities.
     *
     * @param Request $request
     *
     * @Route("/search", name="subject_heading_search", methods={"GET"})")
     *
     * @Template()
     */
    public function searchAction(Request $request, SubjectHeadingRepository $repo) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $subjectHeadings = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $subjectHeadings = array();
        }

        return array(
            'subjectHeadings' => $subjectHeadings,
            'q' => $q,
        );
    }

    /**
     * Creates a new SubjectHeading entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="subject_heading_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $subjectHeading = new SubjectHeading();
        $form = $this->createForm(SubjectHeadingType::class, $subjectHeading);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($subjectHeading);
            $em->flush();

            $this->addFlash('success', 'The new subjectHeading was created.');
            return $this->redirectToRoute('subject_heading_show', array('id' => $subjectHeading->getId()));
        }

        return array(
            'subjectHeading' => $subjectHeading,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new SubjectHeading entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="subject_heading_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a SubjectHeading entity.
     *
     * @param SubjectHeading $subjectHeading
     *
     * @return array
     *
     * @Route("/{id}", name="subject_heading_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(SubjectHeading $subjectHeading) {

        return array(
            'subjectHeading' => $subjectHeading,
        );
    }

    /**
     * Displays a form to edit an existing SubjectHeading entity.
     *
     *
     * @param Request $request
     * @param SubjectHeading $subjectHeading
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="subject_heading_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, SubjectHeading $subjectHeading, EntityManagerInterface $em) {
        $editForm = $this->createForm(SubjectHeadingType::class, $subjectHeading);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The subjectHeading has been updated.');
            return $this->redirectToRoute('subject_heading_show', array('id' => $subjectHeading->getId()));
        }

        return array(
            'subjectHeading' => $subjectHeading,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a SubjectHeading entity.
     *
     *
     * @param Request $request
     * @param SubjectHeading $subjectHeading
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="subject_heading_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, SubjectHeading $subjectHeading, EntityManagerInterface $em) {

        $em->remove($subjectHeading);
        $em->flush();
        $this->addFlash('success', 'The subjectHeading was deleted.');

        return $this->redirectToRoute('subject_heading_index');
    }

}
