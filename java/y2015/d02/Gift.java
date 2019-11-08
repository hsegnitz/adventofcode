package y2015.d02;

import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;

public class Gift {

    private int width  = 0;
    private int length = 0;
    private int height = 0;

    public Gift(int width, int length, int height) {
        this.width  = width;
        this.length = length;
        this.height = height;
    }

    public int getSurface() {
        return 2 * ((length*height) + (length*width) + (height*width));
    }

    public int getExtra() {
        List<Integer> dimensions = new ArrayList<Integer>();
        dimensions.add(this.width);
        dimensions.add(this.height);
        dimensions.add(this.length);

        dimensions.sort(new Comparator<Integer>() {
            @Override
            public int compare(Integer o1, Integer o2) {
                return o1 - o2;
            }
        });

        return dimensions.get(0) * dimensions.get(1);
    }

    public int getTotalWrappingPaper() {
        return getSurface() + getExtra();
    }
}
