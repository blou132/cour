class Main
{
    public static void main(String[] args) {
        Animal animal1 = new Animal();

        Animal animal2 = new Animal("Nom d'Animal", 10);

    //    animal1.makeSound();

    //    animal2.makeSound();

        Animal dog1 = new Dog("Médor", 5, "Caniche");

    //    dog1.makeSound();

    //    System.out.println(dog1.name);

        animal1.displayInfo();
        System.out.println();
        animal2.displayInfo();
        System.out.println();
        dog1.displayInfo();
    }
}