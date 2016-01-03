<?php

// src/Gatsun/WebsiteBundle/Controller/VignetteController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatsun\WebsiteBundle\Entity\Vignette;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VignetteController extends Controller
{
    public function ajouterAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $vignette = new Vignette();

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($vignette);

        $formBuilder
            ->add('titre', TextType::class, array('label' => 'Titre'))
            ->add('description', TextType::class, array('label' => 'Description'))
            ->add('lien', TextType::class, array('label' => 'Lien'))
            ->add('fichierImage', VichImageType::class, array('label' => 'Image', 'allow_delete' => false));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $vignette contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On enregistre notre objet $vignette dans la base de données
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

    public function modifierAction(Request $request, $id)
    {
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
            ->add('titre', TextType::class, array('label' => 'Titre'))
            ->add('description', TextType::class, array('label' => 'Description'))
            ->add('lien', TextType::class, array('label' => 'Lien'))
            ->add('fichierImage', VichImageType::class, array('required' => false, 'label' => 'Image', 'allow_delete' => false));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $vignette contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On enregistre notre objet $vignette dans la base de données
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