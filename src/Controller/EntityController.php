<?php

namespace App\Controller;

use App\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Entity;

use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Entity controller.
 *
 * @Route("/entity")
 */
class EntityController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * Typeahead API endpoint for Book entities.
     *
     * @param Request $request
     *
     * @Route("/typeahead", name="entity_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, EntityRepository $repo) {
        $q = $request->query->get('q');
        if (!$q) {
            return new JsonResponse([]);
        }
        $data = [];
        foreach ($repo->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => sprintf("(%s) %s", $result->getType(), $result)
            ];
        }
        return new JsonResponse($data);
    }

}
