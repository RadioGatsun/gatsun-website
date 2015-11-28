<?php

// src/Gatsun/WebsiteBundle/Controller/EmissionController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatsun\WebsiteBundle\Entity\Emission;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EmissionController extends Controller
{
    public function voirAction($id)
    {
        $emission = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findOneBy(array('id' => $id), array());

        $publications = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication')
            ->findBy(array('emission' => $emission), array('date' => 'DESC'), null, null);

        return $this->render(
            'GatsunWebsiteBundle:Emission:voir.html.twig',
            array('emission' => $emission, 'publications' => $publications)
        );
    }

    public function ajouterAction()
    {
        // Vérification des droits
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedHttpException();
        }

        $emission = new Emission();

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($emission);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('nom', 'text', array('label' => 'Nom : '))
            ->add('description', 'text', array('label' => 'Description : '))
            ->add('vignette', 'url', array('label' => 'Lien vers la vignette : ', 'data' => ''))
            ->add('bandeau', 'url', array('label' => 'Lien vers le bandeau : ', 'data' => ''))
            ->add(
                'presentateurs',
                'entity',
                array(
                    'class' => 'GatsunWebsiteBundle:Utilisateur',
                    'property' => 'username',
                    'label' => 'Présentateurs : ',
                    'multiple' => true,
                )
            );

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On récupère la requête
        $request = $this->get('request');

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $emission contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On l'enregistre notre objet $emission dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($emission);
            $em->flush();

            // On redirige vers la page de visualisation de l'article nouvellement créé
            return $this->redirect($this->generateUrl('gatsun_website_emission', array('id' => $emission->getId())));
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Emission:ajouter.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function modifierAction($id)
    {
        $emission = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findOneById($id);

        // Vérification des droits
        if (!($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || (sizeof(
                    $emission->getPresentateurs()
                ) != 0 && in_array($this->getUser(), $emission->getPresentateurs())))
        ) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedHttpException();
        }

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($emission);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('nom', 'text', array('label' => 'Nom : '))
            ->add('description', 'text', array('label' => 'Description : '))
            ->add('vignette', 'url', array('label' => 'Lien vers la vignette : '))
            ->add('bandeau', 'url', array('label' => 'Lien vers le bandeau : '))
            ->add(
                'presentateurs',
                'entity',
                array(
                    'class' => 'GatsunWebsiteBundle:Utilisateur',
                    'property' => 'username',
                    'label' => 'Présentateurs : ',
                    'multiple' => true,
                )
            );

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On récupère la requête
        $request = $this->get('request');

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $emission contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On l'enregistre notre objet $emission dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($emission);
            $em->flush();

            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                // On redirige vers la page d'administration des émissions
                return $this->redirect($this->generateUrl('gatsun_website_admin_emissions'));
            } else {
                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect(
                    $this->generateUrl('gatsun_website_emission', array('id' => $emission->getId()))
                );
            }
        }


        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Emission:modifier.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function supprimerAction($id)
    {
        // Vérification des droits
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_MEMBRE')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedHttpException('Accès limité aux membres de l\'association');
        }

        // Récupération de l'emission
        $emission = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findOneById($id);

        // Suppression de la base de données
        $em = $this->getDoctrine()->getManager();
        $em->remove($emission);
        $em->flush();

        // Récupération des emissions
        $listeEmissions = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findAll();

        // Envoi de la réponse
        return $this->render('GatsunWebsiteBundle:Admin:emissions.html.twig', array('emissions' => $listeEmissions));
    }
}