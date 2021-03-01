import java.util.ArrayList;
import java.util.Comparator;
import java.util.PriorityQueue;
import java.util.List;

public class Mutex {

	private Node node;
	PriorityQueue<Message> priorityQueue;
//    PriorityQueue<Integer> intPQ;
	private boolean request_made;
	public List<Integer> replies;
//    private boolean executeCS = false;

	public Mutex(Node n) {
		this.node = n;
		this.priorityQueue = new PriorityQueue<Message>(this.node.getNumNodes(), new MessageComparator());
//        this.intPQ = new PriorityQueue<Integer>();
	}

	class MessageComparator implements Comparator<Message> {

		@Override
		public int compare(Message msg1, Message msg2) {
			// sort messages in ascending order of clock values
			if (msg1.getClock() > msg2.getClock())
				return 1;
			else if (msg1.getClock() < msg2.getClock()) {
				return -1;
			}
			return 0;
		}

	}

	public synchronized void getReply(Message msg) {
		if (request_made) {
			replies.remove(Integer.valueOf(msg.getSender()));
//            System.out.println("pending reps: " + this.replies);
//            System.out.println("int pq: " + this.intPQ);
		}
	}

	public synchronized void enqueueReq(Message msg) {
		this.priorityQueue.add(msg);
//        this.intPQ.add(msg.getSender());
//        System.out.println("adding to queue (other)" + msg.getSender());
//        System.out.println("pq head: " + this.priorityQueue.peek().getSender() + " clock " + this.priorityQueue.peek().getClock());
		Message mg = new Message.MessageBuilder().to(msg.getSender()).from(this.node.getPid())
				.clock(this.node.getClock()).type("reply").build();
		this.node.sendMsg(msg.getSender(), "reply", mg);
	}

	private synchronized void enqueueReq() {
		Message msg = new Message.MessageBuilder().from(this.node.getPid()).clock(this.node.getClock()).type("request")
				.build();
		this.priorityQueue.add(msg);
//    	this.intPQ.add(this.node.getPid());
//    	System.out.println("adding to queue (me)" + msg.getSender());
//    	System.out.println("pq head: " + this.priorityQueue.peek().getSender() + " clock " + this.priorityQueue.peek().getClock());
	}

	public synchronized boolean dequeueReq(Message msg) {
//    	this.intPQ.poll();
//    	System.out.println("removing from queue " + msg.getSender());
		if (this.priorityQueue.peek().getSender() == msg.getSender()) {
			this.priorityQueue.poll();
			return true;
		}
		return false;
	}

	synchronized void dequeueReq() {
		this.priorityQueue.poll();
		this.request_made = false;
//        System.out.println("removing from queue " + this.node.getPid());
		this.node.bc("release");
	}

	public boolean execCrit() {
		if (this.request_made && !this.priorityQueue.isEmpty()) {
			if (this.priorityQueue.peek().getSender() == this.node.getPid()) {
				System.out.println("waiting on replies...");
				if (this.replies.isEmpty()) {
					return true;
				}
			}
		}
		return false;
	}

	public synchronized void reqCriticalSection() {
		if (!this.request_made) {
			this.request_made = true;
			replies = new ArrayList<>(this.node.nodes);
			this.enqueueReq();
			this.node.bc("request");
		}
	}
}
