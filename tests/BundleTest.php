<?php declare(strict_types=1);

namespace LinkORB\Bundle\SpicedbBundle\Tests;

use LinkORB\Authzed\ConnectorInterface;
use LinkORB\Authzed\Dto\ObjectReference;
use LinkORB\Authzed\Dto\Request\PermissionCheck as PermissionCheckRequest;
use LinkORB\Authzed\Dto\Response\PermissionCheck;
use LinkORB\Authzed\Dto\SubjectReference;
use LinkORB\Authzed\SpiceDB;
use LinkORB\Bundle\SpicedbBundle\Security\AuthzedSubject;
use LinkORB\Bundle\SpicedbBundle\Security\AuthzedVoter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class BundleTest extends KernelTestCase
{
    public function testBundle(): void
    {
        static::bootKernel();

        $container = static::getContainer();

        $this->assertInstanceOf(SpiceDB::class, $container->get(SpiceDB::class));
        $this->assertInstanceOf(SpiceDB::class, $container->get(ConnectorInterface::class));
    }

    public function testBundleNoPermissions(): void
    {
        static::bootKernel(['environment' => 'test_no_permissions']);

        $container = static::getContainer();

        $this->assertInstanceOf(SpiceDB::class, $container->get(SpiceDB::class));
        $this->assertInstanceOf(SpiceDB::class, $container->get(ConnectorInterface::class));

        $this->expectException(ServiceNotFoundException::class);
        $container->get(AuthzedVoter::class);
    }

    public function testVoter(): void
    {
        static::bootKernel();

        $container = static::getContainer();

        $client = $this->createMock(ConnectorInterface::class);
        $client->expects($this->once())
            ->method('checkPermission')
            ->willReturn(new PermissionCheck(null, PermissionCheck::PERMISSIONSHIP_NO_PERMISSION));
        $container->set(SpiceDB::class, $client);

        $voter = $container->get(AuthzedVoter::class);
        $this->assertInstanceOf(AuthzedVoter::class, $voter);

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $voter->vote(
                new NullToken(),
                new AuthzedSubject(
                    new SubjectReference(new ObjectReference('user_data', '456')),
                    new ObjectReference('user', '123')
                ),
                ['view']
            )
        );
    }

    public function testVoterNotSupports(): void
    {
        static::bootKernel();

        $container = static::getContainer();
        $voter = $container->get(AuthzedVoter::class);

        $this->assertEquals(
            VoterInterface::ACCESS_ABSTAIN,
            $voter->vote(
                new NullToken(),
                new AuthzedSubject(
                    new SubjectReference(new ObjectReference('user_message', '999')),
                    new ObjectReference('user', '777')
                ),
                ['write']
            )
        );
    }

    public function testVoterException(): void
    {
        static::bootKernel();

        $container = static::getContainer();

        $voter = $container->get(AuthzedVoter::class);

        $this->expectException(TransportException::class);

        $voter->vote(
            new NullToken(),
            new AuthzedSubject(
                new SubjectReference(new ObjectReference('user_data', '456')),
                new ObjectReference('user', '123')
            ),
            ['view']
        );
    }

    public function testVoterCaveat(): void
    {
        static::bootKernel();

        $container = static::getContainer();

        $subject = new AuthzedSubject(
            new SubjectReference(new ObjectReference('user_data', '456')),
            new ObjectReference('user', '123'),
            null,
            ['second_parameter' => 'hello world']
        );

        $client = $this->createMock(ConnectorInterface::class);
        $client->expects($this->once())
            ->method('checkPermission')
            ->with(new PermissionCheckRequest(
                $subject->getConsistency(),
                $subject->getObject(),
                'view',
                $subject->getSubject(),
                $subject->getCaveatContext()
            ))
            ->willReturn(new PermissionCheck(null, PermissionCheck::PERMISSIONSHIP_NO_PERMISSION));
        $container->set(SpiceDB::class, $client);

        $voter = $container->get(AuthzedVoter::class);
        $this->assertInstanceOf(AuthzedVoter::class, $voter);

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $voter->vote(new NullToken(), $subject, ['view'])
        );
    }
}
