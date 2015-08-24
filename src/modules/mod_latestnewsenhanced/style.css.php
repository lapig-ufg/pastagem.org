<?php 
/**
* @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

$security = 0;
if (isset($_GET["$security"])) {
	$security = $_GET['security'];
}

define('_JEXEC', $security);

// No direct access to this file
defined('_JEXEC') or die;

// Explicitly declare the type of content
header("Content-type: text/css; charset=UTF-8");
    
// Grab module id from the request
$suffix = $_GET['suffix']; 

$item_width = 100;
$margin_in_perc = 0;
if (isset($_GET['item_w'])) {
	$item_width = (int)$_GET['item_w'];
	
	$news_per_row = (int)(100 / $item_width);
	$left_for_margins = 100 - ($news_per_row * $item_width);
	$margin_in_perc = $left_for_margins / ($news_per_row * 2);
}

$head_width = 0;
if (isset($_GET['head_w'])) {
	$head_width = (int)$_GET['head_w'];
}

$head_height = 0;
if (isset($_GET['head_h'])) {
	$head_height = (int)$_GET['head_h'];
}

$wrap = false;
if (isset($_GET['wrap'])) {
	$wrap = true;
}

// force one line
$force_title_line = false;
if (isset($_GET['title_fl'])) {
	$force_title_line = true;
}

$font_size_ref = -1;
if (isset($_GET['font_s'])) {
	$font_size_ref = (int)$_GET['font_s'];
}
?>

.latestnewsenhanced_<?php echo $suffix; ?>.newslist {}

	.latestnewsenhanced_<?php echo $suffix; ?> ul.newsitems {
		margin: 0;
		padding: 0;
		list-style: none;
		
		/* remove extra gaps between inline blocks */
	    font-size: 0;
	    letter-spacing: -1px; /* only for Safari */
	}
		
		@media only screen and (max-width: 480px) {
			.latestnewsenhanced_<?php echo $suffix; ?> li.newsitem {
				width: 100% !important;
				margin-left: 0 !important;
				margin-right: 0 !important;
			}
		}
		
		<?php if ($item_width < 40) : ?>
			 @media only screen and (min-width: 480px) and (max-width: 767px) {
				.latestnewsenhanced_<?php echo $suffix; ?> li.newsitem {
					width: 48% !important;
					margin-left: 1% !important;
					margin-right: 1% !important;
				}
			}
		<?php endif; ?>
	
		.latestnewsenhanced_<?php echo $suffix; ?> li.newsitem {
			width: <?php echo $item_width; ?>%;
			overflow: hidden;
			display: inline-block;
			
			<?php if ($font_size_ref > 0) : ?>
				font-size: <?php echo $font_size_ref; ?>px;
			<?php else : ?>
				font-size: medium;
			<?php endif; ?>
		
			letter-spacing: normal;
			vertical-align: top;
			margin-bottom: 5px;
			margin-left: <?php echo $margin_in_perc; ?>%;
			margin-right: <?php echo $margin_in_perc; ?>%;
			list-style: none; /* To avoid possible template overrides */
		    padding: 0; /* To avoid possible template overrides */
		    background-image: none !important; /* To avoid possible template overrides */
		}
		
		.latestnewsenhanced_<?php echo $suffix; ?> li.newsitem.active {
			background-color: #CCCCCC;
		}
		
			.latestnewsenhanced_<?php echo $suffix; ?> .news {
				overflow: hidden;
				margin-top: 10px;
			}

			.latestnewsenhanced_94 .news:first-child {
				margin-top: 0;
			}
			
			.latestnewsenhanced_<?php echo $suffix; ?> .odd {
				overflow: hidden;
				padding: 2px;
			}
		
			.latestnewsenhanced_<?php echo $suffix; ?> .even {
				overflow: hidden;
				padding: 2px;
			}
			
				.latestnewsenhanced_<?php echo $suffix; ?> .newshead {		
					/* same column height fix */
					/* margin-bottom: -1000px;
					padding-bottom: 1000px;	*/	
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .headleft {
					float: left;
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .headright {
					float: right;
				}
				
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture,
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture,
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nodate {
						width: <?php echo $head_width; ?>px;
						height: <?php echo $head_height; ?>px;
						min-width: <?php echo $head_width; ?>px;
						min-height: <?php echo $head_height; ?>px;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar {
						width: <?php echo $head_width; ?>px;
						min-width: <?php echo $head_width; ?>px;						
					}
				
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar {
						/* next properties to avoid conflict with calendar.jos.css */
						border: none;
						font-family: inherit;
    					font-size: inherit;
					}	
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar.noimage {			
						background: #F4F4F4; /* Old browsers */
						background: -moz-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* FF3.6+ */
						background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */
						background: -webkit-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Chrome10+,Safari5.1+ */
						background: -o-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Opera11.10+ */
						background: -ms-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* IE10+ */
						filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
						background: linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* W3C */
						
						color: #3D3D3D;						
						
						border-radius: 4px;
						-moz-border-radius: 4px;
						-webkit-border-radius: 4px;
						/* IE 7 AND 8 DO NOT SUPPORT BORDER RADIUS */
						
						-moz-background-clip: padding-box;
						-webkit-background-clip: padding-box;
						background-clip: padding-box;
						/* Use "background-clip: padding-box" when using rounded corners to avoid the gradient bleeding through the corners */
						
						border: 1px solid #DDDDDD;
					}		
		
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .weekday, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .month, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .day, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .year,
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .time {
							position: relative;
							width: 100%;
							text-align: center;
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar.noimage .weekday {							
							background: #C8C8C8; /* Old browsers */
							background: -moz-linear-gradient(top, #eeeeee 0%, #cccccc 100%); /* FF3.6+ */
							background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */
							background: -webkit-linear-gradient(top, #eeeeee 0%,#cccccc 100%); /* Chrome10+,Safari5.1+ */
							background: -o-linear-gradient(top, #eeeeee 0%,#cccccc 100%); /* Opera11.10+ */
							background: -ms-linear-gradient(top, #eeeeee 0%,#cccccc 100%); /* IE10+ */
							filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */
							background: linear-gradient(top, #eeeeee 0%,#cccccc 100%); /* W3C */						
							
							color: #494949;						
							
							border-top-right-radius: 4px;
							border-top-left-radius: 4px;
							-moz-border-top-right-radius: 4px;
							-moz-border-top-left-radius: 4px;
							-webkit-border-top-right-radius: 4px;
							-webkit-border-top-left-radius: 4px;
							
							-moz-background-clip: padding-box;
							-webkit-background-clip: padding-box;
							background-clip: padding-box;
							/* Use "background-clip: padding-box" when using rounded corners to avoid the gradient bleeding through the corners */		
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar.noimage .time {							
							background: #C8C8C8; /* Old browsers */
							background: -moz-linear-gradient(top, #cccccc 0%, #eeeeee 100%); /* FF3.6+ */
							background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cccccc), color-stop(100%,#eeeeee)); /* Chrome,Safari4+ */
							background: -webkit-linear-gradient(top, #cccccc 0%,#eeeeee 100%); /* Chrome10+,Safari5.1+ */
							background: -o-linear-gradient(top, #cccccc 0%,#eeeeee 100%); /* Opera11.10+ */
							background: -ms-linear-gradient(top, #cccccc 0%,#eeeeee 100%); /* IE10+ */
							filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cccccc', endColorstr='#eeeeee',GradientType=0 ); /* IE6-9 */
							background: linear-gradient(top, #cccccc 0%,#eeeeee 100%); /* W3C */						
							
							color: #494949;						
							
							border-bottom-right-radius: 4px;
							border-bottom-left-radius: 4px;
							-moz-border-bottom-right-radius: 4px;
							-moz-border-bottom-left-radius: 4px;
							-webkit-border-bottom-right-radius: 4px;
							-webkit-border-bottom-left-radius: 4px;
							
							-moz-background-clip: padding-box;
							-webkit-background-clip: padding-box;
							background-clip: padding-box;
							/* Use "background-clip: padding-box" when using rounded corners to avoid the gradient bleeding through the corners */		
							
						}
				
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .weekday {
							font-size: 1em;
							text-transform: uppercase;
							letter-spacing: 0.4em;
							line-height: 1.5em;
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .month {
							font-size: 0.8em;
							font-weight: bold;
							letter-spacing: 0.45em;
							line-height: 1.2em;
							margin-top: 0.2em;
							margin-bottom: 0.2em;
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .day {	
							font-size: 2em;
							font-weight: bold;
							letter-spacing: 0.1em;
							line-height: 0.8em;  
							margin-bottom: 0.2em;  						
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .year {
							font-size: 0.8em;
							letter-spacing: 0.35em;
							line-height: 1.2em;
							margin-bottom: 0.2em;
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .time {
							font-size: 0.8em;
							letter-spacing: 0.1em;
							line-height: 1.7em;
						}				
	
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture {
		    			overflow: hidden;
						background-color: #FFFFFF;
						padding: 3px;
						text-align: center;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture a,
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture a {
						text-decoration: none;
						display: inline-block;
						height: 100%;
	    				width: 100%;
	    				cursor: hand;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture a:hover,
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture a:hover {
						text-decoration: none;
					}
		
					.latestnewsenhanced_<?php echo $suffix; ?>  .newshead .picture img {
						max-width: 100%;
						max-height: 100%;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture .defaultpicture {}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture {
		    			overflow: hidden;
						background-color: #FFFFFF;
						border: 1px solid #CCCCCC;
						padding: 3px;
						text-align: center;
					}
		
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture span {
						background-color: #F4F4F4;
						display: inline-block;
						width: 100%;
						height: 100%;
					}
	
				.latestnewsenhanced_<?php echo $suffix; ?> .newsinfo {
					<?php if (!$wrap) : ?>
						overflow: hidden;
					<?php endif; ?>
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .infonoimageleft {}	
						
				.latestnewsenhanced_<?php echo $suffix; ?> .infoleft {
					clear: right;
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .infonoimageright {
					text-align: right;
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .inforight {
					clear: left;
				}
				
					.latestnewsenhanced_<?php echo $suffix; ?> .newstitle {
						font-weight: bold;
					}
					
					<?php if ($force_title_line) : ?>						
						.latestnewsenhanced_<?php echo $suffix; ?> .newstitle a span {
							display: block;
							white-space: nowrap; 
							text-overflow: ellipsis; 
							overflow: hidden;
						}
					<?php endif; ?>
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newsintro {
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newsextra {
						font-size: 0.8em;
					}
					
						.latestnewsenhanced_<?php echo $suffix; ?> .newsextra .delimiter {
							padding: 0 3px;
						}
					
						.latestnewsenhanced_<?php echo $suffix; ?> .newsextra .delimiter:before {
							content: "-";
						}

						.latestnewsenhanced_<?php echo $suffix; ?> .infoleft .newstitle {
					margin: 0 0 0 20px;
				}
				
					.latestnewsenhanced_<?php echo $suffix; ?> .infoleft .newsintro {
						margin: 0 0 0 20px;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .infoleft .newsextra {
						margin: 0 0 0 20px;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .infoleft .link {
						margin: 0 0 0 20px;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .infoleft .catlink {
						margin: 0 0 0 20px;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .inforight .newstitle {
						margin: 0 20px 0 0;
						text-align: right;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .inforight .newsintro {
						margin: 0 20px 0 0;
						text-align: right;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .inforight .newsextra {
						margin: 0 20px 0 0;
						text-align: right;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .inforight .link {
						margin: 0 20px 0 0;
						text-align: right;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .inforight .catlink {
						margin: 0 20px 0 0;
						text-align: right;
					}
				
					.latestnewsenhanced_<?php echo $suffix; ?> .link {}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .catlink {}

	.latestnewsenhanced_<?php echo $suffix; ?> .pagination {
		margin: 0;
		padding: 0;
		list-style: none;
		text-align: center;
		position: relative;
		clear: both;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .pagination li {
		display: inline;
		list-style: none;
		cursor: pointer;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .pagination li.active span {
		text-decoration: underline;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .pagination li.disabled span {
		color: #999999;
		cursor: default;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .onecatlink {
		margin-right: <?php echo $margin_in_perc; ?>%;
		text-align: right;
	}		
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message {
		width: 100%;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message dl {
		border: 1px solid #EED3D7;
		border-radius: 4px;
		background-color: #F2DEDE;
		color: #B94A48;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message dt {
		border-bottom: 1px solid #EED3D7;
		padding-left: 5px;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message dd {
		word-wrap: break-word;
		margin-bottom: 3px;
    	margin-top: 3px;
    	margin-left: 5px;
	}
		