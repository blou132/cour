import java.util.Scanner;

public class Fibonacci
{
    public static void main(String[] args) {
        String suite = "0";
        int previous = 0;
        int inc = 0;

        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter an Integer: ");
        int num = scanner.nextInt();

        for(int i=1; i <= num; )
        {
            inc = i + previous;
            suite += " " + i + " ";
            previous = i;
            i = inc;
        }


        System.out.println(suite);
        scanner.close();
    }
}
