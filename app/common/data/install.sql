-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ec_config`;
CREATE TABLE `ec_config` (
                             `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置id',
                             `group` varchar(128) NOT NULL COMMENT '配置组',
                             `name` varchar(128) NOT NULL COMMENT '配置名',
                             `key` varchar(128) NOT NULL COMMENT '配置键',
                             `value` varchar(256) NOT NULL COMMENT '配置值',
                             `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
                             `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
                             PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

INSERT INTO `ec_config` (`config_id`, `group`, `name`, `key`, `value`, `status`, `create_time`) VALUES
(1,	'wechat_app',	'小程序app_id',	'program_app_id',	'wx4e248c819fec6cba',	1,	1609731417),
(2,	'wechat_app',	'小程序app_id',	'program_app_secret',	'3d93085606ce459f8f77a39d5756cdd2',	1,	1609731417),
(3,	'wechat',	'微信公众号appid',	'wechat_app_id',	'wx973b670fc46995aa',	1,	1609731417),
(4,	'wechat',	'微信公众号appid',	'wechat_app_secret',	'd8890ed670194f7f548e57eea3ba45ee',	1,	1609731417),
(5,	'system',	'后台登录开启验证码',	'has_verify_code',	'1',	1,	1610090089);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `ec_menu`;
CREATE TABLE `ec_menu` (
                           `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
                           `pid` int(10) unsigned NOT NULL COMMENT '上级菜单id',
                           `title` varchar(128) NOT NULL COMMENT '菜单标题',
                           `url` varchar(128) NOT NULL COMMENT '菜单地址',
                           `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单icon',
                           `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '菜单状态，0:禁用,1:开启',
                           `is_hidden` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏，0:否，1:是',
                           `sort` int(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序，大到小',
                           `is_link` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '外部链接, 0:否 ，1:是',
                           `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
                           PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

INSERT INTO `ec_menu` (`menu_id`, `pid`, `title`, `url`, `icon`, `status`, `is_hidden`, `sort`, `is_link`, `create_time`) VALUES
(1,	0,	'主页',	'',	'layui-icon-home',	1,	0,	100,	0,	1610353548),
(2,	1,	'控制台',	'/admin/index/console',	'layui-icon-home',	1,	0,	100,	0,	1610353548),
(3,	0,	'系统',	'',	'layui-icon-set',	1,	0,	99,	0,	1610433860),
(4,	3,	'系统设置',	'',	'',	1,	0,	100,	0,	1610434328),
(5,	4,	'网站配置',	'/admin/config/site',	'',	1,	0,	100,	0,	1610434328),
(6,	3,	'微信配置',	'',	'',	1,	0,	100,	0,	1610434328),
(7,	6,	'公众号配置',	'/admin/config/wechat',	'',	1,	0,	100,	0,	1610434328),
(8,	6,	'小程序配置',	'/admin/config/wechat_app',	'',	1,	0,	99,	0,	1610434328),
(9,	6,	'支付配置',	'/admin/config/wechat_pay',	'',	1,	0,	98,	0,	1610434328),
(10,	4,	'邮件配置',	'/admin/config/email',	'',	1,	0,	99,	0,	1610434328),
(11,	4,	'短信配置',	'/admin/config/sms',	'',	1,	0,	98,	0,	1610434328),
(12,	4,	'上传配置',	'/admin/config/upload',	'',	1,	0,	97,	0,	1610434328);

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
(1,	'超级管理员',	'*',	1,	1610356558);

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
                           `last_login_time` varchar(128) NOT NULL COMMENT '上次登陆时间',
                           `create_time` int(10) unsigned NOT NULL COMMENT '注册时间',
                           PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `ec_user` (`user_id`, `role_id`, `wechat_open_id`, `unionid`, `nickname`, `avatar`, `username`, `password`, `mobile`, `status`, `last_login_time`, `create_time`) VALUES
(11,	0,	'oOWtZtxfsaRd4Zc79RBcLq6jiE4w',	'',	'echo',	'https://thirdwx.qlogo.cn/mmopen/vi_32/xBNWKS6vvH1FZvoj5O2h8yhftkD6ujnETIXeicXRX43WHdibj8t717icOR7fo4X4LInSGSI3rNczRyQAWmFic5cWQA/132',	'sms1609817074',	'6bcd3b89877d5f718ac90a0fe4eb7bc8',	'',	1,	'1609821530',	1609817074),
(12,	1,	'',	'',	'echo',	'https://thirdwx.qlogo.cn/mmopen/vi_32/xBNWKS6vvH1FZvoj5O2h8yhftkD6ujnETIXeicXRX43WHdibj8t717icOR7fo4X4LInSGSI3rNczRyQAWmFic5cWQA/132',	'admin',	'96e79218965eb72c92a549dd5a330112',	'',	1,	'1590830940',	1590830940);

-- 2021-01-13 03:55:35