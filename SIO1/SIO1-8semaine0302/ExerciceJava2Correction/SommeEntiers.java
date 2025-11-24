import java.util.Scanner;

public class SommeEntiers
{
    public static void main(String[] args) {
        String sum = "";
        int total = 0;

        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter an Integer: ");
        int num = scanner.nextInt();
        
        for(int i = 1; i < num; i++)
        {
            if(num == 0)
                break;
            sum += i + " + "; 
            total += i;
        }

        sum += num;
        total += num;

        System.out.println(sum + " = " + total);
        scanner.close();
    }
}
