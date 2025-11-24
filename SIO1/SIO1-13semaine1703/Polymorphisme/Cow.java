class Cow extends Animal
{
    String breed;

    Cow()
    {}

    Cow(String name, int age, String breed)
    {
        super(name, age);
        this.breed = breed;
    }
    void makeSound()
    { 
        System.out.println("Meuh");
    }

    void displayInfo()
    {
        super.displayInfo();
        System.out.println(" Breed: " + breed);
    }

    public void play(){}
}