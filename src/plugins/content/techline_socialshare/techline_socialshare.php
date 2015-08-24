<?php
/**
 * @package	Techlinienfo Responsive Social Share
 * @subpackage	plg_techline_socialshare
 * @copyright	Copyright (C) 2015 techlineinfo.com All rights reserved.
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die( 'Restricted access' );

if(file_exists(JPATH_ADMINISTRATOR.'/components/com_k2/lib/k2parameter.php')){
	JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.'/components/com_k2/lib/k2plugin.php'); 
	class Techline_socialshare extends K2Plugin{}
}else{
	class Techline_socialshare extends JPlugin{}
}


class plgContentTechline_socialshare extends Techline_socialshare {

	public function onContentAfterTitle ( $context , &$row , &$params , $page = 0 ) {
		$app = JFactory::getApplication();
		$active = $app -> getMenu() -> getActive();
		$show = $this->params->get( 'show' );
		if ( $show ) {
			if ( !is_array( $show ) ) {
				$shows[] = $show ;
			} else {
				$shows = $show ;
			}
			
			foreach ( $shows as $va ) {
				if ( $va == 'other' ) {
					if ( ( $active->component != 'com_content' ) || ( $context != 'com_content.article' ) ) {
						return ;
					}
				} else {
					if ( ( JRequest :: getVar( 'view' ) ) == $va ) {
						return ;
					}
					if ( $va == 'frontpage' ) {
						$menu = $app->getMenu();
						if ($active == $menu->getDefault()) {
							return ;
						}
					}
				if ( $va == 'k2categories' ) {
						if ( ($context == 'com_k2.itemlist')) {
						return ;
					}
					}

}
			}
		}
		if ( $context != 'mod_custom.content' ) {
			$exclude_cat = $this->params->get( 'exclude_cat' , 0 );
			if ( !empty( $exclude_cat ) ) {
				if ( strlen( array_search( $row->catid , $exclude_cat ) ) ) { 
					return ; 
				}
			}
			$exclude_art = $this->params->get( 'exclude_art' , '' );
			$articlesArray = explode( "," , $exclude_art );
			if( !empty( $exclude_art ) ) { 
				if ( strlen( array_search( $row->id , $articlesArray ) ) ) {
					return ; 
				}
			}

			require_once JPATH_BASE . '/components/com_content/helpers/route.php' ;
			$Itemid = JRequest::getVar( "Itemid" , "1" );
			if ( $row->id ) {
				$link = JURI::getInstance();
				$root = $link->getScheme() . "://" . $link->getHost();  
				if ( $active->component ) {
					if ( $active->component == 'com_content' ) {
						if ( $row->slug && $row->catslug ) {
							$link = JRoute::_( ContentHelperRoute::getArticleRoute( $row->slug , $row->catslug ) , false );
						} 
					
}

}
if ( $active->component == 'com_content' ) {				

$link = $root . $link ;

}

} else {
				$jURI = &JURI::getInstance();
				$link = $jURI->toString();
			}
if ( $this->params->get( 'enable_bitly' ) == 1 ) { 

/* returns the shortened url */
$bitly_user=$this->params->get( 'bitly_username' );
$bitly_api=$this->params->get( 'bitly_api' );

if (!function_exists('get_bitly_short_url')) {
function get_bitly_short_url($url,$login,$appkey,$format='txt') {
	$connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
	return curl_get_result($connectURL);
}
function get_bitly_long_url($url,$login,$appkey,$format='txt') {
	$connectURL = 'http://api.bit.ly/v3/expand?login='.$login.'&apiKey='.$appkey.'&shortUrl='.urlencode($url).'&format='.$format;
	return curl_get_result($connectURL);
}

/* returns a result form url */
function curl_get_result($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
}
/* get the short url */
$shortlink = get_bitly_short_url($link,$bitly_user,$bitly_api);
if ($shortlink=='INVALID_URI'or $shortlink=='INVALID_LOGIN' or $shortlink=='INVALID_APIKEY')
{
$shortlink=$link;
}
}
else{
$shortlink=$link;
}
//bitly
JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScript(JUri::base() . 'plugins/content/techline_socialshare/js/techline.min.js');
$document->addStyleSheet(JUri::base() . 'plugins/content/techline_socialshare/css/styles.css');
$maxwidth=$this->params->get( 'max_width' );
			$html = '' ;
			$html .= '<div class="share-container"  style="max-width:'.$maxwidth.';"><ul class="tss-techline-icons clearfix">' ;

			if ( $this->params->get( 'email' ) == 1 ) { 
				$html .= '<li class="compartilhar">
							<span>Compartilhe:</span>
					</li>' ;
		
			} else { 
				$html .= '' ; 
}
			
			if ( $this->params->get( 'email' ) == 1 ) { 
				$html .= '<li class="email">
						<a href="mailto:?subject='.$link. '">
							<span class="techline-icon-envelope techline-icon">
								
							</span>
							<span class="text">email</span>
						</a>
					</li>' ;
		
			} else { 
				$html .= '' ; 
}
				if ( $this->params->get( 'facebook' ) == 1 ) { 
$document = JFactory::getDocument();
		    $config = JFactory::getConfig();
		    $pattern = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|JPG|png|jpeg))['\"]?/" ;
			preg_match( $pattern , $row->text , $matches );
			if ( !empty( $matches ) ) {
				$document->addCustomTag( '<meta property="og:image" content="' . JURI::root() . '' . $matches[1] . '"/>' );
			}
				$sitename = $config->get( 'sitename' );
				$document->addCustomTag( '<meta property="og:site_name" content="' . $sitename . '"/>' );
				$document->addCustomTag( '<meta property="og:title" content="' . $row->title . '"/>' );
				$document->addCustomTag( '<meta property="og:type" content="article"/>' );
				$document->addCustomTag( '<meta property="og:url" content="' . $link . '"/>' );
				
				$html .= '<li class="facebook">
						<a href="https://www.facebook.com/sharer/sharer.php?u=' . $link . ' " class="popup">
							<span class="techline-icon-facebook techline-icon"></span>
							<span class="text" style="margin-left:-5px;">facebook</span>
						</a>
					</li>' ;
		
			} else { 
				$html .= '' ; 
			}
			if ( $this->params->get( 'twitter' ) == 1 ) {
				$html .= '<li class="twitter">
					<a href="http://twitter.com/home?status='.$row->title.''. $shortlink .'" class="popup">
						<span class="techline-icon-twitter techline-icon"></span>
						<span class="text">twitter</span>
					</a>
				</li>' ; 
					} else { 
				$html .= '' ; 
			}			
			if ( $this->params->get( 'google' ) == 1 ) {
				
				$html .= '<li class="googleplus" >
					<a href="https://plus.google.com/share?url=' . $link.'" class="popup">
						<span class="techline-icon-google-plus techline-icon">

						</span>
						<span class="text">google+</span>
					</a>
				</li>' ;
		
			} else {
				$html .= '' ;
			}
			if ( $this->params->get( 'linkedin' ) == 1 ) {
				$html .= '<li class="linkedin" >
					<a href="http://www.linkedin.com/shareArticle?mini=true&url=' .  $link . '&title='.$row->title.'" class="popup" >
						<span class="techline-icon-linkedin techline-icon">

						</span>
						<span class="text">linkedin</span>
					</a>
				</li>' ; 
			
			} else {
				$html .= '' ;
			}
if ( $this->params->get( 'stumbleupon' ) == 1 ) {
				$html .= '<li class="stumbleupon" >
					<a href="http://www.stumbleupon.com/submit?url=' .  $link . '&title='.$row->title.'" class="popup" >
						<span class="techline-icon-stumbleupon techline-icon">

						</span>
						<span class="text">stumble</span>
					</a>
				</li>' ; 
			
			} else {
				$html .= '' ;
			}

if ( $this->params->get( 'pinterest' ) == 1 ) {
$document = JFactory::getDocument();
$first_image='';
		    $config = JFactory::getConfig();
		    $pattern = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/" ;
			preg_match( $pattern , $row->text , $matches );
			if ( !empty( $matches ) ) {
				$first_image= JURI::root() . $matches[1] ;
			}
$pinterest_title=$row->title;
				$html .= '<li class="pinterest" >
					<a href="http://pinterest.com/pin/create/button/?url=' . $link. '&media='.$first_image.'&description='.$pinterest_title.'" class="popup">
						<span class="techline-icon-pinterest techline-icon">

						</span>
						<span class="text">pinterest</span>
					</a>
				</li>' ; 
			
			} else {
				$html .= '' ;
			}
			$html .= '</ul></div>' ;
			 $position = $this->params->get( 'position' , 'above' ) ;
			 $position_featured = $this->params->get( 'position_featured' , 'above' ) ;

			if ( $this->params->get( 'show_front' ) == 1 ) {
				if ( $position_featured == 'above' ) {
					$row->introtext = $html . $row->introtext ;
				} else {
					$row->introtext .= $html ;
				
					}
			} 
				if ( $position == 'above' ) {
					$row->text = $html . $row->text ;
				} elseif ( $position == 'below' ){
					$row->text .= $html ;
					}
				elseif ( $position == 'both' )
 					{
					$row->text = $html . $row->text.$html ;
					}
			
		} 
	}
}
?>
