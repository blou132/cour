import java.util.Scanner;

public class Anagramme {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.print("Entrez le premier mot : ");
        String mot1 = scanner.nextLine();
        System.out.print("Entrez le deuxième mot : ");
        String mot2 = scanner.nextLine();

        if (sontAnagrammes(mot1, mot2)) {
            System.out.println(mot1 + " et " + mot2 + " sont des anagrammes.");
        } else {
            System.out.println(mot1 + " et " + mot2 + " ne sont pas des anagrammes.");
        }
    }

    public static boolean sontAnagrammes(String mot1, String mot2) {
        // On vérifie d'abord si les deux mots ont la même longueur
        if (mot1.length() != mot2.length()) {
            return false;
        }

        // On crée deux tableaux de comptage pour chaque lettre de l'alphabet
        int[] compte1 = new int[26];
        int[] compte2 = new int[26];

        // On compte les occurrences de chaque lettre dans chaque mot
        for (int i = 0; i < mot1.length(); i++) {
            compte1[mot1.charAt(i) - 'a']++;
            compte2[mot2.charAt(i) - 'a']++;
        }

        // On compare les deux tableaux de comptage
        for (int i = 0; i < 26; i++) {
            if (compte1[i] != compte2[i]) {
                return false;
            }
        }

        return true;
    }
}