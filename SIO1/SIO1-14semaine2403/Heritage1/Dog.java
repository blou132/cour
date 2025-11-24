class Dog extends Animal
{
    String breed;

    Dog(String name, int age, String breed)
    {
        super(name, age);
        this.breed = breed;
    }

    void makeSound()
    {
        System.out.println("Woof");
    }

    void displayInfo()
    {
        super.displayInfo();
        System.out.println(" Breed: " + breed);
    }
}