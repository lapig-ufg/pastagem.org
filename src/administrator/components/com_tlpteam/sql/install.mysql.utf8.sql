CREATE TABLE IF NOT EXISTS `#__tlpteam_team` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`name` VARCHAR(255)  NOT NULL ,
`position` VARCHAR(255)  NOT NULL ,
`profile_image` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`phone` VARCHAR(255)  NOT NULL ,
`short_bio` TEXT NOT NULL ,
`detail_bio` TEXT NOT NULL ,
`facebook` VARCHAR(100)  NOT NULL ,
`twitter` VARCHAR(150)  NOT NULL ,
`googleplus` VARCHAR(150)  NOT NULL ,
`linkedin` VARCHAR(255)  NOT NULL ,
`web` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `#__tlpteam_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagepath` varchar(255) NOT NULL DEFAULT 'images/tlpteam',
  `smallwidth` varchar(255) NOT NULL DEFAULT '160',
  `smallheight` varchar(255) NOT NULL DEFAULT '160',
  `mediumwidth` varchar(255) NOT NULL DEFAULT '340',
  `mediumheight` varchar(255) NOT NULL DEFAULT '340',
  `largewidth` varchar(255) NOT NULL DEFAULT '1080',
  `largeheight` varchar(255) NOT NULL DEFAULT '1080',
  `display_no` int(11) NOT NULL,
  `enable_bootstrap_css` tinyint(4) NOT NULL,
  `detailpage_image_grid` int(11) NOT NULL,
  `detailpage_content_grid` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `thf3b_tlpteam_settings`
--

INSERT INTO `#__tlpteam_settings` (`id`, `imagepath`, `smallwidth`, `smallheight`, `mediumwidth`, `mediumheight`, `largewidth`, `largeheight`, `display_no`, `enable_bootstrap_css`, `detailpage_image_grid`, `detailpage_content_grid`, `state`, `checked_out`, `checked_out_time`, `created_by`) VALUES
(1, 'images/tlpteam', '90', '90', '215', '195', '600', '400', 3, 1, 4, 0, 0, 0, '0000-00-00 00:00:00', 0);
