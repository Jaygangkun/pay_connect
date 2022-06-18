/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pay_connect

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2022-06-18 06:33:51
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `batch_files`
-- ----------------------------
DROP TABLE IF EXISTS `batch_files`;
CREATE TABLE `batch_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `file_batch_number` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `ordCust_name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `batch_amount` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `total_records` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL COMMENT '1=>submitted,  2=>error, 3=>pending, 4=>authorised, 5=>processed, 6=>partial, 7=>acked, 8=>in_progress',
  `error_msg` text,
  `upload_at` datetime DEFAULT NULL,
  `submit_at` datetime DEFAULT NULL,
  `authorise_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of batch_files
-- ----------------------------
INSERT INTO `batch_files` VALUES ('46', 'MOF18062022BP0001', 'New-Header-Sample3Copy4.csv', 'MOF18062022BP0001', 'MTRF000000915', '1000115041', 'CLEARING ACCOUNT-USD', '8/26/2020', '34944.9', 'USD', '7', 'SUBMITTED', null, '2022-06-18 05:31:55', null, '2022-06-18 05:50:47');
INSERT INTO `batch_files` VALUES ('47', 'MOF18062022BP0002', null, 'MOF18062022BP0002', null, 'werwer', '', '06/18/2022', '0.00', 'USD', '1', 'SUBMITTED', null, '2022-06-18 05:47:04', '2022-06-18 05:47:04', '2022-06-18 05:51:25');

-- ----------------------------
-- Table structure for `batch_records`
-- ----------------------------
DROP TABLE IF EXISTS `batch_records`;
CREATE TABLE `batch_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_file_id` int(11) DEFAULT NULL,
  `payment_seq` int(11) DEFAULT NULL,
  `transaction_ref` varchar(255) DEFAULT NULL,
  `beneficiary_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `amount_pay` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `benef_bank` varchar(255) DEFAULT NULL,
  `bank_biccode` varchar(255) DEFAULT NULL,
  `uploader` varchar(255) DEFAULT NULL,
  `authoriser` varchar(255) DEFAULT NULL,
  `txn_purpose` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>submitted,  2=>error, 3=>pending',
  `resp_rcvStatus` varchar(10) DEFAULT NULL,
  `resp_errorMsg` varchar(255) DEFAULT NULL,
  `resp_statusCode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of batch_records
-- ----------------------------
INSERT INTO `batch_records` VALUES ('275', '46', '1', 'MOF18062022BP0001-0001', 'ABDINASIR ALI AHMED', '40900170001', '7755', 'Mashruuca RCRF', 'PREMEIR BANK', 'PBSMSOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('276', '46', '2', 'MOF18062022BP0001-0002', 'Mohamed Hassan Farah', '30106408001', '4163.4', 'Wasaaradda Arrimaha Gudaha iyo Fadaraalka', 'PREMEIR BANK', 'PBSMSOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('277', '46', '3', 'MOF18062022BP0001-0003', 'Liban Abdi Mohamud', '30915430', '3868.2', 'Mashruuca RCRF', 'SALAMA BANK', 'SSBMSOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('278', '46', '4', 'MOF18062022BP0001-0004', 'Mohamed Sheikh Axmed Mohamed', '0011384-5', '3056.4', 'Wasaaradda Arrimaha Gudaha iyo Fadaraalka', 'PREMEIR BANK', 'PBSMSOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('279', '46', '5', 'MOF18062022BP0001-0005', 'Boniface M Makumbi', '50910984001', '9990', 'SCORE PROJECT', 'PREMEIR BANK', 'PBSMSOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('280', '46', '6', 'MOF18062022BP0001-0006', 'JAZEERA PALCE HOTEL', '30098405', '3055.5', 'SCORE PROJECT', 'SALAMA BANK', 'SSBMSOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('281', '46', '7', 'MOF18062022BP0001-0007', 'Ali Adan Hassan', '112104335', '3056.4', 'Mashruuca RCRF', 'DAHABSHIL BANK INTERNATIONAL', 'DAHISOSM', 'jay1', 'jay1', 'test1', '0', 'NACKED', 'Not Processed', '77');
INSERT INTO `batch_records` VALUES ('282', '47', '1', 'MOF18062022BP0002-0001', '', '', '', 'Mashruuca RCRF', 'part1s', 'PBSMSOSM', 'jay1', 'jay1', 'test1', '1', 'ACKED', 'Success', '00');

-- ----------------------------
-- Table structure for `departments`
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of departments
-- ----------------------------
INSERT INTO `departments` VALUES ('1', 'Mashruuca RCRF');
INSERT INTO `departments` VALUES ('2', 'Wasaaradda Arrimaha Gudaha iyo Fadaraalka');
INSERT INTO `departments` VALUES ('3', 'SCORE PROJECT');
INSERT INTO `departments` VALUES ('4', 'new1');
INSERT INTO `departments` VALUES ('5', 'new13');
INSERT INTO `departments` VALUES ('6', 'ww');

-- ----------------------------
-- Table structure for `email_servers`
-- ----------------------------
DROP TABLE IF EXISTS `email_servers`;
CREATE TABLE `email_servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(255) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `ssl_tls` tinyint(4) DEFAULT NULL COMMENT '1=>ssl/tls',
  `default` tinyint(4) DEFAULT NULL COMMENT '1=>default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of email_servers
-- ----------------------------
INSERT INTO `email_servers` VALUES ('3', 'ert1', '11111', 'ert1', 'ert111', '123123', '0', '0');
INSERT INTO `email_servers` VALUES ('4', 'wer', '3333', 'qqq', '1123', '123123', '0', '1');
INSERT INTO `email_servers` VALUES ('5', '123', '123', '123', '1231', '123', '1', '0');
INSERT INTO `email_servers` VALUES ('6', 'aaa1', '333', 'ccc1', 'ddd111', 'eee1', '1', '1');

-- ----------------------------
-- Table structure for `gateways`
-- ----------------------------
DROP TABLE IF EXISTS `gateways`;
CREATE TABLE `gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `endpoint` varchar(255) DEFAULT NULL,
  `auth` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL COMMENT '30=>active,  31=>suspended',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gateways
-- ----------------------------
INSERT INTO `gateways` VALUES ('3', 'short3', 'desc3', 'end3', 'tttttttttttt', 'OUTWARD', 'Suspended');
INSERT INTO `gateways` VALUES ('4', 'APPSERVER', 'App Server', 'https://5.9.24.51:8889/jethro/indata', 'Basic TlE4RDZRUzlMdnh4N3c0ZjM3REM6NHN1Qk5IaUNpeUtaN3dXc3Vpd3o=', 'OUTWARD', 'Active');
INSERT INTO `gateways` VALUES ('5', 'asdf', 'www', 'werwer', '1123123', 'OUTWARD', 'Suspended');

-- ----------------------------
-- Table structure for `participants`
-- ----------------------------
DROP TABLE IF EXISTS `participants`;
CREATE TABLE `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bic_swift_code` varchar(255) DEFAULT NULL,
  `sort_code` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `participant_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL COMMENT '20=>active,  21=>suspended, 22=>insolvent, 23=>liquidated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of participants
-- ----------------------------
INSERT INTO `participants` VALUES ('1', 'PBSMSOSM', 'sort12', 'short1s', 'part1s', 'account1s', '20');
INSERT INTO `participants` VALUES ('2', 'SSBMSOSM', 'sort2', 'short2', 'part2', 'account2', '22');
INSERT INTO `participants` VALUES ('3', 'DAHISOSM', 'sort23', 'short23', 'part23', 'account23', '21');
INSERT INTO `participants` VALUES ('4', 'bic123456789', 'sort245', 'short24578', 'part24578', 'account245', '22');
INSERT INTO `participants` VALUES ('5', 'bic666', 'sort66', 'short666', 'part666', 'account666', '21');
INSERT INTO `participants` VALUES ('6', 'bic1234567', 'sort67', 'short67', 'part67', 'accou67', '20');

-- ----------------------------
-- Table structure for `txn_purpose`
-- ----------------------------
DROP TABLE IF EXISTS `txn_purpose`;
CREATE TABLE `txn_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of txn_purpose
-- ----------------------------
INSERT INTO `txn_purpose` VALUES ('1', 'test1', 'aaaaa');
INSERT INTO `txn_purpose` VALUES ('3', 'test3', 'aww');

-- ----------------------------
-- Table structure for `user_activities`
-- ----------------------------
DROP TABLE IF EXISTS `user_activities`;
CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `activity` varchar(20) DEFAULT NULL COMMENT '1=>login, 2=>upload, 3=>submit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_activities
-- ----------------------------
INSERT INTO `user_activities` VALUES ('1', '1', '172.16.1.45', '2022-05-08 21:30:04', 'login');
INSERT INTO `user_activities` VALUES ('2', '6', '172.16.1.45', '2022-05-17 21:33:41', 'submit');
INSERT INTO `user_activities` VALUES ('3', '1', 'test ip', '2022-05-09 23:13:38', 'login');
INSERT INTO `user_activities` VALUES ('4', '9', '172.16.1.45', '2022-05-09 23:16:52', 'login');
INSERT INTO `user_activities` VALUES ('5', '1', '172.16.1.45', '2022-05-09 23:18:27', 'logout');
INSERT INTO `user_activities` VALUES ('6', '1', '172.16.1.45', '2022-05-09 23:18:33', 'login');
INSERT INTO `user_activities` VALUES ('7', '1', '172.16.1.45', '2022-05-09 23:20:04', 'logout');
INSERT INTO `user_activities` VALUES ('8', '1', '172.16.1.45', '2022-05-09 23:20:08', 'login');
INSERT INTO `user_activities` VALUES ('9', '9', '172.16.1.45', '2022-05-09 23:21:19', 'login');
INSERT INTO `user_activities` VALUES ('10', '1', '172.16.1.45', '2022-05-09 23:21:49', 'logout');
INSERT INTO `user_activities` VALUES ('11', '9', '172.16.1.45', '2022-05-09 23:21:54', 'login');
INSERT INTO `user_activities` VALUES ('12', '1', '172.16.1.45', '2022-05-10 07:43:09', 'login');
INSERT INTO `user_activities` VALUES ('13', '1', '172.16.1.45', '2022-05-10 09:15:15', 'logout');
INSERT INTO `user_activities` VALUES ('14', '1', '172.16.1.45', '2022-05-10 09:15:25', 'login');
INSERT INTO `user_activities` VALUES ('15', '1', '172.16.1.45', '2022-05-10 09:15:46', 'logout');
INSERT INTO `user_activities` VALUES ('16', '9', '172.16.1.45', '2022-05-10 09:16:09', 'login');
INSERT INTO `user_activities` VALUES ('17', '9', '172.16.1.45', '2022-05-10 10:03:06', 'submit');
INSERT INTO `user_activities` VALUES ('18', '9', '172.16.1.45', '2022-05-10 10:13:26', 'submit');
INSERT INTO `user_activities` VALUES ('19', '9', '172.16.1.45', '2022-05-10 10:13:58', 'submit');
INSERT INTO `user_activities` VALUES ('20', '9', '172.16.1.45', '2022-05-10 10:17:17', 'submit');
INSERT INTO `user_activities` VALUES ('21', '9', '172.16.1.45', '2022-05-10 10:19:25', 'submit');
INSERT INTO `user_activities` VALUES ('22', '9', '172.16.1.45', '2022-05-10 10:32:03', 'submit');
INSERT INTO `user_activities` VALUES ('23', '9', '172.16.1.45', '2022-05-10 10:34:01', 'submit');
INSERT INTO `user_activities` VALUES ('24', '9', '172.16.1.45', '2022-05-10 10:34:57', 'submit');
INSERT INTO `user_activities` VALUES ('25', '9', '172.16.1.45', '2022-05-10 10:35:24', 'submit');
INSERT INTO `user_activities` VALUES ('26', '9', '172.16.1.45', '2022-05-10 10:35:45', 'submit');
INSERT INTO `user_activities` VALUES ('27', '9', '172.16.1.45', '2022-05-10 10:36:35', 'submit');
INSERT INTO `user_activities` VALUES ('28', '9', '172.16.1.45', '2022-05-10 10:39:16', 'submit');
INSERT INTO `user_activities` VALUES ('29', '9', '172.16.1.45', '2022-05-10 10:39:34', 'submit');
INSERT INTO `user_activities` VALUES ('30', '9', '172.16.1.45', '2022-05-10 10:40:59', 'submit');
INSERT INTO `user_activities` VALUES ('31', '9', '172.16.1.45', '2022-05-10 10:43:14', 'submit');
INSERT INTO `user_activities` VALUES ('32', '9', '172.16.1.45', '2022-05-10 10:44:11', 'submit');
INSERT INTO `user_activities` VALUES ('33', '9', '172.16.1.45', '2022-05-10 10:44:37', 'submit');
INSERT INTO `user_activities` VALUES ('34', '9', '172.16.1.45', '2022-05-10 10:45:57', 'submit');
INSERT INTO `user_activities` VALUES ('35', '9', '172.16.1.45', '2022-05-10 10:47:13', 'submit');
INSERT INTO `user_activities` VALUES ('36', '9', '172.16.1.45', '2022-05-10 10:56:02', 'submit');
INSERT INTO `user_activities` VALUES ('37', '9', '172.16.1.45', '2022-05-10 11:04:50', 'submit');
INSERT INTO `user_activities` VALUES ('38', '9', '172.16.1.45', '2022-05-10 11:06:47', 'submit');
INSERT INTO `user_activities` VALUES ('39', '9', '172.16.1.45', '2022-05-10 11:28:15', 'submit');
INSERT INTO `user_activities` VALUES ('40', '1', '172.16.1.45', '2022-05-10 12:06:41', 'login');
INSERT INTO `user_activities` VALUES ('41', '1', '172.16.1.45', '2022-05-10 12:08:39', 'login');
INSERT INTO `user_activities` VALUES ('42', '1', '172.16.1.45', '2022-05-10 12:15:38', 'login');
INSERT INTO `user_activities` VALUES ('43', '1', '172.16.1.45', '2022-05-10 12:19:10', 'login');
INSERT INTO `user_activities` VALUES ('44', '0', '172.16.1.45', '2022-05-10 12:28:19', 'logout');
INSERT INTO `user_activities` VALUES ('45', '1', '172.16.1.45', '2022-05-10 12:31:06', 'login');
INSERT INTO `user_activities` VALUES ('46', '1', '172.16.1.45', '2022-05-10 12:34:46', 'login');
INSERT INTO `user_activities` VALUES ('47', '1', '172.16.1.45', '2022-05-10 12:34:50', 'logout');
INSERT INTO `user_activities` VALUES ('48', '9', '172.16.1.45', '2022-05-10 13:18:47', 'login');
INSERT INTO `user_activities` VALUES ('49', '9', '172.16.1.45', '2022-05-10 13:29:51', 'logout');
INSERT INTO `user_activities` VALUES ('50', '1', '172.16.1.45', '2022-05-10 18:02:47', 'login');
INSERT INTO `user_activities` VALUES ('51', '1', '172.16.1.45', '2022-05-10 18:21:34', 'logout');
INSERT INTO `user_activities` VALUES ('52', '9', '172.16.1.45', '2022-05-10 21:50:47', 'login');
INSERT INTO `user_activities` VALUES ('53', '9', '172.16.1.45', '2022-05-10 21:58:43', 'login');
INSERT INTO `user_activities` VALUES ('54', '9', '172.16.1.45', '2022-05-10 21:58:49', 'login');
INSERT INTO `user_activities` VALUES ('55', '9', '172.16.1.45', '2022-05-10 21:59:09', 'login');
INSERT INTO `user_activities` VALUES ('56', '9', '172.16.1.45', '2022-05-10 22:01:31', 'login');
INSERT INTO `user_activities` VALUES ('57', '9', '172.16.1.45', '2022-05-10 22:04:00', 'logout');
INSERT INTO `user_activities` VALUES ('58', '9', '172.16.1.45', '2022-05-10 22:04:07', 'login');
INSERT INTO `user_activities` VALUES ('59', '9', '172.16.1.45', '2022-05-10 22:04:51', 'logout');
INSERT INTO `user_activities` VALUES ('60', '9', '172.16.1.45', '2022-05-10 22:04:57', 'login');
INSERT INTO `user_activities` VALUES ('61', '9', '172.16.1.45', '2022-05-10 22:11:41', 'logout');
INSERT INTO `user_activities` VALUES ('62', '9', '172.16.1.45', '2022-05-10 22:19:07', 'login');
INSERT INTO `user_activities` VALUES ('63', '9', '172.16.1.45', '2022-05-10 22:25:01', 'submit');
INSERT INTO `user_activities` VALUES ('64', '9', '172.16.1.45', '2022-05-10 22:28:05', 'logout');
INSERT INTO `user_activities` VALUES ('65', '9', '172.16.1.45', '2022-05-10 22:28:11', 'login');
INSERT INTO `user_activities` VALUES ('66', '9', '172.16.1.45', '2022-05-10 22:30:35', 'logout');
INSERT INTO `user_activities` VALUES ('67', '9', '172.16.1.45', '2022-05-10 22:30:42', 'login');
INSERT INTO `user_activities` VALUES ('68', '9', '172.16.1.45', '2022-05-10 22:31:14', 'logout');
INSERT INTO `user_activities` VALUES ('69', '9', '172.16.1.45', '2022-05-10 22:31:20', 'login');
INSERT INTO `user_activities` VALUES ('70', '9', '172.16.1.45', '2022-05-10 22:35:25', 'logout');
INSERT INTO `user_activities` VALUES ('71', '9', '172.16.1.45', '2022-05-10 22:35:49', 'login');
INSERT INTO `user_activities` VALUES ('72', '9', '172.16.1.45', '2022-05-10 22:36:12', 'logout');
INSERT INTO `user_activities` VALUES ('73', '9', '172.16.1.45', '2022-05-10 22:36:18', 'login');
INSERT INTO `user_activities` VALUES ('74', '9', '172.16.1.45', '2022-05-10 22:39:36', 'submit');
INSERT INTO `user_activities` VALUES ('75', '9', '172.16.1.45', '2022-05-10 22:50:07', 'login');
INSERT INTO `user_activities` VALUES ('76', '9', '172.16.1.45', '2022-05-10 23:24:38', 'login');
INSERT INTO `user_activities` VALUES ('77', '9', '172.16.1.45', '2022-05-10 23:36:18', 'authorise');
INSERT INTO `user_activities` VALUES ('78', '9', '172.16.1.45', '2022-05-10 23:36:45', 'submit');
INSERT INTO `user_activities` VALUES ('79', '9', '172.16.1.45', '2022-05-10 23:38:31', 'logout');
INSERT INTO `user_activities` VALUES ('80', '10', '172.16.1.45', '2022-05-10 23:41:33', 'login');
INSERT INTO `user_activities` VALUES ('81', '10', '172.16.1.45', '2022-05-10 23:41:38', 'logout');
INSERT INTO `user_activities` VALUES ('82', '9', '172.16.1.45', '2022-05-10 23:41:46', 'login');
INSERT INTO `user_activities` VALUES ('83', '9', '172.16.1.45', '2022-05-10 23:41:55', 'logout');
INSERT INTO `user_activities` VALUES ('84', '9', '172.16.1.45', '2022-05-11 07:55:18', 'login');
INSERT INTO `user_activities` VALUES ('85', '1', '172.16.1.45', '2022-05-12 03:53:51', 'login');
INSERT INTO `user_activities` VALUES ('86', '9', '172.16.1.45', '2022-05-12 04:04:15', 'login');
INSERT INTO `user_activities` VALUES ('87', '9', '172.16.1.45', '2022-05-12 08:18:57', 'login');
INSERT INTO `user_activities` VALUES ('88', '9', '172.16.1.45', '2022-05-12 11:04:07', 'login');
INSERT INTO `user_activities` VALUES ('89', '9', '172.16.1.45', '2022-05-12 11:04:42', 'submit');
INSERT INTO `user_activities` VALUES ('90', '9', '172.16.1.45', '2022-05-12 11:05:10', 'submit');
INSERT INTO `user_activities` VALUES ('91', '9', '172.16.1.45', '2022-05-12 11:06:15', 'submit');
INSERT INTO `user_activities` VALUES ('92', '9', '172.16.1.45', '2022-05-12 11:16:40', 'login');
INSERT INTO `user_activities` VALUES ('93', '9', '172.16.1.45', '2022-05-12 11:16:51', 'submit');
INSERT INTO `user_activities` VALUES ('94', '9', '172.16.1.45', '2022-05-12 21:37:23', 'login');
INSERT INTO `user_activities` VALUES ('95', '9', '172.16.1.45', '2022-05-12 21:37:47', 'authorise');
INSERT INTO `user_activities` VALUES ('96', '9', '172.16.1.45', '2022-05-13 07:38:01', 'login');
INSERT INTO `user_activities` VALUES ('97', '9', '172.16.1.45', '2022-05-18 22:17:34', 'login');
INSERT INTO `user_activities` VALUES ('98', '9', '172.16.1.45', '2022-05-19 07:46:25', 'login');
INSERT INTO `user_activities` VALUES ('99', '9', '172.16.1.45', '2022-05-19 07:52:22', 'login');
INSERT INTO `user_activities` VALUES ('100', '9', '172.16.1.45', '2022-05-19 08:31:37', 'login');
INSERT INTO `user_activities` VALUES ('101', '9', '172.16.1.45', '2022-05-19 08:39:57', 'submit');
INSERT INTO `user_activities` VALUES ('102', '9', '172.16.1.45', '2022-05-19 08:41:07', 'logout');
INSERT INTO `user_activities` VALUES ('103', '9', '172.16.1.45', '2022-05-19 08:41:13', 'login');
INSERT INTO `user_activities` VALUES ('104', '9', '172.16.1.45', '2022-05-19 08:41:35', 'logout');
INSERT INTO `user_activities` VALUES ('105', '9', '172.16.1.45', '2022-05-19 08:41:42', 'login');
INSERT INTO `user_activities` VALUES ('106', '9', '172.16.1.45', '2022-05-19 08:46:38', 'submit');
INSERT INTO `user_activities` VALUES ('107', '1', '172.16.1.45', '2022-05-20 07:09:31', 'login');
INSERT INTO `user_activities` VALUES ('108', '1', '172.16.1.45', '2022-05-20 07:22:52', 'login');
INSERT INTO `user_activities` VALUES ('109', '1', '172.16.1.45', '2022-05-20 07:29:06', 'login');
INSERT INTO `user_activities` VALUES ('110', '1', '172.16.1.45', '2022-05-20 08:43:50', 'login');
INSERT INTO `user_activities` VALUES ('111', '1', '172.16.1.45', '2022-05-20 08:44:21', 'logout');
INSERT INTO `user_activities` VALUES ('112', '9', '172.16.1.45', '2022-05-20 08:44:30', 'login');
INSERT INTO `user_activities` VALUES ('113', '9', '172.16.1.45', '2022-05-20 08:49:27', 'authorise');
INSERT INTO `user_activities` VALUES ('114', '9', '172.16.1.45', '2022-06-01 04:22:13', 'login');
INSERT INTO `user_activities` VALUES ('115', '9', '172.16.1.45', '2022-06-01 04:54:40', 'login');
INSERT INTO `user_activities` VALUES ('116', '1', '172.16.1.45', '2022-06-13 21:55:51', 'login');
INSERT INTO `user_activities` VALUES ('117', '1', '172.16.1.45', '2022-06-13 22:03:28', 'login');
INSERT INTO `user_activities` VALUES ('118', '9', '172.16.1.45', '2022-06-13 22:12:24', 'login');
INSERT INTO `user_activities` VALUES ('119', '9', '172.16.1.45', '2022-06-13 22:35:16', 'login');
INSERT INTO `user_activities` VALUES ('120', '9', '172.16.1.45', '2022-06-13 22:48:00', 'login');
INSERT INTO `user_activities` VALUES ('121', '1', '172.16.1.45', '2022-06-13 23:09:00', 'login');
INSERT INTO `user_activities` VALUES ('122', '1', '172.16.1.45', '2022-06-13 23:10:32', 'logout');
INSERT INTO `user_activities` VALUES ('123', '1', '172.16.1.45', '2022-06-14 10:39:05', 'login');
INSERT INTO `user_activities` VALUES ('124', '1', '172.16.1.45', '2022-06-14 10:56:48', 'logout');
INSERT INTO `user_activities` VALUES ('125', '1', '172.16.1.45', '2022-06-14 11:10:38', 'login');
INSERT INTO `user_activities` VALUES ('126', '1', '172.16.1.45', '2022-06-14 11:36:46', 'login');
INSERT INTO `user_activities` VALUES ('127', '1', '172.16.1.45', '2022-06-14 11:42:02', 'logout');
INSERT INTO `user_activities` VALUES ('128', '1', '172.16.1.45', '2022-06-14 11:49:25', 'login');
INSERT INTO `user_activities` VALUES ('129', '1', '172.16.1.45', '2022-06-14 11:56:48', 'logout');
INSERT INTO `user_activities` VALUES ('130', '1', '172.16.1.45', '2022-06-14 11:57:45', 'login');
INSERT INTO `user_activities` VALUES ('131', '1', '172.16.1.45', '2022-06-14 12:06:50', 'logout');
INSERT INTO `user_activities` VALUES ('132', '9', '172.16.1.45', '2022-06-14 12:07:59', 'login');
INSERT INTO `user_activities` VALUES ('133', '9', '172.16.1.45', '2022-06-14 12:12:28', 'logout');
INSERT INTO `user_activities` VALUES ('134', '1', '172.16.1.45', '2022-06-14 12:12:33', 'login');
INSERT INTO `user_activities` VALUES ('135', '1', '172.16.1.45', '2022-06-14 12:12:43', 'logout');
INSERT INTO `user_activities` VALUES ('136', '9', '172.16.1.45', '2022-06-14 12:15:36', 'login');
INSERT INTO `user_activities` VALUES ('137', '9', '172.16.1.45', '2022-06-14 12:30:32', 'logout');
INSERT INTO `user_activities` VALUES ('138', '9', '172.16.1.45', '2022-06-17 22:22:07', 'login');
INSERT INTO `user_activities` VALUES ('139', '9', '172.16.1.45', '2022-06-17 22:49:00', 'login');
INSERT INTO `user_activities` VALUES ('140', '9', '172.16.1.45', '2022-06-17 22:53:31', 'authorise');
INSERT INTO `user_activities` VALUES ('141', '9', '172.16.1.45', '2022-06-17 23:17:49', 'login');
INSERT INTO `user_activities` VALUES ('142', '9', '172.16.1.45', '2022-06-17 23:18:11', 'submit');
INSERT INTO `user_activities` VALUES ('143', '9', '172.16.1.45', '2022-06-17 23:19:22', 'logout');
INSERT INTO `user_activities` VALUES ('144', '1', '172.16.1.45', '2022-06-17 23:19:26', 'login');
INSERT INTO `user_activities` VALUES ('145', '1', '172.16.1.45', '2022-06-17 23:19:57', 'logout');
INSERT INTO `user_activities` VALUES ('146', '9', '172.16.1.45', '2022-06-17 23:20:03', 'login');
INSERT INTO `user_activities` VALUES ('147', '9', '172.16.1.45', '2022-06-17 23:22:31', 'submit');
INSERT INTO `user_activities` VALUES ('148', '9', '172.16.1.45', '2022-06-17 23:24:10', 'submit');
INSERT INTO `user_activities` VALUES ('149', '9', '172.16.1.45', '2022-06-18 00:14:05', 'login');
INSERT INTO `user_activities` VALUES ('150', '9', '172.16.1.45', '2022-06-18 00:18:31', 'submit');
INSERT INTO `user_activities` VALUES ('151', '9', '172.16.1.45', '2022-06-18 00:22:07', 'submit');
INSERT INTO `user_activities` VALUES ('152', '9', '172.16.1.45', '2022-06-18 03:18:50', 'login');
INSERT INTO `user_activities` VALUES ('153', '9', '172.16.1.45', '2022-06-18 03:23:17', 'logout');
INSERT INTO `user_activities` VALUES ('154', '9', '172.16.1.45', '2022-06-18 03:23:50', 'login');
INSERT INTO `user_activities` VALUES ('155', '9', '172.16.1.45', '2022-06-18 03:24:11', 'logout');
INSERT INTO `user_activities` VALUES ('156', '9', '172.16.1.45', '2022-06-18 03:24:54', 'login');
INSERT INTO `user_activities` VALUES ('157', '9', '172.16.1.45', '2022-06-18 03:25:05', 'logout');
INSERT INTO `user_activities` VALUES ('158', '9', '172.16.1.45', '2022-06-18 03:25:15', 'login');
INSERT INTO `user_activities` VALUES ('159', '9', '172.16.1.45', '2022-06-18 03:26:08', 'logout');
INSERT INTO `user_activities` VALUES ('160', '9', '172.16.1.45', '2022-06-18 03:27:37', 'login');
INSERT INTO `user_activities` VALUES ('161', '9', '172.16.1.45', '2022-06-18 03:32:09', 'logout');
INSERT INTO `user_activities` VALUES ('162', '1', '172.16.1.45', '2022-06-18 03:32:13', 'login');
INSERT INTO `user_activities` VALUES ('163', '1', '172.16.1.45', '2022-06-18 03:41:11', 'login');
INSERT INTO `user_activities` VALUES ('164', '1', '172.16.1.45', '2022-06-18 03:59:05', 'logout');
INSERT INTO `user_activities` VALUES ('165', '1', '172.16.1.45', '2022-06-18 04:04:36', 'login');
INSERT INTO `user_activities` VALUES ('166', '1', '172.16.1.45', '2022-06-18 04:10:38', 'login');
INSERT INTO `user_activities` VALUES ('167', '1', '172.16.1.45', '2022-06-18 04:20:24', 'logout');
INSERT INTO `user_activities` VALUES ('168', '1', '172.16.1.45', '2022-06-18 04:31:48', 'login');
INSERT INTO `user_activities` VALUES ('169', '1', '172.16.1.45', '2022-06-18 04:38:55', 'login');
INSERT INTO `user_activities` VALUES ('170', '1', '172.16.1.45', '2022-06-18 04:45:25', 'logout');
INSERT INTO `user_activities` VALUES ('171', '1', '172.16.1.45', '2022-06-18 04:48:56', 'login');
INSERT INTO `user_activities` VALUES ('172', '1', '172.16.1.45', '2022-06-18 04:50:02', 'logout');
INSERT INTO `user_activities` VALUES ('173', '4', '172.16.1.45', '2022-06-18 04:50:53', 'login');
INSERT INTO `user_activities` VALUES ('174', '4', '172.16.1.45', '2022-06-18 04:50:59', 'logout');
INSERT INTO `user_activities` VALUES ('175', '1', '172.16.1.45', '2022-06-18 04:51:03', 'login');
INSERT INTO `user_activities` VALUES ('176', '1', '172.16.1.45', '2022-06-18 04:59:18', 'logout');
INSERT INTO `user_activities` VALUES ('177', '1', '172.16.1.45', '2022-06-18 05:05:13', 'login');
INSERT INTO `user_activities` VALUES ('178', '1', '172.16.1.45', '2022-06-18 05:07:51', 'logout');
INSERT INTO `user_activities` VALUES ('179', '9', '172.16.1.45', '2022-06-18 05:07:55', 'login');
INSERT INTO `user_activities` VALUES ('180', '9', '172.16.1.45', '2022-06-18 05:16:03', 'submit');
INSERT INTO `user_activities` VALUES ('181', '9', '172.16.1.45', '2022-06-18 05:25:21', 'login');
INSERT INTO `user_activities` VALUES ('182', '9', '172.16.1.45', '2022-06-18 05:45:49', 'logout');
INSERT INTO `user_activities` VALUES ('183', '9', '172.16.1.45', '2022-06-18 05:46:53', 'login');
INSERT INTO `user_activities` VALUES ('184', '9', '172.16.1.45', '2022-06-18 05:48:38', 'authorise');
INSERT INTO `user_activities` VALUES ('185', '9', '172.16.1.45', '2022-06-18 05:48:44', 'submit');
INSERT INTO `user_activities` VALUES ('186', '9', '172.16.1.45', '2022-06-18 05:50:37', 'authorise');
INSERT INTO `user_activities` VALUES ('187', '9', '172.16.1.45', '2022-06-18 05:50:47', 'submit');
INSERT INTO `user_activities` VALUES ('188', '9', '172.16.1.45', '2022-06-18 05:51:21', 'authorise');
INSERT INTO `user_activities` VALUES ('189', '9', '172.16.1.45', '2022-06-18 05:51:25', 'submit');
INSERT INTO `user_activities` VALUES ('190', '9', '172.16.1.45', '2022-06-18 06:01:56', 'logout');
INSERT INTO `user_activities` VALUES ('191', '1', '172.16.1.45', '2022-06-18 06:05:29', 'login');
INSERT INTO `user_activities` VALUES ('192', '1', '172.16.1.45', '2022-06-18 06:22:40', 'login');
INSERT INTO `user_activities` VALUES ('193', '1', '172.16.1.45', '2022-06-18 06:23:36', 'logout');
INSERT INTO `user_activities` VALUES ('194', '10', '172.16.1.45', '2022-06-18 06:30:31', 'login');
INSERT INTO `user_activities` VALUES ('195', '10', '172.16.1.45', '2022-06-18 06:30:36', 'logout');

-- ----------------------------
-- Table structure for `user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES ('1', 'admin');
INSERT INTO `user_roles` VALUES ('2', 'supervisor');
INSERT INTO `user_roles` VALUES ('3', 'authoriser');
INSERT INTO `user_roles` VALUES ('4', 'uploader');
INSERT INTO `user_roles` VALUES ('5', 'new role1');
INSERT INTO `user_roles` VALUES ('6', 'role2');
INSERT INTO `user_roles` VALUES ('7', 'we');
INSERT INTO `user_roles` VALUES ('8', 'www');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL COMMENT '1=>admin, 2=>supervisor, 3=>authoriser, 4=>uploader',
  `department_id` int(11) DEFAULT NULL,
  `comments` text,
  `status` varchar(10) DEFAULT NULL COMMENT '51=>active, 50=>deactive',
  `reset_password` tinyint(4) DEFAULT NULL COMMENT '1=>yes, 0=>no',
  `reset_token` varchar(255) DEFAULT NULL,
  `login_status` tinyint(4) DEFAULT NULL COMMENT '1=>login now',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 'user 1', 'jay@email.com', '1', '1', 'asdfawer\nasdfwer\nwerwer', 'active', '1', null, '0');
INSERT INTO `users` VALUES ('2', 'rwer', null, 'werw', 'erwe', '2', '2', 'werasdf', '51', null, null, null);
INSERT INTO `users` VALUES ('3', 'we', null, 'we', 'wer', '', '2', 'asdf', '51', null, null, null);
INSERT INTO `users` VALUES ('4', 'wer2', '*06C0BF5B64ECE2F648B5F048A71903906BA08E5C', 'wer2', 'werwer!!222', '4', '5', 'asdfwer2222', 'active', '1', null, '0');
INSERT INTO `users` VALUES ('5', 'werwer1', null, 'wer1', '123123@234234', '2,3', '6', 'asdfwer11111', '0', null, null, null);
INSERT INTO `users` VALUES ('6', 'wewe__', null, 'wer__', 'rwer111__', '4', '6', 'werwer___', '0', null, null, null);
INSERT INTO `users` VALUES ('7', 'test1', null, 'test', 'test12', '4', '1', 'asdfasdf', '0', null, null, null);
INSERT INTO `users` VALUES ('8', 'jay13', '', 'jay1212', 'jau', '2', '1', '', 'active', null, null, null);
INSERT INTO `users` VALUES ('9', 'jay1', '*06C0BF5B64ECE2F648B5F048A71903906BA08E5C', 'jay1212', 'jaygangkun@hotmail.com1', '2', '1', '', 'active', '1', '', '0');
INSERT INTO `users` VALUES ('10', 'jay2', '*BC875279CA91B6EC7CB9573F396FEE2EEBF2967D', 'jay1212', 'jaygangkun@hotmail.com', '2,8', '1', '', '0', '1', '', '0');
INSERT INTO `users` VALUES ('12', 'jay16', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'asdwer', 'jau', '', '2', '', '0', null, null, null);
INSERT INTO `users` VALUES ('13', 'jay17', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'asdwer', 'jau1', '', '2', '', '0', null, null, null);
INSERT INTO `users` VALUES ('15', 'qwe', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', '', 'qwe', '', '4', '', '0', null, null, null);
INSERT INTO `users` VALUES ('16', '', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'we', 'wer', '', '6', '', '0', null, null, null);
INSERT INTO `users` VALUES ('17', 'aaa', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'we', 'werwe@adwe', '', '0', '', '', null, null, null);
