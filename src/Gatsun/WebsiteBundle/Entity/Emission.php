<?php

namespace Gatsun\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Emission
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gatsun\WebsiteBundle\Entity\EmissionRepository")
 */
class Emission
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="bandeau", type="text", nullable=true)
     */
    private $bandeau;

    /**
     * @var string
     *
     * @ORM\Column(name="vignette", type="text")
     */
    private $vignette;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="Jour")
     * @ORM\JoinColumn(name="jour_id", referencedColumnName="id", nullable=true)
     **/
    private $jour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureDebut", type="time", nullable=true)
     **/
    private $heureDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureFin", type="time", nullable=true)
     **/
    private $heureFin;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Gatsun\WebsiteBundle\Entity\Utilisateur", cascade={"persist"})
     */
    private $presentateurs;


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
     * Set nom
     *
     * @param string $nom
     * @return Emission
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
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
     * Set description
     *
     * @param string $description
     * @return Emission
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set bandeau
     *
     * @param string $bandeau
     * @return Emission
     */
    public function setBandeau($bandeau)
    {
        $this->bandeau = $bandeau;

        return $this;
    }

    /**
     * Get bandeau
     *
     * @return string
     */
    public function getBandeau()
    {
        return $this->bandeau;
    }

    /**
     * Set vignette
     *
     * @param string $vignette
     * @return Emission
     */
    public function setVignette($vignette)
    {
        $this->vignette = $vignette;

        return $this;
    }

    /**
     * Get vignette
     *
     * @return string
     */
    public function getVignette()
    {
        return $this->vignette;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->presentateurs = new ArrayCollection();
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return Emission
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Jour
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * @param Jour $jour
     * @return Emission
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHeureDebut()
    {
        return $this->heureDebut;
    }

    /**
     * @param mixed $heureDebut
     * @return Emission
     */
    public function setHeureDebut($heureDebut)
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHeureFin()
    {
        return $this->heureFin;
    }

    /**
     * @param \DateTime $heureFin
     * @return Emission
     */
    public function setHeureFin($heureFin)
    {
        $this->heureFin = $heureFin;

        return $this;
    }


    /**
     * Add presentateurs
     *
     * @param \Gatsun\WebsiteBundle\Entity\Utilisateur $presentateur
     * @return Emission
     */
    public function addPresentateur($presentateur)
    {
        $this->presentateurs[] = $presentateur;

        return $this;
    }

    /**
     * Remove presentateurs
     *
     * @param \Gatsun\WebsiteBundle\Entity\Utilisateur $presentateurs
     */
    public function removePresentateur($presentateurs)
    {
        $this->presentateurs->removeElement($presentateurs);
    }

    /**
     * Get presentateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPresentateurs()
    {
        return $this->presentateurs;
    }
}