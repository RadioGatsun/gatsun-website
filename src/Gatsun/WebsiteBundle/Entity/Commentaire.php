<?php

namespace Gatsun\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gatsun\WebsiteBundle\Entity\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="supprime", type="boolean")
    */
    private $supprime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modere", type="boolean")
    */
    private $modere;

    /**
     * @var \Gatsun\WebsiteBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Gatsun\WebsiteBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @var \Gatsun\WebsiteBundle\Entity\Publication
     *
     * @ORM\ManyToOne(targetEntity="Gatsun\WebsiteBundle\Entity\Publication", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $publication;

    public function __construct()
    {
        $this->supprime = false;
        $this->modere = false;
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
     * Set texte
     *
     * @param string $texte
     * @return Commentaire
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    
        return $this;
    }

    /**
     * Get texte
     *
     * @return string 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commentaire
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
     * Set utilisateur
     *
     * @param \Gatsun\WebsiteBundle\Entity\Utilisateur $utilisateur
     * @return Commentaire
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

    /**
     * Set publication
     *
     * @param \Gatsun\WebsiteBundle\Entity\Publication $publication
     * @return Commentaire
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    
        return $this;
    }

    /**
     * Get publication
     *
     * @return \Gatsun\WebsiteBundle\Entity\Publication 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set supprime
     *
     * @param boolean
     * @return Commentaire
     */
    public function setSupprime($supprime)
    {
        $this->supprime = $supprime;
    
        return $this;
    }

    /**
     * Get supprime
     *
     * @return boolean
     */
    public function getSupprime()
    {
        return $this->supprime;
    }

    /**
     * Set modere
     *
     * @param boolean
     * @return Commentaire
     */
    public function setModere($modere)
    {
        $this->modere = $modere;
    
        return $this;
    }

    /**
     * Get modere
     *
     * @return boolean
     */
    public function getModere()
    {
        return $this->modere;
    }
}