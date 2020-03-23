#!/bin/bash
BINDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
LOGFILE=$BINDIR/../logs/exports/lcsu-trays-`date +%Y%m%d-%H%M`.txt
/usr/bin/php $BINDIR/cake.php Export > $LOGFILE
if [ ! -s $LOGFILE ]
then
	rm $LOGFILE
fi
