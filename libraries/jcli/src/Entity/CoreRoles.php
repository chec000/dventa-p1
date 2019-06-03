<?php

namespace Adteam\Core\Motivale\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoreRoles
 *
 * @ORM\Table(name="core_roles", uniqueConstraints={@ORM\UniqueConstraint(name="role", columns={"role"})}, indexes={@ORM\Index(name="core_roles_ibfk_1", columns={"parent_id"})})
 * @ORM\Entity(repositoryClass="Adteam\Core\Motivale\Repository\CoreRolesRepository")
 */
class CoreRoles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=40, precision=0, scale=0, nullable=false, unique=false)
     */
    private $role;

    /**
     * @var \Adteam\Core\Motivale\Entity\CoreRoles
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Motivale\Entity\CoreRoles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $parent;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return CoreRoles
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set parent
     *
     * @param \Adteam\Core\Motivale\Entity\CoreRoles $parent
     *
     * @return CoreRoles
     */
    public function setParent(\Adteam\Core\Motivale\Entity\CoreRoles $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Adteam\Core\Motivale\Entity\CoreRoles
     */
    public function getParent()
    {
        return $this->parent;
    }
}

