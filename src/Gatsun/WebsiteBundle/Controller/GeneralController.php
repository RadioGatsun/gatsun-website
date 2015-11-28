<?php

// src/Gatsun/WebsiteBundle/Controller/GeneralController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GeneralController extends Controller
{
    public function indexAction()
    {
        /*if($this->getUser() != null)
        {
            $user = new Utilisateur();
            $user = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('GatsunWebsiteBundle:Utilisateur')
                         ->findOneBy(array('id' => $this->getUser()->getId()));

            $user->setRoles(array('ROLE_ADMIN'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }*/

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication');

        $listePublications = $repository->findBy(
            array(),
            array('date' => 'desc'),
            5,
            0
        );

        $listeVignettes = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Vignette')
            ->findAll();

        $listeEmissions = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->getNextEmissions(2);

        return $this->render(
            'GatsunWebsiteBundle:General:accueil.html.twig',
            array(
                'publications' => $listePublications,
                'listeVignettes' => $listeVignettes,
                'listeEmissions' => $listeEmissions
            )
        );
    }

    public function derniersPodcastsAction()
    {
        $listePodcasts = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Publication')
            ->getPodcasts();

        return $this->render(
            'GatsunWebsiteBundle:General:derniersPodcasts.html.twig',
            array('podcasts' => $listePodcasts)
        );
    }

    public function prochainesEmissionsAction($count, $current)
    {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->getNextEmissions($count, $current);
    }

    public function liveAction()
    {
        $emission = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->getCurrentEmission();

        return $this->render('GatsunWebsiteBundle:General:live.html.twig',
            array("emissionCourante" => $emission));
    }

    public function radioAction()
    {
        return $this->render('GatsunWebsiteBundle:General:radio.html.twig');
    }

    public function programmeAction()
    {
        return $this->render('GatsunWebsiteBundle:General:programme.html.twig');
    }

    public function emissionsAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission');

        $listeEmissions = $repository->findBy(
            array('active' => true),
            array('nom' => 'asc'),
            null,
            null
        );

        $listeAnciennesEmissions = $repository->findBy(
            array('active' => false),
            array('nom' => 'asc'),
            null,
            null
        );

        return $this->render(
            'GatsunWebsiteBundle:General:emissions.html.twig',
            array('emissions' => $listeEmissions, 'anciennesEmissions' => $listeAnciennesEmissions)
        );
    }

    public function aidebbcodeAction()
    {
        return $this->render('GatsunWebsiteBundle:Popup:aideBBCode.html.twig');
    }

    public function conditionsUtilisationAction()
    {
        return $this->render('GatsunWebsiteBundle:General:conditions.html.twig');
    }
}