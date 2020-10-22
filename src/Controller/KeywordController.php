<?php

namespace App\Controller;

use App\Repository\KeywordRepository;
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
use App\Entity\Keyword;
use App\Form\KeywordType;

/**
 * Keyword controller.
 *
 * @Route("/keyword")
 */
class KeywordController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all Keyword entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="keyword_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Keyword::class, 'e')->orderBy('e.keyword', 'ASC');
        $query = $qb->getQuery();

        $keywords = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'keywords' => $keywords,
        );
    }

    /**
     * Typeahead API endpoint for Keyword entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="keyword_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, KeywordRepository $repo) {
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
     * Search for Keyword entities.
     *
     * @param Request $request
     *
     * @Route("/search", name="keyword_search", methods={"GET"})")
     *
     * @Template()
     */
    public function searchAction(Request $request, KeywordRepository $repo) {

        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $keywords = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $keywords = array();
        }

        return array(
            'keywords' => $keywords,
            'q' => $q,
        );
    }

    /**
     * Creates a new Keyword entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="keyword_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $keyword = new Keyword();
        $form = $this->createForm(KeywordType::class, $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($keyword);
            $em->flush();

            $this->addFlash('success', 'The new keyword was created.');
            return $this->redirectToRoute('keyword_show', array('id' => $keyword->getId()));
        }

        return array(
            'keyword' => $keyword,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Keyword entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="keyword_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a Keyword entity.
     *
     * @param Keyword $keyword
     *
     * @return array
     *
     * @Route("/{id}", name="keyword_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(Keyword $keyword) {

        return array(
            'keyword' => $keyword,
        );
    }

    /**
     * Displays a form to edit an existing Keyword entity.
     *
     *
     * @param Request $request
     * @param Keyword $keyword
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="keyword_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, Keyword $keyword, EntityManagerInterface $em) {
        $editForm = $this->createForm(KeywordType::class, $keyword);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The keyword has been updated.');
            return $this->redirectToRoute('keyword_show', array('id' => $keyword->getId()));
        }

        return array(
            'keyword' => $keyword,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Keyword entity.
     *
     *
     * @param Request $request
     * @param Keyword $keyword
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="keyword_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, Keyword $keyword, EntityManagerInterface $em) {

        $em->remove($keyword);
        $em->flush();
        $this->addFlash('success', 'The keyword was deleted.');

        return $this->redirectToRoute('keyword_index');
    }

}
