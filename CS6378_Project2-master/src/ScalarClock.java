
public class ScalarClock {
	
	private int inc  = 1;
    private int clock = 0;
    
    public ScalarClock() { }

    public synchronized void event() { 
    	clock += inc;
    }

    public synchronized void msg_event(int msg_clock) {
        this.event();
        if (msg_clock + inc >= this.clock) {
            clock = msg_clock + inc;
        }
    }
    
    public int getClock() { return clock; }   
}
