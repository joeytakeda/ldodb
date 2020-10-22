<?php

namespace App\Controller;

use App\Repository\RoleRepository;
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
use App\Entity\Role;
use App\Form\RoleType;

/**
 * Role controller.
 *
 * @Route("/role")
 */
class RoleController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Lists all Role entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="role_index", methods={"GET"})")
     *
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Role::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $roles = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'roles' => $roles,
        );
    }

    /**
     * Typeahead API endpoint for Role entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="role_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, RoleRepository $repo) {
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
     * Search for Role entities.
     *
     * @param Request $request
     *
     * @Route("/search", name="role_search", methods={"GET"})")
     *
     * @Template()
     */
    public function searchAction(Request $request, RoleRepository $repo) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $roles = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $roles = array();
        }

        return array(
            'roles' => $roles,
            'q' => $q,
        );
    }

    /**
     * Creates a new Role entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="role_new", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($role);
            $em->flush();

            $this->addFlash('success', 'The new role was created.');
            return $this->redirectToRoute('role_show', array('id' => $role->getId()));
        }

        return array(
            'role' => $role,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Role entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="role_new_popup", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a Role entity.
     *
     * @param Role $role
     *
     * @return array
     *
     * @Route("/{id}", name="role_show", methods={"GET"})")
     *
     * @Template()
     */
    public function showAction(Role $role) {

        return array(
            'role' => $role,
        );
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     *
     * @param Request $request
     * @param Role $role
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="role_edit", methods={"GET","POST"})")
     *
     * @Template()
     */
    public function editAction(Request $request, Role $role, EntityManagerInterface $em) {
        $editForm = $this->createForm(RoleType::class, $role);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'The role has been updated.');
            return $this->redirectToRoute('role_show', array('id' => $role->getId()));
        }

        return array(
            'role' => $role,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Role entity.
     *
     *
     * @param Request $request
     * @param Role $role
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="role_delete", methods={"GET"})")
     *
     */
    public function deleteAction(Request $request, Role $role, EntityManagerInterface $em) {

        $em->remove($role);
        $em->flush();
        $this->addFlash('success', 'The role was deleted.');

        return $this->redirectToRoute('role_index');
    }

}
