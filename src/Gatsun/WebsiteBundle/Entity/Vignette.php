<?php

namespace Gatsun\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Vignette
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gatsun\WebsiteBundle\Entity\VignetteRepository")
 * @Vich\Uploadable
 */
class Vignette
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="vignette_image", fileNameProperty="image")
     *
     * @var File
     */
    private $fichierImage;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text")
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $dateMiseaJourImage;


    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255)
     */
    private $lien;


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
     * Set titre
     *
     * @param string $titre
     * @return Vignette
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
     * Set description
     *
     * @param string $description
     * @return Vignette
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
     * Set lien
     *
     * @param string $lien
     * @return Vignette
     */
    public function setLien($lien)
    {
        $this->lien = $lien;
    
        return $this;
    }

    /**
     * Get lien
     *
     * @return string 
     */
    public function getLien()
    {
        return $this->lien;
    }
}
