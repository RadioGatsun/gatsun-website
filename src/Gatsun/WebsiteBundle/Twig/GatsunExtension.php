<?php
// src/Gatsun/WebsiteBundle/Twig/GatsunExtension.php
namespace Gatsun\WebsiteBundle\Twig;

class GatsunExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('code', array($this, 'codeFilter'), array('needs_environment', false)),
        );
    }

    public function codeFilter($texte)
    {
        //Smileys
        $texte = str_replace(':D', '<img src="../images/smileys/tres_heureux.png" title="Très Heureux" alt=":)" />', $texte);
        $texte = str_replace(':) ', '<img src="../images/smileys/sourire.gif" title="Sourire" alt=":D" />', $texte);
        $texte = str_replace(':( ', '<img src="../images/smileys/triste.gif" title="Triste" alt=":(" />', $texte);
        $texte = str_replace(':o ', '<img src="../images/smileys/surpris.gif" title="Surpris" alt=":o" />', $texte);
        $texte = str_replace(':shock: ', '<img src="../images/smileys/choque.gif" title="Choqué" alt=":shock:" />', $texte);
        $texte = str_replace('8) ', '<img src="../images/smileys/cool.gif" title="Cool" alt="8)" />', $texte);
        $texte = str_replace(':lol: ', '<img src="../images/smileys/rire.gif" title="Rire" alt="lol" />', $texte);
        $texte = str_replace(':x ', '<img src="../images/smileys/agressif.gif" title="Agressif" alt=":x" />', $texte);
        $texte = str_replace(':P ', '<img src="../images/smileys/langue.gif" title="Tire la langue" alt=":P" />', $texte);
        $texte = str_replace(':oops: ', '<img src="../images/smileys/oups.gif" title="Embarassé" alt=":oops:" />', $texte);
        $texte = str_replace(':cry: ', '<img src="../images/smileys/pleure.gif" title="Pleure" alt=":cry:" />', $texte);
        $texte = str_replace(':evil: ', '<img src="../images/smileys/fache.gif" title="Fâché" alt=":evil:" />', $texte);
        $texte = str_replace(':twisted: ', '<img src="../images/smileys/diable.gif" title="Diable" alt=":twisted:" />', $texte);
        $texte = str_replace(':roll: ', '<img src="../images/smileys/yeux_roulants.gif" title="Yeux roulants" alt=":roll:" />', $texte);
        $texte = str_replace(';) ', '<img src="../images/smileys/clin_oeil.gif" title="Clin d\'&oelig;il" alt=";)" />', $texte);
        $texte = str_replace(':!:', '<img src="../images/smileys/exclamation.gif" title="Exclamation" alt=":!:" />', $texte);
        $texte = str_replace(':?:', '<img src="../images/smileys/interrogation.gif" title="Interrogation" alt=":?:" />', $texte);
        $texte = str_replace(':idea:', '<img src="../images/smileys/idee.png" title="Idée" alt=":idea:" />', $texte);
        $texte = str_replace(':arrow:', '<img src="../images/smileys/fleche.gif" title="Flèche" alt=":arrow:" />', $texte);
        $texte = str_replace(':| ', '<img src="../images/smileys/neutre.gif" title="Neutre" alt=":|" />', $texte);
        $texte = str_replace(':face:', '<img src="../images/smileys/face.png" title="Face" alt=":face:" />', $texte);
        $texte = str_replace(':star:', '<img src="../images/smileys/etoile.png" title="Etoile" alt=":star:" />', $texte);
        $texte = str_replace(':suspect:', '<img src="../images/smileys/suspect.gif" title="Suspect" alt=":suspect:" />', $texte);
        $texte = str_replace(':heart:', '<img src="../images/smileys/coeur.png" title="CÅ“ur" alt=":heart:" />', $texte);
        $texte = str_replace(':no:', '<img src="../images/smileys/non.gif" title="Non" alt=":no:" />', $texte);
        $texte = str_replace(':@:', '<img src="../images/smileys/@.png" title="@" alt=":@:" />', $texte);
        $texte = str_replace(':cyclops:', '<img src="../images/smileys/cyclope.gif" title="Cyclope" alt=":cyclops:" />', $texte);
        $texte = str_replace(':clown:', '<img src="../images/smileys/clown.png" title="Clown" alt=":clown:" />', $texte);
        $texte = str_replace(':pirat:', '<img src="../images/smileys/pirate.png" title="Pirate" alt=":pirat:" />', $texte);
        $texte = str_replace(':tongue:', '<img src="../images/smileys/nyah-nyah.png" title="Nyah-Nyah" alt=":tongue:" />', $texte);
        $texte = str_replace(':silent:', '<img src="../images/smileys/silence.png" title="Silence" alt=":silent:" />', $texte);
        $texte = str_replace(':pale:', '<img src="../images/smileys/pale.gif" title="Pâle" alt=":pale:" />', $texte);
        $texte = str_replace(':alien:', '<img src="../images/smileys/alien.png" title="Alien" alt=":alien:" />', $texte);
        $texte = str_replace(':cat:', '<img src="../images/smileys/chat.png" title="Chat" alt=":cat:" />', $texte);
        $texte = str_replace(':monkey:', '<img src="../images/smileys/singe.png" title="Singe" alt=":monkey:" />', $texte);
        $texte = str_replace(':pig:', '<img src="../images/smileys/cochon.png" title="Cochon" alt=":pig:" />', $texte);
        $texte = str_replace(':rabbit:', '<img src="../images/smileys/lapin.png" title="Lapin" alt=":rabbit:" />', $texte);
        $texte = str_replace(':bounce:', '<img src="../images/smileys/bong.gif" title="Bong" alt=":bounce:" />', $texte);
        $texte = str_replace(':confused:', '<img src="../images/smileys/confus.png" title="Confus" alt=":confused:" />', $texte);
        $texte = str_replace(':affraid:', '<img src="../images/smileys/effraye.gif" title="Effrayé" alt=":affraid:" />', $texte);
        $texte = str_replace(':bball:', '<img src="../images/smileys/basketball.gif" title="BasketBall" alt=":bball:" />', $texte);
        $texte = str_replace(':cheers:', '<img src="../images/smileys/bravo.png" title="Bravo" alt=":cheers:" />', $texte);
        $texte = str_replace(':bom:', '<img src="../images/smileys/bebe.png" title="Bébé" alt=":bom:" />', $texte);
        $texte = str_replace(':drunken:', '<img src="../images/smileys/bourre.png" title="Bourré" alt=":drunken:" />', $texte);
        $texte = str_replace(':sleep:', '<img src="../images/smileys/endormi.gif" title="Endormi" alt=":sleep:" />', $texte);
        $texte = str_replace(':sunny:', '<img src="../images/smileys/soleil.png" title="Soleil" alt=":sunny:" />', $texte);
        $texte = str_replace(':albino:', '<img src="../images/smileys/albinos.png" title="Lapin Albinos" alt=":albino:" />', $texte);
        $texte = str_replace(':cherry:', '<img src="../images/smileys/cerise.png" title="Cerise" alt=":cherry:" />', $texte);
        $texte = str_replace(':santa:', '<img src="../images/smileys/pere_noel.png" title="Père Noël" alt=":santa:" />', $texte);
        $texte = str_replace(':rendeer:', '<img src="../images/smileys/renne.png" title="Renne" alt=":rendeer:" />', $texte);
        $texte = str_replace(':farao:', '<img src="../images/smileys/pharaon.png" title="Pharaon" alt=":farao:" />', $texte);
        $texte = str_replace(':king:', '<img src="../images/smileys/roi.png" title="Roi" alt=":king:" />', $texte);
        $texte = str_replace(':queen:', '<img src="../images/smileys/reine.png" title="Reine" alt=":queen:" />', $texte);
        $texte = str_replace(':joker:', '<img src="../images/smileys/joker.png" title="Joker" alt=":joker:" />', $texte);
        $texte = str_replace(':geek:', '<img src="../images/smileys/geek.png" title="Geek" alt=":geek:" />', $texte);
        $texte = str_replace(':scratch:', '<img src="../images/smileys/gratte.png" title="Gratte" alt=":scratch" />', $texte);
        $texte = str_replace(':study:', '<img src="../images/smileys/etudie.png" title="Etudie" alt=":study:" />', $texte);
        $texte = str_replace(':elephant:', '<img src="../images/smileys/elephant.png" title="Eléphant" alt=":elephant:" />', $texte);
        $texte = str_replace(':flower:', '<img src="../images/smileys/fleur.png" title="Fleur" alt=":flower:" />', $texte);
        $texte = str_replace(':afro:', '<img src="../images/smileys/afro.png" title="Afro" alt=":afro:" />', $texte);
        $texte = str_replace(':lol!:', '<img src="../images/smileys/lol.gif" title="Lol!" alt=":lol!:" />', $texte);

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