import java.io.IOException;
import java.io.InputStream;
import java.io.ObjectInputStream;
import java.net.ServerSocket;
import java.net.Socket;

public class TestListener extends Thread {

	private TestServer ts;

	public TestListener(TestServer ts) {
		this.ts = ts;
	}

	@Override
	public void run() {
		try (ServerSocket serv = new ServerSocket(this.ts.getPort())) {
			while (true) {
				try {
					Socket conn = serv.accept();
					InputStream in = conn.getInputStream();
					ObjectInputStream instream = new ObjectInputStream(in);
					try {
						Message msg = (Message) instream.readObject();
						this.ts.readMsg(msg);
					} catch (ClassNotFoundException ex) {
						System.err.println(ex);
					}
				} catch (IOException ex) {
					System.err.println(ex);
				}
			}

		} catch (IOException ex) {
		}
	}

}
