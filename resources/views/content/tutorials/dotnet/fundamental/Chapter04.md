# Chapter 4: Object-Oriented Programming – Classes, Objects, and Encapsulation

---

In this chapter, we begin exploring **Object-Oriented Programming (OOP)** in C#.  
OOP is one of the most important paradigms in modern software development, enabling developers to build scalable, reusable, and maintainable applications.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the concept of **classes and objects**
- Learn how to define and instantiate classes in C#
- Explore **constructors** and their role in initialization
- Apply **encapsulation** using access modifiers and properties
- Practice hands-on exercises to reinforce learning

---

## 🔹 Introduction to OOP

### What is OOP?

- A programming paradigm based on **objects** rather than functions.
- Objects combine **data (fields)** and **behavior (methods)**.
- Promotes **reusability, modularity, and abstraction**.

### Four Pillars of OOP:

1. **Encapsulation** – Hiding internal details.
2. **Abstraction** – Exposing only essential features.
3. **Inheritance** – Reusing code across classes.
4. **Polymorphism** – Multiple forms of behavior.

👉 In this chapter, we focus on **Classes, Objects, and Encapsulation**.

---

## 🔹 Classes in C#

### What is a Class?

- A **blueprint** for creating objects.
- Defines **fields (data)** and **methods (behavior)**.

### Syntax:

```csharp
class Person
{
    public string Name;
    public int Age;

    public void Introduce()
    {
        Console.WriteLine($"Hi, I am {Name}, and I am {Age} years old.");
    }
}
```

👉 **Exercise:**

- Create a `Car` class with fields `Brand` and `Year`.
- Add a method `ShowDetails()` to print car info.

---

## 🔹 Objects in C#

### What is an Object?

- An **instance of a class**.
- Created using the `new` keyword.

### Example:

```csharp
class Program
{
    static void Main()
    {
        Person p1 = new Person();
        p1.Name = "Alice";
        p1.Age = 25;
        p1.Introduce();

        Person p2 = new Person();
        p2.Name = "Bob";
        p2.Age = 30;
        p2.Introduce();
    }
}
```

👉 **Exercise:**

- Create two `Car` objects and display their details.

---

## 🔹 Constructors

### What is a Constructor?

- A **special method** used to initialize objects.
- Same name as the class.
- Called automatically when an object is created.

### Example:

```csharp
class Person
{
    public string Name;
    public int Age;

    // Constructor
    public Person(string name, int age)
    {
        Name = name;
        Age = age;
    }

    public void Introduce()
    {
        Console.WriteLine($"Hi, I am {Name}, and I am {Age} years old.");
    }
}

class Program
{
    static void Main()
    {
        Person p = new Person("Charlie", 28);
        p.Introduce();
    }
}
```

👉 **Exercise:**

- Add a constructor to the `Car` class that initializes `Brand` and `Year`.

---

## 🔹 Encapsulation

### What is Encapsulation?

- **Hiding internal details** and exposing only necessary functionality.
- Achieved using **access modifiers** and **properties**.

### Access Modifiers:

- `public` → Accessible everywhere.
- `private` → Accessible only within the class.
- `protected` → Accessible within class and derived classes.
- `internal` → Accessible within the same assembly.

### Example with Private Fields:

```csharp
class BankAccount
{
    private double balance;

    public void Deposit(double amount)
    {
        balance += amount;
    }

    public void Withdraw(double amount)
    {
        if (amount <= balance)
            balance -= amount;
        else
            Console.WriteLine("Insufficient funds!");
    }

    public double GetBalance()
    {
        return balance;
    }
}

class Program
{
    static void Main()
    {
        BankAccount account = new BankAccount();
        account.Deposit(1000);
        account.Withdraw(500);
        Console.WriteLine("Balance: " + account.GetBalance());
    }
}
```

👉 **Exercise:**

- Create a `Student` class with private fields `Name` and `Grade`.
- Provide public methods to set and get values safely.

---

## 🔹 Properties in C#

### What are Properties?

- A cleaner way to expose private fields.
- Provide **getters and setters** with optional validation.

### Example:

```csharp
class Student
{
    private int age;

    public int Age
    {
        get { return age; }
        set
        {
            if (value > 0)
                age = value;
            else
                Console.WriteLine("Age must be positive!");
        }
    }
}

class Program
{
    static void Main()
    {
        Student s = new Student();
        s.Age = 20; // Valid
        Console.WriteLine("Age: " + s.Age);

        s.Age = -5; // Invalid
    }
}
```

👉 **Exercise:**

- Add a property `Grade` to the `Student` class with validation (must be between 0 and 100).

---

## 📘 Chapter Summary

In this chapter, you learned:

- How to define **classes** and create **objects**
- How to use **constructors** for initialization
- How to apply **encapsulation** with access modifiers
- How to use **properties** for safe data access

👉 You also practiced exercises to reinforce learning.
