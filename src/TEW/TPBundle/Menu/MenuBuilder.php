<?php
// src/TEW/TPBundle/Menu/MenuBuilder.php

namespace TEW\TPBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder // extends ContainerAware
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
     * @var Symfony\Component\DependencyInjection\Containert $container
     */
    protected $container;
    
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, $securityContext, $container)
    {
        $this->factory = $factory;
        $this->securityContext = $securityContext;
        $this->container = $container;
    }

    public function createMainMenu(Request $request)    
    {
        $is_client = $this->securityContext->isGranted('ROLE_CLIENT');
        $is_master_executor = $this->securityContext->isGranted('ROLE_MASTER_EXECUTOR');
        $is_std_executor = $this->securityContext->isGranted('ROLE_STD_EXECUTOR');
        $is_tew_staff = $this->securityContext->isGranted('ROLE_TEW_STAFF');
        $is_admin = $this->securityContext->isGranted('ROLE_ADMIN');
        
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        $em = $this->container->get('doctrine')->getManager();
        $user = $this->securityContext->getToken()->getUser();
        
        // Candidates
        if ($is_client) {
            $menu->addChild('Candidates')
                    ->setAttribute('icon', 'icon-male')
                    ->setAttribute('dropdown', true);
            $menu['Candidates']->addChild('Search', array('route' => 'tew_candidate_search'))
                    ->setAttribute('icon', 'icon-eye-open');
            $menu['Candidates']->addChild('List', array('route' => 'tew_candidate'))
                    ->setAttribute('icon', 'icon-list');
            $tps = $is_tew_staff ? $em->getRepository('TEWTPBundle:TalentPool')->findAll()
                        : $em->getRepository('TEWTPBundle:TalentPool')->findByOwningcompany($user->getCompany());
            $menu['Candidates']['List']
                ->setAttribute('dropdown',true)
                ->setAttribute('class', 'dropdown-submenu');
            $menu['Candidates']['List']->addChild('All', array('route' => 'tew_candidate'))
                    ->setAttribute('icon', 'icon-list');
            foreach ($tps as $tp) {
                $menu['Candidates']['List']->addChild($tp, array(
                            'route' => 'tew_candidate_by_tp',
                            'routeParameters' => array( 'id' => $tp->getId() )))
                    ;
            }
            $menu['Candidates']->addChild('Entry pool', array('route' => 'tew_candidate_sas'))
                    ->setAttribute('icon', 'icon-signin');
            $menu['Candidates']->addChild('Add', array('route' => 'tew_candidate_new'))
                    ->setAttribute('icon', 'icon-plus-sign-alt');
        }
        
        // Talent pools
        // add authorized items for the current user
        if ($is_client) {
            $session = $request->getSession();
            $workingtp = $session->get('workingtp');
            // Talent Pools
            if ($workingtp == null) {
                $menu->addChild('Talent pools')
                        ->setAttribute('icon', 'icon-sitemap')
                        ->setAttribute('dropdown', true);
                $menu['Talent pools']->addChild('List', array('route' => 'tew_talentpool'))
                        ->setAttribute('icon', 'icon-list');
                if ($is_tew_staff) {
                    $tps = $em->getRepository('TEWTPBundle:TalentPool')->findAll();
                    $menu['Talent pools']['List']
                        ->setAttribute('dropdown',true)
                        ->setAttribute('class', 'dropdown-submenu');
                    $menu['Talent pools']['List']->addChild('All', array('route' => 'tew_talentpool'))
                        ->setAttribute('icon', 'icon-list');
                    foreach ($tps as $tp) {
                        $menu['Talent pools']['List']->addChild($tp, array(
                                    'route' => 'tew_talentpool_show',
                                    'routeParameters' => array( 'id' => $tp->getId() )))
                            ;
                    }
                }
                if ($is_std_executor) { // only executors can add talentpools
                    $menu['Talent pools']->addChild('Add', array('route' => 'tew_talentpool_new'))
                            ->setAttribute('icon', 'icon-plus-sign-alt');   
                }
            } else { // working talentpool exists
                if ($workingtp->getPicture() != null) {
                    // to be finished
//                    $mediaservice = $this->getService('sonata.media.pool');
//                    $provider = $$mediaservice->getProvider($media->getProviderName());
//                    $format = $provider->getFormatName($workingtp->getPicture(), 'admin');
//                    
//                    $file = $provider->generatePublicUrl($workingtp->getPicture(), $format);
//                    //$path = getExtension();
//                    $menu->addchild('logo')
//                            ->setAttribute('background', '<img src="'.$file.'">');
                }
                $menu->addChild($workingtp->getName())
                        ->setAttribute('icon', 'icon-sitemap')
                        ->setAttribute('dropdown', true);
                $menu[$workingtp->getName()]->addChild('View '.$workingtp->getName(), array(
                            'route' => 'tew_talentpool_show',
                            'routeParameters' => array( 'id' => $workingtp->getId() )
                        ))
                        ->setAttribute('icon', 'icon-bookmark');
                if ($is_master_executor) { // only master executors can edit talentpools
                    $menu[$workingtp->getName()]->addChild('Edit '.$workingtp->getName(), array(
                                'route' => 'tew_talentpool_edit',
                                'routeParameters' => array( 'id' => $workingtp->getId() )
                            ))
                            ->setAttribute('icon', 'icon-edit');
                }
                $menu[$workingtp->getName()]->addChild('Change working talent pool', array('route' => 'tew_talentpool'))
                        ->setAttribute('icon', 'icon-random');
            }
        }
        
        // Companies
        if ($is_tew_staff) {
            $menu->addChild('Companies')
                    ->setAttribute('icon', 'icon-folder-open')
                    ->setAttribute('dropdown', true);
            $menu['Companies']->addChild('List', array('route' => 'tew_company'))
                    ->setAttribute('icon', 'icon-list')
                    ->setAttribute('dropdown',true)
                    ->setAttribute('class', 'dropdown-submenu')
                    ;
            $menu['Companies']['List']->addChild('All', array('route' => 'tew_company'))
                        ->setAttribute('icon', 'icon-list');
            
            $cies = $em->getRepository('TEWTPBundle:Company')->findAll();
            foreach ($cies as $cie) {
                $menu['Companies']['List']->addChild($cie, array(
                            'route' => 'tew_company_show',
                            'routeParameters' => array( 'id' => $cie->getId() )))
                    ;
            }
            if ($is_admin) {
                $menu['Companies']->addChild('Add', array('route' => 'tew_company_new'))
                        ->setAttribute('icon', 'icon-plus-sign-alt');
            }
        }
        
        // Statistics
        if ($is_client) {
            $menu->addChild('Statistics')
                    ->setAttribute('icon', 'icon-bar-chart')
                    ->setAttribute('dropdown', true);
            $menu['Statistics']->addChild('#cdte / talentpool', array('route' => 'tew_stats_cdtetalentpool'))
                    ->setAttribute('icon', 'icon-sitemap');
            $menu['Statistics']->addChild('#cdte / status / talentpool', array('route' => 'tew_stats_cdtestatustalentpool'))
                    ->setAttribute('icon', 'icon-sitemap');
            if ($is_admin) {
                $menu['Statistics']->addChild('Users operations', [
                        'route' => "tew_cdteoperation"
                    ])
                    ->setAttribute('icon', 'icon-wrench');
            }
        }
        
        // Bug tracking
        $is_alpha = preg_match('/app_alpha.php/', $request->getRequestUri());
        if ($is_client && $is_alpha) {
            $menu->addChild('Bugs and improvements')
                    ->setAttribute('icon', 'icon-bug')
                    ->setAttribute('dropdown', true);
            $menu['Bugs and improvements']->addChild('List', array('route' => 'hackzilla_ticket'))
                    ->setAttribute('icon', 'icon-list');
            $menu['Bugs and improvements']->addChild('Add', array('route' => 'hackzilla_ticket_new'))
                    ->setAttribute('icon', 'icon-plus-sign-alt');
        }        
        
        // Other stuff
        if ($is_tew_staff) {
            $users = $em->getRepository('TEWUserBundle:User')->getActive();
            $user_title = \count($users)." online users";
            $menu->addChild($user_title)
                    ->setAttribute('icon', 'icon-group')
                    ->setAttribute('dropdown', true);
            foreach ($users as $user) { // displays each connected user
                $menu[$user_title]->addChild("$user (".$user->getCompany().")", [
                    'route' => 'admin_tew_user_user_show',
                    'routeParameters' => array('id' => $user->getId())
                    ])
                    ->setAttribute('icon', 'icon-user')
                    ->setLinkAttribute('target', '_blank');
                
            }
        }
        
        return $menu;
    }

    public function createUserMenu(Request $request)
    {
        $user = $this->securityContext->getToken()->getUser();
        $is_granted = $this->securityContext->isGranted('ROLE_USER');
        $is_admin = $this->securityContext->isGranted('ROLE_ADMIN');
        
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav pull-right');
        
        if($is_granted) {
            
            $username = $user->getUsername(); // Get username of the current logged in user
            $company = $user->getCompany();
            
            // User
            $menu->addChild('User', array('label' => $username . ($company?' ('.$company.')':'')))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');
            if ($is_admin) {
                $menu['User']->addChild('View my profile', array('route' => 'sonata_user_profile_show'))
                    ->setAttribute('icon', 'icon-user');
                $menu['User']->addChild('Change my password', array('route' => 'sonata_user_change_password'))
                    ->setAttribute('icon', 'icon-random');        
                $menu['User']->addChild('Edit profile', array('route' => 'sonata_user_profile_edit'))
                    ->setAttribute('icon', 'icon-edit');
            }
            $menu['User']->addChild('Logout', array('route' => 'sonata_user_security_logout'))
                ->setAttribute('icon', 'icon-off');
            
            // Backoffice
            if ($this->securityContext->isGranted('ROLE_SONATA_ADMIN')){
                $menu->addChild('Backoffice', array('route' => 'sonata_admin_redirect'))
                    ->setAttribute('icon', 'icon-dashboard')
                    ->setLinkAttribute('target', '_new');
            }
        } else {
//            $menu->addChild('', array('route' => 'sonata_user_security_login'))
//                ->setAttribute('icon', 'icon-user');          
        }
        return $menu;
    }
}

