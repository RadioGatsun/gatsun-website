<?php

// src/Gatsun/WebsiteBundle/Controller/PublicationController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatsun\WebsiteBundle\Entity\Publication;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PublicationController extends Controller
{
    public function voirAction($id)
    {
        $publication = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication')
            ->findOneBy(array('id' => $id));

        if (empty($publication)) {
            throw new NotFoundHttpException("La publication demandée n'existe pas.");
        }

        return $this->render('GatsunWebsiteBundle:Publication:voir.html.twig', array('publication' => $publication));
    }

    public function ajouterAction()
    {
        // Vérification des droits
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_MEMBRE')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedHttpException('Accès limité aux membres de l\'association');
        }

        $publication = new Publication();

        // Définition de l'auteur
        $publication->setUtilisateur($this->getUser());

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($publication);

        $listeEmissions = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findAll();

        $selectEmissions = array('Général' => array(0 => 'Actualités'));
        foreach ($listeEmissions as $emission) {
            $selectEmissions['Émissions'][$emission->getId()] = $emission->getNom();
        }

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add(
                'emission',
                'entity',
                array(
                    'required' => false,
                    'class' => 'GatsunWebsiteBundle:Emission',
                    'property' => 'nom',
                    'empty_value' => 'Actualités',
                    'label' => 'Catégorie : ',
                )
            )
            ->add('titre', 'text', array('label' => 'Titre : '))
            ->add(
                'vignette',
                'url',
                array(
                    'required' => false,
                    'label' => 'Lien vers la vignette (Si non rempli, l\'image par défaut sera associée) : ',
                    'data' => '',
                )
            )
            ->add('contenu', 'textarea', array('label' => 'Contenu : '))
            ->add('podcast', 'text', array('required' => false, 'label' => 'Podcast : '));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On récupère la requête
        $request = $this->get('request');

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $publication contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie la vignette
        // S'il n'y en a pas, on passe à la vignette par défaut de l'émission.
        // Si elle n'existe pas non plus, on conserve la vignette par défaut définie dans l'entité.
        $vignette = $publication->getVignette();
        if ($vignette == "images/defaut/news.png") {
            $emission = $publication->getEmission();
            if (isset($emission)) {
                $vignetteEmission = $emission->getVignette();
                if (isset($vignetteEmission)) {
                    $publication->setVignette($vignetteEmission);
                }
            }
        }
        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
            // On l'enregistre notre objet $publication dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            // On redirige vers la page de visualisation de l'article nouvellement créé
            return $this->redirect(
                $this->generateUrl('gatsun_website_publication', array('id' => $publication->getId()))
            );
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Publication:ajouter.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function modifierAction($id)
    {
        // Récupération de la publication
        $publication = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication')
            ->findOneById($id);

        // Vérification des droits
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') && $publication->getUtilisateur(
            ) != $this->getUser()
        ) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedHttpException('Accès limité à l\'administrateur ou à l\'auteur de la publication.');
        }

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($publication);

        $listeEmissions = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findAll();

        $selectEmissions = array('Général' => array(0 => 'Actualités'));
        foreach ($listeEmissions as $emission) {
            $selectEmissions['Émissions'][$emission->getId()] = $emission->getNom();
        }

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add(
                'emission',
                'entity',
                array(
                    'required' => false,
                    'class' => 'GatsunWebsiteBundle:Emission',
                    'property' => 'nom',
                    'empty_value' => 'Actualités',
                    'label' => 'Catégorie : ',
                )
            )
            ->add('titre', 'text', array('label' => 'Titre : '))
            ->add(
                'vignette',
                'url',
                array(
                    'required' => false,
                    'label' => 'Lien vers la vignette (Si non rempli, l\'image par défaut sera associée) : ',
                    'data' => '',
                )
            )
            ->add('contenu', 'textarea', array('label' => 'Contenu : '))
            ->add('podcast', 'text', array('required' => false, 'label' => 'Podcast : '));
        // Pour l'instant, pas de commentaires, catégories, etc., on les gérera plus tard

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On récupère la requête
        $request = $this->get('request');

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $publication contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie la vignette
        // S'il n'y en a pas, on passe à la vignette par défaut de l'émission.
        // Si elle n'existe pas non plus, on conserve la vignette par défaut définie dans l'entité.
        $vignette = $publication->getVignette();
        if ($vignette == "images/defaut/news.png") {
            $emission = $publication->getEmission();
            if (isset($emission)) {
                $vignetteEmission = $emission->getVignette();
                if (isset($vignetteEmission)) {
                    $publication->setVignette($vignetteEmission);
                }
            }
        }
        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
            // On l'enregistre notre objet $publication dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            // On redirige vers la page de visualisation de l'article nouvellement créé
            return $this->redirect(
                $this->generateUrl('gatsun_website_publication', array('id' => $publication->getId()))
            );
        }


        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Publication:modifier.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function supprimerAction($id)
    {
        // Récupération de la publication
        $publication = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication')
            ->findOneById($id);

        // Vérification des droits
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN') && $publication->getUtilisateur(
            ) != $this->getUser()
        ) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedHttpException('Accès limité à l\'administrateur ou à l\'auteur de la publication.');
        }

        // Suppression de la base de données
        $em = $this->getDoctrine()->getManager();
        $em->remove($publication);
        $em->flush();

        // Récupération des publications
        $listePublications = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication')
            ->findAll();

        // Envoi de la réponse
        return $this->render(
            'GatsunWebsiteBundle:Admin:publications.html.twig',
            array('publications' => $listePublications)
        );
    }
}