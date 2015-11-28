<?php
// Durant la période de mise à jour
if ( time ( ) > 1415923200 && time ( ) < 1430438400	)
{
	switch ( date ( "N" ) )
	{
		// Lundi
		case 1:
			// 20h - 00h
			if ( date ( "G" ) >= 20 && date ( "G" ) < 22 )
			{				
				?>
				<img class="media-object" src="../images/emissions/vignette-fmc.png" />
				<strong><abbr title="Full Metal Condom">FMC</abbr></strong><br />
				<em>Métal !</em><br />
				<?php
			}
			// 00h - 20h
			else
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Début du live dès 20h !</em><br />
				<?php
			}
		break;
		
		// Mardi
		case 2:
			// 20h30 - 00h
			if ( ( date ( "G" ) == 20 && date ( "i") >= 30 ) || date ( "G" ) > 20 )
			{
				?>
				<img class="media-object" src="../images/emissions/vignette-le-son-du-geek.png" />
				<strong>Le Son du Geek</strong><br />
				<em>Culture geek, informatique et hi-tech</em><br />
				<?php
			}

			// 00h - 20h30
			else
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Début du live dès 20h30 !</em><br />
				<?php
			}
		break;
		
		// Mercredi		
		case 3:
			// 00h - 20h
			if ( date ( "G" ) < 20 )
			{
				/*?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Début du live dès 20h !</em><br />
				<?php*/
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Début du live dès 20h !</em><br />
				<?php
			}
			// ----------------------
			// SPÉCIAL : Open Studio
			// ----------------------
			/*elseif ( date ( "G" ) != 20 )				
			{
				?>
				<img class="media-object" src="../images/emissions/vignette-open-studio.png" />
				<strong>Soirée "Open Studio"</strong><br />
				<em>Venez vous exprimer en direct à la radio ! RdC Bât. G-J.</em><br />
				<?php
			}*/

			// Actu Campus
			elseif ( date ( "G" ) == 20 )
			{
				?>
				<img class="media-object" src="../images/emissions/vignette-actu-campus.png" />
				<strong>Actu Campus</strong><br />
				<em>Toute l'actualité de votre campus</em><br />
				<?php
			}

			// Pas d'émission
			else
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Retour du live demain dès 20h !</em><br />
				<?php
			}
		break;

		// Jeudi
		case 4:
			// 20h - 22h
			if ( date ( "G" ) >= 20  && date ( "G" ) < 22 )
			{				
				?>
				<img class="media-object" src="../images/emissions/vignette-des-sons-animes.png" />
				<strong>Des Sons Animés</strong><br />
				<em>Tout sur les films d'animation !</em><br />
				<?php
			}

			// 22h - 00h
			elseif ( date ( "G" ) >= 22 )
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Retour du live demain dès 20h !</em><br />
				<?php
			}
			
			// 00h - 20h
			else
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Début du live dès 20h !</em><br />
				<?php
			}
		break;

		// Vendredi
		case 5:
			// 20h - 22h
			if ( date ( "G" ) >= 20  && date ( "G" ) < 22 )
			{				
				?>
				<img class="media-object" src="../images/emissions/vignette-pixel.png" />
				<strong>Pixel</strong><br />
				<em>Votre émission jeux vidéo !</em><br />
				<?php
			}

			// 22h - 00h
			elseif ( date ( "G" ) >= 22 )
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Retour du live Lundi dès 20h !</em><br />
				<?php
			}
			
			// 00h - 20h
			else
			{
				?>
				<img class="media-object" src="../images/header.png" />
				<strong>La playlist Gatsun</strong><br />
				<em>Début du live dès 20h !</em><br />
				<?php
			}

		
		// Week-end (Vendredi-Dimanche)
		default:
			?>
			<img class="media-object" src="../images/header.png" />
			<strong>La playlist Gatsun</strong><br />
			<em>Retour du live Lundi dès 20h !</em><br />
			<?php
		break;
	}
}
// Hors période
else
{
	?>
	<img class="media-object" src="../images/header.png" />
	<strong>La playlist Gatsun</strong><br />
	<em>Planning des émissions en cours d'élaboration&hellip;</em><br />
	<?php
}
?>