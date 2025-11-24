abstract class Animal implements Pet
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

    abstract void makeSound();

    void displayInfo()
    {
        System.out.print("Name: " + name + ", Age: " + age);
    }

    void eat(){
        System.out.println("This animal is eating");
    }
}