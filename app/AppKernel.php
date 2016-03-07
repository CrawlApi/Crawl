<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/7
 * Time: 上午11:52
 */

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    /**
     * Returns an array of bundles to register.
     *
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface[] An array of bundle instances.
     */
    public function registerBundles()
    {
        $bundles = array(
            // Base Bundle
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),

            // Crawl Bundle
            new Crawl\CommonBundle\CrawlCommonBundle(),
            new Crawl\ApiBundle\CrawlApiBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}