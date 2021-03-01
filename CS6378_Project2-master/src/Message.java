import java.io.Serializable;

public class Message implements Serializable, Comparable<Message> {
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	int from;
	int to;
	final int clock;
	String type;
	final boolean ping;

	private Message(MessageBuilder builder) {
		this.from = builder.from;
		this.to = builder.to;
		this.clock = builder.clock;
		this.type = builder.type;
		this.ping = builder.ping;
	}

	@Override
	public int compareTo(Message that) {
		if (this.clock > that.getClock())
			return +1;
		else if (this.clock < that.getClock())
			return -1;
		else {
			if (this.getSender() > that.getSender())
				return +1;
			else
				return -1;
		}
	}

	@Override
	public String toString() {
		return String.format(from + " " + clock);
	}

	public int getSender() {
		return this.from;
	}

	public int getReceiver() {
		return this.to;
	}

	public void setSender(int from) {
		this.from = from;
	}

	public void setReceiver(int to) {
		this.to = to;
	}

	public void setType(String type) {
		this.type = type;
	}

	public int getClock() {
		return clock;
	}

	public String getType() {
		return type;
	}

	public boolean getPing() {
		return ping;
	}

	public static class MessageBuilder {
		private int to, from;
		private int clock;
		private String type;
		private boolean ping = false;

		public MessageBuilder() {
		}

		public MessageBuilder from(int from) {
			this.from = from;
			return this;
		}

		public MessageBuilder to(int to) {
			this.from = to;
			return this;
		}

		public MessageBuilder clock(int clock) {
			this.clock = clock;
			return this;
		}

		public MessageBuilder type(String type) {
			this.type = type;
			return this;
		}

		public MessageBuilder ping(boolean ping) {
			this.ping = ping;
			return this;
		}

		public Message build() {
			return new Message(this);
		}
	}
}
