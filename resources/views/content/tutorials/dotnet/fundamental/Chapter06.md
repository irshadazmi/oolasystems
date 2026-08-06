# Chapter 6: Object-Oriented Programming – Inheritance and Polymorphism

---

In this chapter, we continue our journey into **Object-Oriented Programming (OOP)** by exploring two of its most powerful concepts: **Inheritance** and **Polymorphism**.

These features allow developers to build scalable, reusable, and flexible applications by reusing code and enabling objects to behave differently based on context.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the concept of **inheritance** in C#
- Learn how to create base and derived classes
- Explore **method overriding** and the `virtual`/`override` keywords
- Understand **polymorphism** and its types
- Use **abstract classes** and **interfaces** for design flexibility
- Practice hands-on exercises to reinforce learning

---

## 🔹 Inheritance

### What is Inheritance?

- Inheritance allows a class (**derived class**) to reuse the properties and methods of another class (**base class**).
- Promotes **code reusability** and **hierarchical relationships**.

### Syntax:

```csharp
class BaseClass
{
    public void ShowMessage()
    {
        Console.WriteLine("Message from BaseClass");
    }
}

class DerivedClass : BaseClass
{
    public void ShowDerivedMessage()
    {
        Console.WriteLine("Message from DerivedClass");
    }
}

class Program
{
    static void Main()
    {
        DerivedClass obj = new DerivedClass();
        obj.ShowMessage();        // Inherited from BaseClass
        obj.ShowDerivedMessage(); // Defined in DerivedClass
    }
}
```

👉 **Exercise:**

- Create a `Vehicle` base class with a method `Start()`.
- Create a `Car` derived class with a method `Drive()`.
- Demonstrate calling both methods from a `Car` object.

---

## 🔹 Method Overriding

### Virtual and Override

- Use `virtual` in the base class to allow overriding.
- Use `override` in the derived class to change behavior.

### Example:

```csharp
class Animal
{
    public virtual void Speak()
    {
        Console.WriteLine("Animal makes a sound");
    }
}

class Dog : Animal
{
    public override void Speak()
    {
        Console.WriteLine("Dog barks");
    }
}

class Program
{
    static void Main()
    {
        Animal a = new Animal();
        a.Speak(); // Animal makes a sound

        Dog d = new Dog();
        d.Speak(); // Dog barks
    }
}
```

👉 **Exercise:**

- Create a `Shape` base class with a virtual method `Draw()`.
- Override it in `Circle` and `Rectangle` classes to print different messages.

---

## 🔹 Polymorphism

### What is Polymorphism?

- **Polymorphism** means "many forms."
- Allows objects of different types to be treated as objects of a common base type.
- Achieved through **method overriding** and **interfaces**.

### Example:

```csharp
class Shape
{
    public virtual void Draw()
    {
        Console.WriteLine("Drawing a shape");
    }
}

class Circle : Shape
{
    public override void Draw()
    {
        Console.WriteLine("Drawing a circle");
    }
}

class Rectangle : Shape
{
    public override void Draw()
    {
        Console.WriteLine("Drawing a rectangle");
    }
}

class Program
{
    static void Main()
    {
        Shape[] shapes = { new Circle(), new Rectangle() };

        foreach (var shape in shapes)
        {
            shape.Draw(); // Calls appropriate method
        }
    }
}
```

👉 **Exercise:**

- Create a `Payment` base class with a virtual method `ProcessPayment()`.
- Override it in `CreditCardPayment` and `PayPalPayment` classes.
- Demonstrate polymorphism by storing them in a `Payment[]` array and calling `ProcessPayment()`.

---

## 🔹 Abstract Classes

### What is an Abstract Class?

- A class that **cannot be instantiated**.
- May contain abstract methods (no implementation).
- Derived classes must implement abstract methods.

### Example:

```csharp
abstract class Animal
{
    public abstract void Speak();
}

class Cat : Animal
{
    public override void Speak()
    {
        Console.WriteLine("Cat meows");
    }
}

class Program
{
    static void Main()
    {
        Animal a = new Cat();
        a.Speak(); // Cat meows
    }
}
```

👉 **Exercise:**

- Create an abstract class `Employee` with an abstract method `CalculateSalary()`.
- Implement it in `FullTimeEmployee` and `PartTimeEmployee` classes.

---

## 🔹 Interfaces

### What is an Interface?

- Defines a **contract** with methods/properties but no implementation.
- Classes that implement the interface must provide implementation.
- Supports **multiple inheritance** (unlike classes).

### Example:

```csharp
interface IPrintable
{
    void Print();
}

class Report : IPrintable
{
    public void Print()
    {
        Console.WriteLine("Printing report...");
    }
}

class Program
{
    static void Main()
    {
        IPrintable printable = new Report();
        printable.Print();
    }
}
```

👉 **Exercise:**

- Create an interface `IDriveable` with method `Drive()`.
- Implement it in `Car` and `Bike` classes.
- Demonstrate polymorphism by calling `Drive()` on both.

---

## 📘 Chapter Summary

In this chapter, you learned:

- How to use **inheritance** to reuse code
- How to override methods with `virtual` and `override`
- How **polymorphism** enables flexible behavior
- How to design with **abstract classes** and **interfaces**

👉 You also practiced exercises to reinforce learning.
