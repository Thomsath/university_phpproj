<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Evaluation", mappedBy="product")
     */
    private $evaluation;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="code_barre", type="bigint", unique=true)
     */
    private $codeBarre;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_consultations", type="integer", nullable=true, unique=false)
     */
    private $nbConsultations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_derniere_vue", type="date", nullable=true, unique=false)
     */
    private $dateDerniereVue;


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
     * Set codeBarre
     *
     * @param integer $codeBarre
     *
     * @return Product
     */
    public function setCodeBarre($codeBarre)
    {
        $this->codeBarre = $codeBarre;

        return $this;
    }

    /**
     * Get codeBarre
     *
     * @return int
     */
    public function getCodeBarre()
    {
        return $this->codeBarre;
    }

    /**
     * Set nbConsultations
     *
     * @param integer $nbConsultations
     *
     * @return Product
     */
    public function setNbConsultations($nbConsultations)
    {
        $this->nbConsultations = $nbConsultations;

        return $this;
    }

    /**
     * Get nbConsultations
     *
     * @return int
     */
    public function getNbConsultations()
    {
        return $this->nbConsultations;
    }

    /**
     * Set dateDerniereVue
     *
     * @param \DateTime $dateDerniereVue
     *
     * @return Product
     */
    public function setDateDerniereVue($dateDerniereVue)
    {
        $this->dateDerniereVue = $dateDerniereVue;

        return $this;
    }

    /**
     * Get dateDerniereVue
     *
     * @return \DateTime
     */
    public function getDateDerniereVue()
    {
        return $this->dateDerniereVue;
    }
}
