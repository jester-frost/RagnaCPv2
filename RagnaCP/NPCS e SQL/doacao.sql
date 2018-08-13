CREATE TABLE IF NOT EXISTS `doacao` (
  `account_id` int(11) unsigned NOT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` int(11) NOT NULL,
  `Rops` int(11) NOT NULL,
  `estado` int(11) unsigned NOT NULL DEFAULT '0',
  `transaction_id` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;