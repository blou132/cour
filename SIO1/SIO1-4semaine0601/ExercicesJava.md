### Exercice 1: Afficher "Hello, World!"
**Description:** Écrivez un programme Java qui affiche "Hello, World!" sur la console.

---

**Solution:**
```java
public class HelloWorld {
    public static void main(String[] args) {
        System.out.println("Hello, World!");
    }
}
```

### Exercice 2: Additionner deux nombres
**Description:** Créez un programme Java qui prend deux nombres en entrée et affiche leur somme.

---

**Solution:**
```java
import java.util.Scanner;

public class Addition {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter first number: ");
        int num1 = scanner.nextInt();
        System.out.print("Enter second number: ");
        int num2 = scanner.nextInt();
        int sum = num1 + num2;
        System.out.println("The sum of " + num1 + " and " + num2 + " is " + sum + ".");
    }
}
```

### Exercice 3: Vérifier si un nombre est pair ou impair
**Description:** Écrivez un programme Java qui vérifie si un nombre donné est pair ou impair.

---

**Solution:**
```java
import java.util.Scanner;

public class EvenOdd {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter a number: ");
        int num = scanner.nextInt();
        
        if (num % 2 == 0) {
            System.out.println(num + " is even.");
        } else {
            System.out.println(num + " is odd.");
        }
    }
}
```

### Exercice 4: Trouver le plus grand de trois nombres
**Description:** Créez un programme Java qui trouve le plus grand de trois nombres donnés.

---


### Exercice 5: Calculer la factorielle d'un nombre
**Description:** Écrivez un programme Java qui calcule la factorielle d'un nombre donné.

---


### Exercice 6: Inverser une chaîne de caractères
**Description:** Créez un programme Java qui inverse une chaîne de caractères donnée.

---


### Exercice 7: Vérifier si une chaîne est un palindrome
**Description:** Écrivez un programme Java qui vérifie si une chaîne de caractères donnée est un palindrome (se lit de la même façon à l'endroit et à l'envers).

---


### Exercice 8: Compter les voyelles dans une chaîne
**Description:** Créez un programme Java qui compte le nombre de voyelles dans une chaîne de caractères donnée.

---


### Exercice 9: Générer des nombres aléatoires
**Description:** Écrivez un programme Java qui génère et affiche 5 nombres aléatoires entre 1 et 100.

---


### Exercice 10: Trouver la longueur de la plus longue chaîne dans un tableau
**Description:** Créez un programme Java qui trouve la longueur de la plus longue chaîne de caractères dans un tableau donné.

---


