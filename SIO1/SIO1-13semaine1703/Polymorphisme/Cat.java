class Cat extends Animal
{
    String breed;

    Cat()
    {}

    Cat(String name, int age, String breed)
    {
        super(name, age);
        this.breed = breed;
    }
    void makeSound()
    {
        System.out.println("Miaou");
    }

    void displayInfo()
    {
        super.displayInfo();
        System.out.println(" Breed: " + breed);
    }

    public void play(){
        System.out.println("The Cat play");
    }
}
