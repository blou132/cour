import java.util.Scanner;

public class Bibliotheque {
    static final int MAX_LIVRES = 10;
    static String[] livres = new String[MAX_LIVRES];
    static int nombreLivres = 0;

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        while (true) {
            System.out.println("\nMenu:");
            System.out.println("1. Ajouter un livre");
            System.out.println("2. Afficher la liste des livres");
            System.out.println("3. Rechercher un livre");
            System.out.println("4. Supprimer un livre");
            System.out.print("Choisissez une option: ");

            int choix = scanner.nextInt();
            scanner.nextLine(); // Consommer le retour à la ligne

            switch (choix) {
                case 1:
                    ajouterLivre(scanner);
                    break;
                case 2:
                    afficherLivres();
                    break;
                case 3:
                    rechercherLivre(scanner);
                    break;
                case 4:
                    supprimerLivre(scanner);
                    break;
                default:
                    System.out.println("Option invalide !");
            }
        }
    }

    static void ajouterLivre(Scanner scanner) {
        if (nombreLivres >= MAX_LIVRES) {
            System.out.println("La bibliothèque est pleine !");
            return;
        }
        System.out.print("Titre du livre: ");
        String titre = scanner.nextLine();
        livres[nombreLivres++] = titre;
        System.out.println("Livre ajouté !");
    }

    static void rechercherLivre(Scanner scanner) {
        System.out.print("Entrez le titre à rechercher: ");
        String recherche = scanner.nextLine().toLowerCase();
        boolean trouve = false;
        for (int i = 0; i < nombreLivres; i++) {
            if (livres[i].toLowerCase().contains(recherche)) {
                System.out.println("Trouvé: " + livres[i]);
                trouve = true;
            }
        }
        if (!trouve) System.out.println("Aucun livre trouvé.");
    }

    static void afficherLivres() {
        if (nombreLivres == 0) {
            System.out.println("Aucun livre enregistré.");
            return;
        }
        trierLivres(); // Trier avant d'afficher
        for (int i = 0; i < nombreLivres; i++) {
            System.out.println(livres[i]);
        }
    }

    static void supprimerLivre(Scanner scanner) {
        System.out.print("Entrez le titre du livre à supprimer: ");
        String titreSuppression = scanner.nextLine();
        int index = -1;

        for (int i = 0; i < nombreLivres; i++) {
            if (livres[i].contains(titreSuppression)) {
                index = i;
                break;
            }
        }

        if (index == -1) {
            System.out.println("Livre non trouvé.");
            return;
        }

        for (int i = index; i < nombreLivres - 1; i++) {
            livres[i] = livres[i + 1]; // Décaler les éléments
        }
        livres[--nombreLivres] = null; // Supprimer la dernière référence
        System.out.println("Livre supprimé !");
    }

    static void trierLivres() {
        for (int i = 0; i < nombreLivres - 1; i++) {
            for (int j = i + 1; j < nombreLivres; j++) {
                if (livres[i].compareToIgnoreCase(livres[j]) > 0) {
                    String temp = livres[i];
                    livres[i] = livres[j];
                    livres[j] = temp;
                }
            }
        }
    }
}
