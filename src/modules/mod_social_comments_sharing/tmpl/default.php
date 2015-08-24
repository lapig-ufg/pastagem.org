<?php
/*
* @version 2.0 Pro
* @package social sharing
* @copyright 2012 OrdaSoft
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @author 2012 Andrey Kvasnekskiy (akbet@ordasoft.com )
* @description social sharing, sharing WEB pages in LinkedIn, FaceBook, Twitter and Google+ (G+)
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
global $realestatemanager_configuration;
$document = JFactory::getDocument();
$database=JFactory::getDBO();
$docType = $document->getType();
$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path'] = JPATH_SITE;
$mosConfig_live_site=JURI::base();
$config = JFactory::getConfig();
//default meta variables
$title = htmlspecialchars(strip_tags($document->getTitle()));
$description=htmlspecialchars(strip_tags($document->getMetaData("description")));
$uri = JURI::getInstance();
$url = htmlspecialchars($uri->toString());
//end

$code_twitter = '';
$code_google = '';
$code_in = '';
$style = '';
$htmlCodeComBox = '';
$htmlCode = '';
$meta = "";
$_google = 0;
$_tw = 0;
$_in = 0;
$icon_size = $icon_size_number =$params->get('icon_size','40');
$icon_size.='px';

$enable_twitter = $params->get('enable_twitter');
$enable_google = $params->get('enable_google');
$enable_in = $params->get('enable_in');
$enable_vk = $params->get('enable_vk');
$enable_add_this = $params->get('enable_add_this');
$enable_ok = $params->get('enable_ok');

//FB settings
$app_id = $params->get('fb_api_id');
$enable_like = $params->get('fb_enable_like');
$enable_share = $params->get('fb_enable_share');
$enable_comments = $params->get('fb_enable_comments');
$enable_send = $params->get('fb_enable_send');
//end FB
//Load language
if ($params->get('auto_language')) {
  $language = str_replace('-', '_', JFactory::getLanguage()->getTag());
} else {
  $language = $params->get('module_language');
}//end
$type = $params->get('type');
//end
//////////////////Start facebook like,share and sent button/////////////////////////////
    if ($enable_like || $enable_share || $enable_comments || $enable_send) {
    ////Start initialise FB script code
    ?>
        <div id="fb-root"></div>
        <?php
        $FbCode = <<<FACEBOOK
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/$language/sdk.js#xfbml=1&appId=$app_id&version=v2.3";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
FACEBOOK;
        $document->addScriptDeclaration($FbCode);
    }
    //end
    if($params->get('module_syle')=='horizontal' || $params->get('module_syle')=='vertical'){
        //////////////////Start facebook like,share and sent buttons/////////////////////////////
        //FB share button
        if ($enable_share) {
            $share_button_style = $params->get('fb_share_layout_style');
            $tmp = "<div class=\"fb-share-button\" data-href=\"$url\" data-layout=\"$share_button_style\"></div>". PHP_EOL;
            $htmlCode.= "<div style=\"margin-right:5px;\" class=\"fb_share_button_container\">$tmp</div>";

        }
        //FB like button
        if ($enable_like ) {
            $layout_style = $params->get('fb_like_layout_style');
            $verb_to_display = $params->get('fb_like_verb_to_display');
            $color_scheme = $params->get('fb_like_color_scheme', 'light');
            $show_faces=$params->get('fb_like_show_faces');
            $tmp ="<div class=\"fb-like\" 
                        data-href=\"$url\" 
                        data-layout=\"$layout_style\" 
                        data-action=\"$verb_to_display\" 
                        data-show-faces=\"$show_faces\" 
                        data-share=\"false\" 
                        colorscheme=\"$color_scheme\"></div>";
            $tmp= $tmp . PHP_EOL;
            $htmlCode.= "<div class=\"fb_like_button_container\">$tmp</div>";
        }
        //FB send
        if ($enable_send) {
            $sent_but_width = $params->get('fb_width_send_but');
            $sent_but_height = $params->get('fb_height_send_but');
            $sent_but_color = $params->get('fb_color_sent_but');
            //print_r(urlencode($url));exit;
            $tmp ="<div class=\"fb-send\"
                        data-href=\"$url\"
                        data-width=\"$sent_but_width\"
                        data-height=\"$sent_but_height\"
                        data-colorscheme=\"$sent_but_color\"></div>";
            $tmp= $tmp . PHP_EOL;
            $htmlCode.= "<div class=\"fb_send_button_container\">$tmp</div>";
        }
        //FB comments
        if ($enable_comments && ($params->get('module_syle') =='horizontal')) {
            $number_comments = $params->get('fb_number_comments');
            $comments_width = $params->get('fb_comments_width');
            $box_color = $params->get('fb_comments_box_color');
            $tmp ="<div class=\"fb-comments\" 
                        data-href=\"$url\" 
                        data-width=\"$comments_width\" 
                        data-numposts=\"$number_comments\" 
                        data-colorscheme=\"$box_color\"></div>";
            $tmp= $tmp . PHP_EOL;
            $htmlCodeComBox.= "<div class=\"fb_comment_container\">$tmp</div>";
        }
    }
    //////////////////End facebook like,share and sent buttons/////////////////////////////
if($params->get('module_syle')=='horizontal'|| $params->get('module_syle')=='vertical'){
    //////////////////Start OK share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    if($enable_ok){
        if($params->get('ok_comment_style'))$style = ",vt:'1'";
        $tmp = "
            <div id=\"ok_shareWidget\"></div>
            <script>
            !function (d, id, did, st) {
              var js = d.createElement(\"script\");
              js.src = \"http://connect.ok.ru/connect.js\";
              js.onload = js.onreadystatechange = function () {
              if (!this.readyState || this.readyState == \"loaded\" || this.readyState == \"complete\") {
                if (!this.executed) {
                  this.executed = true;
                  setTimeout(function () {
                    OK.CONNECT.insertShareWidget(id,did,st);
                  }, 0);
                }
              }};
              d.documentElement.appendChild(js);
            }(document,\"ok_shareWidget\",'".$url."',\"{width:75,height:65,st:'rounded',sz:20".$style.",nt:1}\");
            </script>";
        $tmp.= PHP_EOL;
        $htmlCode.= "<div class=\"cmp_ok_container\" >$tmp</div>";
    }
    //////////////////End OK share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    ////////////////////////Start LIKEDIN share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    if ($enable_in == 1) {
            $data_counter_in = $params->get('data_counter_in');
            $data_showzero_in = $params->get('data_showzero_in');
            if ($data_counter_in == "none") {
                $data_counter_in = "";
                $data_showzero_in = "";
            } else {
                $data_counter_in = "data-counter=\"$data_counter_in\"";
                if ($data_showzero_in == "0") {
                    $data_showzero_in = "";
                } else {
                    $data_showzero_in = 'data-showzero=\"true\"';
                }
            }
            $tmp = "";
            $tmp.="<script src=\"//platform.linkedin.com/in.js\" type=\"text/javascript\"> lang: $language</script>". PHP_EOL;
            $tmp.= "<script type=\"IN/Share\" data-url=\"$url\" $data_counter_in $data_showzero_in ></script>". PHP_EOL;
            $htmlCode.= "<div class=\"cmp_in_container\">$tmp</div>";
    }
    /////////////////////////End LIKEDIN share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    ////////////////////Start TWITER share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    if ($enable_twitter == 1) { 
        $TwCode = "
          window.twttr=(function(d,s,id){
            var js,
            fjs=d.getElementsByTagName(s)[0],
            t=window.twttr||{};
            if(d.getElementById(id))return t;
            js=d.createElement(s);
            js.id=id;
            js.src=\"https://platform.twitter.com/widgets.js\";
            fjs.parentNode.insertBefore(js,fjs);
            t._e=[];t.ready=function(f){t._e.push(f);};
                return t;
        }(document,\"script\",\"twitter-wjs\"));";
        $document->addScriptDeclaration($TwCode);
    //Twitter button
        $data_via_twitter = $params->get('data_via_twitter');
        $data_related_twitter = $params->get('data_related_twitter');
        $show_count_twitter = $params->get('show_count_twitter', 'horizontal');
        $hashtags_twitter = $params->get('hashtags_twitter', '');
        $datasize_twitter = $params->get('datasize_twitter');
        $language_twitter = 'data-lang="'.$language.'"';
        if ($data_via_twitter != "") {
            $data_via_twitter = 'data-via="'.$data_via_twitter.'"';
        } else {
            $data_via_twitter = '';
        }
        if ($data_related_twitter != "") {
            $data_related_twitter = 'data-related="'.$data_related_twitter.'"';
        } else {
            $data_related_twitter = '';
        }
        if ($hashtags_twitter != "") {
            $hashtags_twitter = 'data-hashtags="'.$hashtags_twitter.'"';
        }
        if ($datasize_twitter) {
            $datasize_twitter = 'data-size="'.$datasize_twitter.'"';
        }
        $tmp = "<a href=\"//twitter.com/share\" class=\"twitter-share-button\" ";
        $tmp.= " $language_twitter $data_via_twitter $hashtags_twitter $data_related_twitter $datasize_twitter ";
        $tmp.= "data-url=\"$url\" ";
        $tmp.= "data-count=\"$show_count_twitter\">Tweet</a>";
        $tmp.= PHP_EOL;
        $htmlCode.= "<div class=\"cmp_twitter_container\" >$tmp</div>";
    }
    ///////////////////End TWITER share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    //////////////////Start GOOGLE share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    if ($enable_google) {
    ///initialise google+1 script
        $GoogleCode = "
            window.___gcfg = {lang: \"$language\"};
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/platform.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();";
        $document->addScriptDeclaration($GoogleCode);
    //Google +1 button
        if ($enable_google == 1) {
            $size_google = $params->get('size_google');
            $annotation_google = $params->get('annotation_google');
            $container_google = $params->get('container_google');
            $tmp = "";
            $tmp.= "<div class=\"g-plusone\" data-size=\"$size_google\" data-href=\"$url\" data-annotation=\"$annotation_google\"></div>".PHP_EOL;
            $htmlCode.= "<div class=\"cmp_google_container\">$tmp</div>";
        }
    }
    ///////////////////End GOOGLE share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    // <!-- ///////////////////////////////////////////START VK SHARE BUTTON\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
    if ($enable_vk) {
    ///initialise vk script
        $document->addScript('http://vk.com/js/api/share.js?90');
        $vk_button_style = $params->get('vk_button_style');
        $vk_button_text = $params->get('vk_button_text');
        $vk_logo_type = $params->get('vk_logo_type');
        if($vk_button_style == 'custom'){
            if($vk_logo_type)
                $vk_button_text = "<img src=\"http://vk.com/images/share_32_eng.png\" width=\"32\" height=\"32\" />";
            else
                $vk_button_text = "<img src=\"http://vk.com/images/share_32.png\" width=\"32\" height=\"32\" />";
        }
        $image = (isset($image) && $image!='')? $image : '';
        $htmlCode.= "<div class=\"cmp_vk_container\">";
        $htmlCode.="
        <script type='text/javascript'>
            document.write(VK.Share.button(false,{
            url: '".$url."',
            title: '".$title."',
            description: '".addslashes($description)."',
            image: '".$image."',
            type: '".$vk_button_style."',
            text: '".$vk_button_text."',
            eng: '".$vk_logo_type."',
            noparse: true
            }));
        </script>";
        $htmlCode.="</div>";    
    }
// <!-- //////////////////////////////////////////End VK share button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
}
//////////////////START add_this button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
if($enable_add_this){
    $document->addScript('http://s7.addthis.com/js/250/addthis_widget.js');
    if(($params->get('module_syle')=='horizontal'|| $params->get('module_syle')=='vertical')){
        $htmlCode.= "<div class=\"cmp_AddThis_container\">";
        $htmlCode.="<div class=\"addthis_toolbox addthis_default_style\">
        <a class=\"addthis_button_more\"></a>
        </div>";
        $htmlCode.="</div>";
    }
}
//////////////////end add_this button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
?>

<noscript>Javascript is required to use Joomla Social Comments and Sharing<a href="http://ordasoft.com/joomla-social-comments-and-sharing.html">Joomla module for  Social media integration </a>, 
<a href="http://ordasoft.com/joomla-social-comments-and-sharing.html">Joomla Social Comments and Sharing - share and comment on Joomla site to social media: Facebook, Twitter, LinkedI,Vkontakte, Odnoklassniki</a></noscript>
    <div id="mainF"> 
        <div id="mainCom"> <?php echo $htmlCode; ?> </div>
        <div id="FbComBox"> <?php echo $htmlCodeComBox; ?> </div>
    </div>
<script text="text/javascript">
    <?php 
    if($params->get('module_syle') =='bottom' || $params->get('module_syle') =='top'){?>
        var width = ((document.body.clientWidth)-(<?php echo $box_counter * $params->get('icon_size','40')?>))/2+'px';
        document.getElementById('mainF').style.left = width;
    <?php 
    }
    if($params->get('module_syle') =='left' || $params->get('module_syle') =='right'){
    ?>
        var height = ((window.innerHeight)-(<?php echo $box_counter * $params->get('icon_size','40')?>))/2+'px';
        document.getElementById('mainF').style.top = height;
    <?php 
    }?>
    window.onresize = function(event) {
        <?php 
        if($params->get('module_syle') =='bottom' || $params->get('module_syle') =='top'){?>
            var width = ((document.body.clientWidth)-(<?php echo $box_counter * $params->get('icon_size','40')?>))/2+'px';
            document.getElementById('mainF').style.left = width;
        <?php 
        }
        if($params->get('module_syle') =='left' || $params->get('module_syle') =='right'){
        ?>
            var height = ((window.innerHeight)-(<?php echo $box_counter * $params->get('icon_size','40')?>))/2+'px';
            document.getElementById('mainF').style.top = height;
        <?php 
        }?>
    }
</script>
<!--               CSS for all block-->
    <style type="text/css">
    #addthis_icon .addthis_counter.addthis_bubble_style {
        margin: 0;
        padding: 0;
    }
    #mainF {
        z-index: 99999;
    }
    #mainF a div {
        -webkit-transition: all 0.3s ease-out;
       -moz-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }
    <?php
///////////////////////end\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    /////////////////////Start for custom blocks\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    if($params->get('module_syle') =='horizontal'){?>
            #mainF .fb_like_button_container span,#mainF .fb_send_button_container span{
                width: 450px!important;
            }
            #mainCom{
                padding-left: 8px!important;
            }
            #mainCom .fb_like_button_container,#mainCom .fb_share_button_container,#mainCom .fb_send_button_container,
            #mainCom .cmp_in_container,#mainCom .cmp_twitter_container,#mainCom .cmp_vk_container,.cmp_google_container,
            #mainCom .cmp_ok_container{
                float: left;
            }
            #mainCom .cmp_ok_container{
                margin-right: 4px;
            }
            #mainCom .fb_like_button_container{
                margin: 0px -369px 0px 0;
            }
            #mainF .fb_send_button_container{
                margin: 0px -398px 0px 0;   
            }
            #mainCom .cmp_twitter_container{
                margin-right: 4px;
                position: relative;
            }
            #mainCom .cmp_google_container,#mainCom .cmp_vk_container,#mainCom .cmp_ok_container{
                position: relative;   
            }
            #mainCom .cmp_AddThis_container{
                position: relative;   
                display: inline-block;
            }
            #mainCom .cmp_vk_container{
                margin-right: 3px;
                margin-left: -30px;
                position: relative;   
            }
            #mainCom .pluginButtonContainer{
                width: 62px;
            }
            #mainF .fb_send_button_container span{
                margin-right: 5px;
            }
    <?php
    }elseif($params->get('module_syle') =='vertival'){ ?>
            #mainF .fb_like_button_container span,#mainF .fb_send_button_container span{
                width: 450px!important;
            }
    <?php
    }elseif($params->get('module_syle')!='horizontal' || $params->get('module_syle')=='vertical'){ ?>
            #mainF .fb_like_button_container span,#mainF .fb_send_button_container span{
                width: 450px!important;
            }
            #mainF a div,#mainF #addthis_icon{
                position: relative;
            }
            .addthis_counter {
                width: <?php echo $icon_size; ?>!important;
                height: <?php echo $icon_size; ?>!important;
            }
            #addthis_icon a.addthis_counter.addthis_bubble_style {
                width: 0!important;
            }
            #addthis_icon  .addthis_button_more.at300b, .cmp_AddThis_container  .addthis_button_more.at300b {
                padding: 0;
            }
            .cmp_AddThis_container  .addthis_button_more.at300b, #mainCom .fb_like_button_container,
            #mainCom .fb_send_button_container, #mainCom .cmp_ok_container{
                margin-top: 4px;
            }
            span[id$=_count_box]{
                position: absolute;
                bottom: 0;
                left:0;
                right: 0;
                text-align: center;
                color: #000;
                line-height: 18px;
            }
            <?php
            if($params->get('module_syle') =='top'){?>
                #mainF a,#addthis_icon{
                    display: inline-block;
                }
                #mainF{
                   position: fixed;
                   top: 0;
                  }
                  #mainF a div:hover,  #mainF #addthis_icon:hover .at4-icon.aticon-more {
                    height:  <?php echo $icon_size_number + $icon_size_number *0.2 .'px !important'; ?>;
                    -webkit-transition: all 0.3s ease-out;
                   -moz-transition: all 0.3s ease-out;
                    transition: all 0.3s ease-out;
                    }
                    #mainF a, #addthis_icon {
                        vertical-align: top;
                    }
            <?php 
            }elseif($params->get('module_syle') =='left'){?>
                #mainF{
                    position: fixed;
                    left: 0;
                }
                #mainF a div:hover,  #mainF #addthis_icon:hover  .at4-icon.aticon-more {
                    width:  <?php echo $icon_size_number + $icon_size_number *0.2 .'px !important'; ?>;
                    -webkit-transition: all 0.3s ease-out;
                   -moz-transition: all 0.3s ease-out;
                    transition: all 0.3s ease-out;
                }
                 #mainF #addthis_icon:hover a.addthis_counter.addthis_bubble_style .addthis_button_expanded {
                    width:  <?php echo $icon_size_number + $icon_size_number *0.2 .'px !important'; ?>;
                    -webkit-transition: all 0.3s ease-out;
                   -moz-transition: all 0.3s ease-out;
                    transition: all 0.3s ease-out;
                }
            <?php
            }elseif($params->get('module_syle') =='right'){?>
                #mainF{
                    position: fixed;
                    right: 0;
                }
                #mainF a div:hover,  #mainF #addthis_icon:hover .at4-icon.aticon-more {
                    width:  <?php echo $icon_size_number + $icon_size_number *0.2 .'px !important'; ?>;
                    -webkit-transition: all 0.3s ease-out;
                   -moz-transition: all 0.3s ease-out;
                    transition: all 0.3s ease-out;
                }
                #mainF a div, #mainF #addthis_icon {
                    float: right;
                    clear: both;
                }
                 #mainF #addthis_icon:hover a.addthis_counter.addthis_bubble_style .addthis_button_expanded {
                    width:  <?php echo $icon_size_number + $icon_size_number *0.2 .'px !important'; ?>;
                    -webkit-transition: all 0.3s ease-out;
                   -moz-transition: all 0.3s ease-out;
                    transition: all 0.3s ease-out;
                }
            <?php 
            }elseif($params->get('module_syle') =='bottom'){ ?>
                #mainF a,#addthis_icon{
                    display: inline-block;
                }
                #mainF a div:hover,  #mainF #addthis_icon:hover .at4-icon.aticon-more{
                    height:  <?php echo $icon_size_number + $icon_size_number *0.2 .'px !important'; ?>;
                    -webkit-transition: all 0.3s ease-out;
                   -moz-transition: all 0.3s ease-out;
                    transition: all 0.3s ease-out;
                }
                #mainF{
                   position: fixed;
                   bottom: 0;
                   line-height: 10px;
                }
            <?php
            }elseif($params->get('module_syle') =='horizontal_icon'){?>
                #mainF a,#addthis_icon{
                    display: inline-block;
                }
            <?php
            }?>
            #mainF #fb_share_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/face.png';?>);
                background-position: center;
                -moz-background-size: 100%; /* Firefox 3.6+ */
                -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
                -o-background-size: 100%; /* Opera 9.6+ */
                background-size: 100%; /* Современные браузеры */
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #facebook-share-dialog {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }
            #mainF #liked_in_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/liked_in.png';?>);
                    -moz-background-size: 100%; /* Firefox 3.6+ */
                -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
                -o-background-size: 100%; /* Opera 9.6+ */
                background-size: 100%; /* Современные браузеры */
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #mainF #twitter_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/twitter_icon.png';?>);
                    -moz-background-size: 100%; /* Firefox 3.6+ */
        -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
        -o-background-size: 100%; /* Opera 9.6+ */
        background-size: 100%; /* Современные браузеры */
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #mainF #google_plus_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/google_plus_icon.png';?>);
                    -moz-background-size: 100%; /* Firefox 3.6+ */
        -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
        -o-background-size: 100%; /* Opera 9.6+ */
        background-size: 100%; /* Современные браузеры */
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #mainF #vk_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/vk_icon.png';?>);
                    -moz-background-size: 100%; 
                -webkit-background-size: 100%; 
                -o-background-size: 100%; 
                background-size: 100%; 
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #mainF #odnoklasniki_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/odnoklasniki_icon.png';?>);
                -moz-background-size: 100%; 
                -webkit-background-size: 100%; 
                -o-background-size: 100%; 
                background-size: 100%; 
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #mainF #fb_send_icon{
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/face_send.png';?>);
                -moz-background-size: 100%;
                -webkit-background-size: 100%; 
                -o-background-size: 100%; /
                background-size: 100%;
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
            }
            #mainF .at4-icon.aticon-more {
                background-image: url(<?php echo $mosConfig_live_site.
                    'modules/mod_social_comments_sharing/images/addthis-icon.png';?>)!important;
                -moz-background-size: 100%; 
                -webkit-background-size: 100%; 
                -o-background-size: 100%; 
                background-size: 100% !important; 
                background-position: center;
                width: <?php echo $icon_size; ?>;
                height: <?php echo $icon_size; ?>;
                -webkit-transition: all 0.3s ease-out;
               -moz-transition: all 0.3s ease-out;
                transition: all 0.3s ease-out;
            }
            #mainF .addthis_counter.addthis_bubble_style{
                background-image: none!important;
                position: absolute;
                bottom: 0;
                left:0;
                right: 0;
                text-align: center;
            }
            #addthis_icon a.addthis_counter .addthis_button_expanded {
                padding-bottom: 0;
                margin-bottom: 0;
                box-sizing: border-box;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                -o-box-sizing: border-box;
                color: #000;
                font-size: 13px;
                font-weight: 400;
                line-height: 18px;
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                width: <?php echo $icon_size; ?>!important;
                height: 18px;
                -webkit-transition: all 0.3s ease-out;
               -moz-transition: all 0.3s ease-out;
                transition: all 0.3s ease-out;
            }
    <?php
    }
    ?>
</style>