package y2015.d02;

public class Gift {

    private int width  = 0;
    private int length = 0;
    private int height = 0;

    public Gift(int width, int length, int height) {
        this.width = width;
        this.length = length;
        this.height = height;
    }

    public int getSurface() {
        return 2 * ((length*height) + (length*width) + (height*width));
    }

}
