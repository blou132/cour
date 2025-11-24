
class Circle extends Shape
{
    // Inheritance Above

    private double radius;

    public Circle(double radius)
    {
        this.radius = radius;
    }

    public double getArea()
    {
       return Math.PI * radius * radius;
    } 

    public double getPerimeter()
    {
        return 2 * Math.PI * radius; 
    }
    // Overloading
    // void display(double myradius){}

    //Overriding
    void display()
    {
        System.out.println("This is a circle");
    }
}