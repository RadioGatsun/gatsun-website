<?php

namespace Gatsun\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Emission
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gatsun\WebsiteBundle\Entity\EmissionRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="emission_image", fileNameProperty="bandeau")
     *
     * @var File
     */
    private $fichierBandeau;

    /**
     * @var string
     *
     * @ORM\Column(name="bandeau", type="text", nullable=true)
     */
    private $bandeau;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $dateMiseaJourBandeau;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="emission_image", fileNameProperty="vignette")
     *
     * @var File
     */
    private $fichierVignette;

    /**
     * @var string
     *
     * @ORM\Column(name="vignette", type="text", nullable=true)
     */
    private $vignette;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $dateMiseaJourVignette;

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
     * Constructor
     */
    public function __construct()
    {
        $this->presentateurs = new ArrayCollection();
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setFichierBandeau(File $image = null)
    {
        $this->fichierBandeau = $image;

        if ($image) {
            // Il est obligatoire de changer au moins une valeur si Doctrine est utilisé
            // sinon les écouteurs d'événements ne seront pas appelés et le fichier sera perdu.
            $this->dateMiseaJourBandeau = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFichierBandeau()
    {
        return $this->fichierBandeau;
    }

    /**
     * @param string $nom
     */
    public function setBandeau($nom)
    {
        $this->bandeau = $nom;
    }

    /**
     * @return string
     */
    public function getBandeau()
    {
        return $this->bandeau;
    }

    /**
     * Set vignette
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setFichierVignette(File $image = null)
    {
        $this->fichierVignette = $image;

        if ($image) {
            // Il est obligatoire de changer au moins une valeur si Doctrine est utilisé
            // sinon les écouteurs d'événements ne seront pas appelés et le fichier sera perdu.
            $this->dateMiseaJourVignette = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFichierVignette()
    {
        return $this->fichierVignette;
    }

    /**
     * @param string $nom
     */
    public function setVignette($nom)
    {
        $this->vignette = $nom;
    }

    /**
     * @return string
     */
    public function getVignette()
    {
        return $this->vignette;
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