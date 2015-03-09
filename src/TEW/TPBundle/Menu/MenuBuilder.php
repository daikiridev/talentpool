<?php
// src/TEW/TPBundle/Menu/MenuBuilder.php

namespace TEW\TPBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    /**
     * @var Symfony\Component\Form\FormFactory $factory
     */
    private $factory;

    /**
     * @var Symfony\Component\Security\Core\SecurityContext $securityContext
     */
    private $securityContext;
    
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, $securityContext)
    {
        $this->factory = $factory;
        $this->securityContext = $securityContext;
    }

    public function createMainMenu(Request $request)    
    {
        $is_client = $this->securityContext->isGranted(array('ROLE_CLIENT'));
        
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

//        $menu->addChild('Home', array('route' => 'tp_home'))
//            ->setAttribute('icon', 'icon-home');
        
        // add authorized items for the current user
        if ($is_client) {
            // Talent Pools
            $menu->addChild('Talent pools')
                    ->setAttribute('icon', 'icon-sitemap')
                    ->setAttribute('dropdown', true);
            $menu['Talent pools']->addChild('List', array('route' => 'tew_talentpool'))
                    ->setAttribute('icon', 'icon-list');
            $menu['Talent pools']->addChild('New', array('route' => 'tew_talentpool_new'))
                    ->setAttribute('icon', 'icon-plus-sign-alt');
            
            // Candidates
            $menu->addChild('Candidates')
                    ->setAttribute('icon', 'icon-male')
                    ->setAttribute('dropdown', true);
            $menu['Candidates']->addChild('Search', array('route' => 'tew_candidate_search'))
                    ->setAttribute('icon', 'icon-eye-open');
            $menu['Candidates']->addChild('List', array('route' => 'tew_candidate'))
                    ->setAttribute('icon', 'icon-list');
            $menu['Candidates']->addChild('Add', array('route' => 'tew_candidate_new'))
                    ->setAttribute('icon', 'icon-plus-sign-alt');
        }
        return $menu;
    }

    public function createUserMenu(Request $request)
    {
        $user = $this->securityContext->getToken()->getUser();
        $is_granted = $this->securityContext->isGranted(array('ROLE_USER'));
        $is_admin = $this->securityContext->isGranted(array('ROLE_ADMIN'));
        
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav pull-right');
        
        if($is_granted) {
            
            $username = $user->getUsername(); // Get username of the current logged in user
            
            // User
            $menu->addChild('User', array('label' => $username))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');
            
            $menu['User']->addChild('View my profile', array('route' => 'sonata_user_profile_show'))
                ->setAttribute('icon', 'icon-user');
            $menu['User']->addChild('Change my password', array('route' => 'sonata_user_change_password'))
                ->setAttribute('icon', 'icon-random');        
            $menu['User']->addChild('Edit profile', array('route' => 'sonata_user_profile_edit'))
                ->setAttribute('icon', 'icon-edit');
            $menu['User']->addChild('Logout', array('route' => 'sonata_user_security_logout'))
                ->setAttribute('icon', 'icon-off');
            
            // Backoffice
            if ($is_admin){
                $menu->addChild('Backoffice', array('route' => 'sonata_admin_redirect'))
                    ->setAttribute('icon', 'icon-dashboard')
                    ->setLinkAttribute('target', '_new');
            }
        } else {
            $menu->addChild('', array('route' => 'sonata_user_security_login'))
                ->setAttribute('icon', 'icon-user');          
        }
        return $menu;
    }
}

