package y2015.d08;

public class Line {

    private String rawLine;

    public Line(String rawLine) {
        this.rawLine = rawLine;
    }

    public int codeChars() {
        return this.rawLine.length();
    }

    public int memoryChars() {
        String strippedLine = this.rawLine.replaceAll("^\"", "")
                .replaceAll("\"$", "")
                .replaceAll("\\\\x[0-9a-f]{2}", "y")
                .replace("\\\\", "y")
                .replace("\\\"", "z");

        return strippedLine.length();
    }

}
