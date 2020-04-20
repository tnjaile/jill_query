CREATE TABLE `jill_query` (
  `qsn` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '編號',
  `title` varchar(255) NOT NULL COMMENT '名稱',
  `directions` text NOT NULL COMMENT '說明',
  `editorEmail` text NOT NULL COMMENT '承辦人Email',
  `isEnable` enum('0','1') NOT NULL COMMENT '是否啟用',
  `counter` mediumint(8) unsigned NOT NULL COMMENT '瀏覽人數',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '開設者帳號',
  `passwd` varchar(255) NOT NULL COMMENT '密碼',
  `ispublic` enum('0','1') NOT NULL COMMENT '是否公開',
  `read_group` varchar(255) NOT NULL DEFAULT '[\"2\",\"3\"]' COMMENT '可讀取群組',
  PRIMARY KEY (`qsn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `jill_query_col` (
  `qcsn` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '欄位編號',
  `qsn` int(10) unsigned NOT NULL COMMENT '編號',
  `qc_title` varchar(255) NOT NULL COMMENT '欄位名稱',
  `qcsnSearch` enum('1','0') NOT NULL COMMENT '搜尋欄位',
  `search_operator` varchar(255) NOT NULL DEFAULT 'or' COMMENT '搜尋運算符',
  `isShow` enum('1','0') NOT NULL DEFAULT '1' COMMENT '顯示欄位',
  `qcSort` smallint(6) NOT NULL COMMENT '排序欄位',
  `isLike` enum('0','1') NOT NULL DEFAULT '0' COMMENT '啟用關鍵字查詢',
  PRIMARY KEY (`qcsn`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `jill_query_sn` (
  `ssn` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '資料編號',
  `qsn` int(10) NOT NULL COMMENT '編號',
  `createDate` datetime NOT NULL COMMENT '創建日期',
  `qrSort` smallint(6) NOT NULL COMMENT '列排序欄位',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '匯入者帳號',
  PRIMARY KEY (`ssn`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `jill_query_col_value` (
  `ssn` int(10) NOT NULL COMMENT '資料編號',
  `qcsn` smallint(6) unsigned NOT NULL COMMENT '欄位編號',
  `fillValue` text NOT NULL COMMENT '內容',
  PRIMARY KEY (`ssn`,`qcsn`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

