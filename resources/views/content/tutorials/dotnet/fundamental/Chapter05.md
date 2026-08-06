# Chapter 5: SOLID Principles – Writing Maintainable and Scalable Code

---

In this chapter, we explore the **SOLID principles**, which are five key guidelines in object-oriented programming and design.  
They help developers write code that is **clean, maintainable, scalable, and flexible**.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the importance of **SOLID principles** in software design
- Learn each principle with examples in C#
- Apply these principles to improve code quality
- Practice exercises to reinforce learning

---

## 🔹 Single Responsibility Principle (SRP)

### Definition

- A class should have **only one reason to change**.
- Each class should focus on a **single responsibility**.

### Example (Violation):

```csharp
class Report
{
    public string Content { get; set; }

    public void GenerateReport()
    {
        Console.WriteLine("Report generated.");
    }

    public void SaveToFile(string filePath)
    {
        System.IO.File.WriteAllText(filePath, Content);
    }
}
```

👉 Problem: `Report` is handling both **report generation** and **file saving**.

### Corrected:

```csharp
class Report
{
    public string Content { get; set; }
    public void GenerateReport()
    {
        Console.WriteLine("Report generated.");
    }
}

class ReportSaver
{
    public void SaveToFile(string filePath, string content)
    {
        System.IO.File.WriteAllText(filePath, content);
    }
}
```

👉 **Exercise:**

- Refactor a `User` class that handles both user data and email sending into separate classes.

---

## 🔹 Open/Closed Principle (OCP)

### Definition

- Classes should be **open for extension** but **closed for modification**.
- You should be able to add new functionality without changing existing code.

### Example (Violation):

```csharp
class DiscountCalculator
{
    public double CalculateDiscount(string customerType, double amount)
    {
        if (customerType == "Regular")
            return amount * 0.1;
        else if (customerType == "Premium")
            return amount * 0.2;
        else
            return 0;
    }
}
```

👉 Problem: Adding new customer types requires modifying the class.

### Corrected:

```csharp
abstract class DiscountStrategy
{
    public abstract double GetDiscount(double amount);
}

class RegularDiscount : DiscountStrategy
{
    public override double GetDiscount(double amount) => amount * 0.1;
}

class PremiumDiscount : DiscountStrategy
{
    public override double GetDiscount(double amount) => amount * 0.2;
}

class DiscountCalculator
{
    public double CalculateDiscount(DiscountStrategy strategy, double amount)
    {
        return strategy.GetDiscount(amount);
    }
}
```

👉 **Exercise:**

- Add a new `StudentDiscount` strategy without modifying `DiscountCalculator`.

---

## 🔹 Liskov Substitution Principle (LSP)

### Definition

- Subclasses should be **substitutable** for their base classes without breaking functionality.
- Derived classes must honor the behavior expected of the base class.

### Example (Violation):

```csharp
class Bird
{
    public virtual void Fly()
    {
        Console.WriteLine("Flying...");
    }
}

class Ostrich : Bird
{
    public override void Fly()
    {
        throw new NotImplementedException(); // Ostrich cannot fly
    }
}
```

👉 Problem: Substituting `Ostrich` for `Bird` breaks expectations.

### Corrected:

```csharp
abstract class Bird
{
    public abstract void Move();
}

class Sparrow : Bird
{
    public override void Move() => Console.WriteLine("Flying...");
}

class Ostrich : Bird
{
    public override void Move() => Console.WriteLine("Running...");
}
```

👉 **Exercise:**

- Create a `Penguin` class that swims instead of flying, while still respecting LSP.

---

## 🔹 Interface Segregation Principle (ISP)

### Definition

- Clients should not be forced to depend on interfaces they do not use.
- Prefer **smaller, specific interfaces** over large, general ones.

### Example (Violation):

```csharp
interface IWorker
{
    void Work();
    void Eat();
}

class Robot : IWorker
{
    public void Work() => Console.WriteLine("Robot working...");
    public void Eat() => throw new NotImplementedException(); // Robots don't eat
}
```

### Corrected:

```csharp
interface IWorkable
{
    void Work();
}

interface IEatable
{
    void Eat();
}

class Human : IWorkable, IEatable
{
    public void Work() => Console.WriteLine("Human working...");
    public void Eat() => Console.WriteLine("Human eating...");
}

class Robot : IWorkable
{
    public void Work() => Console.WriteLine("Robot working...");
}
```

👉 **Exercise:**

- Create separate interfaces for `IDriveable` and `IFlyable`. Implement them in `Car` and `Airplane`.

---

## 🔹 Dependency Inversion Principle (DIP)

### Definition

- High-level modules should not depend on low-level modules.
- Both should depend on **abstractions**.
- Use **interfaces** or **abstract classes** to decouple dependencies.

### Example (Violation):

```csharp
class FileLogger
{
    public void Log(string message)
    {
        Console.WriteLine("Logging to file: " + message);
    }
}

class App
{
    private FileLogger logger = new FileLogger();

    public void Run()
    {
        logger.Log("App started.");
    }
}
```

👉 Problem: `App` is tightly coupled to `FileLogger`.

### Corrected:

```csharp
interface ILogger
{
    void Log(string message);
}

class FileLogger : ILogger
{
    public void Log(string message)
    {
        Console.WriteLine("Logging to file: " + message);
    }
}

class ConsoleLogger : ILogger
{
    public void Log(string message)
    {
        Console.WriteLine("Logging to console: " + message);
    }
}

class App
{
    private readonly ILogger logger;

    public App(ILogger logger)
    {
        this.logger = logger;
    }

    public void Run()
    {
        logger.Log("App started.");
    }
}
```

👉 **Exercise:**

- Implement a `DatabaseLogger` and inject it into `App` without modifying `App`.

---

## 📘 Chapter Summary

In this chapter, you learned the **SOLID principles**:

1. **Single Responsibility Principle** – One reason to change
2. **Open/Closed Principle** – Open for extension, closed for modification
3. **Liskov Substitution Principle** – Subclasses must be substitutable
4. **Interface Segregation Principle** – Prefer small, specific interfaces
5. **Dependency Inversion Principle** – Depend on abstractions, not implementations

👉 Applying these principles leads to cleaner, more maintainable, and scalable code.
