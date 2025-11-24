import java.util.Scanner;

public class MaxTableau
{
    public static void main(String[] args) {
        int max = 0;

        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter the Array length: ");
        int segment = scanner.nextInt();

        int []tableau = new int[segment];

        for(int i = 0; i < segment; i++)
        {
            System.out.print("Enter the Integer Value at Index " + i + ": ");
            int value = scanner.nextInt();
            tableau[i] = value;
            max = Math.max(max, tableau[i]);
        }

        System.out.println("The maximum value in the tableau is " + max);
        scanner.close();
    }
}
