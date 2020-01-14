SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `block_list` (
  `userid` bigint(20) NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `checkin` (
  `checkorder` bigint(11) NOT NULL,
  `id` bigint(20) NOT NULL,
  `checkindate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `continuouscheckin` (
  `id` int(11) NOT NULL,
  `times` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `forumlist` (
  `gid` int(11) NOT NULL,
  `gname` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `ipcheck` (
  `ipaddr` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `laf_polling` (
  `id` int(11) NOT NULL,
  `poll_options` json NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` int(11) NOT NULL,
  `disabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `laf_settings` (
  `is_deploy` tinyint(1) NOT NULL DEFAULT '0',
  `version` text COLLATE utf8_unicode_ci NOT NULL,
  `lfpi` int(11) NOT NULL,
  `release_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `maintainance` (
  `id` int(11) NOT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_date` datetime NOT NULL,
  `e_date` datetime NOT NULL,
  `min_right` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Moderators` (
  `fid` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `rank` (
  `rnumber` bigint(20) NOT NULL,
  `rname` varchar(1000) NOT NULL,
  `min_mark` bigint(20) NOT NULL,
  `read` int(11) NOT NULL,
  `tagcolor` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `replies` (
  `topic_id` bigint(20) NOT NULL,
  `reply_id` bigint(20) NOT NULL,
  `reply_topic` varchar(999) DEFAULT NULL,
  `reply_content` longtext NOT NULL,
  `author` bigint(20) NOT NULL,
  `hiddeni` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `reserved_usernames` (
  `reserved_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reserved_by_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `tagcolor` longtext NOT NULL,
  `r_edit` tinyint(1) NOT NULL,
  `r_del` tinyint(1) NOT NULL,
  `r_promo` int(11) NOT NULL,
  `r_hide` int(11) NOT NULL DEFAULT '0',
  `r_manage` int(11) DEFAULT '0',
  `profile_invisible` tinyint(1) NOT NULL DEFAULT '0',
  `rights` int(11) NOT NULL DEFAULT '10'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `specialteam` (
  `id` bigint(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `role_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `locale` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `subforum` (
  `fid` bigint(20) NOT NULL,
  `gid` int(11) NOT NULL,
  `fname` longtext NOT NULL,
  `url` varchar(1000) NOT NULL DEFAULT 'viewforum.php?id=',
  `rights` int(11) NOT NULL,
  `min_author_rights` int(11) NOT NULL,
  `rules` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `threads` (
  `fid` int(11) NOT NULL,
  `topic_id` bigint(20) NOT NULL,
  `topic_name` varchar(9999) NOT NULL,
  `topic_content` longtext NOT NULL,
  `author` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) NOT NULL DEFAULT '0',
  `draft` int(11) NOT NULL DEFAULT '0',
  `hiddeni` int(11) NOT NULL DEFAULT '0',
  `rights` int(11) NOT NULL DEFAULT '0',
  `stickyness` int(11) NOT NULL DEFAULT '0',
  `stickyuntil` date DEFAULT NULL,
  `highlightcolor` text,
  `showInIndex` int(11) DEFAULT '0',
  `seo` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `timezone` (
  `timezid` int(11) NOT NULL,
  `tz` varchar(255) NOT NULL,
  `gmt` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `usertz` (
  `id` bigint(20) NOT NULL,
  `timezid` int(11) NOT NULL DEFAULT '25'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `block_list`
  ADD UNIQUE KEY `userid` (`userid`),
  ADD KEY `uid` (`userid`);

ALTER TABLE `checkin`
  ADD PRIMARY KEY (`checkorder`);

ALTER TABLE `continuouscheckin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forumlist`
  ADD PRIMARY KEY (`gid`),
  ADD UNIQUE KEY `gid` (`gid`);

ALTER TABLE `laf_settings`
  ADD PRIMARY KEY (`lfpi`);

ALTER TABLE `maintainance`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rank`
  ADD PRIMARY KEY (`rnumber`),
  ADD UNIQUE KEY `rnumber` (`rnumber`);

ALTER TABLE `replies`
  ADD PRIMARY KEY (`topic_id`,`reply_id`);

ALTER TABLE `reserved_usernames`
  ADD PRIMARY KEY (`reserved_username`),
  ADD KEY `idlink` (`reserved_by_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

ALTER TABLE `specialteam`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `subforum`
  ADD PRIMARY KEY (`fid`);

ALTER TABLE `threads`
  ADD PRIMARY KEY (`topic_id`);

ALTER TABLE `timezone`
  ADD PRIMARY KEY (`timezid`);


ALTER TABLE `checkin`
  MODIFY `checkorder` bigint(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `forumlist`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `maintainance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rank`
  MODIFY `rnumber` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `subforum`
  MODIFY `fid` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `threads`
  MODIFY `topic_id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `timezone`
  MODIFY `timezid` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `block_list`
  ADD CONSTRAINT `block_list_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `reserved_usernames`
  ADD CONSTRAINT `idlink` FOREIGN KEY (`reserved_by_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
