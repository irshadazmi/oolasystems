# Chapter 3: Methods & Functions – Parameters, Return Types, and Scope

---

In this chapter, we explore **methods and functions in C#**, which are the building blocks of reusable and organized code.  
You’ll learn how to define methods, pass parameters, return values, and understand scope. We’ll also cover advanced topics like method overloading and static methods.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand what methods are and why they are used
- Define and call methods in C#
- Work with parameters and return types
- Explore method overloading and static methods
- Understand variable scope and lifetime
- Practice exercises to reinforce learning

---

## 🔹 Introduction to Methods

### What is a Method?

- A **method** is a block of code that performs a specific task.
- Helps in **code reusability** and **modularity**.
- Reduces duplication and improves readability.

### Syntax:

```csharp
returnType MethodName(parameters)
{
    // code block
    return value; // optional
}
```

### Example:

```csharp
using System;

class Program
{
    static void Greet()
    {
        Console.WriteLine("Hello, welcome to C# training!");
    }

    static void Main()
    {
        Greet(); // Calling the method
    }
}
```

👉 **Exercise:**

- Write a method `SayHello()` that prints your name.
- Call it from `Main()`.

---

## 🔹 Parameters in Methods

### Passing Parameters

Parameters allow methods to accept input values.

```csharp
static void PrintSum(int a, int b)
{
    Console.WriteLine("Sum: " + (a + b));
}

static void Main()
{
    PrintSum(5, 10); // Output: Sum: 15
}
```

### Multiple Parameters

```csharp
static void PrintDetails(string name, int age)
{
    Console.WriteLine($"{name} is {age} years old.");
}
```

### Default Parameters

```csharp
static void Greet(string name = "Guest")
{
    Console.WriteLine("Hello, " + name);
}
```

👉 **Exercise:**

- Write a method `CalculateArea(int length, int width)` that prints the area of a rectangle.
- Call it with different values.

---

## 🔹 Return Types

### Returning Values

Methods can return values using `return`.

```csharp
static int Square(int number)
{
    return number * number;
}

static void Main()
{
    int result = Square(5);
    Console.WriteLine("Square: " + result);
}
```

### Returning Strings

```csharp
static string GetGreeting(string name)
{
    return "Hello, " + name;
}
```

👉 **Exercise:**

- Write a method `AddNumbers(int a, int b)` that returns the sum.
- Print the result in `Main()`.

---

## 🔹 Method Overloading

### What is Overloading?

- Defining multiple methods with the same name but different parameters.
- Improves flexibility.

### Example:

```csharp
static int Multiply(int a, int b)
{
    return a * b;
}

static double Multiply(double a, double b)
{
    return a * b;
}

static void Main()
{
    Console.WriteLine(Multiply(3, 4));      // 12
    Console.WriteLine(Multiply(2.5, 4.2));  // 10.5
}
```

👉 **Exercise:**

- Create overloaded methods `PrintInfo()` that accept either a string (name) or string + int (name + age).

---

## 🔹 Static vs Instance Methods

### Static Methods

- Belong to the class, not an object.
- Called using the class name.

```csharp
class MathHelper
{
    public static int Add(int a, int b)
    {
        return a + b;
    }
}

class Program
{
    static void Main()
    {
        Console.WriteLine(MathHelper.Add(5, 7));
    }
}
```

### Instance Methods

- Require an object to call.

```csharp
class Person
{
    public string Name;

    public void Introduce()
    {
        Console.WriteLine("Hi, I am " + Name);
    }
}

class Program
{
    static void Main()
    {
        Person p = new Person();
        p.Name = "Alice";
        p.Introduce();
    }
}
```

👉 **Exercise:**

- Create a `Calculator` class with both static and instance methods for addition and subtraction.

---

## 🔹 Scope and Lifetime of Variables

### Local Variables

- Declared inside a method.
- Exist only while the method runs.

```csharp
static void ShowMessage()
{
    string message = "Hello!";
    Console.WriteLine(message);
}
```

### Global Variables (Fields)

- Declared inside a class but outside methods.
- Accessible by all methods in the class.

```csharp
class Program
{
    static int counter = 0;

    static void Increment()
    {
        counter++;
        Console.WriteLine("Counter: " + counter);
    }

    static void Main()
    {
        Increment();
        Increment();
    }
}
```

👉 **Exercise:**

- Create a global counter variable and increment it each time a method is called.

---

## 📘 Chapter Summary

In this chapter, you learned:

- What methods are and why they are important
- How to define and call methods
- How to use parameters and return values
- Method overloading for flexibility
- Difference between static and instance methods
- Scope and lifetime of variables

👉 You also practiced exercises to reinforce learning.
