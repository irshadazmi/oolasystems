# Chapter 7: Data Structures Basics – Arrays, Lists, Dictionaries, Stacks, and Queues

---

In this chapter, we explore **data structures in C#**, which are essential for storing and organizing data efficiently.  
You’ll learn how to use arrays, lists, dictionaries, stacks, and queues, along with practical coding examples.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the role of **data structures** in programming
- Learn how to use **arrays** for fixed-size collections
- Explore **lists** for dynamic collections
- Work with **dictionaries** for key-value storage
- Implement **stacks** and **queues** for specialized data handling
- Practice exercises to reinforce learning

---

## 🔹 Arrays

### What is an Array?

- An **array** is a fixed-size collection of elements of the same type.
- Elements are stored in **contiguous memory locations**.

### Syntax:

```csharp
int[] numbers = new int[5]; // Array of size 5
numbers[0] = 10;
numbers[1] = 20;
```

### Example:

```csharp
using System;

class Program
{
    static void Main()
    {
        int[] scores = { 90, 85, 70, 95, 100 };

        Console.WriteLine("Scores:");
        foreach (int score in scores)
        {
            Console.WriteLine(score);
        }
    }
}
```

👉 **Exercise:**

- Create an array of 10 integers.
- Print the sum and average of all elements.

---

## 🔹 Lists

### What is a List?

- A **List** is a dynamic collection that can grow or shrink at runtime.
- Part of the **System.Collections.Generic** namespace.

### Example:

```csharp
using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        List<string> fruits = new List<string>();
        fruits.Add("Apple");
        fruits.Add("Banana");
        fruits.Add("Cherry");

        Console.WriteLine("Fruits:");
        foreach (string fruit in fruits)
        {
            Console.WriteLine(fruit);
        }
    }
}
```

### Common Operations:

```csharp
fruits.Remove("Banana");
fruits.Insert(1, "Mango");
Console.WriteLine("Count: " + fruits.Count);
```

👉 **Exercise:**

- Create a list of student names.
- Add 5 names, remove 1, and print the remaining names.

---

## 🔹 Dictionaries

### What is a Dictionary?

- A **Dictionary** stores data in **key-value pairs**.
- Keys must be unique.
- Useful for fast lookups.

### Example:

```csharp
using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        Dictionary<int, string> employees = new Dictionary<int, string>();
        employees.Add(101, "Alice");
        employees.Add(102, "Bob");
        employees.Add(103, "Charlie");

        Console.WriteLine("Employees:");
        foreach (var kvp in employees)
        {
            Console.WriteLine($"ID: {kvp.Key}, Name: {kvp.Value}");
        }
    }
}
```

### Lookup:

```csharp
if (employees.ContainsKey(102))
{
    Console.WriteLine("Employee 102: " + employees[102]);
}
```

👉 **Exercise:**

- Create a dictionary of product IDs and names.
- Print all products and search for a specific ID.

---

## 🔹 Stacks

### What is a Stack?

- A **Stack** is a collection that follows **LIFO (Last In, First Out)**.
- Useful for undo operations, expression evaluation, etc.

### Example:

```csharp
using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        Stack<int> stack = new Stack<int>();
        stack.Push(10);
        stack.Push(20);
        stack.Push(30);

        Console.WriteLine("Stack elements:");
        foreach (int item in stack)
        {
            Console.WriteLine(item);
        }

        Console.WriteLine("Popped: " + stack.Pop()); // Removes 30
        Console.WriteLine("Peek: " + stack.Peek());  // Shows 20
    }
}
```

👉 **Exercise:**

- Push 5 numbers onto a stack.
- Pop 2 numbers and print the remaining stack.

---

## 🔹 Queues

### What is a Queue?

- A **Queue** is a collection that follows **FIFO (First In, First Out)**.
- Useful for scheduling tasks, message handling, etc.

### Example:

```csharp
using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        Queue<string> queue = new Queue<string>();
        queue.Enqueue("Task1");
        queue.Enqueue("Task2");
        queue.Enqueue("Task3");

        Console.WriteLine("Queue elements:");
        foreach (string task in queue)
        {
            Console.WriteLine(task);
        }

        Console.WriteLine("Dequeued: " + queue.Dequeue()); // Removes Task1
        Console.WriteLine("Peek: " + queue.Peek());        // Shows Task2
    }
}
```

👉 **Exercise:**

- Enqueue 5 tasks into a queue.
- Dequeue 2 tasks and print the remaining queue.

---

## 📘 Chapter Summary

In this chapter, you learned:

- How to use **arrays** for fixed-size collections
- How to use **lists** for dynamic collections
- How to store key-value pairs in **dictionaries**
- How to implement **stacks (LIFO)** and **queues (FIFO)**

👉 You also practiced exercises to reinforce learning.
