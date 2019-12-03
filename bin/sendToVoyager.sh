#!/bin/bash
LOGDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"/../logs/exports
VOYAGERSERVER=voy-db-dev-02.cssd.pitt.edu
if [ `hostname` == 'voy-staff-01.library.pitt.edu' ]
then
	VOYAGERSERVER=voy-db-prod-02.cssd.pitt.edu
fi
for f in $LOGDIR/*.*
do
	if [ -e $f ]
	then
		scp -q $f voyager@$VOYAGERSERVER:/m1/incoming/eisi_dmg/pittlcsu/stage/
		if [ $? == 0 ]
		then
			rm -f $f
		else
			>& echo "scp returned $? for "$f
		fi
	fi
done
