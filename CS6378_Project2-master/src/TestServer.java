import java.io.IOException;
import java.io.ObjectOutputStream;
import java.io.OutputStream;
import java.net.Socket;
import java.util.Arrays;
import java.util.HashMap;

public class TestServer implements Runnable {

	private int numNodes;
	private int port;
	private int reqPerNode;
	private int pingbacks;
	public int nodes_in_cs[];
	private HashMap<Integer, String> nodeHostIp;

	public TestServer(int port, int numNodes, String allNodes, int reqPerNode) {
		this.numNodes = numNodes;
		this.pingbacks = 0;
		this.port = port;
		this.reqPerNode = reqPerNode;
		this.nodes_in_cs = new int[numNodes];
		Arrays.fill(this.nodes_in_cs, 0);
		this.nodeHostIp = new HashMap<Integer, String>();
		String[] nodeInfo = allNodes.split(" ");
		for (int i = 0; i < numNodes; i++) {
			this.nodeHostIp.put(i, nodeInfo[i]);
		}
	}

	public int getPort() {
		return this.port;
	}

	public synchronized void readMsg(Message msg) {
		if (msg.getType().equals("in")) {
			this.pingbacks++;
			this.nodes_in_cs[msg.getSender()] = 1;
			String res = "";
			for (int element : this.nodes_in_cs) {
				res += element + " ";
			}
			System.out.println("nodes in cs: " + res + "\ttotal runs: " + this.pingbacks);
			if (this.pingbacks >= this.numNodes*reqPerNode) {
				System.out.println("all requests for the nodes have been fulfilled");
				System.out.println("run cleanup script to close");
			}
		} else if (msg.getType().equals("out")) {
			this.nodes_in_cs[msg.getSender()] = 0;
//			System.out.println("node " + msg.getSender() + " is out of cs :'(");
		}
	}

	public synchronized void ping() {

		Message msg = new Message.MessageBuilder().type("ping").build();

		for (int id : this.nodeHostIp.keySet()) {

			String[] rcv_host_ip = this.nodeHostIp.get(id).split(":");
			String rcv_host = rcv_host_ip[0];
			int rcv_port = Integer.parseInt(rcv_host_ip[1]);

			msg.setReceiver(id);

			try (Socket sock = new Socket(rcv_host + ".utdallas.edu", rcv_port)) {
				OutputStream out = sock.getOutputStream();
				ObjectOutputStream outstream = new ObjectOutputStream(out);
				outstream.writeObject(msg);
				outstream.close();
				out.close();
				sock.close();
				System.out.println("ping sent to: " + rcv_host + ":" + rcv_port);
			} catch (IOException ex) {
				System.err.println("can't send message" + ex);
			}
		}
	}

	public void listen() {
		Thread listener = new TestListener(this);
		listener.start();
//        System.out.println("listening...");
	}

	@Override
	public void run() {
		// TODO Auto-generated method stub
		this.listen();

		try {
			Thread.sleep(1500);
		} catch (InterruptedException ex) {
		}

		while (true) {
//			this.pingbacks = 0;
//			this.ping();
//			while (true) {
////				System.out.print("");
//				if (this.pingbacks >= this.numNodes) {
//					break;
//				}
////				System.out.println("pb: " + pingbacks + " nn: " + numNodes);
//			}
//			String res = "";
//			for (int element : this.nodes_in_cs) {
//				res += element + " ";
//			}
//			System.out.println("nodes in cs: " + res);
//			
//			long waitTime = System.currentTimeMillis() + 500; //wait 1 seconds
//            while(System.currentTimeMillis() < waitTime);
		}

	}

	public static void main(String[] args) {
		String hosts_ips = args[2];
		for (int i = 0; i < Integer.parseInt(args[1]) - 1; i++) {
			hosts_ips += " " + args[3 + i];
		}
		TestServer test = new TestServer(Integer.parseInt(args[0]), Integer.parseInt(args[1]), hosts_ips, Integer.parseInt(args[args.length - 1]));
		Thread thread = new Thread(test);
		thread.start();
		System.out.println("running test server");
	}

}
