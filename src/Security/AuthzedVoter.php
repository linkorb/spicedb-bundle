<?php declare(strict_types=1);

namespace LinkORB\AuthzedBundle\Security;

use LinkORB\Authzed\ConnectorInterface;
use LinkORB\Authzed\Dto\PermissionUpdate;
use LinkORB\Authzed\Dto\Request\PermissionCheck as PermissionCheckRequest;
use LinkORB\Authzed\Exception\SpiceDBServerException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AuthzedVoter extends Voter
{
    private ConnectorInterface $connector;
    private array $permissions;

    public function __construct(ConnectorInterface $connector, array $permissions)
    {
        $this->connector = $connector;
        $this->permissions = $permissions;
    }

    /**
     * @inheritDoc
     *
     * @param AuthzedSubject|mixed $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (!$subject instanceof AuthzedSubject) {
            return false;
        }

        $availablePermissions = $this->permissions[$subject->getSubject()->getObject()->getObjectType() ?? ''] ?? [];

        return in_array($attribute, $availablePermissions, true);
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        assert($subject instanceof AuthzedSubject);

        try {
            $response = $this->connector->checkPermission(
                new PermissionCheckRequest(
                    $subject->getConsistency(),
                    $subject->getObject(),
                    $attribute,
                    $subject->getSubject(),
                    $subject->getCaveatContext()
                )
            );
        } catch (SpiceDBServerException $e) {
            return false;
        }

        return $response->getPermissionship() === PermissionUpdate::PERMISSIONSHIP_HAS_PERMISSION;
    }
}
