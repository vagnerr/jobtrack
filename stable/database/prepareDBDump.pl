#!/usr/bin/perl -w
# ======================================================================
# Project:             Job DB
# Project Leader:      Peter Wise
# ----------------------------------------------------------------------
# Program name:        prepareDBData
# Program state:       pre-alpha
# Program notes:       Adds the required updates for the zero ID's
#
# Program filename:    prepareDBData.pl
# ----------------------------------------------------------------------
# Version  Author      Date       Comment
# ~~~~~~~~ ~~~~~~~~~~~ ~~~~~~~~~~ ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
# 1.0      P.J.Wise    19/05/2003 Initial Version
#
# ----------------------------------------------------------------------
# CVS:
#    ID:        $Id: prepareDBDump.pl,v 1.1.1.1 2003/06/02 21:34:59 vagnerr Exp $
#    Author:    $Author: vagnerr $
#    Date:      $Date: 2003/06/02 21:34:59 $
#    Revision:  $Revision: 1.1.1.1 $
#
# Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
# This code is protected under the Gnu Public License (See LICENSE).
# ----------------------------------------------------------------------
# Notes:
# ~~~~~~
# 
# ======================================================================
use strict;

my %matches = (
	"INSERT INTO AGENCY VALUES (0,'');" =>
	"INSERT INTO AGENCY VALUES (0,'');\nUPDATE AGENCY SET ID=0;",
	"INSERT INTO AGENT VALUES (0,0,'');" =>
	"INSERT INTO AGENT VALUES (0,0,'');\nUPDATE AGENT SET ID=0;",
	"INSERT INTO COMPANY VALUES (0,'');" =>
	"INSERT INTO COMPANY VALUES (0,'');\nUPDATE COMPANY SET ID=0;",
	"INSERT INTO LOCATION_CONST VALUES (0,'');" =>
	"INSERT INTO LOCATION_CONST VALUES (0,'');\nUPDATE LOCATION_CONST SET ID=0;",
	"INSERT INTO SOURCE_CONST VALUES (0,'');" =>
	"INSERT INTO SOURCE_CONST VALUES (0,'');\nUPDATE SOURCE_CONST SET ID=0;"
);



my $target = $ARGV[0];

$/ = undef;
open(FILE,"<$target");

my $file = <FILE>;
close FILE;

foreach my $key (keys(%matches)){
	my $replace  = $matches{$key};
	my $esckey = quotemeta($key);
	if($file =~ s/$esckey/$replace/ge){
		print ".\n";
	}
}

open(FILE,">$target");
print FILE $file;
close FILE;


	
