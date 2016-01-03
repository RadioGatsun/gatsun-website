<?php

namespace Gatsun\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Publication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gatsun\WebsiteBundle\Entity\PublicationRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="publication_image", fileNameProperty="image")
     *
     * @var File
     */
    private $fichierImage;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $dateMiseaJourImage;

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

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Gatsun\WebsiteBundle\Entity\Commentaire", mappedBy="publication", cascade={"remove"})
     */
    private $commentaires;

    /**
     * Publication constructor.
     */
    public function __construct()
    {
        $this->date = new \Datetime();  // Par défaut, la date de la publication est la date d'aujourd'hui
        $this->podcast = '';            // Par défaut, la publication est une news
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
     * Set image
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setFichierImage(File $image = null)
    {
        $this->fichierImage = $image;

        if ($image) {
            // Il est obligatoire de changer au moins une valeur si Doctrine est utilisé
            // sinon les écouteurs d'événements ne seront pas appelés et le fichier sera perdu.
            $this->dateMiseaJourImage = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFichierImage()
    {
        return $this->fichierImage;
    }

    /**
     * @param string $nom
     */
    public function setImage($nom)
    {
        $this->image = $nom;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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

    /**
     * Add commentaire
     *
     * @param \Gatsun\WebsiteBundle\Entity\Commentaire $commentaire
     * @return Emission
     */
    public function addCommentaire($commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \Gatsun\WebsiteBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire($commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}