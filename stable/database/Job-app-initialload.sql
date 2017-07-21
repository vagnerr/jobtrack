# $Id: Job-app-initialload.sql,v 1.1.1.1 2003/06/02 21:34:59 vagnerr Exp $ 

# Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
# This code is protected under the Gnu Public License (See LICENSE).


# MySQL dump 8.16
#
# Host: localhost    Database: JOBAPPLICATIONS
#--------------------------------------------------------
# Server version	3.23.47

#
# Table structure for table 'AGENCY'
#

CREATE TABLE AGENCY (
  ID int(11) NOT NULL auto_increment,
  Name varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'AGENCY'
#

INSERT INTO AGENCY VALUES (0,'');
UPDATE AGENCY SET ID=0;

#
# Table structure for table 'AGENCYCONTACT_LNK'
#

CREATE TABLE AGENCYCONTACT_LNK (
  ID int(11) NOT NULL auto_increment,
  Agency_ID int(11) NOT NULL default '0',
  ContactType_ID int(11) NOT NULL default '0',
  Data varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'AGENCYCONTACT_LNK'
#


#
# Table structure for table 'AGENT'
#

CREATE TABLE AGENT (
  ID int(11) NOT NULL auto_increment,
  Agency_ID int(11) NOT NULL default '0',
  Name varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'AGENT'
#

INSERT INTO AGENT VALUES (0,0,'');
UPDATE AGENT SET ID=0;

#
# Table structure for table 'AGENTCONTACT_LNK'
#

CREATE TABLE AGENTCONTACT_LNK (
  ID int(11) NOT NULL auto_increment,
  Agent_ID int(11) NOT NULL default '0',
  ContactType_ID int(11) NOT NULL default '0',
  Data varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'AGENTCONTACT_LNK'
#

#
# Table structure for table 'COMPANY'
#

CREATE TABLE COMPANY (
  ID int(11) NOT NULL auto_increment,
  Name varchar(100) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'COMPANY'
#

INSERT INTO COMPANY VALUES (0,'');
UPDATE COMPANY SET ID=0;

#
# Table structure for table 'COMPANYCONTACT_LNK'
#

CREATE TABLE COMPANYCONTACT_LNK (
  Company_ID int(11) NOT NULL default '0',
  ContactType_ID int(11) NOT NULL default '0',
  ID int(11) NOT NULL auto_increment,
  Data varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'COMPANYCONTACT_LNK'
#

#
# Table structure for table 'CONTACTTYPE_CONST'
#

CREATE TABLE CONTACTTYPE_CONST (
  ID int(11) NOT NULL auto_increment,
  Keyword varchar(10) NOT NULL default '',
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'CONTACTTYPE_CONST'
#

INSERT INTO CONTACTTYPE_CONST VALUES (1,'PHONE','Telephone');
INSERT INTO CONTACTTYPE_CONST VALUES (2,'PHONEDL','Direct Line');
INSERT INTO CONTACTTYPE_CONST VALUES (3,'FAX','Fax Number');
INSERT INTO CONTACTTYPE_CONST VALUES (4,'EMAIL','EMail Address');
INSERT INTO CONTACTTYPE_CONST VALUES (5,'ADDRESS','Address');
INSERT INTO CONTACTTYPE_CONST VALUES (6,'URL','Web Address');

#
# Table structure for table 'JOB'
#

CREATE TABLE JOB (
  ID int(11) NOT NULL auto_increment,
  DateAdded datetime NOT NULL,
  Reference varchar(100) default NULL,
  DateLastChanged datetime NOT NULL default '0000-00-00 00:00:00',
  DateToCheck date default NULL,
  NextAction_ID int(11) default NULL,
  JobTitle varchar(100) NOT NULL default '',
  DateOfInterview datetime default NULL,
  Company_ID int(11) default NULL,
  Location_ID int(11) NOT NULL default '0',
  Agency_ID int(11) default NULL,
  Type_ID int(11) NOT NULL default '0',
  Salary varchar(100) default NULL,
  Source_ID int(11) NOT NULL default '0',
  Status_ID int(11) NOT NULL default '0',
  Fake tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'JOB'
#

#
# Table structure for table 'JOBAGENT_LNK'
#

CREATE TABLE JOBAGENT_LNK (
  ID int(11) NOT NULL auto_increment,
  Job_ID int(11) NOT NULL default '0',
  Agent_ID int(11) NOT NULL default '0',
  PrimaryAgent tinyint(1) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'JOBAGENT_LNK'
#


#
# Table structure for table 'JOBDATA'
#

CREATE TABLE JOBDATA (
  ID int(11) NOT NULL auto_increment,
  Job_ID int(11) NOT NULL default '0',
  JobDataType_ID int(11) NOT NULL default '0',
  Description varchar(100) NOT NULL default '',
  Data mediumblob NOT NULL,
  FileName varchar(100) default NULL,
  FileSize int(11) default NULL,
  FileType varchar(20) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'JOBDATA'
#


#
# Table structure for table 'JOBDATATYPE_CONST'
#

CREATE TABLE JOBDATATYPE_CONST (
  ID int(11) NOT NULL auto_increment,
  Keyword varchar(10) NOT NULL default '',
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'JOBDATATYPE_CONST'
#

INSERT INTO JOBDATATYPE_CONST VALUES (1,'HTML','HTML File');
INSERT INTO JOBDATATYPE_CONST VALUES (2,'TEXT','Text');
INSERT INTO JOBDATATYPE_CONST VALUES (3,'EMAIL','Text Email Message');
INSERT INTO JOBDATATYPE_CONST VALUES (4,'IMAGE','Image');
INSERT INTO JOBDATATYPE_CONST VALUES (5,'DOC','Word Document');
INSERT INTO JOBDATATYPE_CONST VALUES (6,'BINARY','Other Binary File');

#
# Table structure for table 'JOBNOTES'
#

CREATE TABLE JOBNOTES (
  ID int(11) NOT NULL auto_increment,
  Job_ID int(11) NOT NULL default '0',
  Agent_ID int(11) default NULL,
  AddDate timestamp(14) NOT NULL,
  Data text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'JOBNOTES'
#


#
# Table structure for table 'JOBRELATED_LNK'
#

CREATE TABLE JOBRELATED_LNK (
  ID int(11) NOT NULL auto_increment,
  Parent_ID int(11) NOT NULL default '0',
  Child_ID int(11) NOT NULL default '0',
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'JOBRELATED_LNK'
#


#
# Table structure for table 'KEYWORD_CONST'
#

CREATE TABLE KEYWORD_CONST (
  ID int(11) NOT NULL auto_increment,
  Keyword varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'KEYWORD_CONST'
#


#
# Table structure for table 'KEYWORD_LNK'
#

CREATE TABLE KEYWORD_LNK (
  ID int(11) NOT NULL auto_increment,
  Job_ID int(11) NOT NULL default '0',
  Keyword_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'KEYWORD_LNK'
#


#
# Table structure for table 'LOCATION_CONST'
#

CREATE TABLE LOCATION_CONST (
  ID int(11) NOT NULL auto_increment,
  Value varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'LOCATION_CONST'
#

INSERT INTO LOCATION_CONST VALUES (0,'');
UPDATE LOCATION_CONST SET ID=0;
INSERT INTO LOCATION_CONST VALUES (1,'Cambridge');
INSERT INTO LOCATION_CONST VALUES (2,'Cambridgeshire');
INSERT INTO LOCATION_CONST VALUES (3,'London');
INSERT INTO LOCATION_CONST VALUES (4,'City');

#
# Table structure for table 'NEXTACTION_CONST'
#

CREATE TABLE NEXTACTION_CONST (
  ID int(11) NOT NULL auto_increment,
  Keyword varchar(10) NOT NULL default '',
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'NEXTACTION_CONST'
#

INSERT INTO NEXTACTION_CONST VALUES (1,'NONE','Do Nothing');
INSERT INTO NEXTACTION_CONST VALUES (2,'CALL','Call');
INSERT INTO NEXTACTION_CONST VALUES (3,'EMAIL','EMail');
INSERT INTO NEXTACTION_CONST VALUES (4,'CHECK','Check Status');
INSERT INTO NEXTACTION_CONST VALUES (5,'POST','Write to them');
INSERT INTO NEXTACTION_CONST VALUES (6,'CLOSE','Close Job');

#
# Table structure for table 'SOURCE_CONST'
#

CREATE TABLE SOURCE_CONST (
  ID int(11) NOT NULL auto_increment,
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'SOURCE_CONST'
#

INSERT INTO SOURCE_CONST VALUES (0,'');
UPDATE SOURCE_CONST SET ID=0;

#
# Table structure for table 'STATUS_CONST'
#

CREATE TABLE STATUS_CONST (
  ID int(11) NOT NULL auto_increment,
  Keyword varchar(10) NOT NULL default '',
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'STATUS_CONST'
#

INSERT INTO STATUS_CONST VALUES (1,'OPEN','Open');
INSERT INTO STATUS_CONST VALUES (2,'HOLD','On Hold');
INSERT INTO STATUS_CONST VALUES (3,'NORESP','Closed - No response');
INSERT INTO STATUS_CONST VALUES (4,'REJECTED','Closed - Rejected');
INSERT INTO STATUS_CONST VALUES (5,'CLOSED','Closed - Other');
INSERT INTO STATUS_CONST VALUES (6,'NOVAC','Closed - No Vacancies');

#
# Table structure for table 'TYPE_CONST'
#

CREATE TABLE TYPE_CONST (
  ID int(11) NOT NULL auto_increment,
  Keyword varchar(10) NOT NULL default '',
  Description varchar(100) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'TYPE_CONST'
#

INSERT INTO TYPE_CONST VALUES (1,'PERM','Permanent');
INSERT INTO TYPE_CONST VALUES (2,'CONTRACT','Contract');
INSERT INTO TYPE_CONST VALUES (3,'PART','Part Time');

