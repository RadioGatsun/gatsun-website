<?php

// src/Gatsun/WebsiteBundle/Controller/VignetteController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Gatsun\WebsiteBundle\Entity\Vignette;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class VignetteController extends Controller
{
    public function ajouterAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $vignette = new Vignette();

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($vignette);

        $formBuilder
            ->add('titre', 'text', array('label' => 'Titre : '))
            ->add('description', 'text', array('label' => 'Description : '))
            ->add('lien', 'text', array('label' => 'Lien : '))
            ->add('fichier', 'file', array('label' => 'Image : '));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On récupère la requête
        $request = $this->get('request');

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $vignette contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On l'enregistre notre objet $user dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($vignette);
            $em->flush();

            // On redirige vers la page d'administration des vignettes
            return $this->redirect($this->generateUrl('gatsun_website_admin_vignettes'));
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Vignette:ajouter.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function modifierAction(
        $id
    ) {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // Récupération de la vignette
        $vignette = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Vignette')
            ->findOneById($id);

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($vignette);

        $formBuilder
            ->add('titre', 'text', array('label' => 'Titre : '))
            ->add('description', 'text', array('label' => 'Description : '))
            ->add('lien', 'text', array('label' => 'Lien : '))
            ->add('fichier', 'file', array('required' => false, 'label' => 'Image : '));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On récupère la requête
        $request = $this->get('request');

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $vignette contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On met à jour la vignette manuellement (Symfony n'appelle pas automatiquement l'upload)
            $vignette->preUpload();

            // On l'enregistre notre objet $user dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($vignette);
            $em->flush();

            // On redirige vers la page d'administration des vignettes
            return $this->redirect($this->generateUrl('gatsun_website_admin_vignettes'));
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Vignette:modifier.html.twig',
            array(
                'form' => $form->createView(),
                'vignette' => $vignette,
            )
        );
    }

    public
    function supprimerAction(
        $id
    ) {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        // Récupération de la vignette
        $vignette = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Vignette')
            ->findOneById($id);

        // Suppression de la base de données
        $em = $this->getDoctrine()->getManager();
        $em->remove($vignette);
        $em->flush();

        // Récupération des vignettes
        $listeVignettes = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Vignette')
            ->findAll();

        // Envoi de la réponse
        return $this->render('GatsunWebsiteBundle:Admin:vignettes.html.twig', array('vignettes' => $listeVignettes));
    }
}