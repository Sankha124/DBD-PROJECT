#!/bin/bash

# Change this to your netid
netid=tdl190000

# Root directory of your project
PROJDIR=/home/trey/Documents/CS6378_Project2

# Directory where the config file is located on your local system
CONFIGLOCAL=$PROJDIR/config3.txt

# Directory your java classes are in
BINDIR=$PROJDIR/src

# Your main project class
PROG=Node

n=0

cat $CONFIGLOCAL | sed -e "s/#.*//" | sed -e "/^\s*$/d" |
(
    read line
    i=$( echo $line | awk '{ print $1 }' )
    ird_mean=$( echo $line | awk '{ print $2 }' )
    ex_mean=$( echo $line | awk '{ print $3 }' )
    num_req=$( echo $line | awk '{ print $4 }' )
    while [[ $n -lt $i ]]
    do
        read line
        nodes[$n]=$( echo $line | awk '{ print $1 }' )
        hosts[$n]=$( echo $line | awk '{ print $2 }' )
        ports[$n]=$( echo $line | awk '{ print $3 }' )
        h_p[$n]="${hosts[$n]}:${ports[$n]}"
        n=$(( n + 1 ))
    done
    n=0
    gnome-terminal -e "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $netid@dc30.utdallas.edu cd CS6378_Project2_TraviousLewis/src; java TestServer 1270 ${i} ${h_p[*]} $num_req"
    while [[ $n -lt $i ]]
    do
	
	gnome-terminal -e "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $netid@${hosts[$n]}.utdallas.edu cd CS6378_Project2_TraviousLewis/src; java $PROG ${nodes[$n]} ${ports[$n]} $i $ird_mean $ex_mean $num_req ${h_p[*]} dc30 1270"

        n=$(( n + 1 ))
    done
    echo \"${h_p[*]}\"
)
