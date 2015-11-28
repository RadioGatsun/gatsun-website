<?php

namespace Gatsun\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gatsun\WebsiteBundle\Entity\PublicationRepository")
 */
class Publication
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="vignette", type="string", length=255)
     */
    private $vignette;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="podcast", type="text")
     */
    private $podcast;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \Gatsun\WebsiteBundle\Entity\Emission
     *
     * @ORM\ManyToOne(targetEntity="Gatsun\WebsiteBundle\Entity\Emission")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emission;


    /**
     * @var \Gatsun\WebsiteBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Gatsun\WebsiteBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;


    public function __construct()
    {
        $this->date = new \Datetime();  // Par défaut, la date de la publication est la date d'aujourd'hui
        $this->podcast = '';            // Par défaut, la publication est une news
        $this->vignette = 'images/defaut/news.png';
    }


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
     * Set titre
     *
     * @param string $titre
     * @return Publication
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set vignette
     *
     * @param string $vignette
     * @return Publication
     */
    public function setVignette($vignette)
    {
        if($vignette == null)
        {
            $vignette = 'images/defaut/news.png';
        }

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
     * Set contenu
     *
     * @param string $contenu
     * @return Publication
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set podcast
     *
     * @param string $podcast
     * @return Publication
     */
    public function setPodcast($podcast = '')
    {
        if($podcast == null)
        {
            $podcast = '';
        }

        $this->podcast = $podcast;
    
        return $this;
    }

    /**
     * Get podcast
     *
     * @return string 
     */
    public function getPodcast()
    {
        return $this->podcast;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Publication
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set emission
     *
     * @param \Gatsun\WebsiteBundle\Entity\Emission $emission
     * @return Publication
     */
    public function setEmission($emission = null)
    {
        $this->emission = $emission;

        return $this;
    }

    /**
     * Get emission
     *
     * @return \Gatsun\WebsiteBundle\Entity\Emission 
     */
    public function getEmission()
    {
        return $this->emission;
    }

    /**
     * Set utilisateur
     *
     * @param \Gatsun\WebsiteBundle\Entity\Utilisateur $utilisateur
     * @return Publication
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
    
        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Gatsun\WebsiteBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}