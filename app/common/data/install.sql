-- Adminer 4.7.6 MySQL dump

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
(1,	'wechat_program',	'小程序app_id',	'program_app_id',	'wx4e248c819fec6cba',	1,	1609731417),
(2,	'wechat_program',	'小程序app_id',	'program_app_secret',	'3d93085606ce459f8f77a39d5756cdd2',	1,	1609731417),
(3,	'wechat',	'微信公众号appid',	'wechat_app_id',	'wx973b670fc46995aa',	1,	1609731417),
(4,	'wechat',	'微信公众号appid',	'wechat_app_secret',	'd8890ed670194f7f548e57eea3ba45ee',	1,	1609731417),
(5,	'system',	'后台登录开启验证码',	'has_verify_code',	'1',	1,	1610090089);

DROP TABLE IF EXISTS `ec_user`;
CREATE TABLE `ec_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
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

INSERT INTO `ec_user` (`user_id`, `wechat_open_id`, `unionid`, `nickname`, `avatar`, `username`, `password`, `mobile`, `status`, `last_login_time`, `create_time`) VALUES
(11,	'oOWtZtxfsaRd4Zc79RBcLq6jiE4w',	'',	'echo',	'https://thirdwx.qlogo.cn/mmopen/vi_32/xBNWKS6vvH1FZvoj5O2h8yhftkD6ujnETIXeicXRX43WHdibj8t717icOR7fo4X4LInSGSI3rNczRyQAWmFic5cWQA/132',	'sms1609817074',	'6bcd3b89877d5f718ac90a0fe4eb7bc8',	'',	1,	'1609821530',	1609817074),
(12,	'',	'',	'echo',	'https://thirdwx.qlogo.cn/mmopen/vi_32/xBNWKS6vvH1FZvoj5O2h8yhftkD6ujnETIXeicXRX43WHdibj8t717icOR7fo4X4LInSGSI3rNczRyQAWmFic5cWQA/132',	'admin',	'96e79218965eb72c92a549dd5a330112',	'',	1,	'1590830940',	1590830940);

-- 2021-01-11 06:10:12