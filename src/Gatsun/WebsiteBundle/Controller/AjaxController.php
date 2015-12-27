<?php

// src/Gatsun/WebsiteBundle/Controller/AjaxController.php

namespace Gatsun\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gatsun\WebsiteBundle\Entity\Commentaire;
use Gatsun\WebsiteBundle\Entity\CommentaireLive;

class AjaxController extends Controller
{
	public function rafraichirCommentairesAction($page)
	{
		if($page == "live")
		{
			$listeCommentaires = $this->getDoctrine()
									  ->getManager()
									  ->getRepository('GatsunWebsiteBundle:CommentaireLive')
									  ->getCommentaires();
		}
		else
		{
			$publication = $this->getDoctrine()
								->getManager()
								->getRepository('GatsunWebsiteBundle:Publication')
								->findOneBy(array('id' => $page), array(), null, null);

			$listeCommentaires = $this->getDoctrine()
									  ->getManager()
									  ->getRepository('GatsunWebsiteBundle:Commentaire')
									  ->findBy(array('publication' => $publication), array('date' => 'DESC'), null, null);
		}
		return $this->render('GatsunWebsiteBundle:Ajax:commentaires.html.twig', array('commentaires' => $listeCommentaires, 'page' => $page));
	}

	public function ajouterCommentaireAction(Request $request)
	{
		$texte = $request->get("texte");
		$page = $request->get("page");

		if(!empty($texte) && !preg_match ("#^(\s)+$#", $texte) && !empty($page))
		{
			if($page == "live")
			{
				$commentaire = new CommentaireLive();
				$commentaire->setTexte(htmlspecialchars($texte));
				$commentaire->setDate(new \DateTime());
				$commentaire->setUtilisateur($this->getUser());
			}
			else
			{
				$commentaire = new Commentaire();
				$publication = $this->getDoctrine()
									->getManager()
									->getRepository('GatsunWebsiteBundle:Publication')
									->findOneBy(array('id' => $page), array(), null, null);

				$commentaire->setTexte(htmlspecialchars($texte));
				$commentaire->setDate(new \DateTime());
				$commentaire->setUtilisateur($this->getUser());
				$commentaire->setPublication($publication);
			}

			$em = $this->getDoctrine()->getManager();
			$em->persist($commentaire);
			$em->flush();
			return new Response("Message envoyé");
		}
		return new Response("Message non envoyé");
	}

	public function supprimerCommentaireAction(Request $request)
	{
		$page = $request->query->get("page");
		$id = $request->query->get("id");

		if(!empty($page))
		{
			if($page == "live")
			{
				// Récupération de l'ancien commentaire
				$commentaire = $this->getDoctrine()
									->getManager()
									->getRepository('GatsunWebsiteBundle:CommentaireLive')
									->findOneById($id);				
			}
			else
			{
				// Récupération de l'ancien commentaire
				$commentaire = $this->getDoctrine()
									->getManager()
									->getRepository('GatsunWebsiteBundle:Commentaire')
									->findOneById($id);
			}

			// Modification du statut
			$commentaire->setSupprime(true);

			// Envoi des modifications en base de données
			$em = $this->getDoctrine()->getManager();
			$em->persist($commentaire);
			$em->flush();
			return new Response("Commentaire supprimé", 200);
		}
		return new Response("Commentaire non supprimé", 400);
	}

	public function modererCommentaireAction(Request $request)
	{
		$page = $request->query->get("page");
		$id = $request->query->get("id");

		if(!empty($page))
		{
			if($page == "live")
			{
				// Récupération de l'ancien commentaire
				$commentaire = $this->getDoctrine()
									->getManager()
									->getRepository('GatsunWebsiteBundle:CommentaireLive')
									->findOneById($id);				
			}
			else
			{
				// Récupération de l'ancien commentaire
				$commentaire = $this->getDoctrine()
									->getManager()
									->getRepository('GatsunWebsiteBundle:Commentaire')
									->findOneById($id);
			}

			// Modification du statut
			$commentaire->setModere(true);

			// Envoi des modifications en base de données
			$em = $this->getDoctrine()->getManager();
			$em->persist($commentaire);
			$em->flush();
			return new Response("Commentaire modéré", 200);
		}
		return new Response("Commentaire non modéré" , 400);
	}
}