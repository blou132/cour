
import java.util.Scanner;

public class GestionNotes {
    
    static String[] noms;
    static double[] notes;

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        // Étape 1 : Saisie des données
        System.out.print("Combien d'élèves ? ");
        int nombreEleves = scanner.nextInt();
        scanner.nextLine(); // Consommer le retour à la ligne
        noms = new String[nombreEleves];
        notes = new double[nombreEleves];

        for (int i = 0; i < nombreEleves; i++) {
            System.out.print("Entrez le nom de l'élève " + (i + 1) + " : ");
            noms[i] = scanner.nextLine();
            System.out.print("Entrez la note de " + noms[i] + " : ");
            notes[i] = scanner.nextDouble();
            scanner.nextLine(); // Consommer le retour à la ligne
        }
        
        // Étape 2 : Affichage des données
        System.out.println("\nRésultats :");
        for (int i = 0; i < nombreEleves; i++) {
            System.out.println(noms[i] + " : " + notes[i]);
        }
        
        // Étape 3 : Calcul des statistiques
        double somme = 0, maxNote = Double.MIN_VALUE, minNote = Double.MAX_VALUE;
        String maxEleve = "", minEleve = "";
        
        for (int i = 0; i < nombreEleves; i++) {
            somme += notes[i];
            if (notes[i] > maxNote) {
                maxNote = notes[i];
                maxEleve = noms[i];
            }
            if (notes[i] < minNote) {
                minNote = notes[i];
                minEleve = noms[i];
            }
        }
        
        System.out.println("\nNote moyenne : " + (somme / nombreEleves));
        System.out.println("Meilleure note : " + maxEleve + " avec " + maxNote);
        System.out.println("Moins bonne note : " + minEleve + " avec " + minNote);
        
        // Étape 4 : Recherche d'un élève
        System.out.print("\nEntrez un nom à rechercher : ");
        String recherche = scanner.nextLine();
        boolean trouve = false;
        for (int i = 0; i < nombreEleves; i++) {
            if (noms[i].equalsIgnoreCase(recherche)) {
                System.out.println(recherche + " a obtenu " + notes[i]);
                trouve = true;
                break;
            }
        }
        if (!trouve) {
            System.out.println(recherche + " n'existe pas dans la liste.");
        }

        //Si temps disponible. Trier les élèves

        System.out.print("Entrez 'oui' pour trier les élèves : ");
        String choix = scanner.nextLine();

        if(choix.equalsIgnoreCase("oui"))
        {
            System.out.println("\nRésultats :");
            trierParNotes(noms, notes);
        }

        scanner.close();   	
    }      

    // Méthode pour trier les élèves par leurs notes
    public static void trierParNotes(String[] noms, double[] notes) {
        for (int i = 0; i < notes.length; i++) {
            for (int j = i + 1; j < notes.length; j++) {
                if (notes[i] > notes[j]) {
                    // Échange des notes
                    double tempNote = notes[i];
                    notes[i] = notes[j];
                    notes[j] = tempNote;

                    // Échange des noms correspondants
                    String tempNom = noms[i];
                    noms[i] = noms[j];
                    noms[j] = tempNom;
                }
            }
            System.out.println(noms[i] + " : " + notes[i]);
        }
    }
}
