-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2020 年 01 月 19 日 09:13
-- 伺服器版本： 8.0.18
-- PHP 版本： 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `php_forum`
--

-- --------------------------------------------------------

--
-- 資料表結構 `block_list`
--

CREATE TABLE `block_list` (
  `userid` bigint(20) NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `block_list`
--

INSERT INTO `block_list` (`userid`, `end_date`, `reason`) VALUES
(2, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `checkin`
--

CREATE TABLE `checkin` (
  `checkorder` bigint(11) NOT NULL,
  `id` bigint(20) NOT NULL,
  `checkindate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `checkin`
--

INSERT INTO `checkin` (`checkorder`, `id`, `checkindate`) VALUES
(10, 1, '2019-05-28 22:29:58'),
(11, 1, '2019-05-29 07:44:11'),
(12, 1, '2019-05-30 16:37:53'),
(13, 1, '2019-05-31 15:38:53'),
(14, 1, '2019-06-01 13:05:37'),
(15, 1, '2019-06-03 13:03:26'),
(16, 1, '2019-06-04 22:15:16'),
(17, 1, '2019-06-05 19:21:16'),
(18, 1, '2019-06-06 10:35:04'),
(19, 1, '2019-06-11 17:54:24'),
(20, 1, '2019-06-12 09:00:25'),
(21, 1, '2019-06-16 09:46:53'),
(22, 1, '2019-06-17 22:38:07'),
(23, 1, '2019-06-18 11:32:49'),
(24, 1, '2019-06-19 16:38:10'),
(25, 1, '2019-07-13 12:52:50'),
(26, 1, '2019-07-20 13:14:29'),
(27, 1, '2019-07-21 02:58:06'),
(28, 1, '2019-07-27 22:39:55'),
(29, 1, '2019-07-29 23:00:31'),
(30, 1, '2019-08-02 22:33:57'),
(31, 1, '2019-08-11 20:39:45'),
(32, 1, '2019-08-13 22:12:27'),
(33, 1, '2019-08-14 21:15:22'),
(34, 1, '2019-09-21 22:08:22'),
(35, 1, '2019-09-22 22:18:25'),
(36, 1, '2019-09-25 21:17:22'),
(37, 1, '2019-10-01 21:54:47'),
(38, 1, '2019-10-02 08:42:17'),
(39, 1, '2019-10-04 22:56:13'),
(40, 1, '2019-10-05 21:31:47'),
(41, 1, '2019-12-19 15:17:06'),
(42, 1, '2019-12-20 01:56:31'),
(43, 1, '2019-12-21 11:25:31');

-- --------------------------------------------------------

--
-- 資料表結構 `continuouscheckin`
--

CREATE TABLE `continuouscheckin` (
  `id` int(11) NOT NULL,
  `times` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `continuouscheckin`
--

INSERT INTO `continuouscheckin` (`id`, `times`) VALUES
(1, 42),
(4, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `forumlist`
--

CREATE TABLE `forumlist` (
  `gid` int(11) NOT NULL,
  `gname` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `forumlist`
--

INSERT INTO `forumlist` (`gid`, `gname`) VALUES
(1, 'General'),
(2, '論壇事務');

-- --------------------------------------------------------

--
-- 資料表結構 `ipcheck`
--

CREATE TABLE `ipcheck` (
  `ipaddr` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `laf_settings`
--

CREATE TABLE `laf_settings` (
  `laf_api` bigint(11) NOT NULL,
  `laf_version` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_deploy` tinyint(1) NOT NULL DEFAULT '0',
  `laf_release_date` date NOT NULL,
  `db_version` bigint(20) NOT NULL,
  `channel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `laf_settings`
--

INSERT INTO `laf_settings` (`laf_api`, `laf_version`, `is_deploy`, `laf_release_date`, `db_version`, `channel`) VALUES
(1, '20.1.5', 0, '2020-01-05', 0, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `maintainance`
--

CREATE TABLE `maintainance` (
  `id` int(11) NOT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_date` datetime NOT NULL,
  `e_date` datetime NOT NULL,
  `min_right` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `Moderators`
--

CREATE TABLE `Moderators` (
  `fid` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `Moderators`
--

INSERT INTO `Moderators` (`fid`, `id`) VALUES
(1, 13);

-- --------------------------------------------------------

--
-- 資料表結構 `rank`
--

CREATE TABLE `rank` (
  `rnumber` bigint(20) NOT NULL,
  `rname` varchar(1000) NOT NULL,
  `min_mark` bigint(20) NOT NULL,
  `read` int(11) NOT NULL,
  `tagcolor` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `rank`
--

INSERT INTO `rank` (`rnumber`, `rname`, `min_mark`, `read`, `tagcolor`) VALUES
(1, '系統用戶', 0, 10, 'black'),
(2, '敢於嘗試的 Fans', 100, 15, '#00c5ff'),
(3, '軟件測試員', 500, 15, '#005cff'),
(4, '系統分析員', 1000, 25, 'orange'),
(5, '系統程式員', 5000, 25, '#ffd700'),
(0, 'CDROM', 0, 0, 'grey');

-- --------------------------------------------------------

--
-- 資料表結構 `replies`
--

CREATE TABLE `replies` (
  `topic_id` bigint(20) NOT NULL,
  `reply_id` bigint(20) NOT NULL,
  `reply_topic` varchar(999) DEFAULT NULL,
  `reply_content` longtext NOT NULL,
  `author` bigint(20) NOT NULL,
  `hiddeni` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `replies`
--

INSERT INTO `replies` (`topic_id`, `reply_id`, `reply_topic`, `reply_content`, `author`, `hiddeni`) VALUES
(18, 3, NULL, 'Try Replying', 1, 0),
(19, 1, NULL, '修復現在已完成', 1, 0),
(18, 1, 'Reply to the thread', 'Try Replying', 1, 0),
(18, 2, '回覆測試手機版', '測試文字：\r\n歡迎加入Labo論壇，我們有很多的朋友正在等你來發言。論壇設有回覆發獎勵機制，當用戶回覆的時候，將可獲得1分的獎勵。\r\n至於如果用戶發帖，則可獲得2分獎勵。', 1, 0),
(13, 1, NULL, '回覆檢查', 1, 0),
(28, 1, 'HAHA', 'Congrats to everyone hardwork', 1, 0),
(29, 1, NULL, '哈～遲D將個 Search Bar 放返嚟 Forum&nbsp;', 1, 0),
(29, 2, NULL, '哈～遲D將個 Search Bar 放返嚟 Forum&nbsp;', 1, 0),
(29, 3, '好勁呀!', '小風哥好嘢!!', 13, 0),
(29, 4, '好勁呀!', '小風哥好嘢!!', 13, 0),
(30, 1, '小號 - 1', '哇!!好西利呀<div>我愛你ChampionBB!!</div>', 13, 0),
(26, 1, '劉冬', '聽說有人在叫我????', 13, 0),
(26, 2, '劉冬', '聽說有人在叫我????', 13, 0),
(30, 2, NULL, '早晨!', 4, 0),
(30, 3, NULL, '早晨!', 4, 0),
(30, 4, NULL, '早晨!', 4, 0),
(30, 5, '你好', '晚安', 4, 0),
(33, 1, '123', '123', 15, 0),
(33, 2, '123', '123', 15, 0),
(33, 3, '123', '123', 15, 0),
(33, 4, '123', '123', 15, 0),
(33, 5, '123', '123', 15, 0),
(33, 6, '123', '123', 15, 0),
(33, 7, '123', '123', 15, 0),
(33, 8, '123', '123', 15, 0),
(33, 9, '123', '123', 15, 0),
(33, 10, '123', '123', 15, 0),
(33, 11, '123', '123', 15, 0),
(31, 1, 'Jaiden', '6666', 4, 0),
(31, 2, NULL, 'test', 4, 0),
(31, 3, NULL, 'test2', 4, 0),
(31, 4, NULL, 'test3', 4, 0),
(31, 5, NULL, 'test4', 4, 0),
(31, 6, '5', 'test5', 4, 0),
(31, 7, NULL, 'test6', 4, 0),
(31, 8, NULL, 'test7', 4, 0),
(31, 9, NULL, 'test8', 4, 0),
(34, 1, NULL, '==', 4, 0),
(34, 2, NULL, '-_- 我哋睇到，只不過無 profile pic 而已', 1, 0),
(57, 1, '', '預留<br>This reply is sumbitted by Project PostCard</br>', 1, 0),
(12, 3, 'Try again', 'It clears out :)<br>This reply is sumbitted by Project PostCard</br>', 1, 0),
(12, 2, NULL, 'Just try one more thing<br>This reply is sumbitted by Project PostCard</br>', 1, 0),
(12, 1, 'Yeah, we are doing something great', 'Do you know that we have created something great ?<br>This reply is sumbitted by Project PostCard</br>', 1, 0),
(44, 1, '00', '', 13, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `reserved_usernames`
--

CREATE TABLE `reserved_usernames` (
  `reserved_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reserved_by_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `reserved_usernames`
--

INSERT INTO `reserved_usernames` (`reserved_username`, `reserved_by_id`) VALUES
('admin', 1),
('little', 1),
('littlephone', 1),
('littlephone506', 1),
('root', 1),
('webmaster', 1),
('小風', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `roles`
--

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

--
-- 傾印資料表的資料 `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `tagcolor`, `r_edit`, `r_del`, `r_promo`, `r_hide`, `r_manage`, `profile_invisible`, `rights`) VALUES
(1, '管理員', 'red', 1, 1, 1, 1, 1, 1, 255),
(2, '超級版主', '#beffbb', 1, 1, 1, 0, 0, 0, 200),
(3, '版主', 'green', 1, 0, 1, 0, 0, 0, 90),
(13, '普通用戶', '', 0, 0, 0, 0, 0, 0, 10),
(14, '禁止立足', 'black', 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `specialteam`
--

CREATE TABLE `specialteam` (
  `id` bigint(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `role_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `locale` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `specialteam`
--

INSERT INTO `specialteam` (`id`, `username`, `role_id`, `visible`, `locale`) VALUES
(1, '小風哥', 1, 0, NULL),
(3, 'DanielSururu', 1, 1, NULL),
(4, 'Jaiden ^^', 1, 1, NULL),
(13, 'Champion', 2, 1, NULL),
(9, 'keith', 2, 1, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `subforum`
--

CREATE TABLE `subforum` (
  `fid` bigint(20) NOT NULL,
  `gid` int(11) NOT NULL,
  `fname` longtext NOT NULL,
  `url` varchar(1000) NOT NULL DEFAULT 'viewforum.php?id=',
  `rights` int(11) NOT NULL,
  `min_author_rights` int(11) NOT NULL,
  `rules` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `subforum`
--

INSERT INTO `subforum` (`fid`, `gid`, `fname`, `url`, `rights`, `min_author_rights`, `rules`) VALUES
(1, 1, 'Labstry General', 'viewforum.php?id=', 0, 0, NULL),
(21, 2, '論壇通知', 'viewforum.php?id=', 0, 255, '論壇通知，最cool管理員的主場'),
(89, 2, '延伸開發組', 'tester.php?id=', 85, 0, '程式開發組的延伸'),
(2, 1, 'New Functions', 'viewforum.php?id=2', 0, 255, NULL),
(88, 2, 'Documentation', 'viewforum.php?id=', 255, 255, NULL),
(3, 1, '刷機專區', 'viewforum.php?id=', 0, 0, '本板塊是 Labo 刷機討論區。用戶可以發表關於刷機相關的話題。以下是規則：\r\n</br></br>\r\n<ol>\r\n<li>不准發表與刷機無關的內容，否則帖子會被移動到離題區，且扣 3 積分</li>\r\n<li>禁止在板塊中灌水，或以任何方式或藉口進行多重發佈內容相同或內容相似的帖子。若發現有此行為，將會扣 5 積分，及對該行為進行記錄。</li>\r\n<li>發表的內容必須尊重他人的知識版權。 若發表的內容包括由他處得到的內容且允許重新發表，請註明出處。</li>\r\n');

-- --------------------------------------------------------

--
-- 資料表結構 `threads`
--

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

--
-- 傾印資料表的資料 `threads`
--

INSERT INTO `threads` (`fid`, `topic_id`, `topic_name`, `topic_content`, `author`, `date`, `views`, `draft`, `hiddeni`, `rights`, `stickyness`, `stickyuntil`, `highlightcolor`, `showInIndex`, `seo`) VALUES
(21, 12, 'Search Test...', 'This is a thread for search test <br/>\r\nPlease be patient before we open this function to general users... :D', 1, '2017-07-08 13:48:10', 93, 0, 0, 0, 0, NULL, 'orange', 0, NULL),
(21, 13, '中文搜尋測試', '測試中文的搜尋情況', 1, '2017-07-08 15:40:03', 65, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 15, '有關論壇進行網頁提升工程事宜', '\n	\n	由於論壇目前正在進行一系列的系統升級工程，並正逐步升級轉移至php 7 平台。<div>因此，論壇的服務可能出現不穩定的情況。</div><div><br></div><div>在論壇升級的過程中，我們會短暫的將論壇屏蔽，使我們升級的過程變得更爲順利。</div><div>因此，請盡量利用系統的編輯工具，以便不時之需。</div><div><br></div><div>敬請各位留意</div><div>2017-8-12</div><div>Labo 管理員<br><br><br><br><br><br></div>', 1, '2017-08-10 01:43:30', 85, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 16, '2017/8/22 論壇更新維護通知', '\r\n	\r\n	\r\n	除了更換至PHP7 平台外，我們也會在近期對編輯帖子的版面進行一系列的更新。<div><br></div><div><b>論壇更新維護通知</b></div><div>時間： 2017/8/22 22:00 - 2017/8/23 00:00</div><div>地點：Labo 論壇</div><div>影響功能或描述：</div><div><div><br></div><div>屆時，用戶的發表，回覆，或編輯帖子的功能將受限。</div><div>如上次的安排一致，我們會使用升級畫面來屏蔽用戶發言的頁面。</div><div>用戶請耐心等候系統回復正常，謝謝</div></div>', 1, '2017-08-10 05:08:23', 159, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 18, '帖子大小及功能測試', '\r\n	\r\n	\r\n	\r\n	<font face=\"Times New Roman\" size=\"5\">這是新功能測試</font><div><ul><li>用戶可以不必理會</li><li>論壇現在恢復正常</li></ul></div><div><font face=\"Tahoma\">Testing of new functions,</font></div><div><font face=\"Tahoma\">please continue with your discussions</font></div><div><font face=\"Tahoma\">The forum will be resumed later</font></div>', 1, '2017-08-22 15:11:09', 351, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 19, '【已完成】有關論壇域名遷移的通告', '\r\n	\r\n	\r\n	\r\n	目前論壇所在的域名是以 forumv2 做網址的。由於原論壇原定於今月中停止運作，但目前發生技術問題，因此決定將本論壇網址將移至舊網站運作。我們計劃由今天開始移動網站，以下是通告：<div><b><br></b></div><div><b>論壇維護通知</b></div><div><b><br></b></div><div><b>將進行的工作：將論壇的網站移動至主網域 forum</b></div><div><b>時間：即日起至另行通知</b></div><div><b>可能構成的影響：</b></div><div><b>1. 兩個網站均指向相同網站</b></div><div><b>2. 舊有的帖子內容將消失</b></div><div><b>3. 發帖受到一定的影響</b></div><div><b><br></b></div><div>今次<b><u>無須</u></b>對論壇進行屏蔽，請繼續進行討論</div>', 1, '2017-09-01 11:07:39', 130, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(1, 20, 'Testing', 'This is a testing thread', 1, '2017-09-18 10:47:01', 75, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(1, 21, '[Forum Status] 論壇的最新情報', '經過一輪服務器的轉移後，論壇基本上回復正常的運作了。。。<br>大家可以如常討論 :)<br><br>', 1, '2018-03-22 06:08:13', 65, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 22, 'Labo 0.1 18.4.7T1 測試版發布', '<b>&lt;div style=\"color:green\" &gt;Labo 18.4.7T1 測試版 Release &lt;/div&gt;<br><br>更新日誌：</b><br><br>Conquer<br>- 做更好用的 Console, 設有標準指令指引<br>- 支持硬件中斷，可用滑鼠和鍵盤<br>- 基本指令： version -- 查看Conquer 組建編號,&nbsp; gmode -- 選用 VGA 模式<br>- 支持 Backspace 來更改輸入內容<br><br><br>', 1, '2018-04-17 02:40:23', 51, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(1, 23, '[Forum Status] 用户註冊問題', '\r\n	<div>我們已經留意到有部份用户向我們<b>反映 Register 出現問題</b> 。由於 Forum 在移植後出現好多問題，我們正在<u><b>逐一修復</b></u>。</div><div>對這問題而言，我們正在查找解決方法，請大家耐心等候</div><div><br></div><div>對無法註冊這個問題造成嘅不便，我深感歉意，並請大家多多體諒<br></div><div><br></div><div>【更新 7/9】對於無法長時間等待修復的用戶，請以論壇 email 聯絡本人， 我將以特快通道幫大家開 acc，THX～</div>', 1, '2018-05-27 13:11:53', 175, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 24, '[已完成][7/17]定期系統重新整理的通知', '<div>【更新】重新整理操作已經大致完成啦！感謝大家的支持</div><div><br></div>\r\n		 	在 2018/7/17 22:00 - 22:30，本站的電腦系統需要進行定期更新，並對部份的論壇版面進行更動。<div>屆時<b>論壇功能將會受限</b>，只有持管理員帳號的用戶<u><b>不受此影響</b></u>。</div><div><br></div><div>敬請期待我們論壇的全新版面！</div><div>如有任何問題，歡迎在下方 Comment</div><div><br></div><div><br></div><div>最cool的管理員</div><div>小風哥</div><div>2018/7/17</div>', 1, '2018-07-17 09:35:02', 87, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 25, '最近我做左管理員。重要通知~', '\r\n	\r\n	\r\n	<font face=\"Georgia\" size=\"5\">最近服務器不斷更新。不太穩定。若遇到任何問題，請與我們幾位管理員反映。</font>\r\n<br>\r\n<font face=\"Georgia\" size=\"5\"><b><br></b></font>\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Georgia\">最cool的管理員@小風哥</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Georgia\">happyJaiden^^</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Georgia\"><br></font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Georgia\"><br></font>\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n\r\n<br>\r\n<font face=\"Georgia\" size=\"6\"><b><br></b></font>\r\n<br>\r\n\r\n<br>\r\n\r\n<br>\r\n', 4, '2018-07-22 14:33:47', 256, 0, 0, 0, 0, NULL, NULL, 0, ''),
(1, 26, '最cool管理員: Jaiden ^^ 頭大', '@Jaiden ^^ 頭大, HAHA<div>我哋整到頭痛 :(</div><div><br></div><div>最cool管理員 小風哥</div>', 1, '2018-07-23 09:00:14', 99, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 27, '論壇主頁新增 Submenu Beta', '在我們嘅計劃中的新論壇主頁包括一個更人性化的副目錄。該目錄可以令各位用戶能夠快速的使用論壇各功能。稍後的版面更新陸續有嚟，由 HappyJaiden ^^ 同我，為大家開發<div><br></div><div>最cool的管理員</div><div>小風哥</div>', 1, '2018-07-23 13:02:49', 317, 0, 0, 0, 0, NULL, NULL, 1, NULL),
(1, 28, '今天開發進度良好!!!', '一日內多左幾頁功能頁~ 產品類別 、產品資訊、購物車等等 ^^', 4, '2018-07-25 14:41:09', 217, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(1, 29, '今天又完成多兩頁啦!!!(主頁,購物車)', '經過小組ge 努力 今日主頁同購物車已經可以使用啦。大家可以盡情去購物(假的)~~', 4, '2018-07-26 15:02:13', 278, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(1, 30, '大家好!我系ChampionBB', '咁多位鐘愛 Champion 既 BB 你地好!我代系表 Champion-日本 同大家系到拜個早年。<div>大家對我地品牌有咩意見可以系以下回覆，我地會有專人去睇，但唔會接受你地既意見。</div><div>多謝大家!</div><div><span style=\"white-space:pre\">	</span></div><div><span style=\"white-space:pre\">												</span><u>——Champion PR 部</u></div>', 13, '2018-07-27 08:37:56', 312, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 31, '論壇更新工程介紹', '\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	我們今天進一步對<b> Forum 的搜尋機制</b>及對前幾天加入的 <b>Menu 進行改善</b>，並對<b>帖子版面進行一系列的更改</b>。<div><br></div><div><b><u>大家係唔係好興奮呢？</u></b></div><div><br></div><div><ul><li>新增 Secondary Menu 中的動態搜尋，以代替昔日開發並日漸失修的搜尋。</li><li>為 Secondary Menu 新增 圖標， 使用戶更容易明白選項的意義及使操作更加輕鬆。</li><li>【7/27】帖子版面重新設計，修復 bug 問題</li><li>【7/28】全新商城帳戶設定版面，及對帖子編輯器進行更改</li><li>【7/28】對板塊頁面進行更新，能夠顯示所有板塊</li><li>【8/14】我哋重新設計了編輯帖子的界面</li></ul></div><div>同埋在此分享一下<b>簽到功能</b>的使用情況：</div><div>自簽到功能啟用以來，已經有 6 位用戶持續簽到多於 1 天。</div><div>各位加油，希望能夠喺將來簽到版啟用時見到大家</div><div><br></div><div><br></div><div>最cool嘅管理員</div><div>小風哥</div>', 1, '2018-07-27 12:02:41', 364, 0, 0, 0, 1, NULL, '', 0, NULL),
(1, 32, 'We are testing out the sticky post system', 'When the previous post is sticky, they will be staying on top', 1, '2018-07-28 03:19:56', 57, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(1, 33, 'Hi I am new', '123', 15, '2018-07-28 06:08:48', 105, 0, 1, 0, 0, NULL, NULL, 0, NULL),
(1, 34, '你睇我唔到~你睇我唔到~', '你睇我唔到~你睇我唔到~', 9, '2018-07-28 09:01:01', 64, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 35, '有關更新論壇主頁顯示算法的通知', '由於論壇需要適應日益增加的發帖量，避免主頁顯示的長度超過數據庫允許的限制，以及對官方的有關消息進行統一整合。<div><br></div><div><b>論壇首頁的算法將更改如下：</b><div><div>1. 對於一般用戶的發帖，我們改為在各板塊逐一呈現。</div></div><div>2.新增提升和下沉通知的功能。</div></div><div>3. 一般用戶的帖子不再顯示在首頁當中。</div><div><br></div><div>如有需要，建議前往<b>板塊頁面</b>中查看。</div><div><br></div><div>多謝各位的合作</div>', 1, '2018-07-28 15:33:16', 247, 0, 0, 0, 2, NULL, '', 1, NULL),
(1, 45, '[Sharing] ROM update-script 嘅寫法', '前幾天發表了基於 Kenzo 裝置的 Treble 底包，今天就來講述 update-script 的寫法。Update Script 對於一部沒有 Fastboot 或下載模式的裝置是十分重要的，因為它是能夠在這些手機上刷機的唯一方法。在 Treble 世代下，大家就更加要學會編寫刷機包，那麼就算該手機沒有第三方 ROM 開發者提供刷機包，您也能進行相應的開發並刷機。 \r\n<br><br>\r\n讓我們開始吧。 <br>\r\n<img style=\"text-align:center\" src=\"images/post/romflashingshare1.png\"/>\r\n<br>\r\n設您有上述幾個文件。若要刷到手機上，您需要在刷機 update-script 中加入：  \r\n<ul>\r\n<li>刷入 boot.img 鏡像的命令</li>\r\n<li>刷入 recovery.img 鏡像的命令</li>  \r\n<li>刷入 vendor 的命令</li>\r\n</ul>\r\n<br>\r\n<br>\r\n<b>\r\n等我介紹幾個刷機 update-script 函式：<br>\r\nui_print(\"some text\") : 在刷機畫面中打印文字 <br>\r\nblock_image_update(\"dev/block/bootdevice/by-name/somedir\",  package_extract_file(\"somefile.transfer.list\"), \"somefile.new.dat.br\", \"somefile.patch.dat\") : 這些是雙重壓縮的文件，這命令是讓手機解壓這些文件到相應的目錄並打補丁。 <br>\r\npackage_extract_file(\"somefile.img\", \"/dev/block/bootdevice/by-name/somedir\") : 將鏡像文件直接解壓到相應目錄 <br>\r\nshow_progress(progress_rate): 在 Recovery 顯示相應的刷機進度 set_progress(progress_rate): 設定相應的進度 <br><br>\r\n</b>\r\n現在附上 Kenzo Treble 底包刷機包文件截圖，大家應該也看到內部是怎麼完成刷機的了：<br>\r\n<img style=\"text-align:center\" src=\"images/post/romflashingshare2.png\"/>', 1, '2018-09-10 15:16:15', 356, 0, 0, 0, 2, NULL, 'orange', 1, NULL),
(1, 36, 'Labstry MC 發佈了 Labstry Forum 2', '\r\n	我們在今天的 Labstry MC 發佈了 Labstry Forum 2.\r\nLabstry Forum 2 是一個全新設計嘅 Forum。 更新內容：<br>\r\n<video src=\"images/PromoteVideo.mp4\" style=\"width:700px; height:400px\" controls=\"controls\"></video><ul>\r\n<li>全新的 Forum 首頁</li><li>查詢帖子速度提升 90%</li>\r\n<li>引進動態搜尋，使搜尋帖子更加輕鬆</li>\r\n<li>全新帖子頁面，重新編排帖文的顯示位置</li>\r\n<li>全新編輯帖子頁面</li>\r\n<li>重新設計帳戶登入和帳戶設定的版面及功能</li>\r\n<li>更新首頁帖子編排算法</li>\r\n<li>全新簽到頁面，讓用戶每天進入論壇時能夠進行簽到</li></ul>\r\n更多更新內容，請留意之後的論壇通知', 1, '2018-07-29 23:27:34', 318, 0, 0, 0, 1, NULL, 'orange', 0, NULL),
(1, 38, '有關 Labstry Shop 已在 8/14 關閉的事宜', '\r\n			 		 	<span style=\"font-variant-ligatures: no-common-ligatures;\">Labstry&nbsp;Shop 是一個在&nbsp;Labstry&nbsp;MC 中作為示範演示的平台，而&nbsp;Labstry&nbsp;Forum 2 則是真正發布的產品。</span><div><span style=\"font-variant-ligatures: no-common-ligatures;\">Labstry&nbsp;Shop App 是一款以 GNU General Public License v3 發布的軟件產品。</span></div><div><span style=\"font-variant-ligatures: no-common-ligatures;\"><br></span><div>近期網站更新，將會對&nbsp;Labstry&nbsp;各網站有以下安排：</div><div><br></div><div><ol><li>Labstry&nbsp;主頁現已<b><u>重新導向</u></b>至&nbsp;Labstry&nbsp;Forum， 直至另行通知</li><li>Labstry&nbsp;Forum 的Labstry Shop 商城按鈕已在<u><b> 8/14 起 </b></u>被停用</li><li>由於我們正在商討網站重用的可行性，Labstry&nbsp;Shop 網站已在<b><u>&nbsp;8/14 起&nbsp;</u></b>暫時停用，直至另行通知</li><li>Labstry&nbsp;Shop App 在打包後，將會上傳到 Forum 的帖子中。敬請期待</li><li><b><u>@小風哥 和 Happy @Jaiden ^^ 將會對論壇繼續進行更新及開發</u></b>。但礙於休假原因，進度可能稍為延遲，敬請見諒。</li></ol><div>小風哥在休假期間仍會為大家附上最新的動向。鼓掌時間到了&nbsp;</div></div><div><br></div><div>最 cool 的管理員</div><div>小風哥</div><div><br></div></div>', 1, '2018-08-13 14:16:18', 386, 0, 0, 0, 1, NULL, '#00c5ff', 0, NULL),
(88, 39, ' Labstry 主頁示範後的改動', '	【8/14】鑒於&nbsp;Labstry&nbsp;主頁在示範後不再適用，因此對 HTML 做了以下改動：<div><ol><li>在主頁 menu/header.php 中加入了重新導向到 forum index 的 script tag</li><li>在 forum header.php 註解了 Labstry Shop 的路徑</li></ol><div><br></div></div><div>操作結果： Labstry Shop 主頁暫時無法訪問，若訪問Shop 所屬網站將直接前往 Forum 主頁，只有 login.php, register.php 不受影響</div>', 1, '2018-08-14 14:24:12', 40, 0, 0, 255, 0, NULL, NULL, 0, NULL),
(1, 40, '管理員測試帖', '\r\n	\r\n	測試閱讀權限', 2, '2018-08-15 23:50:42', 49, 0, 0, 255, 0, NULL, NULL, 0, NULL),
(1, 41, '有關部份用戶的論壇及網站權限更改事宜', '\r\n	<div>- Labstry&nbsp;Forum 部份頭銜是臨時供演示使用的頭銜。目前該頭銜將會有以下安排及更動：</div><div><ol><li>品牌供應商頭銜將會被撤銷，在該頭銜下的用戶將<b><u>自動轉換成版主頭銜</u></b>。請聯絡任意管理員選定欲管理的板塊。</li><li>所有之前在品牌供應商名下的用戶將獲得使用論壇的一般權利</li><li>在名銜更換的過程中可能會出現頭銜顯示錯誤的問題，我們即將修復</li><li>所有其他在演示過程中獲得的名銜將會<b><u>繼續保留，以感謝各位在過去 1 個月以來的辛勞。</u></b></li><li>其他頭銜將保持不變</li></ol></div><div>- Labstry 網站的文件系統登入用戶的更改則如下：</div><div><ol><li>所有現有的用戶繼續保留</li><li>將會申請開放更多用戶，確保將來能夠繼續添加用戶</li></ol><div><b><u>再次感謝各位在過去 1 個月以來的辛勞。</u></b></div></div><div><br></div><div>最 cool 的管理員</div><div>小風哥</div>', 1, '2018-08-16 01:27:56', 66, 0, 0, 90, 0, NULL, NULL, 0, NULL),
(1, 42, '測試 post.php 正式發布版本', '測試進行中。', 1, '2018-08-16 11:03:45', 34, 0, 0, 255, 0, NULL, NULL, 0, NULL),
(21, 43, '手機版已恢復正常', '\r\n	在我們修復後，手機版已恢復正常。多謝各位長期的忍耐。', 1, '2018-08-18 09:37:55', 93, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(3, 44, 'kenzo Treble 底包刷機包', '<div>今天我們發表 Kenzo 及 Kate 的 Treble 底包刷機包。</div><div><br></div><div>kenzo 底包版本：18.8.26 <br></div><div><br></div><div>#include&lt;std/terms_and_conditions.h&gt;</div><div>#ifndef _TERMS_AND_CONDITIONS</div><div><br></div><div>若您在裝置上解鎖並刷入此包或表示您的保修會失效。<b>（懷疑該條款是否適用，因 Redmi Note 3 並非一年有限保養範圍的手機）。</b>在操作前，請檢閱手機製造商的解鎖條款</div><div><br></div><div>您將為您的選擇負責。刷機包提供方不會對刷機對裝置造成的任何後果進行負責，也不保證該刷機包是有效的。不論因為您刷機後引起任何戰爭，鬧鐘問題，時間問題或人為或非人為因素，提供者不會對刷機操作造成的任何損失負責。</div><div><b>繼續進行下述的操作</b>表示您<b>已經同意</b>上述的條款及細則並<u><b>不會</b></u>在刷機後<u><b>有任何異議</b></u><br></div><div><br></div><div>#endif</div><div><br></div><div><br></div><div><u><b>Thanks</b></u><br></div><div>AryToNex - Treble boot 及 vendor<br></div><div>Twrp - Treble based Twrp Recovery<br></div><div><br></div><div><br></div><div>在刷入本包後，手機將可以刷入任何 Android 8.0+ 版本的 <b>一般系統鏡像 (Generic System Image)</b><br></div><div>在刷本刷機包前，請確保你已經在手機上：</div><div><ol><li>裝有非官方 Recovery 的 twrp。</li><li>有可以選用的系統。（刷入該底包後<b> 無法繼續使用</b> 官方系統）<br></li><li>已經在官方網站進行解鎖&nbsp;<a href=\"http://www.miui.com/unlock\"> (請按這裡)</a></li></ol><div>請在手機上長按 Vol+ + Power 進入 twrp recovery<br></div><div><br></div><div><b>注意：</b></div><div><ol><li><b>在刷機後若您需要返回 MIUI 系統，請重刷官方綫刷包</b></li><li><b><b>在刷機前請確保您的手機電量充足，否則可能會無法完成刷機工作，引致手機磚化的問題。</b></b></li><li><b><b>若發生刷機中斷的情況，請使用官方</b></b><b>綫刷包暫時還原 boot</b></li></ol></div><div><b><br></b></div><div><b><a href=\"http://www.labstry.com/update/18.8.26/kernel-base-toolkit-kenzo-18.8.26-aff6a7.zip\">下載</a><br></b></div><div><b><br></b></div><div><b></b><br></div><div><br></div></div>', 1, '2018-08-28 06:20:29', 420, 0, 0, 0, 2, NULL, NULL, 1, NULL),
(1, 46, '測試帖，將刪除', '	<h1>This is a test thread only, haha</h1>\r\n<br>\r\nbut I think it is a good idea to add more items into the edit mode\r\n<br>\r\n', 1, '2018-09-11 05:28:14', 36, 1, 0, 0, 0, NULL, NULL, 0, NULL),
(88, 47, 'Y4S1 課程文件下載帖', '\r\n	在此提供 Year 4 Semester 1 的主要課程文件下載：&nbsp;\r\n\r\n<a style=\"background-color:orange; border-radius:4px\" href=\"http://www.labstry.com/JavaEE/j2ee.zip\">JavaEE</a>\r\n<a style=\"background-color:orange; border-radius:4px\" href=\"http://www.labstry.com/ProSystem/\">Professional System</a>\r\n<a style=\"background-color:orange; border-radius:4px\" href=\"http://www.labstry.com/EC/EC.zip\">E-Commerce</a>\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n<b>隨著課程和 Y4S1 的結束，本帖的下載功能已經失效。</b>\r\n<br>\r\n\r\n<br>\r\n<b>如需要下載，請和本人聯絡</b>\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n', 1, '2018-09-12 03:35:02', 33, 0, 0, 15, 0, NULL, NULL, 0, ''),
(1, 48, '緊急通告：論壇外觀可能不正常顯示', '目前正在替換論壇頁面的某些項目，因此論壇可能看上去很糟糕。\r\n\r\n更新：我們目前正在對手機版的帖子查看頁面進行修復。因此外觀將恢復正常', 1, '2018-09-12 12:09:49', 55, 0, 0, 0, 0, NULL, NULL, 0, NULL),
(21, 49, '緊急通吿：主頁內容顯示錯誤', '\r\n	\r\n	我們目前發現在對論壇頂部選項進行修改後，labstry 主頁的頁面錯誤顯示。對此，我們正在進行緊急修復。對因為本次人為疏忽而造成一系列的錯誤，我們在此表示歉意。目前通過緊急修復下，選項單將會陸續恢復正常', 1, '2018-09-13 02:53:07', 44, 0, 0, 0, 0, NULL, NULL, 0, ''),
(21, 50, '論壇已採用 HTTPS 加密技術', '\r\n	\r\n	由於有部份瀏覽器因為論壇沒有設定 HTTPS 的關係而將本網站標示成不安全，所以我們決定將本網站的連線升級成 HTTPS 連線。\r\n 目前，論壇已經啟用了全新的 HTTPS 連線技術。 該技術可以確保論壇用戶的內容，密碼等的安全。請各位繼續放心討論。\r\n\r\n 最cool 的管理員\r\n 小風哥', 1, '2018-09-16 14:20:10', 140, 0, 0, 0, 0, NULL, NULL, 0, 'https, encryption'),
(21, 51, '論壇的速度進一步提升', '各位論壇朋友，<br/>\r\n<br>\r\n又係我，小風哥來同大家介紹論壇最近的動向。<br/><br/>\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n第一項想介紹的是論壇速度優化。</br>\r\n<br>\r\n\r\n<br>\r\n我們今次優化由 php 處理以及 html, jquery 效果等各方面着手，減低整個頁面嘅加載時間。從此，頁面兩秒載入不是夢。<br/><br/>\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n第二項係我哋正在開發嘅 人類導向注冊頁面。\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n', 1, '2018-09-24 10:27:33', 63, 0, 0, 255, 0, NULL, NULL, 1, '由 8/24 日起，論壇的載入速度進一步提升'),
(21, 52, '[已完成] 今晚(10/15)將更新發帖介面 ', '\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	\r\n	各位論壇朋友，<br><br>\r\n今天 22:00 - 23:00 將更新發帖介面。屆時除了管理員及權限高於 90 的用戶外，其他用戶將不能訪問論壇。<br><br>在<b>更新之前，請先將閣下所有之前已開啟草稿模式的帖子設定成 Off 狀態並發布，否則將有機會影響內容的顯示</b>\r\n<br>\r\n更新後，我們將會為各位呈現全新的發帖功能。\r\n<br>\r\n<br>\r\n在隨後的時間，我們將會另開新帖，為大家介紹眾多最近新增的功能<br>\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n\r\n<b>目前介面已經完成更新。</b><br><br>\r\n最cool 的管理員<br>\r\n小風哥\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n\r\n<br>\r\n\r\n<br>\r\n', 1, '2018-10-15 11:08:23', 42, 0, 0, 0, 0, NULL, NULL, 0, '關於 10/15 論壇更新的說明。到目前為止，介面已經完全更新。'),
(88, 53, '論壇部份網頁已採用 pdo 連線模式', '\n	目前網站在逐步將 mysqli 連線轉換成 pdo 連線。注意：由於我們脫離了 mysqli，因此日後無法再依賴 mysqli_num_rows()來查詢結果行數。\n<br>\n<br>\n<br>\n\n<br>\n目前我們已經開發了替代函數來解決 pdo 缺乏行數的問題。\n<br>\n\n<br>\n請使用 $pdotoolkit 中的 rowCounter() 或者 rowCounterWithPara() 來獲取返回行數。\n<br>\n\n<br>\n<br>\n<br>\n\n<br>\n詳情請查看論壇內部代碼\n<br>\n', 1, '2018-10-24 07:34:43', 16, 0, 0, 90, 0, NULL, NULL, 0, ''),
(21, 54, 'Labstry 論壇已採用 HTTP/2 協議', '	\n<br>\n各位 Labstry Forum 用戶，\n<br>\n\n<br>\n讓用戶快樂一直係我們營運論壇的宗旨，且我們也願意為了提高用戶體驗而改用新技術。因此，我們一直致力研究如何由多方面加快論壇網頁的載入速度。\n<br>\n\n<br>\n論壇的經過今天更新後，論壇已經全部採用 HTTPS 連線技術及 HTTP 協議第二版 （即 HTTP/2 協議）進行連線。\n<br>\n\n<img src=\"https://css-tricks.com/wp-content/uploads/2017/02/image02.gif\" style=\"text-align:center; max-width: 100%\">\n\n<br>\n由於 HTTP/2 不再以純文字形式傳輸，而改用了二進制檔案格式進行。因此在一次 HTTP 連線中就能同時傳送多個檔案，從而減少訪客瀏覽網頁時的等候速度。\n<br>\n\n<br>\n在啟用 HTTP/2 協議的同時，我們一併將我們的網站統一改為使用 HTTPS 連線，這樣就能確保用戶有一個快速，且良好的用戶體驗。\n<br>\n\n<br>\n在此同時，希望各位討論愉快！\n<br>\n\n<br>\n<br>\n<br>\n\n<br>\n最 cool 的管理員\n<br>\n\n<br>\n小風哥<br>\n<br>\n', 1, '2018-11-08 12:30:28', 147, 0, 0, 0, 0, NULL, NULL, 1, '本文章介紹論壇全新啟用的 HTTP/2 技術。 HTTP/2 技術增強了論壇的用戶體驗'),
(21, 55, '通知：論壇用戶資料進行遷移', '\r\n	Labstry 即將開始開發全新產品。為了確保用戶資料能夠在不同的產品之間同步，我們現正將用戶資料遷移至用戶專用資料庫中。其中有機會影響用戶登入，用戶設定，發帖，帖子操作，資料查詢等多項功能。全新的用戶資料存取方式將增強論壇用戶的體驗。\r\n<br>\r\n<br>\r\n<br>\r\n該項工程詳細如下，請知悉。\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n時間： 2018/12/29 23:00 - 2018/12/29 23:30\r\n<br>\r\n\r\n<br>\r\n地點： Labstry 網站\r\n<br>\r\n\r\n<br>\r\n處理方法： 在階段1 評估結果顯示，無需屏蔽論壇<br>\r\n<br>\r\n<br>狀態：已經完成，但部份網頁：\r\n<br>\r\n- viewthread.php\r\n<br>\r\n\r\n<br>\r\n- account.php&nbsp;\r\n<br>\r\n\r\n<br>\r\n需進一步修復<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n最 cool 的管理員\r\n<br>\r\n\r\n<br>\r\n小風哥\r\n<br>\r\n\r\n<br>\r\n', 1, '2018-12-28 05:23:30', 56, 0, 0, 0, 2, NULL, 'red', 1, '有關論壇正在進行用戶資料遷移的通知'),
(1, 56, '我對 JavaEE 嘅心得', '<font face=\"Tahoma\">今日我想講吓我對 JakartaEE 嘅一些睇法。首先係 JakartaEE 雖然睇落好方便，但我覺得唔係太好用。唔似 php 咁， JakartaEE 比一個框架局限。JakartaEE 分成了好多層， jstl 同 jsp 語法混合，反而無 php 咁寛鬆，可以比你自由發揮。反觀 php, 就講我哋一直引以為傲的 safelogin。一開始我哋係亂咁唸到什麼就寫什麼，但 php 從來唔會同我哋講呢樣唔得果樣唔得，只係效率差啲咁解。後來，通過我哋自己慢慢摸索，最終能成功最佳化。</font>\r\n<br>\r\n<font face=\"Tahoma\"><br></font>\r\n<br>\r\n', 1, '2018-12-30 08:02:02', 7, 0, 0, 0, 0, NULL, NULL, 0, ''),
(1, 57, '談論論壇 2.5 版及論壇卡片新設計', '\r\n	今天我們來討論 Labstry 論壇 2.5。\r\n<br><br>\r\nLabstry 論壇 2.5 更新工程的進度目前在 OOP（物件導向） 及卡片設計中。在 Labstry Forum 2.0 中，我們引入了第一代卡片設計，其設計模式跟從 Google 在 Material Design 給出的設計模式。在此設計中的內容會更容易呈現，且適合多種不同的裝置瀏覽。\r\n<br><br>\r\n但為了迎合第一代卡片與本站最新的設計，我們進一步改進卡片的呈現方式。如果大家有留意最近更新的帖子顯示頁面，就能夠注意<b>以下幾點</b>：\r\n<br><ol><li>卡片使用網頁的大部分空間 - 我們使卡片與網頁的大小貼齊，盡量善用頁面的大小來顯示內容</li><li>卡片是圓角卡片，以便設計內容統一</li><li>弱化內容與設計的邊框，減少內容的邊界，增強可讀程度</li></ol>\r\n除了卡片外，我們還繼續對論壇的瀏覽速度進行最佳化。在以往的編程中，我們選擇以逐個頁面的方法進行編寫，導致很多實現方法出現重複，進一步減慢開發速度，也對網頁加載性能造成一定的影響。從本版開始，我們會盡量使用 OOP 形式來開發頁面，從而解決網頁功能的碎片問題。\r\n<br>\r\n\r\n<br><br>\r\n本論壇的開發宗旨是做一個好用的論壇，使用戶感到滿意。由 Labstry Forum 第一版開始，我們就十分著重用戶的使用體驗。現在也歡迎用戶繼續反映，以便繼續改善討論環境。\r\n<br><br>\r\n\r\n<br>\r\n小風哥\r\n<br>\r\n', 1, '2019-02-05 12:59:36', 0, 0, 0, 0, 0, NULL, NULL, 0, '進來一下，我們討論 Labstry 論壇 2.5及進度'),
(1, 58, '關於域名服務器轉移', '各位論壇朋友，\r\n<br>\r\n由於服務器轉移的原因，labstry.com 以指向全新的服務器。在服務器轉移後，論壇的響應速度會變得更快。\r\n<br>\r\n\r\n<br>\r\n所有的資料都不受影響。\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n多謝各位的支持\r\n<br>\r\n\r\n<br>\r\nlittlephone\r\n<br>\r\n', 1, '2019-03-31 13:36:37', 0, 0, 0, 0, 0, NULL, NULL, 0, '域名指向的服務器轉移的通告'),
(1, 60, '小風哥網誌：頁面最佳化 1', '<font face=\"Noto Sans TC\">今日有人問我，為什麼會對著我的電腦鄒眉頭。看到這樣的分數，想不鄒眉頭也難了。</font>\r\n<br>\r\n<font face=\"Noto Sans TC\"><img src=\'images/post/pageinsightpoor.png\' alt=\'poor page insight result\'></font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\"><br></font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">沒有錯，這是我編寫的其中一個網站程式之一，一個既失敗，又可稱的上成功的作品。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">從分析中來看，其實一點也不驚訝。光是加載網頁的時候就使用了大量的時間載入插件。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">在項目要求下，帶圖片的搜尋結果必須要一次性的在網頁上完成加載，不加入類似於 Google 搜尋的分頁顯示方法。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\"><br></font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">雖然此項目基本上已完成，但是我卻得出以下反思。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\"><br></font>\r\n<br>\r\n\r\n<br>\r\n<b><font face=\"Noto Sans TC\">1. 插件及需要查詢數據庫等內容應該盡量在異步加載</font></b>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">異步加載可以減少網頁的加載速度。在項目完成以後，我想到要繼續提升網站的速度，因此開始了論壇第三版的開發。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">其實在 Labstry 首頁當中就是採用了異步加載的方式完成。如果大家留意 Labstry Forum 3 的實現方法，就會發現帖子會在整個網頁完成載入後再加載，而不是直接同時加載。此外，在第三版當中的 css 文件大多都是後期載入的。至於前期而言，僅加載必須的 css 文件。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\"><br></font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">以下是引進了異步加載的 Labstry 論壇，其載入速度如下：</font>\r\n<br>\r\n\r\n<br>\r\n<span style=\"font-family: &quot;Noto Sans TC&quot;;\"><img src=\'images/post/pageinsightbetter.png\' alt=\'better page insight result\'></span>\r\n<br>\r\n\r\n<br>\r\n<span style=\"font-family: &quot;Noto Sans TC&quot;;\"><br></span>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\">在實現異步加載後，網頁儘管在網路環境較差的情況下，還能維持一定的響應速度。</font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\"><br></font>\r\n<br>\r\n\r\n<br>\r\n<font face=\"Noto Sans TC\"><b>2. 網頁圖片應儘量使用大小較小的文件</b></font>\r\n<br>\r\n\r\n<br>\r\n從 Page Insight 網頁看，項目網頁就是採用了很多未經壓縮的圖片。這些圖片由於需要瀏覽器進行下載，因此大大的提升了瀏覽器的下載時間，影響網頁加載。其實在開發的過程中我們曾經發現過此問題，也就此問題提出過許多解決方案，例如：圖片懶加載 (Lazy load) 及分頁等。\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n<b>3. 網頁必要在需要無障礙環境的用戶角度中考量</b>\r\n<br>\r\n\r\n<br>\r\n在網頁訪問的過程中，如果加入了部分插件時，會對無障礙訪問造成影響。因此在發布網頁前，需確保網頁的無障礙功能正常。決不能為了美觀的原因而喪失可用性。\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n', 1, '2019-10-11 15:27:13', 0, 0, 0, 0, 0, NULL, NULL, 0, '關於最近項目進行最佳化及反思'),
(21, 61, '有關論壇進行維護通告', '各位論壇用戶，\r\n<br>\r\nLabstry 論壇將於今天晚上 8 時 - 晚上 11 時進行維護，屆時論壇可能無法登入及使用。在維護工作開始前，請先確定您的數據已經備份，否則可能會丟失。\r\n<br>\r\n\r\n<br>\r\n多謝各位的諒解。\r\n<br>\r\n\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<br>\r\n小風哥\r\n<br>\r\n', 1, '2020-01-02 02:02:50', 0, 0, 0, 0, 0, NULL, NULL, 0, '');

-- --------------------------------------------------------

--
-- 資料表結構 `timezone`
--

CREATE TABLE `timezone` (
  `timezid` int(11) NOT NULL,
  `tz` varchar(255) NOT NULL,
  `gmt` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `timezone`
--

INSERT INTO `timezone` (`timezid`, `tz`, `gmt`) VALUES
(1, '-12:00', '(GMT -12:00) Eniwetok, Kwajalein'),
(2, '-11:00', '(GMT -11:00) 中途島, 薩摩亞'),
(3, '-10:00', '(GMT -10:00) 夏威夷'),
(4, '-09:00', '(GMT -9:00) 阿拉斯加'),
(5, '-08:00', '(GMT -8:00) 洛杉磯, 西雅圖'),
(6, '-07:00', '(GMT -7:00) 丹佛'),
(7, '-06:00', '(GMT -6:00) 芝加哥, 墨西哥城'),
(8, '-05:00', '(GMT -5:00)  紐約, 波哥大，利馬'),
(9, '-04:00', '(GMT -4:00) 加拉加斯，拉巴斯'),
(10, '-03:30', '(GMT -3:30) 紐芬蘭'),
(11, '-03:00', '(GMT -3:00) 巴西, 布宜諾斯艾利斯, 喬治城'),
(12, '-02:00', '(GMT -2:00) Mid-Atlantic'),
(13, '-01:00', '(GMT -1:00) 亞速爾群島，佛得角群島'),
(14, '+00:00', '(GMT)  倫敦, 里斯本, 卡薩布蘭卡'),
(15, '+01:00', '(GMT +1:00) 布魯塞爾，哥本哈根，馬德里，巴黎'),
(16, '+02:00', '(GMT +2:00) 加里寧格勒,  南非'),
(17, '+03:00', '(GMT +3:00) 巴格達, 莫斯科, 聖彼得堡'),
(18, '+03:30', '(GMT +3:30) 德黑蘭'),
(19, '+04:00', '(GMT +4:00) 阿布扎比，馬斯喀特，巴庫，第比利斯'),
(20, '+04:30', '(GMT +4:30) 喀布爾'),
(21, '+05:00', '(GMT +5:00) 葉卡捷琳堡，伊斯蘭堡，卡拉奇，塔什幹'),
(22, '+05:30', '(GMT +5:30) 孟買，加爾各答，馬德拉斯, 新德里'),
(23, '+06:00', '(GMT +6:00) 阿拉木圖，達卡，科倫坡'),
(24, '+07:00', '(GMT +7:00) 曼谷, 河內,  雅加達'),
(25, '+08:00', '(GMT +8:00) 北京, 伯斯, 新加坡, 香港, 台北, 烏魯木齊'),
(27, '+09:00', '(GMT +9:00) 東京, 首爾, 大阪, 札幌, 雅庫次克'),
(28, '+09:30', '(GMT +9:30) 阿得萊德, 達爾文'),
(29, '+10:00', '(GMT +10:00) 悉尼, 墨爾本'),
(30, '+11:00', '(GMT +11:00) 馬加丹，所羅門群島，新喀裡多尼亞'),
(31, '+12:00', '(GMT +12:00) 奧克蘭, 威靈頓, 斐濟, Kamchatka');

-- --------------------------------------------------------

--
-- 資料表結構 `usertz`
--

CREATE TABLE `usertz` (
  `id` bigint(20) NOT NULL,
  `timezid` int(11) NOT NULL DEFAULT '25'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `usertz`
--

INSERT INTO `usertz` (`id`, `timezid`) VALUES
(1, 25),
(2, 25),
(3, 25),
(19, 1),
(4, 5),
(15, 1),
(9, 1),
(13, 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `block_list`
--
ALTER TABLE `block_list`
  ADD UNIQUE KEY `userid` (`userid`),
  ADD KEY `uid` (`userid`);

--
-- 資料表索引 `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`checkorder`);

--
-- 資料表索引 `continuouscheckin`
--
ALTER TABLE `continuouscheckin`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `forumlist`
--
ALTER TABLE `forumlist`
  ADD PRIMARY KEY (`gid`),
  ADD UNIQUE KEY `gid` (`gid`);

--
-- 資料表索引 `laf_settings`
--
ALTER TABLE `laf_settings`
  ADD PRIMARY KEY (`laf_api`);

--
-- 資料表索引 `maintainance`
--
ALTER TABLE `maintainance`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`rnumber`),
  ADD UNIQUE KEY `rnumber` (`rnumber`);

--
-- 資料表索引 `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`topic_id`,`reply_id`);

--
-- 資料表索引 `reserved_usernames`
--
ALTER TABLE `reserved_usernames`
  ADD PRIMARY KEY (`reserved_username`),
  ADD KEY `idlink` (`reserved_by_id`);

--
-- 資料表索引 `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- 資料表索引 `specialteam`
--
ALTER TABLE `specialteam`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `subforum`
--
ALTER TABLE `subforum`
  ADD PRIMARY KEY (`fid`);

--
-- 資料表索引 `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`topic_id`);

--
-- 資料表索引 `timezone`
--
ALTER TABLE `timezone`
  ADD PRIMARY KEY (`timezid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `checkin`
--
ALTER TABLE `checkin`
  MODIFY `checkorder` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `forumlist`
--
ALTER TABLE `forumlist`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `maintainance`
--
ALTER TABLE `maintainance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `rank`
--
ALTER TABLE `rank`
  MODIFY `rnumber` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `subforum`
--
ALTER TABLE `subforum`
  MODIFY `fid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `threads`
--
ALTER TABLE `threads`
  MODIFY `topic_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `timezone`
--
ALTER TABLE `timezone`
  MODIFY `timezid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `block_list`
--
ALTER TABLE `block_list`
  ADD CONSTRAINT `block_list_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `reserved_usernames`
--
ALTER TABLE `reserved_usernames`
  ADD CONSTRAINT `idlink` FOREIGN KEY (`reserved_by_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

