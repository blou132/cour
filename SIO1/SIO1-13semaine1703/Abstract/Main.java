public class Main
{
    public static void main(String[] args) {
        Shape circle = new Circle(5);

        circle.display();
        System.out.println("Circle Area: " + circle.getArea());
        System.out.println("Circle Perimeter: " + circle.getPerimeter());

        Shape rectangle = new Rectangle(5, 7);

        rectangle.display();
        System.out.println("Rectangle Area: " + rectangle.getArea());
        System.out.println("Rectangle Perimeter: " + rectangle.getPerimeter());

    }
}