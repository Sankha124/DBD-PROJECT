# CS6378_Project2
Team: Travious Lewis and Sankhadeep Dutta

This project based on the project here -> https://github.com/swairshah/LamportMutex

** Note: the scripts are designed to work with my information for the dc systems and on my file system. The project directories and information for the dc systems in the scripts will need to be updated to work for another user.

** Note: The scripts were all only tested and run in a Linux environment. If shell scripts aren't executable, run 'chmod 755 <shell_script>' on them.

Test for Correctness:

To test for correctness of the algorithm, view the Testing Server terminal that appears when running the program (first terminal that is spawned). The Testing Server keeps track of everytime a node enters its critical section, and prints out the current nodes in the critical section. Each time the state is printed, an array of length n (n = # nodes) is shown. A '0' in the n-th place means node n is not in its critical section and a '1' means node n is in its critical section. You will see that no two nodes are ever in critical section at once. This implementation is confirmed to be correct by also keeping track of the total critical section runs. Once all nodes have fulfilled all their requests, the nodes terminate but the Testing Server stays up until cleanup script is run to view the testing results.

Compile:

To compile the program, use the recompile.sh script.

$ ./recompile.sh

This will compile both the algorithm and testing server on the dc machines.


Run:

To run the program, use the launcher.sh script.

$ ./launcher.sh

This will run the program based on the parameters in the chosen config file. There are 3 different config files for this project: config.txt, config2.txt, and config3.txt. Update the value for the config file in the launcher.sh script to choose a different configuration.


Cleanup:

To cleanup the program, use the cleanup.sh script.

$ ./cleanup.sh

This will make sure the nodes and testing server are stopped on the dc machines that were hosting them. This script will close all terminals that were opened to run the program.
