<?php

namespace App\Controller;

use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Subject;
use App\Form\SubjectType;

/**
 * Subject controller.
 *
 * @Route("/subject")
 */
class SubjectController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all Subject entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="subject_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Subject::class, 'e')->orderBy('e.subjectName', 'ASC');
        $query = $qb->getQuery();

        $subjects = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'subjects' => $subjects,
        );
    }

    /**
     * Typeahead API endpoint for Subject entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="subject_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, SubjectRepository $repo) {
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
     * Search for Subject entities.
     *
     * @param Request $request
     *
     * @Route("/search", name="subject_search", methods={"GET"})")
     *
     * @Template()
     */
    public function searchAction(Request $request, SubjectRepository $repo) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $subjects = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $subjects = array();
        }

        return array(
            'subjects' => $subjects,
            'q' => $q,
        );
    }

    /**
     * Creates a new Subject entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="subject_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($subject);
            $em->flush();

            $this->addFlash('success', 'The new subject was created.');
            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        }

        return array(
            'subject' => $subject,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Subject entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="subject_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a Subject entity.
     *
     * @param Subject $subject
     *
     * @return array
     *
     * @Route("/{id}", name="subject_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(Subject $subject) {
        $iterator = $subject->getBooks()->getIterator();
        $iterator->uasort(function(Book $a, Book $b){
            return strcasecmp($a->getTitle(), $b->getTitle());
        });

        return array(
            'subject' => $subject,
            'books' => $iterator,
        );
    }

    /**
     * Displays a form to edit an existing Subject entity.
     *
     *
     * @param Request $request
     * @param Subject $subject
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="subject_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, Subject $subject, EntityManagerInterface $em) {
        $editForm = $this->createForm(SubjectType::class, $subject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The subject has been updated.');
            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        }

        return array(
            'subject' => $subject,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Subject entity.
     *
     *
     * @param Request $request
     * @param Subject $subject
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="subject_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, Subject $subject, EntityManagerInterface $em) {

        $em->remove($subject);
        $em->flush();
        $this->addFlash('success', 'The subject was deleted.');

        return $this->redirectToRoute('subject_index');
    }

}
