class Rectangle extends Shape
{
    // Inheritance Above

    private double width;
    private double height;

    public Rectangle(double width, double height)
    {
        this.width = width;
        this.height = height;
    }

    public double getArea()
    {
       return width * height;
    } 

    public double getPerimeter()
    {
        return 2 * (width + height); 
    }
    // Overloading
    // void display(double myradius){}

    //Overriding
    void display()
    {
        System.out.println("This is a Rectangle");
    }
}