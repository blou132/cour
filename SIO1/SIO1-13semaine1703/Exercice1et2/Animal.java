class Animal
{
    String name;
    int age;

    Animal()
    {}
    
    Animal(String name, int age)
    {
        this.name = name;
        this.age = age;
    }

    void makeSound()
    {
        System.out.println("Random Sound!");
    }

    void displayInfo()
    {
        System.out.print("Name: " + name + ", Age: " + age);
    }
}