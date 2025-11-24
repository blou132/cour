import java.util.Scanner;

public class NombrePremier
{
    public static void main(String[] args) {
        boolean resultat = false;

        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter an Integer: ");
        int num = scanner.nextInt();
        
        for(int i = 2; i <= num; i++)
        {
            if(num % i == 0 && num != i)
            {
                resultat = false;
                break;
            }
            else if(num % i == 0 && num == i)
            {
                resultat = true;
                break;
            }
            System.out.println("Increment: " + i);
        }

        if(resultat == true)
            System.out.println(num + " est un nombre premier");
        
        scanner.close();
    }
}
