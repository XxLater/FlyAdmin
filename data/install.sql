-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `flyadmin` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `flyadmin`;

DROP TABLE IF EXISTS `ec_attachment`;
CREATE TABLE `ec_attachment` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `md5` varchar(256) NOT NULL COMMENT '文件md5名',
  `name` char(64) NOT NULL COMMENT '文件名',
  `type` tinyint(1) unsigned NOT NULL COMMENT '文件上传类型 1本地 2七牛云 3OSS 4COS ',
  `path` varchar(256) NOT NULL COMMENT '文件路径',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0:禁用，1:可用',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='附件表';


DROP TABLE IF EXISTS `ec_config`;
CREATE TABLE `ec_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `group` varchar(128) NOT NULL COMMENT '配置组',
  `name` varchar(128) NOT NULL COMMENT '配置名',
  `key` varchar(128) NOT NULL COMMENT '配置键',
  `value` varchar(256) NOT NULL COMMENT '配置值',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `test_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

INSERT INTO `ec_config` (`config_id`, `group`, `name`, `key`, `value`, `status`, `create_time`, `test_time`) VALUES
(1,	'wechat_app',	'小程序app_id',	'program_app_id',	'wx4e248c819fec6cba',	1,	1609731417,	'2021-06-19 23:55:20'),
(2,	'wechat_app',	'小程序app_secret',	'program_app_secret',	'3d93085606ce459f8f77a39d5756cdd2',	1,	1609731417,	'2021-06-20 17:22:50'),
(3,	'wechat',	'微信公众号appid',	'wechat_app_id',	'wx973b670fc46995aa',	1,	1609731417,	'2021-06-19 21:52:33'),
(4,	'wechat',	'微信公众号appid',	'wechat_app_secret',	'd8890ed670194f7f548e57eea3ba45ee',	1,	1609731417,	'2021-06-19 21:52:33'),
(5,	'system',	'后台登录开启验证码',	'has_verify_code',	'1',	1,	1610090089,	'2021-07-14 11:13:59'),
(6,	'system',	'网站标题',	'site_title',	'flyAdmin',	1,	1610090089,	'2021-06-19 21:52:33'),
(8,	'system',	'网站logo',	'site_logo',	'/static/admin/images/logo.png',	1,	1610090089,	'2021-06-19 21:52:33'),
(9,	'system',	'文件后缀',	'file_ext',	'jpg,gif,png,jpeg,xls,xlsx,doc,pdf,mp4,txt,zip,ico',	1,	1611559118,	'2021-06-19 21:52:33'),
(10,	'system',	'文件大小(单位字节)',	'file_size',	'20',	1,	1611559118,	'2021-06-19 21:52:33'),
(11,	'system',	'网站关键词',	'site_keyword',	'',	1,	1610090089,	'2021-07-16 07:09:31'),
(12,	'system',	'网站描述',	'site_description',	'',	1,	1610090089,	'2021-07-16 07:09:31');

DROP TABLE IF EXISTS `ec_log`;
CREATE TABLE `ec_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` char(20) NOT NULL COMMENT '请求模块',
  `method` char(20) NOT NULL DEFAULT 'GET' COMMENT '请求方式',
  `href` char(50) NOT NULL COMMENT '请求地址',
  `client` char(50) NOT NULL DEFAULT '' COMMENT '浏览器',
  `ip` char(50) NOT NULL COMMENT 'ip地址',
  `user_id` int(10) unsigned NOT NULL COMMENT '操作人id',
  `param` json NOT NULL COMMENT '请求数据',
  `response` json NOT NULL COMMENT '响应数据',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统日志表';


DROP TABLE IF EXISTS `ec_menu`;
CREATE TABLE `ec_menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `title` varchar(128) NOT NULL COMMENT '菜单标题',
  `href` varchar(128) NOT NULL DEFAULT '#' COMMENT '菜单地址',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单icon',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '菜单状态，0:禁用,1:开启',
  `is_hidden` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏，0:否，1:是',
  `sort` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序，升序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

INSERT INTO `ec_menu` (`menu_id`, `pid`, `title`, `href`, `icon`, `status`, `is_hidden`, `sort`, `create_time`) VALUES
(1,	0,	'仪表盘',	'/admin/index/index',	'layui-icon-console',	1,	0,	1,	1610353548),
(2,	1,	'控制台',	'/admin/index/console',	'',	1,	0,	1,	1610353548),
(3,	0,	'系统',	'',	'layui-icon-set',	1,	0,	2,	1610433860),
(4,	3,	'系统配置',	'',	'',	1,	0,	1,	1610434328),
(5,	4,	'网站配置',	'/admin/config/site',	'',	1,	0,	1,	1610434328),
(6,	3,	'微信配置',	'',	'',	1,	0,	2,	1610434328),
(7,	6,	'公众号配置',	'/admin/config/wechat',	'',	1,	0,	1,	1610434328),
(8,	6,	'小程序配置',	'/admin/config/wechatApp',	'',	1,	0,	2,	1610434328),
(14,	1,	'数据分析',	'/admin/index/analysis',	'',	1,	0,	2,	1610353548),
(19,	0,	'用户',	'',	'layui-icon-user',	1,	0,	3,	1610353548),
(20,	19,	'用户管理',	'/admin/user/list',	'',	1,	0,	1,	1610353548),
(21,	19,	'角色管理',	'/admin/role/list',	'',	1,	0,	2,	1610353548),
(22,	0,	'菜单',	'',	'layui-icon-align-left',	1,	0,	4,	1610434328),
(25,	22,	'菜单管理',	'/admin/menu/list',	'',	1,	0,	1,	1610353548),
(27,	3,	'运营数据',	'',	'',	1,	0,	3,	1625147653),
(28,	27,	'后台日志',	'/admin/log/list',	'',	1,	0,	1,	1625147697),
(29,	20,	'新增',	'/admin/user/create',	'',	1,	1,	1,	1626296573),
(30,	20,	'编辑',	'/admin/user/update',	'',	1,	1,	2,	1626296612),
(31,	20,	'删除',	'/admin/user/delete',	'',	1,	1,	3,	1626296648),
(32,	21,	'新增',	'/admin/role/create',	'',	1,	1,	1,	1626296673),
(33,	21,	'编辑',	'/admin/role/update',	'',	1,	1,	2,	1626296696),
(34,	21,	'删除',	'/admin/role/delete',	'',	1,	1,	3,	1626296722),
(35,	20,	'快速编辑',	'/admin/user/quickEdit',	'',	1,	1,	4,	1626296853),
(36,	21,	'快速编辑',	'/admin/role/quickEdit',	'',	1,	1,	4,	1626296876),
(37,	25,	'新增',	'/admin/menu/create',	'',	1,	1,	1,	1626296905),
(38,	25,	'编辑',	'/admin/menu/update',	'',	1,	1,	2,	1626296930),
(39,	25,	'删除',	'/admin/menu/delete',	'',	1,	1,	3,	1626296961),
(40,	25,	'快速编辑',	'/admin/menu/quickEdit',	'',	1,	1,	4,	1626296985);

DROP TABLE IF EXISTS `ec_role`;
CREATE TABLE `ec_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `title` varchar(128) NOT NULL COMMENT '角色标题',
  `menu` varchar(500) NOT NULL COMMENT '权限菜单',
  `status` tinyint(1) unsigned NOT NULL COMMENT '角色状态,0:禁用,1:启用',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

INSERT INTO `ec_role` (`role_id`, `title`, `menu`, `status`, `create_time`) VALUES
(1,	'超级管理员',	'*',	1,	1626420392);

DROP TABLE IF EXISTS `ec_user`;
CREATE TABLE `ec_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `wechat_open_id` varchar(64) NOT NULL DEFAULT '' COMMENT '微信开放平台id',
  `unionid` varchar(128) NOT NULL DEFAULT '' COMMENT '微信开放平台唯一id',
  `nickname` varchar(128) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(256) NOT NULL DEFAULT '' COMMENT '头像',
  `username` varchar(128) NOT NULL COMMENT '用户名',
  `password` varchar(128) NOT NULL COMMENT '用户密码',
  `mobile` varchar(128) NOT NULL DEFAULT '' COMMENT '用户手机',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态,0:禁用,1:正常',
  `last_login_time` varchar(128) DEFAULT NULL COMMENT '上次登陆时间',
  `create_time` int(10) unsigned NOT NULL COMMENT '注册时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `ec_user` (`user_id`, `role_id`, `wechat_open_id`, `unionid`, `nickname`, `avatar`, `username`, `password`, `mobile`, `status`, `last_login_time`, `create_time`, `delete_time`) VALUES
(1,	1,	'',	'',	'echo',	'/static/admin/images/avatar.jpg',	'admin',	'21232f297a57a5a743894a0e4a801fc3',	'',	1,	'0',	1626420474,	0);

-- 2021-07-16 07:31:55