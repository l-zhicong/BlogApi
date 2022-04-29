SET NAMES utf8mb4;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL COMMENT '分类id',
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `abstract` varchar(255) DEFAULT NULL COMMENT '摘要',
  `related_words` varchar(255) DEFAULT NULL COMMENT '关联词',
  `source` varchar(255) DEFAULT NULL COMMENT '来源',
  `author` varchar(11) DEFAULT NULL COMMENT '作者',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '发布状态 1发布 2未发布',
  `release_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `read_num` int(11) DEFAULT '0' COMMENT '阅读量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='文章主表';

-- ----------------------------
-- Table structure for article_category
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `article_category_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章分类id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `title` varchar(32) NOT NULL COMMENT '文章分类标题',
  `info` varchar(255) DEFAULT NULL COMMENT '文章分类简介',
  `image` varchar(128) DEFAULT NULL COMMENT '文章分类图片',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态 0异常 1正常',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`article_category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Table structure for article_comment
-- ----------------------------
DROP TABLE IF EXISTS `article_comment`;
CREATE TABLE `article_comment` (
  `artucle_id` int(11) NOT NULL COMMENT '文章表id',
  `uid` int(11) DEFAULT NULL,
  `content` text COMMENT '内容',
  `pid` int(11) DEFAULT NULL COMMENT '评论回复父级id',
  PRIMARY KEY (`artucle_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章评论表';

-- ----------------------------
-- Table structure for article_content
-- ----------------------------
DROP TABLE IF EXISTS `article_content`;
CREATE TABLE `article_content` (
  `article_content_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `content` longtext NOT NULL COMMENT '文章内容',
  UNIQUE KEY `article_content_id` (`article_content_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章内容表';

-- ----------------------------
-- Table structure for article_fabulous
-- ----------------------------
DROP TABLE IF EXISTS `article_fabulous`;
CREATE TABLE `article_fabulous` (
  `article_id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 0取消点赞 1点赞'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章点赞表';

-- ----------------------------
-- Table structure for music
-- ----------------------------
DROP TABLE IF EXISTS `music`;
CREATE TABLE `music` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `poster_url` varchar(255) NOT NULL,
  `lyrics` text NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for myhomepage
-- ----------------------------
DROP TABLE IF EXISTS `myhomepage`;
CREATE TABLE `myhomepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '名称',
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '简介',
  `is_app` tinyint(1) DEFAULT '1' COMMENT '是否应用 0不是 1是',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0' COMMENT '是否删除 ',
  `introduce` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for myhomepage_img
-- ----------------------------
DROP TABLE IF EXISTS `myhomepage_img`;
CREATE TABLE `myhomepage_img` (
  `id` int(11) NOT NULL,
  `home_id` int(11) NOT NULL COMMENT '主页id',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片类型名称',
  `is_del` tinyint(1) DEFAULT NULL COMMENT '是否删除',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'url',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for myhomepage_letter
-- ----------------------------
DROP TABLE IF EXISTS `myhomepage_letter`;
CREATE TABLE `myhomepage_letter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `is_del` int(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for myhomepage_skills
-- ----------------------------
DROP TABLE IF EXISTS `myhomepage_skills`;
CREATE TABLE `myhomepage_skills` (
  `home_id` int(11) NOT NULL COMMENT '主页id',
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '技能名称',
  `schedule` int(2) DEFAULT NULL COMMENT '掌握进度'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_admin
-- ----------------------------
DROP TABLE IF EXISTS `system_admin`;
CREATE TABLE `system_admin` (
  `admin_id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台管理员表ID',
  `account` varchar(32) NOT NULL COMMENT '后台管理员账号',
  `pwd` varchar(64) NOT NULL COMMENT '后台管理员密码',
  `real_name` varchar(16) NOT NULL COMMENT '后台管理员姓名',
  `phone` varchar(12) DEFAULT NULL COMMENT '联系电话',
  `roles` varchar(128) NOT NULL COMMENT '后台管理员权限(role_id), 多个逗号分隔',
  `last_ip` varchar(16) DEFAULT NULL COMMENT '后台管理员最后一次登录ip',
  `last_time` int(11) DEFAULT NULL COMMENT '后台管理员最后一次登录时间',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '后台管理员状态 1有效0无效',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL COMMENT '后台管理员添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '后台管理员编辑时间',
  PRIMARY KEY (`admin_id`) USING BTREE,
  KEY `account` (`account`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
-- Records of system_admin
-- ----------------------------

BEGIN;
INSERT INTO `system_admin` (`admin_id`, `account`, `pwd`, `real_name`, `phone`, `roles`, `last_ip`, `last_time`, `login_count`, `status`, `level`, `is_del`, `create_time`, `update_time`) VALUES (2, 'admin', 'dce9b4bf4ee9c5085e6f434a2635a100', '梁智聪', '14778363135', '2', '10.42.0.1', 1651118404, 693, 1, 0, 0, NULL, 1651118404);
INSERT INTO `system_admin` (`admin_id`, `account`, `pwd`, `real_name`, `phone`, `roles`, `last_ip`, `last_time`, `login_count`, `status`, `level`, `is_del`, `create_time`, `update_time`) VALUES (3, 'yaoguai1', 'fcea920f7412b5da7be0cf42b8c93759', '梁智聪', '18707664170', '2', NULL, NULL, 0, 1, 1, 0, 1645153126, 1648267819);
COMMIT;

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `path` varchar(512) NOT NULL COMMENT '路径',
  `icon` varchar(32) DEFAULT '' COMMENT '图标',
  `menu_name` varchar(128) NOT NULL DEFAULT '' COMMENT '按钮名',
  `route` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '路由名称',
  `sort` tinyint(3) NOT NULL DEFAULT '1' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `plat_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '模块，1 后台平台，2-博客 ',
  `is_menu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型，1菜单 0 权限',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`menu_id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
BEGIN;
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (7, 0, '/', 'el-icon-s-tools', '设置', '/settings', 1, 1, 1, 1, 1615259641, 1619499036);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (9, 7, '/7/', '', '权限管理', '/setting', 1, 1, 1, 1, 1619352594, 1619500336);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (10, 9, '/7/9/', '', '菜单管理', '/setting/menu', 1, 1, 1, 1, 1619352594, 1619352594);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (28, 9, '/7/9/', NULL, '管理员管理', '/setting/systemAdmin', 0, 1, 1, 1, 1619403186, 1619403186);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (29, 9, '/7/9/', NULL, '身份管理', '/setting/systemRole', 0, 1, 1, 1, 1619403218, 1619403218);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (172, 0, '/', 'el-icon-edit', '文章管理', '/article', 0, 1, 1, 1, 1623401662, 1623401662);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (173, 172, '/172/', '', '文章列表', '/article/list', 0, 1, 1, 1, 1623401679, 1623401679);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (174, 172, '/172/', '', '分类列表', '/article/category', 0, 1, 1, 1, 1623401697, 1623401697);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (176, 0, '/', 'el-icon-s-tools', '个人资料管理', '/mydataManage', 1, 1, 1, 1, 1645424815, 1645424815);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (181, 176, '/176/', '', '主页管理', '/mydataManage/myhomepage', 1, 1, 1, 1, 2022, 1645425391);
INSERT INTO `system_menu` (`menu_id`, `pid`, `path`, `icon`, `menu_name`, `route`, `sort`, `is_show`, `plat_type`, `is_menu`, `create_time`, `update_time`) VALUES (182, 176, '/176/', '', '博客管理', '/mydataManage/myblog', 1, 1, 1, 1, 1645425240, 1645425240);
COMMIT;

-- ----------------------------
-- Table structure for system_role
-- ----------------------------
DROP TABLE IF EXISTS `system_role`;
CREATE TABLE `system_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '身份管理id',
  `role_name` varchar(32) NOT NULL COMMENT '身份管理名称',
  `rules` text NOT NULL COMMENT '身份管理权限(menus_id)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `plat_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '模块，1 平台',
  `plat_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应平台id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`role_id`) USING BTREE,
  KEY `mer_id` (`plat_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='身份管理表';
-- ----------------------------
-- Records of system_role
-- ----------------------------
BEGIN;
INSERT INTO `system_role` (`role_id`, `role_name`, `rules`, `status`, `plat_type`, `plat_id`, `create_time`, `update_time`) VALUES (2, '管理员', '1,2,8,3,5,6,36,37,57,7,9,10,26,35,38,39,40,54,11,28,41,42,43,44,45,46,47,29,48,49,50,51,52,53', 1, 1, 1, 1615342124, 1645165023);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
