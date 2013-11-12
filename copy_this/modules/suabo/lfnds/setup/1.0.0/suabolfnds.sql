CREATE TABLE IF NOT EXISTS `suabolfnds` (
  `oxid` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `oxorderid` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `lfndsdonation` longtext COLLATE latin1_general_ci NOT NULL,
  `lfndsstate` varchar(16) CHARACTER SET utf8 NOT NULL,
  `lfndstime` datetime NOT NULL,
  UNIQUE KEY `oxid` (`oxid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;