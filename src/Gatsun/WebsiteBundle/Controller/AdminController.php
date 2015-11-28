<?php

// src/Gatsun/WebsiteBundle/Controller/AdminController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatsun\WebsiteBundle\Entity\Utilisateur;

class AdminController extends Controller
{
	public function utilisateursAction()
	{
		$listeUtilisateurs = $this->getDoctrine()
								  ->getManager()
								  ->getRepository('GatsunWebsiteBundle:Utilisateur')
								  ->findAll();

		return $this->render('GatsunWebsiteBundle:Admin:utilisateurs.html.twig', array('utilisateurs' => $listeUtilisateurs));
	}

	public function publicationsAction()
	{
		$listePublications = $this->getDoctrine()
								  ->getManager()
								  ->getRepository('GatsunWebsiteBundle:Publication')
								  ->findAll();

		return $this->render('GatsunWebsiteBundle:Admin:publications.html.twig', array('publications' => $listePublications));
	}

	public function emissionsAction()
	{
		$listeEmissions = $this->getDoctrine()
								  ->getManager()
								  ->getRepository('GatsunWebsiteBundle:Emission')
								  ->findAll();

		return $this->render('GatsunWebsiteBundle:Admin:emissions.html.twig', array('emissions' => $listeEmissions));
	}

	public function vignettesAction()
	{
		$listeVignettes = $this->getDoctrine()
								  ->getManager()
								  ->getRepository('GatsunWebsiteBundle:Vignette')
								  ->findAll();

		return $this->render('GatsunWebsiteBundle:Admin:vignettes.html.twig', array('vignettes' => $listeVignettes));
	}

	public function commentairesAction()
	{
		$listeCommentaires = $this->getDoctrine()
								  ->getManager()
								  ->getRepository('GatsunWebsiteBundle:Commentaire')
								  ->findAll();

		return $this->render('GatsunWebsiteBundle:Admin:commentaires.html.twig', array('commentaires' => $listeCommentaires));
	}

	public function commentairesLiveAction()
	{
		$listeCommentairesLive = $this->getDoctrine()
								  ->getManager()
								  ->getRepository('GatsunWebsiteBundle:CommentaireLive')
								  ->findAll();

		return $this->render('GatsunWebsiteBundle:Admin:commentaires.html.twig', array('commentaires' => $listeCommentairesLive));
	}
}