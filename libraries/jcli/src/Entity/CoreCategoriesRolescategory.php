<?php

namespace Adteam\Core\Motivale\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoreCategoriesRolescategory
 *
 * @ORM\Table(name="core_categories_rolescategory", uniqueConstraints={@ORM\UniqueConstraint(name="category_id", columns={"category_id", "role_id"})}, indexes={@ORM\Index(name="core_categories_rolescategory_ibfk_1", columns={"role_id"}), @ORM\Index(name="IDX_595BD3EA12469DE2", columns={"category_id"})})
 * @ORM\Entity
 */
class CoreCategoriesRolescategory
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
     * @var float
     *
     * @ORM\Column(name="fee", type="float", precision=20, scale=5, nullable=false, unique=false)
     */
    private $fee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdAt;

    /**
     * @var \Adteam\Core\Motivale\Entity\CoreRoles
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Motivale\Entity\CoreRoles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $role;

    /**
     * @var \Adteam\Core\Motivale\Entity\CoreProductCategories
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Motivale\Entity\CoreProductCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $category;


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
     * Set fee
     *
     * @param float $fee
     *
     * @return CoreCategoriesRolescategory
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * Get fee
     *
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CoreCategoriesRolescategory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set role
     *
     * @param \Adteam\Core\Motivale\Entity\CoreRoles $role
     *
     * @return CoreCategoriesRolescategory
     */
    public function setRole(\Adteam\Core\Motivale\Entity\CoreRoles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Adteam\Core\Motivale\Entity\CoreRoles
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set category
     *
     * @param \Adteam\Core\Motivale\Entity\CoreProductCategories $category
     *
     * @return CoreCategoriesRolescategory
     */
    public function setCategory(\Adteam\Core\Motivale\Entity\CoreProductCategories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Adteam\Core\Motivale\Entity\CoreProductCategories
     */
    public function getCategory()
    {
        return $this->category;
    }
}

