import java.util.Scanner;

public class TriTableau {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        // Demander à l'utilisateur la taille du tableau
        System.out.print("Entrez la taille du tableau : ");
        int taille = scanner.nextInt();

        // Créer un tableau d'entiers de la taille spécifiée
        int[] tableau = new int[taille];

        // Demander à l'utilisateur de saisir les éléments du tableau
        System.out.println("Entrez les éléments du tableau :");
        for (int i = 0; i < taille; i++) {
            tableau[i] = scanner.nextInt();
        }

        // Appeler la fonction de tri par sélection
        triParSelection(tableau);

        // Ou appeler la fonction de tri à bulles

        triABulles(tableau);

        // Afficher le tableau trié
        System.out.println("Tableau trié :");
        for (int i = 0; i < taille; i++) {
            System.out.print(tableau[i] + " ");
        }
    }

    // Fonction pour trier un tableau par sélection
    public static void triParSelection(int[] tableau) {
        int n = tableau.length;

        for (int i = 0; i < n - 1; i++) {
            int minIndex = i;
            for (int j = i + 1; j < n; j++) {
                if (tableau[j] < tableau[minIndex]) {
                    minIndex = j;
                }
            }

            // Échanger les éléments à la position i et minIndex
            int temp = tableau[minIndex];
            tableau[minIndex] = tableau[i];
            tableau[i] = temp;
        }
    }

    public static void triABulles(int[] tableau) {
        int n = tableau.length;
        for (int i = 0; i < n - 1; i++) {
            for (int j = 0; j < n - i - 1; j++) {
                if (tableau[j] > tableau[j + 1]) {
                    // Échanger les éléments
                    int temp = tableau[j];
                    tableau[j] = tableau[j + 1];
                    tableau[j + 1] = temp;
                }   
            }
        }
    }
}