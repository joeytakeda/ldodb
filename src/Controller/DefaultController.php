<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\BindingFeature;
use App\Entity\MapSize;
use App\Entity\MapType;
use App\Entity\PlateType;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController  implements PaginatorAwareInterface {
    use PaginatorTrait;


    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @Template()
     */
    public function indexAction(Request $request) {
        return [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ];
    }

    /**
     * @Route("/features", name="homepage_features")
     * @Template()
     */
    public function featuresAction(Request $request, EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $bindingFeatures = $qb->select('bf')->from(BindingFeature::class, 'bf')->orderBy('bf.bindingFeature', 'ASC')->getQuery()->execute();
        $mapSizes = $qb->select('ms')->from(MapSize::class, 'ms')->orderBy('ms.mapSize', 'ASC')->getQuery()->execute();
        $mapTypes = $qb->select('mt')->from(MapType::class, 'mt')->orderBy('mt.mapType', 'ASC')->getQuery()->execute();
        $plateTypes = $qb->select('pt')->from(PlateType::class, 'pt')->orderBy('pt.plateType', 'ASC')->getQuery()->execute();

        return array(
            'bindingFeatures' => $bindingFeatures,
            'mapSizes' => $mapSizes,
            'mapTypes' => $mapTypes,
            'plateTypes' => $plateTypes,
        );
    }

    /**
     * @Route("/privacy", name="privacy", methods={"GET"})
     * @Template()
     */
    public function privacyAction(Request $request) {

    }
}
