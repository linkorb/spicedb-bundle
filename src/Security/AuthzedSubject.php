<?php declare(strict_types=1);

namespace LinkORB\AuthzedBundle\Security;

use LinkORB\Authzed\Dto\Consistency;
use LinkORB\Authzed\Dto\ObjectReference;
use LinkORB\Authzed\Dto\SubjectReference;

class AuthzedSubject
{
    private SubjectReference $subject;
    private ObjectReference $object;
    private ?Consistency $consistency;
    private ?array $caveatContext;

    public function __construct(
        SubjectReference $subject,
        ObjectReference  $object,
        Consistency      $consistency = null,
        array            $caveatContext = null
    )
    {
        $this->subject       = $subject;
        $this->object        = $object;
        $this->consistency   = $consistency;
        $this->caveatContext = $caveatContext;
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
