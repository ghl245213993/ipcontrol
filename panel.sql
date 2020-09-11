-- Adminer 4.7.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `config` (`id`, `key`, `value`) VALUES
(1,	'license_key',	NULL),
(2,	'local_key',	NULL);

DROP TABLE IF EXISTS `gost_server_list`;
CREATE TABLE `gost_server_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `server_cname` varchar(255) DEFAULT NULL COMMENT 'DDNS',
  `server_ip` varchar(255) NOT NULL COMMENT '公网IP，如果有DDNS定时任务会更新此处IP',
  `server_key` varchar(255) NOT NULL COMMENT 'KEY',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `action` tinyint(4) NOT NULL,
  `text` tinytext,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `server_list`;
CREATE TABLE `server_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '服务器ID',
  `name` varchar(255) NOT NULL COMMENT '服务器名称',
  `server_cname` varchar(255) NOT NULL COMMENT '服务器cname',
  `server_ip` varchar(255) NOT NULL COMMENT '如果启用了动态IP，定时任务要将解析IP同步到此',
  `server_in_ip` varchar(255) NOT NULL COMMENT '如果启用了动态IP，定时任务要将解析IP同步到此',
  `server_key` varchar(255) NOT NULL,
  `eth` varchar(255) NOT NULL,
  `dynamic_enable` tinyint(255) NOT NULL DEFAULT '0' COMMENT '启用动态IP：0：否；1：是',
  `speed` int(11) NOT NULL DEFAULT '0' COMMENT '网速，单位Mbps，大于0',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `server_rules`;
CREATE TABLE `server_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `server_id` int(11) NOT NULL COMMENT '服务器ID',
  `user_id` int(11) NOT NULL,
  `gost_server_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL COMMENT '转发类型',
  `local_port` varchar(255) NOT NULL COMMENT '服务器本地监听端口',
  `local_ip` varchar(255) DEFAULT NULL COMMENT '如果这个是空，就使用serverlist中的内网IP',
  `remote_cname` varchar(255) DEFAULT NULL COMMENT '远程服务器ddns-如果是隧道，无视这个',
  `remote_ip` varchar(255) DEFAULT NULL COMMENT '远程IP-如果是隧道，就不用这个',
  `remote_port` varchar(255) DEFAULT NULL COMMENT '远程监听端口(如果是隧道，就不用这个)',
  `listen_port` int(11) DEFAULT NULL COMMENT '落地鸡监听端口',
  `to_port` varchar(255) DEFAULT NULL COMMENT '落地鸡转发到端口',
  `limit_speed` int(11) NOT NULL DEFAULT '0' COMMENT '限速(0为不限速，不得大于设定的速度)',
  `status` int(255) NOT NULL DEFAULT '0' COMMENT '状态：0：等待生效，1：已生效，2：已挂起',
  `enable` int(255) NOT NULL DEFAULT '1',
  `traffic_all` bigint(20) NOT NULL DEFAULT '0',
  `traffic_used` bigint(20) NOT NULL DEFAULT '0',
  `reset_day` tinyint(4) NOT NULL DEFAULT '0',
  `last_reset_day` tinyint(4) NOT NULL DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `server_id` (`server_id`) USING BTREE,
  KEY `gost_server_id` (`gost_server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `traffic_log`;
CREATE TABLE `traffic_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) NOT NULL,
  `traffic` int(11) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名(唯一)',
  `password` varchar(255) NOT NULL COMMENT '密码（MD5加密）',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不是管理员，1：是管理员',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `user` (`id`, `username`, `password`, `admin`) VALUES
(17,	'admin',	'e10adc3949ba59abbe56e057f20f883e',	1);

DROP TABLE IF EXISTS `user_gostserver`;
CREATE TABLE `user_gostserver` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `server_id` int(11) NOT NULL COMMENT '服务器id',
  PRIMARY KEY (`user_id`,`server_id`) USING BTREE,
  KEY `server_id` (`server_id`),
  CONSTRAINT `user_gostserver_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `gost_server_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_gostserver_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `user_server`;
CREATE TABLE `user_server` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `server_id` int(11) NOT NULL COMMENT '服务器id',
  PRIMARY KEY (`user_id`,`server_id`) USING BTREE,
  KEY `server_id` (`server_id`),
  CONSTRAINT `user_server_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_server_ibfk_3` FOREIGN KEY (`server_id`) REFERENCES `server_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


-- 2020-05-06 01:51:38

ALTER TABLE `config`
CHANGE `key` `ip_key` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `id`,
CHANGE `value` `ip_value` text COLLATE 'utf8_general_ci' NULL AFTER `ip_key`;

ALTER TABLE `server_list`
ADD `check_mode` tinyint(255) NOT NULL DEFAULT '0' COMMENT '0:严格，1:宽松' AFTER `dynamic_enable`;
