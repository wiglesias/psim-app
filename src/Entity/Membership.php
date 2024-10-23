<?php

namespace App\Entity;

use App\Repository\MembershipRepository;
use App\Value\MembershipRole;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
#[ORM\UniqueConstraint(name: 'memberships_org_user_id_uniq', columns: ['organization_id', 'user_id'])]
final class Membership
{
    public const ROLE_ADMIN = 'admin';

    public function __construct(Organization $organization, User $user, MembershipRole $role)
    {
        $this->organization = $organization;
        $this->user = $user;
        $this->role = $role;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private MembershipRole $role;

    #[ORM\ManyToOne(targetEntity: 'User', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: 'Organization', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Organization $organization;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): MembershipRole
    {
        return $this->role;
    }

    public function setRole(MembershipRole $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }
}
