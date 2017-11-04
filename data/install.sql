SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `{orginal}system_auth`;
CREATE TABLE `{orginal}system_auth` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '权限名称',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(1:禁用,2:启用)',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT '排序权重',
  `desc` varchar(255) DEFAULT NULL COMMENT '备注说明',
  `create_by` bigint(11) unsigned DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_auth_title` (`title`) USING BTREE,
  KEY `index_system_auth_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统权限表';


INSERT INTO `{orginal}system_auth` (`id`,`title`,`status`,`sort`,`desc`,`create_by`,`create_at`) VALUES ('1','超级管理员','1','0','所有权限','0','2017-10-20 17:15:44');

DROP TABLE IF EXISTS `{orginal}system_auth_node`;
CREATE TABLE `{orginal}system_auth_node` (
  `auth` bigint(20) unsigned DEFAULT NULL COMMENT '角色ID',
  `node` varchar(200) DEFAULT NULL COMMENT '节点路径',
  KEY `index_system_auth_auth` (`auth`) USING BTREE,
  KEY `index_system_auth_node` (`node`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色与节点关系表';

INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/index');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/apply');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/add');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/edit');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/forbid');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/resume');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/auth/del');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/config');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/config/index');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/config/file');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/log');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/log/index');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/log/del');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu/index');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu/add');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu/edit');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu/del');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu/forbid');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/menu/resume');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/node');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/node/index');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/node/save');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/index');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/auth');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/add');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/edit');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/pass');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/del');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/forbid');
INSERT INTO `{orginal}system_auth_node` (`auth`,`node`) VALUES ('1','admin/user/resume');


DROP TABLE IF EXISTS `{orginal}system_config`;
CREATE TABLE `{orginal}system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` varchar(500) DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`),
  KEY `index_system_config_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统参数配置';


INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('148','site_name','后台管理系统');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('149','site_copy','绵阳顺为科技有限公司 © 2016~2017');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('164','storage_type','local');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('165','storage_qiniu_is_https','1');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('166','storage_qiniu_bucket','static');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('167','storage_qiniu_domain','static.ctolog.com');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('168','storage_qiniu_access_key','OAFHGzCgZjod2-s4xr-g5ptkXsNbxDO_t2fozIEC');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('169','storage_qiniu_secret_key','gy0aYdSFMSayQ4kMkgUeEeJRLThVjLpUJoPFxd-Z');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('170','storage_qiniu_region','华东');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('173','app_name','后台管理系统');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('174','app_version','1.00');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('176','browser_icon','http://127.0.0.6/static/upload/44453ff85b4080bd/edb0ca8b549926d9.ico');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('197','tongji_baidu_key','aa2f9869e9b578122e4692de2bd9f80f');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('198','tongji_cnzz_key','1261854404');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('199','storage_oss_bucket','think-oss');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('200','storage_oss_keyid','WjeX0AYSfgy5VbXQ');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('201','storage_oss_secret','hQTENHy6MYVUTgwjcgfOCq5gckm2Lp');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('202','storage_oss_domain','think-oss.oss-cn-shanghai.aliyuncs.com');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('203','storage_oss_is_https','1');
INSERT INTO `{orginal}system_config` (`id`,`name`,`value`) VALUES ('204','storage_local_exts','png,jpg,doc,rar,ico');



DROP TABLE IF EXISTS `{orginal}system_log`;
CREATE TABLE `{orginal}system_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `node` char(200) NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='系统操作日志表';


INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('1','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-20 16:33:08');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('2','127.0.0.1','admin/login/out','admin','系统管理','用户退出系统成功','2017-10-20 16:42:27');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('3','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-20 16:43:02');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('4','127.0.0.1','admin/config/file','admin','系统管理','系统参数配置成功','2017-10-20 17:08:25');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('5','127.0.0.1','admin/config/index','admin','系统管理','系统参数配置成功','2017-10-20 17:09:10');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('6','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-21 09:27:35');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('7','127.0.0.1','admin/login/out','admin','系统管理','用户退出系统成功','2017-10-21 09:31:24');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('8','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-21 09:31:37');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('9','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-23 09:06:24');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('10','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-24 09:02:13');
INSERT INTO `{orginal}system_log` (`id`,`ip`,`node`,`username`,`action`,`content`,`create_at`) VALUES ('11','127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-10-26 09:32:44');



DROP TABLE IF EXISTS `{orginal}system_menu`;
CREATE TABLE `{orginal}system_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `node` varchar(200) NOT NULL DEFAULT '' COMMENT '节点代码',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(400) NOT NULL DEFAULT '' COMMENT '链接',
  `params` varchar(500) DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
  `sort` int(11) unsigned DEFAULT '0' COMMENT '菜单排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `create_by` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_menu_node` (`node`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8 COMMENT='系统菜单表';


INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('2','0','后台首页','','','#','','_self','1000','1','0','2015-11-16 19:15:38');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('4','2','系统配置','','','#','','_self','100','1','0','2016-03-14 18:12:55');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('5','4','网站参数','','fa fa-apple','admin/config/index','','_self','20','1','0','2016-05-06 14:36:49');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('6','4','文件存储','','fa fa-save','admin/config/file','','_self','30','1','0','2016-05-06 14:39:43');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('9','20','操作日志','','glyphicon glyphicon-console','admin/log/index','','_self','50','1','0','2017-03-24 15:49:31');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('19','20','权限管理','','fa fa-user-secret','admin/auth/index','','_self','10','1','0','2015-11-17 13:18:12');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('20','2','系统权限','','','#','','_self','200','1','0','2016-03-14 18:11:41');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('21','20','系统菜单','','glyphicon glyphicon-menu-hamburger','admin/menu/index','','_self','30','1','0','2015-11-16 19:16:16');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('22','20','节点管理','','fa fa-ellipsis-v','admin/node/index','','_self','20','1','0','2015-11-16 19:16:16');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('29','20','系统用户','','fa fa-users','admin/user/index','','_self','40','1','0','2016-10-31 14:31:40');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('95','2','数据管理','','','#','','_self','300','1','0','2017-10-20 17:21:56');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('96','95','模型管理','','fa fa-database','/admin/model/model','','_self','0','1','0','2017-10-20 17:22:32');
INSERT INTO `{orginal}system_menu` (`id`,`pid`,`title`,`node`,`icon`,`url`,`params`,`target`,`sort`,`status`,`create_by`,`create_at`) VALUES ('109','95','系统备份','','fa fa-list-alt','admin/baksql/index','','_self','0','1','0','2017-10-26 10:23:46');



DROP TABLE IF EXISTS `{orginal}system_model`;
CREATE TABLE `{orginal}system_model` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `menuname` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单名',
  `tablename` varchar(50) NOT NULL DEFAULT '' COMMENT '表名',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '描述',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `menuid` varchar(11) DEFAULT '' COMMENT '菜单ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `issys` int(11) NOT NULL DEFAULT '0' COMMENT '是否是系统模型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统模型';



DROP TABLE IF EXISTS `{orginal}system_modelfield`;
CREATE TABLE `{orginal}system_modelfield` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `field` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `css` varchar(30) NOT NULL DEFAULT '' COMMENT '样式名',
  `minlength` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '字段最小值',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '字段最大值',
  `pattern` varchar(255) NOT NULL DEFAULT '' COMMENT '数据校验正则',
  `formtype` varchar(20) NOT NULL DEFAULT '' COMMENT '字段类型',
  `setting` mediumtext COMMENT '相关参数',
  `formattribute` varchar(255) NOT NULL DEFAULT '' COMMENT '附加属性',
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '预留字段',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否系统字段',
  `isunique` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '值唯一',
  `isbase` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '作为基本信息',
  `issearch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '作为搜索条件',
  `islist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示在列表页',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `isdisabled` int(11) NOT NULL DEFAULT '0' COMMENT '是否显示',
  PRIMARY KEY (`id`),
  KEY `modelid` (`modelid`,`status`),
  KEY `field` (`field`,`modelid`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='模型字段';



DROP TABLE IF EXISTS `{orginal}system_node`;
CREATE TABLE `{orginal}system_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `node` varchar(100) DEFAULT NULL COMMENT '节点代码',
  `title` varchar(500) DEFAULT NULL COMMENT '节点标题',
  `is_menu` tinyint(1) unsigned DEFAULT '0' COMMENT '是否可设置为菜单',
  `is_auth` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启动RBAC权限控制',
  `is_login` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启动登录控制',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_node_node` (`node`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统节点表';


INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('131','admin/auth/index','权限列表','1','1','1','2017-08-23 15:45:42');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('132','admin','后台管理','0','1','1','2017-08-23 15:45:44');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('133','admin/auth/apply','节点授权','0','1','1','2017-08-23 16:05:18');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('134','admin/auth/add','添加授权','0','1','1','2017-08-23 16:05:19');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('135','admin/auth/edit','编辑权限','0','1','1','2017-08-23 16:05:19');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('136','admin/auth/forbid','禁用权限','0','1','1','2017-08-23 16:05:20');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('137','admin/auth/resume','启用权限','0','1','1','2017-08-23 16:05:20');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('138','admin/auth/del','删除权限','0','1','1','2017-08-23 16:05:21');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('139','admin/config/index','参数配置','1','1','1','2017-08-23 16:05:22');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('140','admin/config/file','文件配置','1','1','1','2017-08-23 16:05:22');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('141','admin/log/index','日志列表','1','1','1','2017-08-23 16:05:23');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('142','admin/log/del','删除日志','0','1','1','2017-08-23 16:05:24');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('143','admin/menu/index','菜单列表','1','1','1','2017-08-23 16:05:25');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('144','admin/menu/add','添加菜单','0','1','1','2017-08-23 16:05:25');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('145','admin/menu/edit','编辑菜单','0','1','1','2017-08-23 16:05:26');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('146','admin/menu/del','删除菜单','0','1','1','2017-08-23 16:05:26');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('147','admin/menu/forbid','禁用菜单','0','1','1','2017-08-23 16:05:27');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('148','admin/menu/resume','启用菜单','0','1','1','2017-08-23 16:05:28');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('149','admin/node/index','节点列表','1','1','1','2017-08-23 16:05:29');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('150','admin/node/save','节点更新','0','1','1','2017-08-23 16:05:30');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('151','admin/user/index','用户管理','1','1','1','2017-08-23 16:05:31');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('152','admin/user/auth','用户授权','0','1','1','2017-08-23 16:05:32');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('153','admin/user/add','添加用户','0','1','1','2017-08-23 16:05:33');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('154','admin/user/edit','编辑用户','0','1','1','2017-08-23 16:05:33');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('155','admin/user/pass','用户密码','0','1','1','2017-08-23 16:05:34');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('156','admin/user/del','删除用户','0','1','1','2017-08-23 16:05:34');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('157','admin/user/forbid','禁用用户','0','1','1','2017-08-23 16:05:34');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('158','admin/user/resume','启用用户','0','1','1','2017-08-23 16:05:35');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('159','demo/plugs/file','文件上传','0','0','0','2017-08-23 16:05:36');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('160','demo/plugs/region','区域选择','0','0','0','2017-08-23 16:05:36');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('161','demo/plugs/editor','富文本器','0','0','0','2017-08-23 16:05:37');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('194','admin/auth','权限管理','0','1','1','2017-08-23 16:06:58');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('195','admin/config','系统配置','0','1','1','2017-08-23 16:07:34');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('196','admin/log','系统日志','0','1','1','2017-08-23 16:07:46');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('197','admin/menu','系统菜单','0','1','1','2017-08-23 16:08:02');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('198','admin/node','系统节点','0','1','1','2017-08-23 16:08:44');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('199','admin/user','系统用户','0','1','1','2017-08-23 16:09:43');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('200','demo','插件案例','0','1','1','2017-08-23 16:10:43');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('201','demo/plugs','插件案例','0','1','1','2017-08-23 16:10:51');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('209','admin/model','模型管理','0','1','1','2017-10-21 09:30:25');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('210','admin/model/model','模型列表','1','1','1','2017-10-21 09:30:34');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('211','admin/index','后台首页','0','1','1','2017-10-21 09:30:44');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('212','admin/index/index','后台首页','0','0','1','2017-10-21 09:30:51');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('213','admin/index/main','后台主界面','0','0','1','2017-10-21 09:31:02');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('214','admin/index/pass','修改密码','0','0','1','2017-10-21 09:31:07');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('215','admin/index/info','基本信息','0','0','1','2017-10-21 09:31:14');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('216','admin/field','字段管理','0','1','1','2017-10-26 10:16:46');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('217','admin/field/index','字段列表','0','1','1','2017-10-26 10:16:50');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('218','admin/field/add','新增字段','0','1','1','2017-10-26 10:16:54');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('219','admin/field/edit','编辑字段','0','1','1','2017-10-26 10:16:57');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('220','admin/field/status','状态更改','0','1','1','2017-10-26 10:17:04');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('221','admin/field/del','删除字段','0','1','1','2017-10-26 10:17:08');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('222','admin/field/getfieldpost','','0','1','1','2017-10-26 10:17:12');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('223','admin/model/add','新增模型','0','1','1','2017-10-26 10:17:38');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('224','admin/model/edit','编辑模型','0','1','1','2017-10-26 10:17:45');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('225','admin/model/status','状态更改','0','1','1','2017-10-26 10:17:49');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('226','admin/model/del','删除模型','0','1','1','2017-10-26 10:17:53');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('227','admin/model/generate','生成模型','0','1','1','2017-10-26 10:17:57');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('228','admin/baksql','数据库备份','0','1','1','2017-10-26 10:21:53');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('229','admin/baksql/backsql','数据库操作','0','1','1','2017-10-26 10:21:57');
INSERT INTO `{orginal}system_node` (`id`,`node`,`title`,`is_menu`,`is_auth`,`is_login`,`create_at`) VALUES ('230','admin/baksql/index','数据库列表','0','1','1','2017-10-26 10:21:59');



DROP TABLE IF EXISTS `{orginal}system_sequence`;
CREATE TABLE `{orginal}system_sequence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL COMMENT '序号类型',
  `sequence` char(50) NOT NULL COMMENT '序号值',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_sequence_unique` (`type`,`sequence`) USING BTREE,
  KEY `index_system_sequence_type` (`type`),
  KEY `index_system_sequence_number` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统序号表';



DROP TABLE IF EXISTS `{orginal}system_user`;
CREATE TABLE `{orginal}system_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户登录名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户登录密码',
  `qq` varchar(16) DEFAULT NULL COMMENT '联系QQ',
  `mail` varchar(32) DEFAULT NULL COMMENT '联系邮箱',
  `phone` varchar(16) DEFAULT NULL COMMENT '联系手机号',
  `desc` varchar(255) DEFAULT '' COMMENT '备注说明',
  `login_num` bigint(20) unsigned DEFAULT '0' COMMENT '登录次数',
  `login_at` datetime DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `authorize` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '删除状态(1:删除,0:未删)',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_user_username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='系统用户表';


INSERT INTO `{orginal}system_user` (`id`,`username`,`password`,`qq`,`mail`,`phone`,`desc`,`login_num`,`login_at`,`status`,`authorize`,`is_deleted`,`create_by`,`create_at`) VALUES ('10000','admin','21232f297a57a5a743894a0e4a801fc3','505058216','505058216@qq.com','15008167425','超级管理员','5','2017-10-26 09:32:43','1','1','0','0','2015-11-13 15:14:22');

