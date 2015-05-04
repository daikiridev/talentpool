<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // SYMFONY STANDARD EDITION
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            
            // DOCTRINE
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(), // Test packs
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            
            // USER
            new FOS\UserBundle\FOSUserBundle(), // User management
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'), // User managment via Sonata
            new TEW\UserBundle\TEWUserBundle(),
            
            // MEDIA
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(), // needed by Sonata Media
            new Sonata\ClassificationBundle\SonataClassificationBundle(), // needed by Sonata Media
            new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle(), // needed by Sonata Media
            
            // STATISTICS
            new SaadTazi\GChartBundle\SaadTaziGChartBundle(),
            
            // SONATA CORE & HELPER BUNDLES
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(), // In order to generate a valid bundle structure from a Vendor bundle
            new Sonata\CoreBundle\SonataCoreBundle(), // In order to make the admin managment work
            new Sonata\IntlBundle\SonataIntlBundle(), // Internationalisation (locale, etc.)
            new Sonata\AdminBundle\SonataAdminBundle(), // Backoffice
            new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(), // Blocks (in backoffice)
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            
            // KNP HELPER BUNDLES
            new Knp\Bundle\MenuBundle\KnpMenuBundle(), // used by sonata-admin and front-office as well
            
            // FPN TAG MANAGEMENT
            new FPN\TagBundle\FPNTagBundle(),
            //new Fogs\TaggingBundle\FogsTaggingBundle(),
            
//            // CK EDITOR
//            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            
            // MISC
            //new AppBundle\AppBundle(),
            new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle(),
        
            // TEW BUNDLE
            new TEW\TPBundle\TEWTPBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test', 'alpha'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            // TICKETING
            $bundles[] = new Hackzilla\Bundle\TicketBundle\HackzillaTicketBundle();
            $bundles[] = new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle();
            //$bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
