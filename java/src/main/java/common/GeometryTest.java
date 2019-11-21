package common;

import org.junit.Test;

import static org.junit.Assert.*;

public class GeometryTest {

    @Test
    public void taxiDistance() {
        assertEquals(5, Geometry.taxiDistance(0, 0, 3, 3));
    }
}