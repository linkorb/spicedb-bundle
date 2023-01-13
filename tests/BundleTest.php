<?php declare(strict_types=1);

namespace LinkORB\AuthzedBundle\Tests;

use LinkORB\Authzed\ConnectorInterface;
use LinkORB\Authzed\SpiceDB;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BundleTest extends KernelTestCase
{
    public function testBundle()
    {
        static::bootKernel();

        $container = static::getContainer();

        $this->assertInstanceOf(SpiceDB::class, $container->get(SpiceDB::class));
        $this->assertInstanceOf(SpiceDB::class, $container->get(ConnectorInterface::class));
    }
}
