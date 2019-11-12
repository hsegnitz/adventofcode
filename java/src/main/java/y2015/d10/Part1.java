package y2015.d10;

public class Part1 {

    public static void main(String[] args) {
        String numbers = "1113122113";

        for (int i = 1; i <= 40; i++) {
            numbers = lookAndSay(numbers);
            System.out.println(i + ": " + numbers.length());
        }
    }

    public static String lookAndSay(String numbers) {
        StringBuilder out = new StringBuilder();

        int count = 0;
        for (int i = 0; i < numbers.length(); i++) {
            count++;
            if (i == numbers.length()-1 || numbers.charAt(i) != numbers.charAt(i+1)) {
                out.append("").append(count).append(numbers.charAt(i));
                count = 0;
            }
        }

        return out.toString();
    }

}
