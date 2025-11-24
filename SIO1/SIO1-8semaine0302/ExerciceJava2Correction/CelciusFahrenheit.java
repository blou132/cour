import java.util.Scanner;

public class CelciusFahrenheit
{
    public static void main(String[] args) {
        float celcius = 0.0f;
        float fahrenheit = 0.0f;

        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter \'C' to convert in Celsius or \'F' to convert in fahrenheit: ");
        String choice = scanner.nextLine();
        
        if(choice.equalsIgnoreCase("c"))
        {
            System.out.print("Enter the temperature in fahrenheit: ");
            fahrenheit = scanner.nextFloat();
            celcius = (fahrenheit - 32) * 5/9; 
            System.out.print("The temperatue is " + celcius + "°C" );            
        }
        else if(choice.equalsIgnoreCase("f"))
        {
            System.out.print("Enter the temperature in celcius: ");
            celcius = scanner.nextFloat();
            fahrenheit = (celcius * 9/5) + 32; 
            System.out.print("The temperatue is " + fahrenheit + "°F" );            
        }
        else
            System.out.print("Wrong choice, try again");     
        scanner.close();       
    }
}
