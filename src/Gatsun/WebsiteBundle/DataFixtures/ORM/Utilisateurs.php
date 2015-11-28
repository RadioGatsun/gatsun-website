<?php

namespace Gatsun\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gatsun\WebsiteBundle\Entity\Utilisateur;

class Utilisateurs implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		// On créé l'utilisateur
		$user = new Utilisateur;

		// Le nom d'utilisateur et le mot de passe sont identiques
		$user->setUsername('Tom65380');
		$user->setPassword('tomossun65');
		$user->setEmail('tom65@hotmail.fr');

		// Le sel et les rôles sont vides pour l'instant
		$user->setSalt('');
		$user->setRoles(array());

		// On le persiste
		$manager->persist($user);

		// On déclenche l'enregistrement
		$manager->flush();
	}
}