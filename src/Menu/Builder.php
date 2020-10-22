<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class to build some menus for navigation.
 */
class Builder implements ContainerAwareInterface {

    use ContainerAwareTrait;

    const CARET = ' ▾'; // U+25BE, black down-pointing small triangle.

    /**
     * @var FactoryInterface
     */

    private $factory;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $authChecker, TokenStorageInterface $tokenStorage) {
        $this->factory = $factory;
        $this->authChecker = $authChecker;
        $this->tokenStorage = $tokenStorage;
    }

    private function hasRole($role) {
        if (!$this->tokenStorage->getToken()) {
            return false;
        }
        return $this->authChecker->isGranted($role);
    }

    /**
     * Build a menu for blog posts.
     *
     * @param array $options
     * @return ItemInterface
     */
    public function mainMenu(array $options) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttributes(array(
            'class' => 'nav navbar-nav',
        ));

        $browse = $menu->addChild('browse', array(
            'label' => 'Browse ' . self::CARET,
            'uri' => '#',
        ));
        $browse->setAttribute('dropdown', true);
        $browse->setLinkAttribute('class', 'dropdown-toggle');
        $browse->setLinkAttribute('data-toggle', 'dropdown');
        $browse->setChildrenAttribute('class', 'dropdown-menu');

        $browse->addChild('book_index', array(
            'label' => 'Books',
            'route' => 'book_index',
        ));
        $browse->addChild('people_index', array(
            'label' => 'People',
            'route' => 'people_index',
        ));
        $browse->addChild('place_index', array(
            'label' => 'Places',
            'route' => 'place_index',
        ));

        $browse->addChild('divider1', array(
            'label' => '',
        ));
        $browse['divider1']->setAttributes(array(
            'role' => 'separator',
            'class' => 'divider',
        ));

        $browse->addChild('genre_index', array(
            'label' => 'Genres',
            'route' => 'genre_index',
        ));
        $browse->addChild('keyword_index', array(
            'label' => 'Keywords',
            'route' => 'keyword_index',
        ));
        $browse->addChild('subject_index', array(
            'label' => 'Subjects',
            'route' => 'subject_index',
        ));

        if ($this->hasRole('ROLE_CONTENT_ADMIN')) {
            $browse->addChild('divider', array(
                'label' => '',
            ));
            $browse['divider']->setAttributes(array(
                'role' => 'separator',
                'class' => 'divider',
            ));

            $browse->addChild('admin_only', array(
                'label' => '<b>Administrators</b>',
                'uri' => '#',
                'class' => 'disabled',
                'extras' => array('safe_label' => true),
            ));

            $browse->addChild('bibliographic_term_index', array(
                'label' => 'Bibliographic Terms',
                'route' => 'bibliographic_terms_index',
            ));
            $browse->addChild('binding_index', array(
                'label' => 'Binding Features',
                'route' => 'binding_feature_index'
            ));
            $browse->addChild('digital_copy_holder_index', array(
                'label' => 'Digital Copy Holders',
                'route' => 'digital_copy_holder_index',
            ));

            $browse->addChild('features', array(
                'label' => 'Features',
                'route' => 'homepage_features'
            ));
            $browse->addChild('map_size_index', array(
                'label' => 'Map Sizes',
                'route' => 'map_size_index'
            ));
            $browse->addChild('map_type_index', array(
                'label' => 'Map Types',
                'route' => 'map_type_index'
            ));
            $browse->addChild('organization_index', array(
                'label' => 'Organizations',
                'route' => 'organization_index',
            ));
            $browse->addChild('other_copy_location_index', array(
                'label' => 'Other Copy Locations',
                'route' => 'other_copy_location_index',
            ));
            $browse->addChild('other_national_edition_index', array(
                'label' => 'Other National Editions',
                'route' => 'other_national_edition_index',
            ));
            $browse->addChild('plate_type_index', array(
                'label' => 'Plate Types',
                'route' => 'plate_type_index'
            ));
            $browse->addChild('referenced_person_index', array(
                'label' => 'Referenced People',
                'route' => 'referenced_person_index',
            ));
            $browse->addChild('referenced_place_index', array(
                'label' => 'Referenced Places',
                'route' => 'referenced_place_index',
            ));
            $browse->addChild('role_index', array(
                'label' => 'Roles',
                'route' => 'role_index',
            ));
            $browse->addChild('subject_heading_index', array(
                'label' => 'Subject Headings',
                'route' => 'subject_heading_index',
            ));
            $browse->addChild('supplemental_place_data_index', array(
                'label' => 'Supplemental Place Data',
                'route' => 'supplemental_place_data_index',
            ));
            $browse->addChild('task_index', array(
                'label' => 'Tasks',
                'route' => 'task_index',
            ));

        }

        return $menu;
    }

}
