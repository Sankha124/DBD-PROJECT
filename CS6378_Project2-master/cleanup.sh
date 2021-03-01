#!/bin/bash

netid=tdl190000

PROJDIR=/home/trey/Documents/CS6378_Project2

CONFIGLOCAL=$PROJDIR/config3.txt

n=0

cat $CONFIGLOCAL | sed -e "s/#.*//" | sed -e "/^\s*$/d" |
(
    read line
    i=$( echo $line | awk '{ print $1 }' )

    while [[ $n -lt $i ]]
    do
        read line
        host=$( echo $line | awk '{ print $2 }' )

        gnome-terminal -e "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $netid@$host.utdallas.edu killall -u $netid"

        n=$(( n + 1 ))
    done
    gnome-terminal -e "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $netid@dc30.utdallas.edu killall -u $netid"
)

echo "Cleanup complete"
