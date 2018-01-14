<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Evaluation", mappedBy="user")
     */
    private $evaluation;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /*
     * @ORM\nom
     * @ORM\Column(type="string")
     */
    private $nom;
    /*
     * @ORM\date_naissance
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /*
     * @ORM\sexe
     * @ORM\Column(type="boolean")
     */
    private $sexe;
    public function __construct()
    {
        parent::__construct();
       //$this->nom = new ArrayCollection();
    }

        /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

     /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get date_naissance
     *
     * @return datetime
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

     /**
     * Get sexe
     *
     * @return boolean
     */
    public function getSexe()
    {
        return $this->sexe;
    }
}
