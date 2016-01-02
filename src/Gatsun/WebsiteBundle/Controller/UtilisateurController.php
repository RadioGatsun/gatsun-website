<?php

// src/Gatsun/WebsiteBundle/Controller/UtilisateurController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gatsun\WebsiteBundle\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UtilisateurController extends Controller
{
    public function connexionAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        $error = $authenticationUtils->getLastAuthenticationError();

        // Valeur du précédent nom d'utilisateur entré par l'internaute
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'GatsunWebsiteBundle:Utilisateur:connexion.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    public function inscriptionAction(Request $request)
    {
        $user = new Utilisateur();
        $user->setConfirmation(gencode(10));

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($user);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('username', TextType::class, array('label' => 'Identifiant'))
            ->add(
                'password',
                RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe doivent correspondre',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Mot de passe (validation)'),
                )
            )
            ->add('email', EmailType::class, array('label' => 'E-mail'))
            ->add('fichierAvatar', VichFileType::class, array('required' => false, 'label' => 'Avatar'))
            ->add('facebook', TextType::class, array('required' => false, 'label' => 'Facebook'))
            ->add('twitter', TextType::class, array('required' => false, 'label' => 'Twitter'))
            ->add('googlePlus', TextType::class, array('required' => false, 'label' => 'Google+'))
            ->add('skype', TextType::class, array('required' => false, 'label' => 'Skype'))
            ->add('nom', TextType::class, array('required' => false, 'label' => 'Nom'))
            ->add('prenom', TextType::class, array('required' => false, 'label' => 'Nom'))
            ->add(
                'dateNaissance',
                DateType::class,
                array(
                    'required' => false,
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'format' => 'dd MMMM y',
                    'attr' => array('class' => 'datepicker')
                )
            )
            ->add('nom', TextType::class, array('required' => false, 'label' => 'Prénom'))
            ->add('adresse', TextType::class, array('required' => false, 'label' => 'Adresse'))
            ->add('codePostal', TextType::class, array('required' => false, 'label' => 'Code postal'))
            ->add('ville', TextType::class, array('required' => false, 'label' => 'Ville'))
            ->add('telephone', TextType::class, array('required' => false, 'label' => 'Téléphone'))
            ->add(
                'acceptConditions',
                CheckboxType::class,
                array(
                    'required' => true,
                    'label' => 'J\'ai lu et j\'accepte les ',
                    'mapped' => false,
                    'attr' => array('class' => 'filled-in'),
                )
            );

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $user contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->isValid()) {
            // On encrypte le mot de passe
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            // On enregistre notre objet $user dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('[Gatsun Site] Confirmation de l\'inscription')
                ->setFrom('gatsun.radio@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'GatsunWebsiteBundle:Utilisateur:emailConfirmation.html.twig',
                        array('utilisateur' => $user)
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);

            // On redirige vers la page indiquant que le mail de confirmation vient d'être envoyé
            return $this->render(
                'GatsunWebsiteBundle:Utilisateur:inscriptionTerminee.html.twig',
                array('utilisateur' => $user)
            );
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Utilisateur:inscription.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function modifierAction(Request $request, $nom)
    {
        // Si on est pas connecté, redirection vers la connexion
        if (false === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('gatsun_website_connexion'));
        }

        // Si on est ni admin ni la personne à qui appartient le profil, erreur 403
        if ($this->getUser()->getUsername() != $nom && false === $this->get(
                'security.authorization_checker'
            )->isGranted('ROLE_ADMIN')
        ) {
            throw new AccessDeniedException("Vous ne pouvez pas modifier un compte différent. Accès refusé.");
        }

        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findOneBy(array('username' => $nom));

        // On crée le FormBuilder grâce à la méthode du contrôleur
        $formBuilder = $this->createFormBuilder($user);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('fichierAvatar', VichFileType::class, array('required' => false, 'label' => 'Avatar'))
            ->add('facebook', TextType::class, array('required' => false, 'label' => 'Facebook'))
            ->add('twitter', TextType::class, array('required' => false, 'label' => 'Twitter'))
            ->add('googlePlus', TextType::class, array('required' => false, 'label' => 'Google+'))
            ->add('skype', TextType::class, array('required' => false, 'label' => 'Skype'))
            ->add('nom', TextType::class, array('required' => false, 'label' => 'Nom'))
            ->add('prenom', TextType::class, array('required' => false, 'label' => 'Nom'))
            ->add(
                'dateNaissance',
                DateType::class,
                array(
                    'required' => false,
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'format' => 'dd MMMM y',
                    'attr' => array('class' => 'datepicker')
                )
            )
            ->add('nom', TextType::class, array('required' => false, 'label' => 'Prénom'))
            ->add('adresse', TextType::class, array('required' => false, 'label' => 'Adresse'))
            ->add('codePostal', TextType::class, array('required' => false, 'label' => 'Code postal'))
            ->add('ville', TextType::class, array('required' => false, 'label' => 'Ville'))
            ->add('telephone', TextType::class, array('required' => false, 'label' => 'Téléphone'));

        // Modification du rôle uniquement si l'on est admin
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $formBuilder->add(
                'roles',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Auditeur' => 'ROLE_USER',
                        'Membre de l\'association' => 'ROLE_MEMBRE',
                        'Administrateur' => 'ROLE_ADMIN',
                    ),
                    'multiple' => true,
                    'choices_as_values' => true,
                    'required' => true,
                    'label' => 'Rôle'
                )
            );
        }

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $user contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);
            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                // On l'enregistre notre objet $user dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                    return $this->redirect($this->generateUrl('gatsun_website_admin_utilisateurs'));
                } else     // Modification par le propriétaire du profil
                {
                    // On redirige vers la page du profil modifié
                    return $this->redirect(
                        $this->generateUrl('gatsun_website_utilisateur', array('nom' => $user->getUsername()))
                    );
                }
            }
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render(
            'GatsunWebsiteBundle:Utilisateur:modifier.html.twig',
            array(
                'utilisateur' => $user,
                'form' => $form->createView(),
            )
        );
    }

    public function voirAction($nom)
    {
        $utilisateur = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findOneBy(array('username' => $nom));

        if (empty($utilisateur)) {
            throw new NotFoundHttpException("Utilisateur inconnu");
        }

        return $this->render(
            'GatsunWebsiteBundle:Utilisateur:voir.html.twig',
            array(
                'utilisateur' => $utilisateur,
            )
        );
    }

    public function bannirAction($nom)
    {
        // Gestion des accès
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        // Récupération de l'utilisateur
        $utilisateur = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findOneBy(array('username' => $nom));

        if (empty($utilisateur))    // Utilisateur inconnu
        {
            throw new NotFoundHttpException("Utilisateur inconnu");
        }

        // Banissement
        $utilisateur->setAccountLocked(true);

        // Persistance en base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();

        $listeUtilisateurs = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findAll();

        return $this->render(
            'GatsunWebsiteBundle:Admin:utilisateurs.html.twig',
            array('utilisateurs' => $listeUtilisateurs)
        );
    }

    public function debannirAction($nom)
    {
        // Gestion des accès
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        // Récupération de l'utilisateur
        $utilisateur = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findOneBy(array('username' => $nom));

        if (empty($utilisateur))    // Utilisateur inconnu
        {
            throw new NotFoundHttpException("Utilisateur inconnu");
        }

        // Débanissement
        $utilisateur->setAccountLocked(false);

        // Persistance en base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();

        $listeUtilisateurs = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findAll();

        return $this->render(
            'GatsunWebsiteBundle:Admin:utilisateurs.html.twig',
            array('utilisateurs' => $listeUtilisateurs)
        );
    }

    public function confirmationAction($code)
    {
        $utilisateur = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findOneBy(
                array('confirmation' => $code),
                array()
            );

        // Cas du code ne correspondant à aucun compte
        if (is_null($utilisateur)) {
            throw new NotFoundHttpException("C'est pas bien de bidouiller les URLs !");
        } // Cas de l'utilisateur banni
        elseif (!$utilisateur->isAccountNonLocked()) {
            throw new AccessDeniedException("Vous avez été banni. Accès refusé.");
        } // Cas de l'utilisateur déjà confirmé
        elseif ($utilisateur->isEnabled()) {
            throw new AccessDeniedException("Vous avez déjà validé votre compte. Accès refusé.");
        } // Cas normal
        else {
            $utilisateur->setEnabled(true);
            $utilisateur->setRoles(array('ROLE_USER'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->render(
                'GatsunWebsiteBundle:Utilisateur:confirmation.html.twig',
                array('utilisateur' => $utilisateur)
            );
        }
    }

    public function supprimerAvatarAction($id)
    {
        $utilisateur = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Utilisateur')
            ->findOneById($id);
        $utilisateur->supprimerImage();
        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();

        return new Response("HTTP_OK");
    }
}

function gencode($car)
{
    $string = "";
    $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    srand((double)microtime() * 1000000);
    for ($i = 0; $i < $car; $i++) {
        $string .= $chaine[rand() % strlen($chaine)];
    }

    return $string;
}