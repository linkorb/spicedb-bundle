<?php declare(strict_types=1);

namespace LinkORB\AuthzedBundle\Tests;

use LinkORB\AuthzedBundle\AuthzedBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        $bundles = [];

        if (in_array($this->getEnvironment(), ['test'])) {
            $bundles[] = new FrameworkBundle();
            $bundles[] = new AuthzedBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config_' . $this->getEnvironment() . '.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/AuthzedBundle/cache';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/AuthzedBundle/logs';
    }
}
