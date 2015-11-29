# gatsun-website


Le projet Git du site Inetrnet de Radio Gatsun.<br />
http://gatsun.asso.insa-lyon.fr/<br />
Copyright &copy; 2015 Gatsun
 
## Licence

Pour des informations sur la licence, consulez le fichier [`LICENCE`](./LICENCE).

## Mise en route

1. Clonez le projet dans un répertoire configuré pour le web.
2. Téléchargez [Composer](https://getcomposer.org/) et installez-le.
3. Récupérez les `vendors` via la commande `composer update`.

    > Si vous avez opté pour le téléchargement du fichier composer.phar, la commande devient : `php composer.phar update`.

4. Configurez le fichier `app/config/parameters.yml` à partir du template [`app/config/parameters.yml.dist`](./app/config/parameters.yml.dist).
5. Créez une base de données dont le nom sera celui donné comme `database_name` du fichier précédent.
6. Générez les tables à l'aide de la commande `php app/console doctrine:schema:update --force`.

