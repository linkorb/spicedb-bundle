<?php declare(strict_types=1);

namespace LinkORB\Bundle\SpicedbBundle\Security;

use LinkORB\Authzed\Dto\Consistency;
use LinkORB\Authzed\Dto\ObjectReference;
use LinkORB\Authzed\Dto\SubjectReference;

class AuthzedSubject
{
    private readonly SubjectReference $subject;
    private readonly ObjectReference $object;

    public function __construct(
        SubjectReference $subject,
        ObjectReference  $object,
        private readonly ?Consistency      $consistency = null,
        private readonly ?array            $caveatContext = null
    )
    {
        $this->subject       = $subject;
        $this->object        = $object;
    }

    public function getSubject(): SubjectReference
    {
        return $this->subject;
    }

    public function getObject(): ObjectReference
    {
        return $this->object;
    }

    public function getConsistency(): ?Consistency
    {
        return $this->consistency;
    }

    public function getCaveatContext(): ?array
    {
        return $this->caveatContext;
    }
}
