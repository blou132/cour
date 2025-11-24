class Farm
{
    public static void main(String[] args) {

        Animal[] animals = {new Dog(), new Cat(), new Cow()};

        for(Animal animal : animals)
        {
            animal.makeSound();
            animal.eat();
            animal.play();
/*
            if(animal instanceof Pet)
            {
                ((Pet)animal).play();
            }
*/
        }
    }
}