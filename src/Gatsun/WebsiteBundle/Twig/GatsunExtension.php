<?php
// src/Gatsun/WebsiteBundle/Twig/GatsunExtension.php
namespace Gatsun\WebsiteBundle\Twig;

use Symfony\Component\Asset\Packages;

class GatsunExtension extends \Twig_Extension
{
    private $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('code', array($this, 'codeFilter'), array('needs_environment', false)),
        );
    }

    public function codeFilter($texte)
    {
        //Smileys
        $texte = str_replace(':D', '<img src="' . $this->packages->getUrl('images/smileys/tres_heureux.png') . '" title="Très Heureux" alt=":)" />', $texte);
        $texte = str_replace(':) ', '<img src="' . $this->packages->getUrl('images/smileys/sourire.gif') . '" title="Sourire" alt=":D" />', $texte);
        $texte = str_replace(':( ', '<img src="' . $this->packages->getUrl('images/smileys/triste.gif') . '" title="Triste" alt=":(" />', $texte);
        $texte = str_replace(':o ', '<img src="' . $this->packages->getUrl('images/smileys/surpris.gif') . '" title="Surpris" alt=":o" />', $texte);
        $texte = str_replace(':shock: ', '<img src="' . $this->packages->getUrl('images/smileys/choque.gif') . '" title="Choqué" alt=":shock:" />', $texte);
        $texte = str_replace('8) ', '<img src="' . $this->packages->getUrl('images/smileys/cool.gif') . '" title="Cool" alt="8)" />', $texte);
        $texte = str_replace(':lol: ', '<img src="' . $this->packages->getUrl('images/smileys/rire.gif') . '" title="Rire" alt="lol" />', $texte);
        $texte = str_replace(':x ', '<img src="' . $this->packages->getUrl('images/smileys/agressif.gif') . '" title="Agressif" alt=":x" />', $texte);
        $texte = str_replace(':P ', '<img src="' . $this->packages->getUrl('images/smileys/langue.gif') . '" title="Tire la langue" alt=":P" />', $texte);
        $texte = str_replace(':oops: ', '<img src="' . $this->packages->getUrl('images/smileys/oups.gif') . '" title="Embarassé" alt=":oops:" />', $texte);
        $texte = str_replace(':cry: ', '<img src="' . $this->packages->getUrl('images/smileys/pleure.gif') . '" title="Pleure" alt=":cry:" />', $texte);
        $texte = str_replace(':evil: ', '<img src="' . $this->packages->getUrl('images/smileys/fache.gif') . '" title="Fâché" alt=":evil:" />', $texte);
        $texte = str_replace(':twisted: ', '<img src="' . $this->packages->getUrl('images/smileys/diable.gif') . '" title="Diable" alt=":twisted:" />', $texte);
        $texte = str_replace(':roll: ', '<img src="' . $this->packages->getUrl('images/smileys/yeux_roulants.gif') . '" title="Yeux roulants" alt=":roll:" />', $texte);
        $texte = str_replace(';) ', '<img src="' . $this->packages->getUrl('images/smileys/clin_oeil.gif') . '" title="Clin d\'&oelig;il" alt=";)" />', $texte);
        $texte = str_replace(':!:', '<img src="' . $this->packages->getUrl('images/smileys/exclamation.gif') . '" title="Exclamation" alt=":!:" />', $texte);
        $texte = str_replace(':?:', '<img src="' . $this->packages->getUrl('images/smileys/interrogation.gif') . '" title="Interrogation" alt=":?:" />', $texte);
        $texte = str_replace(':idea:', '<img src="' . $this->packages->getUrl('images/smileys/idee.png') . '" title="Idée" alt=":idea:" />', $texte);
        $texte = str_replace(':arrow:', '<img src="' . $this->packages->getUrl('images/smileys/fleche.gif') . '" title="Flèche" alt=":arrow:" />', $texte);
        $texte = str_replace(':| ', '<img src="' . $this->packages->getUrl('images/smileys/neutre.gif') . '" title="Neutre" alt=":|" />', $texte);
        $texte = str_replace(':face:', '<img src="' . $this->packages->getUrl('images/smileys/face.png') . '" title="Face" alt=":face:" />', $texte);
        $texte = str_replace(':star:', '<img src="' . $this->packages->getUrl('images/smileys/etoile.png') . '" title="Etoile" alt=":star:" />', $texte);
        $texte = str_replace(':suspect:', '<img src="' . $this->packages->getUrl('images/smileys/suspect.gif') . '" title="Suspect" alt=":suspect:" />', $texte);
        $texte = str_replace(':heart:', '<img src="' . $this->packages->getUrl('images/smileys/coeur.png') . '" title="CÅ“ur" alt=":heart:" />', $texte);
        $texte = str_replace(':no:', '<img src="' . $this->packages->getUrl('images/smileys/non.gif') . '" title="Non" alt=":no:" />', $texte);
        $texte = str_replace(':@:', '<img src="' . $this->packages->getUrl('images/smileys/@.png') . '" title="@" alt=":@:" />', $texte);
        $texte = str_replace(':cyclops:', '<img src="' . $this->packages->getUrl('images/smileys/cyclope.gif') . '" title="Cyclope" alt=":cyclops:" />', $texte);
        $texte = str_replace(':clown:', '<img src="' . $this->packages->getUrl('images/smileys/clown.png') . '" title="Clown" alt=":clown:" />', $texte);
        $texte = str_replace(':pirat:', '<img src="' . $this->packages->getUrl('images/smileys/pirate.png') . '" title="Pirate" alt=":pirat:" />', $texte);
        $texte = str_replace(':tongue:', '<img src="' . $this->packages->getUrl('images/smileys/nyah-nyah.png') . '" title="Nyah-Nyah" alt=":tongue:" />', $texte);
        $texte = str_replace(':silent:', '<img src="' . $this->packages->getUrl('images/smileys/silence.png') . '" title="Silence" alt=":silent:" />', $texte);
        $texte = str_replace(':pale:', '<img src="' . $this->packages->getUrl('images/smileys/pale.gif') . '" title="Pâle" alt=":pale:" />', $texte);
        $texte = str_replace(':alien:', '<img src="' . $this->packages->getUrl('images/smileys/alien.png') . '" title="Alien" alt=":alien:" />', $texte);
        $texte = str_replace(':cat:', '<img src="' . $this->packages->getUrl('images/smileys/chat.png') . '" title="Chat" alt=":cat:" />', $texte);
        $texte = str_replace(':monkey:', '<img src="' . $this->packages->getUrl('images/smileys/singe.png') . '" title="Singe" alt=":monkey:" />', $texte);
        $texte = str_replace(':pig:', '<img src="' . $this->packages->getUrl('images/smileys/cochon.png') . '" title="Cochon" alt=":pig:" />', $texte);
        $texte = str_replace(':rabbit:', '<img src="' . $this->packages->getUrl('images/smileys/lapin.png') . '" title="Lapin" alt=":rabbit:" />', $texte);
        $texte = str_replace(':bounce:', '<img src="' . $this->packages->getUrl('images/smileys/bong.gif') . '" title="Bong" alt=":bounce:" />', $texte);
        $texte = str_replace(':confused:', '<img src="' . $this->packages->getUrl('images/smileys/confus.png') . '" title="Confus" alt=":confused:" />', $texte);
        $texte = str_replace(':affraid:', '<img src="' . $this->packages->getUrl('images/smileys/effraye.gif') . '" title="Effrayé" alt=":affraid:" />', $texte);
        $texte = str_replace(':bball:', '<img src="' . $this->packages->getUrl('images/smileys/basketball.gif') . '" title="BasketBall" alt=":bball:" />', $texte);
        $texte = str_replace(':cheers:', '<img src="' . $this->packages->getUrl('images/smileys/bravo.png') . '" title="Bravo" alt=":cheers:" />', $texte);
        $texte = str_replace(':bom:', '<img src="' . $this->packages->getUrl('images/smileys/bebe.png') . '" title="Bébé" alt=":bom:" />', $texte);
        $texte = str_replace(':drunken:', '<img src="' . $this->packages->getUrl('images/smileys/bourre.png') . '" title="Bourré" alt=":drunken:" />', $texte);
        $texte = str_replace(':sleep:', '<img src="' . $this->packages->getUrl('images/smileys/endormi.gif') . '" title="Endormi" alt=":sleep:" />', $texte);
        $texte = str_replace(':sunny:', '<img src="' . $this->packages->getUrl('images/smileys/soleil.png') . '" title="Soleil" alt=":sunny:" />', $texte);
        $texte = str_replace(':albino:', '<img src="' . $this->packages->getUrl('images/smileys/albinos.png') . '" title="Lapin Albinos" alt=":albino:" />', $texte);
        $texte = str_replace(':cherry:', '<img src="' . $this->packages->getUrl('images/smileys/cerise.png') . '" title="Cerise" alt=":cherry:" />', $texte);
        $texte = str_replace(':santa:', '<img src="' . $this->packages->getUrl('images/smileys/pere_noel.png') . '" title="Père Noël" alt=":santa:" />', $texte);
        $texte = str_replace(':rendeer:', '<img src="' . $this->packages->getUrl('images/smileys/renne.png') . '" title="Renne" alt=":rendeer:" />', $texte);
        $texte = str_replace(':farao:', '<img src="' . $this->packages->getUrl('images/smileys/pharaon.png') . '" title="Pharaon" alt=":farao:" />', $texte);
        $texte = str_replace(':king:', '<img src="' . $this->packages->getUrl('images/smileys/roi.png') . '" title="Roi" alt=":king:" />', $texte);
        $texte = str_replace(':queen:', '<img src="' . $this->packages->getUrl('images/smileys/reine.png') . '" title="Reine" alt=":queen:" />', $texte);
        $texte = str_replace(':joker:', '<img src="' . $this->packages->getUrl('images/smileys/joker.png') . '" title="Joker" alt=":joker:" />', $texte);
        $texte = str_replace(':geek:', '<img src="' . $this->packages->getUrl('images/smileys/geek.png') . '" title="Geek" alt=":geek:" />', $texte);
        $texte = str_replace(':scratch:', '<img src="' . $this->packages->getUrl('images/smileys/gratte.png') . '" title="Gratte" alt=":scratch" />', $texte);
        $texte = str_replace(':study:', '<img src="' . $this->packages->getUrl('images/smileys/etudie.png') . '" title="Etudie" alt=":study:" />', $texte);
        $texte = str_replace(':elephant:', '<img src="' . $this->packages->getUrl('images/smileys/elephant.png') . '" title="Eléphant" alt=":elephant:" />', $texte);
        $texte = str_replace(':flower:', '<img src="' . $this->packages->getUrl('images/smileys/fleur.png') . '" title="Fleur" alt=":flower:" />', $texte);
        $texte = str_replace(':afro:', '<img src="' . $this->packages->getUrl('images/smileys/afro.png') . '" title="Afro" alt=":afro:" />', $texte);
        $texte = str_replace(':lol!:', '<img src="' . $this->packages->getUrl('images/smileys/lol.gif') . '" title="Lol!" alt=":lol!:" />', $texte);

        //Mise en forme du texte
        //gras
        $texte = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $texte); 
        //italique
        $texte = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $texte);
        //souligné
        $texte = preg_replace('#\[u\](.+)\[/u\]#isU', '<ins>$1</ins>', $texte);
        //barré
        $texte = preg_replace('#\[s\](.+)\[/s\]#isU', '<del>$1</del>', $texte);
        //texte à gauche
        $texte = preg_replace('#\[left\](.+)\[/left\]#isU', '<div style="text-align: left;">$1</div>', $texte);
        //texte centré
        $texte = preg_replace('#\[center\](.+)\[/center\]#isU', '<div style="text-align: center;">$1</div>', $texte);
        //texte à droite
        $texte = preg_replace('#\[right\](.+)\[/right\]#isU', '<div style="text-align: right;">$1</div>', $texte);
        //texte justifié
        $texte = preg_replace('#\[justified\](.+)\[/justified\]#isU', '<div style="text-align: justify;">$1</div>', $texte);
        //lien + texte
        $texte = preg_replace('#\[url=(.+)\](.+)\[/url\]#isU', '<a href="$1" target="_blank">$2</a>', $texte);
        //lien
        $texte = preg_replace('#\[url\](.+)\[/url\]#isU', '<a href="$1" target="_blank">$1</a>', $texte);
        //citation
        $texte = preg_replace('#\[quote=([a-z0-9A-Z._-]+)\](.+)\[/quote\]#isU', '<blockquote><p>$2</p><footer><cite title="$1">$1</cite></footer></blockquote>', $texte);
        //couleur du texte
        $texte = preg_replace('#\[color=(aqua|black|blue|fuchsia|gray|green|lime|maroon|navy|olive|purple|red|silver|teal|white|yellow|\#[a-z0-9A-Z]{6}|RGB\([0-9]{0,3},[0-9]{0,3},[0-9]{0,3}\))\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $texte);
        //taille du texte
        $texte = preg_replace('#\[size=(xx-small|x-small|small|medium|large|x-large|xx-large|[0-9]+px|[0-9\.]+%|[0-9\.]+em)\](.+)\[/size\]#isU', '<span style="font-size:$1">$2</span>', $texte);
        //police
        $texte = preg_replace('#\[font=(.+)\](.+)\[/font\]#', '<span style="font-family: \'$1\', serif;">$2</span>', $texte);
        //liste à  puces
        $texte = preg_replace('#\[list\]#', '<ul>', $texte);
        $texte = preg_replace('#\[/list\]#', '</li></ul>', $texte);
        $texte = preg_replace('#\[\*\](.+)\n#', '<li>$1</li>', $texte);
        //liste numérotée
        $texte = preg_replace('#\[list=1\]#', '<ol>', $texte);
        $texte = preg_replace('#\[/list=1\]#', '</li></ol>', $texte);
        //image
        $texte = preg_replace('#\[img\]((.+).[jpeg|jpg|gif|png])\[/img\]#isU', '<a href="$1" target="_blank"><img src="$1" style="max-width: 150px; max-height: 150px;" alt="" /></a>', $texte);
        //tableaux
        $texte = preg_replace('#\[table\]#', '<table>', $texte);
        $texte = preg_replace('#\[/table\]#', '</table>', $texte);
        $texte = preg_replace('#\[tr\]#', '<tr>', $texte);
        $texte = preg_replace('#\[/tr\]#', '</tr>', $texte);
        $texte = preg_replace('#\[td\]#', '<td>', $texte);
        $texte = preg_replace('#\[/td\]#', '</td>', $texte);
        $texte = preg_replace('#\[th\]#', '<th>', $texte);
        $texte = preg_replace('#\[/th\]#', '</th>', $texte);
        //exposant
        $texte = preg_replace('#\[sup\](.+)\[/sup\]#isU', '<sup>$1</sup>', $texte);
        //indice
        $texte = preg_replace('#\[sub\](.+)\[/sub\]#isU', '<sub>$1</sub>', $texte);
        //insérer une ligne
        $texte = preg_replace('#\[hr\]#', '<br /><hr />', $texte);
        //vidéo Youtube
        $texte = preg_replace('#\[video\](http|https)://www.youtube.com/watch\?v=(.+)\[/video\]#isU', '<div><iframe width="640" height="360" src="//www.youtube-nocookie.com/embed/$2?rel=0" frameborder="0" allowfullscreen></iframe></div>', $texte);
        //vidéo Dailymotion
        $texte = preg_replace('#\[video\](http|https)://www.dailymotion.com/video/(.+)_(.+)\[/video\]#isU', '<div><iframe width="640" height="360" src="http://www.dailymotion.com/embed/video/$2" frameborder="0" allowfullscreen></iframe></div>', $texte);
        /*//flottant gauche
        $texte = preg_replace('#\[flottg\](.+)\[/flottg\]#isU', '<div class="image_gauche">$1</div>', $texte);
        //flottant droit
        $texte = preg_replace('#\[flottd\](.+)\[/flottd\]#isU', '<div class="image_droite">$1</div>', $texte);
        //retour après le flottant
        $texte = preg_replace('#\[aprflott\](.+)\[/aprflott\]#isU', '<div class="dessous">$1</div>', $texte);
        //titres
        $texte = preg_replace('#\[t([1-6]{1})\](.+)\[/t([1-6]{1})\](\n){1}#isU', '<h$1>$2</h$3>', $texte);
        //acronyme
        $texte = preg_replace('#\[acr=(.+)\](.+)\[/acr\]#isU', '<acronym title="$1">$2</acronym>', $texte);
        //code sans formatage
        $texte = preg_replace('#\[pre\](.+)\[/pre\]#isU', '<pre>$1</pre>', $texte);*/

        // Saut de ligne après un div
        $texte = preg_replace('#</div>\s{2}#', '</div>', $texte);

        // Sauts de ligne en surnombre
        $texte = preg_replace('#\s{3,}#', '<br />', $texte);

        // Lien sans balise
        $texte = preg_replace('#^https?://(?:\w|[/.-])*#is', '<a href="$0">$0</a>', $texte);
        //etc., etc.

        //On retourne la variable texte
        return $texte;
    }

    public function getName()
    {
        return 'gatsun_extension';
    }
}