<?php

// src/Gatsun/WebsiteBundle/Controller/GeneralController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Facebook\Facebook;
use Facebook\FacebookRequest;

class GeneralController extends Controller
{
    public function indexAction()
    {
        // Initialisation de Facebook
        $fb = new Facebook(
            [
                'app_id' => $this->getParameter('facebook.app_id'),
                'app_secret' => $this->getParameter('facebook.app_secret'),
                'default_graph_version' => $this->getParameter('facebook.default_graph_version'),
                'default_access_token' => $this->getParameter('facebook.default_access_token'),
            ]
        );

        // Requête sur le nombre de likes
        $request = new FacebookRequest(
            $fb->getApp(),
            $fb->getDefaultAccessToken(),
            'GET',
            '/RadioGatsun',
            array(
                'fields' => 'likes',
            )
        );

        // Extraction
        $likes = $fb->getClient()->sendRequest($request)->getGraphNode()->getField('likes');

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
                'listeEmissions' => $listeEmissions,
                'facebookLikes' => $likes
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
        return $this->render('GatsunWebsiteBundle:General:live.html.twig');
    }

    public function radioAction()
    {
        return $this->render('GatsunWebsiteBundle:General:radio.html.twig');
    }

    public function programmeAction()
    {
        $listeEmissions = $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('GatsunWebsiteBundle:Emission')
            ->findBy(
                array('active' => true),
                array('jour' => 'asc', 'heureDebut' => 'asc'),
                null,
                null
            );

        return $this->render(
            'GatsunWebsiteBundle:General:programme.html.twig',
            array('listeEmissions' => $listeEmissions)
        );
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

    public function conditionsUtilisationAction()
    {
        return $this->render('GatsunWebsiteBundle:General:conditions.html.twig');
    }

    public function liveInfoAction()
    {
        return new Response(
            $this->get('jms_serializer')->serialize(
                $this->getDoctrine()
                    ->getManager()
                    ->getRepository('GatsunWebsiteBundle:Emission')
                    ->getCurrentEmission(),
                'json'
            )
        );
    }
}