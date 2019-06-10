
/*for create table `jd_comment`*/
CREATE TABLE `jd_comment` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `g_id` varchar(20) DEFAULT NULL,
  `g_nickname` varchar(25) DEFAULT NULL,
  `g_level` varchar(30) DEFAULT NULL,
  `g_score` int(11) DEFAULT NULL,
  `g_client` varchar(50) DEFAULT NULL,
  `g_content` varchar(200) DEFAULT NULL,
  `g_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`num`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4


/* for create table `jd_gooditems`*/
CREATE TABLE `jd_gooditems` (
  `g_index` int(11) NOT NULL AUTO_INCREMENT,
  `g_id` varchar(15) DEFAULT NULL,
  `g_name` varchar(100) DEFAULT NULL,
  `g_price` int(11) DEFAULT NULL,
  `g_shop` varchar(50) DEFAULT NULL,
  `g_gettime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`g_index`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4