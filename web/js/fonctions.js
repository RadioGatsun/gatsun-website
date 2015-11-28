/*** FACEBOOK ***/
( function ( d, s, id ) 
{
	var js, fjs = d.getElementsByTagName ( s ) [ 0 ];
	if ( d.getElementById ( id ) ) return;
	js = d.createElement ( s ); 
	js.id = id;
	js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=314380608681202";
	fjs.parentNode.insertBefore ( js, fjs );
} ( document, 'script', 'facebook-jssdk' ) );

/*** TWITTER ***/
! function ( d, s, id )
{
	var js, fjs = d.getElementsByTagName ( s ) [ 0 ];
	if ( !d.getElementById ( id ) )
	{
		js = d.createElement ( s );
		js.id = id;
		js.src = "//platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore ( js, fjs );
	}
} ( document, "script", "twitter-wjs" );

/*** COMMENTAIRES ***/
function rafraichirCommentaires ( page ) 
{
	try 
	{
		xhrComs = new ActiveXObject ( "Microsoft.XMLHTTP" );	// tenter IE
	}
	catch ( e )	// en cas d'échec
	{
		xhrComs = new XMLHttpRequest ( );	// autres navigateurs
	}

	xhrComs.onreadystatechange = function ( ) 
	{
		if ( xhrComs.readyState == 4 && xhrComs.status == 200 ) 
		{
			var reponse = xhrComs.responseText;
			document.getElementById ( "commentaires" ).innerHTML = reponse;
		}
	}
	
	xhrComs.open ( "GET", "../ajax/rafraichirCommentaires.php?page=" + page, true );
	xhrComs.send ( null );
}

function commenter ( page )
{
	try 
	{
		xhrCom = new ActiveXObject ( "Microsoft.XMLHTTP" );	// tenter IE
	}
	catch ( e )	// en cas d'échec
	{
		xhrCom = new XMLHttpRequest ( );	// autres navigateurs
	}
	
	xhrCom.onreadystatechange = function ( ) 
	{
		if ( xhrCom.readyState == 4 && xhrCom.status == 200 ) 
		{
			rafraichirCommentaires ( page );		
			document.getElementById ( "texte" ).value = "";
		}
	}
	var commentaire = document.getElementById ( "texte" ).value;
	xhrCom.open ( "POST", "./ajax/commenter.php", true );
	xhrCom.setRequestHeader ( "Content-Type", "application/x-www-form-urlencoded" );
	xhrCom.send( "commentaire=" + commentaire + "&page=" + page );
}

/*** BBCODE ***/
function bbcode ( bbdebut, bbfin )
{
	var input = document.getElementById ( "form_contenu" );
	input.focus ( );
	if( typeof document.selection != "undefined" )
	{
		var range = document.selection.createRange ( );
		var insText = range.text;
		range.text = bbdebut + insText + bbfin;
		range = document.selection.createRange ( );
		if ( insText.length == 0 )
		{
			range.move ( "character", -bbfin.length );
		}
		else
		{
			range.moveStart ( "character", bbdebut.length + insText.length + bbfin.length );
		}
		range.select ( );
	}
	else if ( typeof input.selectionStart != "undefined" )
	{
		var start = input.selectionStart;
		var end = input.selectionEnd;
		var insText = input.value.substring ( start, end );
		input.value = input.value.substr ( 0, start ) + bbdebut + insText + bbfin + input.value.substr ( end );
		var pos;
		if ( insText.length == 0 )
		{
			pos = start + bbdebut.length;
		}
		else
		{
			pos = start + bbdebut.length + insText.length + bbfin.length;
		}
		input.selectionStart = pos;
		input.selectionEnd = pos;
	}
	else
	{
		var pos;
		var re = new RegExp ( "^[0-9]{0,3}$" );
		while ( !re.test ( pos ) )
		{
			pos = prompt ( "insertion (0.." + input.value.length + "):", "0" );
		}
		if ( pos > input.value.length )
		{
			pos = input.value.length;
		}
		var insText = prompt ( "Veuillez taper le texte" );
		input.value = input.value.substr ( 0, pos ) + bbdebut + insText + bbfin + input.value.substr ( pos );
	}
}

function smilies ( img )
{
	document.getElementById ( "form_contenu" ).value += "" + img + "";
}

function actionMenu ( )
{
	if ( document.getElementById ( "nav" ).style.display == "block" )
	{
		document.getElementById ( "nav" ).style.display = "none";
	}
	else
	{
		document.getElementById ( "nav" ).style.display = "block";
	}
}