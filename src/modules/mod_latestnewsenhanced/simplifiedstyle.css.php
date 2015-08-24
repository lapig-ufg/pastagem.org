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
		    padding: 0 !important; /* To avoid possible template overrides */
		    background-image: none !important; /* To avoid possible template overrides */
		}
		
		.latestnewsenhanced_<?php echo $suffix; ?> li.newsitem.active {}
		
			.latestnewsenhanced_<?php echo $suffix; ?> .news {
				overflow: hidden;
				padding: 2px;
			}
			
			.latestnewsenhanced_<?php echo $suffix; ?> .odd {
				padding: 0; /* to override k2 style */
			}
		
			.latestnewsenhanced_<?php echo $suffix; ?> .even {
				padding: 0; /* to override k2 style */
			}
			
				.latestnewsenhanced_<?php echo $suffix; ?> .newshead {}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .headleft {
					float: left;
					margin-right: 8px;
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .headright {
					float: right;
					margin-left: 8px;
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
						font-family: inherit;
    					font-size: inherit;
					}	
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar.noimage {}		
		
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .weekday, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .month, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .day, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .year, 
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .time {
							position: relative;
							width: 100%;
							text-align: center;
						}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar.noimage .weekday {}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar.noimage .time {}
				
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .weekday {}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .month {}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .day {}
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .year {}	
						
						.latestnewsenhanced_<?php echo $suffix; ?> .newshead .calendar .time {}			
	
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture {
		    			overflow: hidden;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture a,
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture a {
						display: inline-block;
						height: 100%;
	    				width: 100%;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture a:hover,
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture a:hover {}
		
					.latestnewsenhanced_<?php echo $suffix; ?>  .newshead .picture img {
						max-width: 100%;
						max-height: 100%;
					}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .picture .defaultpicture {}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture {
		    			overflow: hidden;
					}
		
					.latestnewsenhanced_<?php echo $suffix; ?> .newshead .nopicture span {
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
						
				.latestnewsenhanced_<?php echo $suffix; ?> .infoleft {}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .infonoimageright {
					text-align: right;
				}
				
				.latestnewsenhanced_<?php echo $suffix; ?> .inforight {
					text-align: right;
				}
				
					.latestnewsenhanced_<?php echo $suffix; ?> .newstitle {}
					
					<?php if ($force_title_line) : ?>						
						.latestnewsenhanced_<?php echo $suffix; ?> .newstitle a span {
							display: block;
							white-space: nowrap; 
							text-overflow: ellipsis; 
							overflow: hidden;
						}
					<?php endif; ?>
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newsintro {}
					
					.latestnewsenhanced_<?php echo $suffix; ?> .newsextra {}
					
						.latestnewsenhanced_<?php echo $suffix; ?> .newsextra .delimiter {
							padding: 0 3px;
						}
					
						.latestnewsenhanced_<?php echo $suffix; ?> .newsextra .delimiter:before {
							content: "-";
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
		padding: 0 2px;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .pagination li.active span {}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .pagination li.disabled span {}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .onecatlink {
		margin-right: <?php echo $margin_in_perc; ?>%;
	}		
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message {
		width: 100%;
	}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message dl {}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message dt {}
	
	.latestnewsenhanced_<?php echo $suffix; ?> .error-message dd {}
		