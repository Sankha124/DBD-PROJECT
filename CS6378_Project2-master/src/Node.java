import java.io.*;
import java.util.Random;
import java.net.Socket;
import java.util.HashMap;
import java.util.ArrayList;
import java.util.List;

public class Node implements Runnable {

	private ScalarClock myClock;
	private Mutex mutex;
	private int pid;
	private int port;
	private int numNodes;
	private int ird_mean;
	private int exec_mean;
	private int num_req;
	private int tsPort;
	private String tsHost;
	public boolean inCS;
	private int done;
	private boolean doneSent;

	public final List<Integer> nodes;
	private HashMap<Integer, String> nodeHostIp;

//	private int total_application_msgs = 0;
//	private int total_protocol_msgs = 0;
//	private int count_per_crit = 0;
//	private long delay_per_crit = 0;

	private int csReqs = 0;

	public Node(int pid, int port, int numNodes, int ird_mean, int exec_mean, int num_req, String allNodes,
			String tsHost, int tsPort) {

		this.pid = pid;
		this.port = port;
		this.numNodes = numNodes;
		this.ird_mean = ird_mean;
		this.exec_mean = exec_mean;
		this.num_req = num_req;
		this.tsHost = tsHost;
		this.tsPort = tsPort;
		this.inCS = false;
		this.done = 0;
		this.doneSent = false;
		this.nodeHostIp = new HashMap<Integer, String>();
		this.myClock = new ScalarClock();
		this.mutex = new Mutex(this);
		String[] nodeInfo = allNodes.split(" ");
		this.nodes = new ArrayList<Integer>();
		for (int i = 0; i < numNodes; i++) {
			if (i != this.pid) {
				this.nodes.add(i);
				this.nodeHostIp.put(i, nodeInfo[i]);
			}
		}
	}

	public int getNumNodes() {
		return this.numNodes;
	}

	public int getPid() {
		return this.pid;
	}

	public int getPort() {
		return this.port;
	}

	public int getClock() {
		return this.myClock.getClock();
	}

	public void run_listener() {
		Thread listener = new NodeListener(this);
		listener.start();
	}

	public synchronized void readMsg(Message msg) {
		if (msg.getType().equals("done")) {
			this.done++;
			return;
		}
		// System.out.println(msg+" "+msg.getType()+".from..."+msg.getSender()+" local
		// clock: "+myClock.peek());
		this.myClock.msg_event(msg.getClock());
		// System.out.println("new local clock: "+myClock.peek());
		if (msg.getType().equals("request")) {
//            System.out.println(msg.getType()+".from..."+msg);
			this.mutex.enqueueReq(msg);
//            System.out.println("reply sent to " + msg.getSender());
//            send_message(msg.getSender(),"reply");
		} else if (msg.getType().equals("release")) {
			// this.total_protocol_msgs += 1;
			if (!mutex.dequeueReq(msg))
				System.err.println("Release received from req not at top of queue");
		} else if (msg.getType().equals("reply")) {
//			this.total_protocol_msgs += 1;
			System.out.println(msg.getType() + " from node " + msg);
			mutex.getReply(msg);
		}
	}

	public synchronized void sendMsg(int dest, String type, Message msg) {
		if (type.equals("reply")) {
			this.myClock.event();
		}

		if (type.equals("application")) {
//			this.total_application_msgs += 1;
		} else {
			if (this.pid != dest) {
//				if (!type.equals("reply"))
//					this.total_protocol_msgs += 1;
			}
		}

		String[] rcv_host_ip = this.nodeHostIp.get(dest).split(":");
		String rcv_host = rcv_host_ip[0];
		int rcv_port = Integer.parseInt(rcv_host_ip[1]);

		try (Socket sock = new Socket(rcv_host + ".utdallas.edu", rcv_port)) {
			OutputStream out = sock.getOutputStream();
			ObjectOutputStream outstream = new ObjectOutputStream(out);
			outstream.writeObject(msg);
			outstream.close();
			out.close();
			sock.close();
		} catch (IOException e) {
			System.err.println("failed to send message" + e);
		}
	}

	public synchronized void bc(String type) {
		this.myClock.event();

		Message msg = new Message.MessageBuilder().from(this.pid).clock(this.myClock.getClock()).type(type).build();

		for (int pid : this.nodes) {
			msg.setReceiver(pid);
			sendMsg(pid, type, msg);
		}
	}

	private synchronized void execute_crit() {
		this.inCS = true;
		Message mg = new Message.MessageBuilder().from(this.pid).ping(this.inCS).type("in").build();
		// send pingback msg
		try (Socket sock = new Socket(this.tsHost + ".utdallas.edu", this.tsPort)) {
			OutputStream out = sock.getOutputStream();
			ObjectOutputStream outstream = new ObjectOutputStream(out);
			outstream.writeObject(mg);
			outstream.close();
			out.close();
			sock.close();
		} catch (IOException e) {
			System.err.println("failed to send msg to TestServer " + e);
		}
		System.out.println("executing crit");
		long stopTime = System.currentTimeMillis() + this.exec_mean;
		while (System.currentTimeMillis() < stopTime)
			;
		this.inCS = false;
		mg.setType("out");
		try (Socket sock = new Socket(this.tsHost + ".utdallas.edu", this.tsPort)) {
			OutputStream out = sock.getOutputStream();
			ObjectOutputStream outstream = new ObjectOutputStream(out);
			outstream.writeObject(mg);
			outstream.close();
			out.close();
			sock.close();
		} catch (IOException e) {
			System.err.println("failed to send msg to TestServer " + e);
		}
	}

	@Override
	public void run() {

		this.run_listener();
		// wait for all processes to spawn
		try {
			Thread.sleep(5000);
		} catch (InterruptedException e) {
		}

		while (true) {
			Random randVal = new Random();
			int wait = randVal.nextInt(100) + 10;

			try {
				Thread.sleep(wait * 10);
			} catch (InterruptedException e) {
			}

			int x = randVal.nextInt(100);

			if (this.csReqs >= this.num_req) {
				System.out.println("Max number of requests reached.");
				if (!this.doneSent) {
					bc("done");
					this.done++;
					this.doneSent = true;
				}
				if (this.done >= this.numNodes)
					break;
			} else if (x >= 40) {
				bc("application");
			} else {

//				long startTime = System.currentTimeMillis();
//				int proto_messages_before = this.total_protocol_msgs;

				this.csReqs++;
				System.out.println();
				System.out.println("crit section run " + this.csReqs);
				this.mutex.reqCriticalSection();
				while (!this.mutex.execCrit()) {
					long waitTime = System.currentTimeMillis() + 10;
					while (System.currentTimeMillis() < waitTime)
						;
				}

//				long endTime = System.currentTimeMillis();
//				long duration = (endTime - startTime);
				execute_crit();
				System.out.println("run " + this.csReqs + " complete");
				System.out.println();
				this.mutex.dequeueReq();
				System.out.println("releasing lock");

//				int proto_messages_after = this.total_protocol_msgs;
//				this.delay_per_crit = duration;
//				this.count_per_crit = proto_messages_after - proto_messages_before;

				long waitTime = System.currentTimeMillis() + this.ird_mean;
				while (System.currentTimeMillis() < waitTime)
					;
			}
		}
		System.out.println("protocol done.");
		System.exit(1);
	}

	public static void main(String[] args) {
		if (args.length < 7) {
			System.out.println("not enough arguments, need at least 7");
			return;
		}
		String host_ips = args[6];
		for (int i = 0; i < Integer.parseInt(args[2]) - 1; i++) {
			host_ips += " " + args[7 + i];
		}
		Node node = new Node(Integer.parseInt(args[0]), Integer.parseInt(args[1]), Integer.parseInt(args[2]),
				Integer.parseInt(args[3]), Integer.parseInt(args[4]), Integer.parseInt(args[5]), host_ips,
				args[args.length - 2], Integer.parseInt(args[args.length - 1]));
		node.run_listener();
		System.out.println("all connections made");
		Thread t = new Thread(node);
		t.start();
		System.out.println("running Lamport mutex algorithm");
	}
}
