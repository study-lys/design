/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-05-05 16:34:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for attendance
-- ----------------------------
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `a_id` int(100) NOT NULL AUTO_INCREMENT,
  `s_id` int(100) DEFAULT NULL,
  `a_attendance` varchar(50) DEFAULT NULL,
  `a_vacate` varchar(50) DEFAULT NULL,
  `a_overtime` varchar(50) DEFAULT NULL,
  `a_specialOvertime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`a_id`),
  KEY `s_id` (`s_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `staff` (`s_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attendance
-- ----------------------------
INSERT INTO `attendance` VALUES ('1', '1', '8', '1', '2', '0');
INSERT INTO `attendance` VALUES ('2', '2', '2', '2', '2', '2');
INSERT INTO `attendance` VALUES ('3', null, '4', '4', '4', '4');
INSERT INTO `attendance` VALUES ('4', '4', '4', '4', '4', '4');
INSERT INTO `attendance` VALUES ('5', '5', '4', '4', '4', '4');
INSERT INTO `attendance` VALUES ('6', '7', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('7', null, '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('8', '29', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('9', '30', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('10', '31', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('11', null, '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('12', null, '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('13', null, '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('14', '37', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('15', '38', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('16', '39', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('17', '40', '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('18', null, '0', '0', '0', '0');
INSERT INTO `attendance` VALUES ('19', '42', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `d_id` int(100) NOT NULL AUTO_INCREMENT,
  `d_name` varchar(50) DEFAULT NULL,
  `s_id` int(100) DEFAULT NULL,
  `d_details` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`d_id`),
  KEY `s_id` (`s_id`),
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `staff` (`s_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('1', '工程部', '1', '这是工程部门');
INSERT INTO `department` VALUES ('2', '设计部', '4', '这是设计部');
INSERT INTO `department` VALUES ('3', '测试部', '29', '这是测试部门');
INSERT INTO `department` VALUES ('22', '测试部门1', null, '测试部门1');
INSERT INTO `department` VALUES ('23', '测试部门2', null, '测试部门2');
INSERT INTO `department` VALUES ('24', '测试部门3', null, '测试部门3');
INSERT INTO `department` VALUES ('25', '测试部门4', null, '测试部门1');
INSERT INTO `department` VALUES ('26', '部门删除测试', null, '部门删除测试');
INSERT INTO `department` VALUES ('27', 'sadsad', null, 'sadas');

-- ----------------------------
-- Table structure for post
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `p_id` int(100) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(50) DEFAULT NULL,
  `p_wage` varchar(50) DEFAULT NULL,
  `d_id` int(100) DEFAULT NULL,
  PRIMARY KEY (`p_id`),
  KEY `d_id` (`d_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `department` (`d_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('1', '测试工程师', '8000', '1');
INSERT INTO `post` VALUES ('2', '开发工程师', '9000', '1');
INSERT INTO `post` VALUES ('3', '研发', '5000', '3');
INSERT INTO `post` VALUES ('4', '开发工程师', '8000', '3');
INSERT INTO `post` VALUES ('11', '测试1', '5638', '1');
INSERT INTO `post` VALUES ('12', '测试', '1232', '1');
INSERT INTO `post` VALUES ('14', '测试工程师', '5635', '3');
INSERT INTO `post` VALUES ('15', '测试工程师', '2222', '2');
INSERT INTO `post` VALUES ('16', '技术总监', '20000', '2');
INSERT INTO `post` VALUES ('17', '删除测试1', '5000', '26');
INSERT INTO `post` VALUES ('18', '职位测试', '2555', '26');
INSERT INTO `post` VALUES ('20', '删除测', '12345', '26');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `s_id` int(100) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(50) DEFAULT NULL,
  `s_sex` varchar(50) DEFAULT NULL,
  `s_birthday` varchar(50) DEFAULT NULL,
  `s_education` varchar(50) DEFAULT NULL,
  `s_phone` varchar(100) DEFAULT NULL,
  `s_email` varchar(50) DEFAULT NULL,
  `d_id` int(100) DEFAULT NULL,
  `p_id` int(100) DEFAULT NULL,
  `s_startTime` varchar(100) DEFAULT NULL,
  `s_maritalStatus` varchar(50) DEFAULT NULL,
  `s_nation` varchar(50) DEFAULT NULL,
  `s_nativePlace` varchar(50) DEFAULT NULL,
  `s_location` varchar(50) DEFAULT NULL,
  `s_stature` varchar(50) DEFAULT NULL,
  `s_weight` varchar(50) DEFAULT NULL,
  `s_idNumber` varchar(50) DEFAULT NULL,
  `s_skill` varchar(100) DEFAULT NULL,
  `s_politicsStatus` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`s_id`),
  KEY `d_id` (`d_id`),
  KEY `p_id` (`p_id`),
  CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `department` (`d_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `post` (`p_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', '张三', '男', '1982-02-10', '博士', '18925786825', '112asdsa@163.com', '1', '1', '2016-04-12', '未婚', '汉', '重庆', '重庆', '168', '50', '500382199705057075', null, '群众');
INSERT INTO `staff` VALUES ('2', '李四', '男', '2001-06-12', '高中', '15798564484', 'dasdasd@163.com', '1', '1', '2019-04-16', '已婚', '汉', null, '', null, null, '500382199705057074', null, null);
INSERT INTO `staff` VALUES ('4', '张晓雪', '女', '2001-06-12', '高中', '13358978546', '4154545@163.com', '2', '1', '2019-04-10', null, null, null, null, null, null, '500382199705057072', null, null);
INSERT INTO `staff` VALUES ('5', '李欣怡', '女', '2001-06-12', '高中', '15784875967', '524545@163.com', '2', '1', '2019-04-11', null, null, null, null, null, null, '500382199705057071', null, null);
INSERT INTO `staff` VALUES ('7', '邵华乾', '男', '2001-06-12', '高中', '15789684758', 'shaohuaqian@163.com', '2', '1', '2019-04-27', null, null, null, null, null, null, '500382199805057075', null, null);
INSERT INTO `staff` VALUES ('29', '王王五', '男', '2019-04-11', '高中', '18857584785', '51521485@163.com', '3', '4', '2017-04-12', '未婚', '汉', '重庆', '重庆', '158', '70', '5003821997050575604', '', '群众');
INSERT INTO `staff` VALUES ('30', '小老虎', '女', '2010-06-16', '高中', '13325878563', '51521485@163.com', '2', '15', '2017-04-12', '未婚', '汉', '重庆', '重庆', '158', '70', '500278699805057085', '', '群众');
INSERT INTO `staff` VALUES ('31', '阮小宝', '男', '1970-02-26', '博士', '', '', '3', '14', '2018-04-04', '已婚', '', '', '', '', '', '51128795548257868', '', '');
INSERT INTO `staff` VALUES ('37', 'ssss', '男', '2019-04-02', '初中', '', '', '2', '16', '2019-04-04', '', '', '', '', '', '', '500382199705057893', '', '');
INSERT INTO `staff` VALUES ('38', '员工添加测试', '男', '2016-04-05', '初中', '', '', '26', '17', '2019-04-30', '', '', '', '', '', '', '500382199705057222', '', '');
INSERT INTO `staff` VALUES ('39', '员工删除测试', '男', '2019-04-08', '专科', '', '', '3', '4', '2019-04-11', '', '', '', '', '', '', '500382199705052222', '', '');
INSERT INTO `staff` VALUES ('40', '员工删除测试1', '男', '2019-04-08', '专科', '', '', '3', '4', '2019-04-11', '', '', '', '', '', '', '500382199705052444', '', '');
INSERT INTO `staff` VALUES ('42', '邹大哥', '男', '1997-05-15', '本科', '', '', '3', '4', '2017-05-09', '已婚', '', '', '', '', '', '500258795517257852', '', '');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `u_id` int(100) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(50) DEFAULT NULL,
  `u_password` varchar(50) DEFAULT NULL,
  `u_account` varchar(50) DEFAULT NULL,
  `u_img` varchar(100) DEFAULT NULL,
  `u_type` varchar(50) DEFAULT NULL,
  `u_sex` varchar(50) DEFAULT NULL,
  `u_phone` varchar(50) DEFAULT NULL,
  `u_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'admin', 'admin', 'upload/20190505\\81dbc4e55a8556fafdbe326271695d18.jpg', '超级管理员', '男', '13389625771', '1071645772@qq.com');
INSERT INTO `user` VALUES ('3', '是是', 'liyinsheng', 'liyinsheng', 'upload/20190423\\6cef77b9556c4eeb382db4881c8aa588.jpg', '超级管理员', '男', null, null);
INSERT INTO `user` VALUES ('6', 'admin', '123213', null, null, null, null, null, '');
INSERT INTO `user` VALUES ('7', '小小', '123456', null, null, '超级管理员', '女', '13359825778', '1564165@qq.com');
INSERT INTO `user` VALUES ('8', '小小', '123456', null, null, '超级管理员', '女', '13359825778', '1564165@qq.com');
INSERT INTO `user` VALUES ('9', '小小', '123456', null, null, '超级管理员', '女', '13359825778', '1564165@qq.com');
INSERT INTO `user` VALUES ('12', 'xyz', 'aaaaaa', 'cheshi', null, '超级管理员', '女', '13389625778', '154655@qq.com');
INSERT INTO `user` VALUES ('13', '111', '111111', 'asdsad', null, '管理员', '男', '', '');
INSERT INTO `user` VALUES ('16', '普通管理员', 'admin1', 'admin1', null, '管理员', '男', '', '');
