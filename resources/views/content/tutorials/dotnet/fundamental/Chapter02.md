# Chapter 2: C# Basics – Variables, Data Types, Operators, Control Flow, and I/O

---

In this chapter, we dive into the **building blocks of C# programming**.  
You’ll learn how to declare and use variables, understand data types, apply operators, control program flow with conditions and loops, and perform basic input/output operations.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand **variables and data types** in C#
- Use **operators** for arithmetic, comparison, and logic
- Apply **control flow statements** (if, switch, loops)
- Perform **input/output operations** with the console
- Practice hands-on exercises to reinforce learning

---

## 🧩 Variables and Data Types

### What is a Variable?

- A **named storage location** in memory.
- Holds data that can change during program execution.

### Syntax:

```csharp
int age = 25;
string name = "Irshad";
double salary = 55000.75;
```

### Common Data Types:

| Type    | Example | Description              |
| ------- | ------- | ------------------------ |
| int     | 42      | Whole numbers            |
| double  | 3.14    | Floating-point numbers   |
| decimal | 199.99m | High-precision for money |
| char    | 'A'     | Single character         |
| string  | "Hello" | Text                     |
| bool    | true    | Boolean values           |

### Example:

```csharp
using System;

class Program
{
    static void Main()
    {
        int age = 30;
        string name = "Alice";
        bool isStudent = true;

        Console.WriteLine($"{name} is {age} years old. Student: {isStudent}");
    }
}
```

👉 **Exercise:**

- Declare variables for your name, age, and monthly salary.
- Print them in a formatted sentence.

---

## ➗ Operators in C#

### Arithmetic Operators

```csharp
int a = 10, b = 3;
Console.WriteLine(a + b); // 13
Console.WriteLine(a - b); // 7
Console.WriteLine(a * b); // 30
Console.WriteLine(a / b); // 3
Console.WriteLine(a % b); // 1
```

### Comparison Operators

```csharp
Console.WriteLine(a > b);  // true
Console.WriteLine(a == b); // false
Console.WriteLine(a != b); // true
```

### Logical Operators

```csharp
bool x = true, y = false;
Console.WriteLine(x && y); // false
Console.WriteLine(x || y); // true
Console.WriteLine(!x);     // false
```

👉 **Exercise:**

- Write a program to check if a number is even or odd using `%` operator.
- Write a program to compare two numbers and print the larger one.

---

## 🔀 Control Flow

### If-Else Statement

```csharp
int marks = 85;
if (marks >= 90)
    Console.WriteLine("Grade A");
else if (marks >= 75)
    Console.WriteLine("Grade B");
else
    Console.WriteLine("Grade C");
```

### Switch Statement

```csharp
int day = 3;
switch (day)
{
    case 1: Console.WriteLine("Monday"); break;
    case 2: Console.WriteLine("Tuesday"); break;
    case 3: Console.WriteLine("Wednesday"); break;
    default: Console.WriteLine("Invalid day"); break;
}
```

### Loops

#### For Loop

```csharp
for (int i = 1; i <= 5; i++)
{
    Console.WriteLine("Iteration: " + i);
}
```

#### While Loop

```csharp
int count = 1;
while (count <= 5)
{
    Console.WriteLine("Count: " + count);
    count++;
}
```

#### Do-While Loop

```csharp
int num = 1;
do
{
    Console.WriteLine("Number: " + num);
    num++;
} while (num <= 5);
```

👉 **Exercise:**

- Write a program to print numbers from 1 to 10 using `for`.
- Write a program to calculate the sum of numbers from 1 to 100 using `while`.
- Write a program to display a multiplication table using `do-while`.

---

## ⌨️ Input/Output Basics

### Console Output

```csharp
Console.WriteLine("Hello, World!");
Console.Write("Enter your name: ");
```

### Console Input

```csharp
string name = Console.ReadLine();
Console.WriteLine("Welcome, " + name);
```

### Parsing Input

```csharp
Console.Write("Enter your age: ");
int age = int.Parse(Console.ReadLine());
Console.WriteLine("You are " + age + " years old.");
```

👉 **Exercise:**

- Write a program to ask the user for two numbers and print their sum.
- Write a program to ask for a name and age, then print:  
  `"Hello John, you are 25 years old."`

---

## 📘 Chapter Summary

In this chapter, you learned:

- How to declare and use **variables and data types**
- How to apply **operators** for calculations and logic
- How to control program flow with **if, switch, and loops**
- How to perform **basic input/output operations**

👉 You also practiced exercises to reinforce learning.
