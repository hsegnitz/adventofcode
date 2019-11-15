package y2015.d12;

import java.io.File;
import java.util.Map;
import java.util.Scanner;
import java.util.Set;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;

public class Part2 {

    public static void main(String[] args) {
        try {
            File file = new File("src/main/java/y2015/d12/in.json");
            Scanner scanner = new Scanner(file);
            String json = scanner.nextLine();

            JSONParser parser = new JSONParser();
            Object root = parser.parse(json);

            System.out.println(recursiveSum(root));

            scanner.close();
        } catch (Exception e) {
            System.out.println(e.getMessage());
            System.exit(42);
        }
    }

    private static long recursiveSum(Object object) {
        if (object instanceof Long || object instanceof Double) {
            return (long) object;
        }
        if (object instanceof String) {
            return 0L;
        }

        if (object instanceof JSONArray) {
            long sum = 0L;
            for (Object obj: (JSONArray)object) {
                sum += recursiveSum(obj);
            }
            return sum;
        }

        if (object instanceof JSONObject) {
            JSONObject jsonObject = (JSONObject)object;
            long sum = 0L;
            for (Object entry: jsonObject.values()) {
                if (entry instanceof String) {
                    String str = (String)entry;
                    if (str.equals("red")) {
                        return 0L;
                    }
                } else {
                    sum += recursiveSum(entry);
                }
            }
            return sum;
        }

        return 0;
    }

}
