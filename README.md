# gatsun-website


Le projet Git du site Inetrnet de Radio Gatsun.<br />
http://gatsun.asso.insa-lyon.fr/<br />
Copyright &copy; 2015 Gatsun
 
## Licence

Pour des informations sur la licence, consulez le fichier [`LICENCE`](./LICENCE).

## Mise en route

1. Clonez le projet dans un répertoire configuré pour le web.

```
git clone https://github.com/RadioGatsun/gatsun-website
```

2. Téléchargez [Composer](https://getcomposer.org/) et installez-le.
 Sous archlinux, installez le paquet `php-composer`.
 Sous une autre distribution linux :

```
$ cd /usr/src
$ sudo apt-get install curl php5-cli
$ curl -sS https://getcomposer.org/installer | sudo php
$ sudo mv composer.phar /usr/bin/composer
```
N'oubliez pas d'activer `phar` dans le fichier de config php,
d'installer `php-pear` et de vérifier que composer est bien dans le path
de pear (dans `php.ini`)

3. Récupérez les `vendors` via la commande `composer update`.

    > Si vous avez opté pour le téléchargement du fichier composer.phar, la commande devient : `php composer.pharu pdate`.

4. Configurez le fichier `app/config/parameters.yml` à partir du template [`app/config/parameters.yml.dist`](./app/config/parameters.yml.dist).
 Ou remplissez le lorsque composer vous le demande (Linux cli)
5. Créez une base de données dont le nom sera celui donné comme `database_name` du fichier précédent.
6. Générez les tables à l'aide de la commande
```php app/console doctrine:schema:update --force```

## Troubleshouting

Selon le système que vous utilisez, vous allez potentiellement galérer à configurer apache et php.
