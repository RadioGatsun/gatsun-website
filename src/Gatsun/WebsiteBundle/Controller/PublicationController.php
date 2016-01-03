<?php

// src/Gatsun/WebsiteBundle/Controller/PublicationController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatsun\WebsiteBundle\Entity\Publication;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Vich\UploaderBundle\Form\Type\VichImageType;

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

    public function ajouterAction(Request $request)
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
                EntityType::class,
                array(
                    'required' => false,
                    'class' => 'GatsunWebsiteBundle:Emission',
                    'choice_label' => 'nom',
                    'placeholder' => 'News',
                    'label' => 'Catégorie',
                )
            )
            ->add('titre', TextType::class, array('label' => 'Titre'))
            ->add(
                'fichierImage',
                VichImageType::class,
                array('required' => false, 'label' => 'Image',)
            )
            ->add(
                'contenu',
                TextareaType::class,
                array('label' => 'Contenu', 'attr' => array('class' => 'materialize-textarea'))
            )
            ->add('podcast', TextType::class, array('required' => false, 'label' => 'Podcast'));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $publication contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
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

    public function modifierAction(Request $request, $id)
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
                EntityType::class,
                array(
                    'required' => false,
                    'class' => 'GatsunWebsiteBundle:Emission',
                    'choice_label' => 'nom',
                    'placeholder' => 'News',
                    'label' => 'Catégorie',
                )
            )
            ->add('titre', TextType::class, array('label' => 'Titre'))
            ->add(
                'fichierImage',
                VichImageType::class,
                array('required' => false, 'label' => 'Image',)
            )
            ->add(
                'contenu',
                TextareaType::class,
                array('label' => 'Contenu', 'attr' => array('class' => 'materialize-textarea'))
            )
            ->add('podcast', TextType::class, array('required' => false, 'label' => 'Podcast'));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $publication contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
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

    public function supprimerAction(Request $request)
    {
        // Récupération de l'ID en paramètre de l'URL
        $id = $request->query->get("id");

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