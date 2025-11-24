import java.io.*;
import java.util.Scanner;

// Encapsulation: Accès de portée publique
public class GestionLivres {
    static final int MAX_LIVRES = 10;
    static Livre[] livres = new Livre[MAX_LIVRES];
    static int nombreLivres = 0;

    public static void main(String[] args) {
        chargerLivres();  // Charger les livres depuis le fichier au démarrage
        Scanner scanner = new Scanner(System.in);

        while (true) {
            System.out.println("\nMenu:");
            System.out.println("1. Ajouter un livre");
            System.out.println("2. Rechercher un livre");
            System.out.println("3. Afficher la liste des livres");
            System.out.println("4. Supprimer un livre");
            System.out.println("5. Quitter et sauvegarder");
            System.out.print("Choisissez une option: ");

            int choix = scanner.nextInt();
            scanner.nextLine(); // Consommer le retour à la ligne

            switch (choix) {
                case 1:
                    ajouterLivre(scanner);
                    break;
                case 2:
                    rechercherLivre(scanner);
                    break;
                case 3:
                    afficherLivres();
                    break;
                case 4:
                    supprimerLivre(scanner);
                    break;
                case 5:
                    sauvegarderLivres();
                    System.out.println("Données sauvegardées. Au revoir !");
                    return;
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
        System.out.print("Auteur du livre: ");
        String auteur = scanner.nextLine();
        livres[nombreLivres++] = new Livre(titre, auteur);
        System.out.println("Livre ajouté !");
    }

    static void rechercherLivre(Scanner scanner) {
        System.out.print("Entrez le titre à rechercher: ");
        String recherche = scanner.nextLine().toLowerCase();
        boolean trouve = false;
        for (int i = 0; i < nombreLivres; i++) {
            if (livres[i].titre.toLowerCase().contains(recherche)) {
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
            if (livres[i].titre.equalsIgnoreCase(titreSuppression)) {
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
                if (livres[i].titre.compareToIgnoreCase(livres[j].titre) > 0) {
                    Livre temp = livres[i];
                    livres[i] = livres[j];
                    livres[j] = temp;
                }
            }
        }
    }

    static void sauvegarderLivres() {
        try (PrintWriter writer = new PrintWriter(new FileWriter("livres.txt"))) {
            for (int i = 0; i < nombreLivres; i++) {
                writer.println(livres[i].titre + ";" + livres[i].auteur);
            }
        } catch (IOException e) {
            System.out.println("Erreur lors de la sauvegarde !");
        }
    }

    static void chargerLivres() {
        try (BufferedReader reader = new BufferedReader(new FileReader("livres.txt"))) {
            String ligne;
            while ((ligne = reader.readLine()) != null && nombreLivres < MAX_LIVRES) {
                String[] data = ligne.split(";");
                livres[nombreLivres++] = new Livre(data[0], data[1]);
            }
        } catch (IOException e) {
            System.out.println("Aucun fichier trouvé, création d'une nouvelle bibliothèque.");
        }
    }
}

// POO - Pas d'inhéritance
class Livre {
    String titre;
    String auteur;

    Livre(String titre, String auteur) {
        this.titre = titre;
        this.auteur = auteur;
    }

    // Polymorphism: Overriden built-in method toString() implicitely called in class GestionLivres
    public String toString() {
        return "Titre: " + titre + ", Auteur: " + auteur;
    }

}
