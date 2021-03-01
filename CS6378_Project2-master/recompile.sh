scp -r /home/trey/eclipse-workspace/LampDistMutex/src tdl190000@dc23.utdallas.edu:/home/010/t/td/tdl190000/CS6378_Project2_TraviousLewis
cp -r /home/trey/eclipse-workspace/LampDistMutex/src /home/trey/Documents/CS6378_Project2
gnome-terminal -e "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no tdl190000@dc23.utdallas.edu cd CS6378_Project2_TraviousLewis/src; javac Node.java; javac TestServer.java"

