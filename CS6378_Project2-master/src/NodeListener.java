import java.io.IOException;
import java.io.InputStream;
import java.io.ObjectInputStream;
import java.net.ServerSocket;
import java.net.Socket;

public class NodeListener extends Thread {

	private Node node;

	public NodeListener(Node n) {
		this.node = n;
	}

	@Override
	public void run() {
		try (ServerSocket serv = new ServerSocket(node.getPort())) {
			while (true) {
				try {
					Socket conn = serv.accept();
					InputStream in = conn.getInputStream();
					ObjectInputStream instream = new ObjectInputStream(in);
					try {
						Message msg = (Message) instream.readObject();
//                        if (msg.getType().equals("ping")) {
//                        	Message mg = new Message.MessageBuilder()
//                                  .from(this.node.getPid())
//                                  .type("pingback").build();
//                        	OutputStream out = conn.getOutputStream();
//                        	ObjectOutputStream outstream = new ObjectOutputStream(out);
//                            outstream.writeObject(mg);
//                            outstream.close();
//                            out.close();
//                        } else
						node.readMsg(msg);
					} catch (ClassNotFoundException e) {
						System.err.println(e);
					}
				} catch (IOException e) {
					System.err.println(e);
				}
			}

		} catch (IOException ex) {
		}
	}
}
