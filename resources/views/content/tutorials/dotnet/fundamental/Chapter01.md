# Chapter 1: Orientation & Setup

---

In this chapter, we establish the foundation for learning **Programming Fundamentals with C# and .NET**.

We’ll explore the **.NET ecosystem**, understand the **role of C# in modern development**, set up the development environment, and finally write and experiment with our first **Hello World** program.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the **.NET ecosystem** and its relevance in industry
- Recognize the **role of C#** in modern applications
- Set up **Visual Studio / VS Code** for development
- Create, run, and modify your first **C# console application**
- Practice hands-on exercises to reinforce learning

---

## 🌐 Introduction to the .NET Ecosystem

### What is .NET?

- A **developer platform** created by Microsoft for building apps across web, desktop, mobile, cloud, gaming, and IoT.
- Supports multiple languages: **C#, F#, VB.NET**.
- Provides a **runtime (CLR)**, **libraries**, and **tools**.

### Key Components:

- **.NET SDK** → Tools & compilers to build apps.
- **CLR (Common Language Runtime)** → Executes code, manages memory, handles exceptions.
- **BCL (Base Class Library)** → Prebuilt classes for I/O, collections, networking, etc.
- **ASP.NET Core** → Web framework for APIs and MVC apps.
- **Entity Framework Core** → ORM for database access.

### Example Discussion:

- Compare **Java ecosystem vs .NET ecosystem**.
- Show how **.NET Core** runs cross-platform (Windows, Linux, macOS).

👉 **Exercise:**

- Research 3 companies using .NET Core in production.
- Discuss why enterprises prefer .NET for mission-critical apps.

---

## 💡 C# Role in Modern Development

### Why C#?

- **Object-oriented** → Classes, inheritance, polymorphism.
- **Modern features** → LINQ, async/await, pattern matching.
- **Enterprise adoption** → Banking, healthcare, SaaS platforms.
- **Versatility** → Web APIs, desktop apps, mobile apps (MAUI), games (Unity).

### Example Code: LINQ in C#

```csharp
using System;
using System.Linq;

class Program
{
    static void Main()
    {
        int[] numbers = { 1, 2, 3, 4, 5 };
        var evenNumbers = numbers.Where(n => n % 2 == 0);

        Console.WriteLine("Even Numbers:");
        foreach (var num in evenNumbers)
        {
            Console.WriteLine(num);
        }
    }
}
```

👉 **Exercise:**

- Write a program to filter names starting with “A” from a list.
- Discuss how LINQ simplifies collection handling compared to loops.

---

## 🛠️ Setting up Visual Studio / VS Code

### Option 1: Visual Studio

- Download **Visual Studio Community Edition**.
- Select **“.NET desktop development” workload**.
- Create a new project → Console App (.NET Core).

### Option 2: Visual Studio Code

- Install **VS Code**.
- Extensions:
    - C# (OmniSharp)
    - .NET Install Tool
    - GitHub integration
- Verify installation:

```bash
dotnet --version
```

👉 **Exercise:**

- Create a new folder `Fundamentals` and initialize a console project:

```bash
dotnet new console -n FundamentalsApp
cd FundamentalsApp
dotnet run
```

---

## ▶️ First C# Program (Hello World)

### Step 1: Create Project

```bash
dotnet new console -n HelloWorldApp
cd HelloWorldApp
```

### Step 2: Program.cs

```csharp
using System;

class Program
{
    static void Main(string[] args)
    {
        Console.WriteLine("Hello, World!");
    }
}
```

### Step 3: Run

```bash
dotnet run
```

👉 Output:

```
Hello, World!
```

---

### Step 4: Modify Program

Experiment with variations:

```csharp
Console.WriteLine("Welcome to .NET Training!");
Console.WriteLine("Today’s Date: " + DateTime.Now);
Console.WriteLine("Your lucky number is: " + new Random().Next(1, 100));
```

👉 **Exercise:**

- Print your name, today’s date, and a random number.
- Discuss how `DateTime` and `Random` are part of the **Base Class Library**.

---

### Step 5: Input & Output

```csharp
Console.Write("Enter your name: ");
string name = Console.ReadLine();
Console.WriteLine("Hello, " + name + "!");
```

👉 **Exercise:**

- Extend program to ask for age and print:  
  `"Hello John, you are 25 years old."`

---

### Step 6: Debugging Basics

- Use breakpoints in Visual Studio.
- Step through code execution.
- Inspect variables in the debugger.

👉 **Exercise:**

- Debug the HelloWorld program and watch variable values.

---

## 📘 Chapter Summary

In this chapter, you:

- Explored the **.NET ecosystem** and its components
- Understood the **role of C#** in modern development
- Set up **Visual Studio / VS Code**
- Built and modified your first **Hello World program**
- Practiced input/output, random numbers, and debugging
