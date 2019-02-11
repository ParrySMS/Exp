CREATE TABLE `exp_sort` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `funcname` varchar(255) DEFAULT NULL,
  `len` int(11) DEFAULT NULL,
  `sample_num` varchar(255) DEFAULT NULL,
  `exc_time` double DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


