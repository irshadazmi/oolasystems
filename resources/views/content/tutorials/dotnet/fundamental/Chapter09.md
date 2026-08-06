# Chapter 9: Async and Multithreading – Task-based Programming and Parallelism

---

In this chapter, we explore **asynchronous programming** and **multithreading** in C#.  
These concepts are critical for building responsive, scalable, and high-performance applications.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the difference between **synchronous** and **asynchronous** programming
- Learn about the **Task Parallel Library (TPL)**
- Use **async/await** for asynchronous operations
- Explore **threads** and the **Thread class**
- Implement **parallel programming patterns** with `Parallel` and PLINQ
- Practice hands-on exercises to reinforce learning

---

## 🔹 Synchronous vs Asynchronous Programming

### Synchronous

- Code executes **line by line**.
- Blocks execution until a task completes.

```csharp
Console.WriteLine("Start");
Thread.Sleep(2000); // Blocks for 2 seconds
Console.WriteLine("End");
```

### Asynchronous

- Code executes without blocking.
- Frees up resources while waiting.

```csharp
Console.WriteLine("Start");
await Task.Delay(2000); // Non-blocking wait
Console.WriteLine("End");
```

👉 **Exercise:**

- Write a synchronous program that downloads a file (simulate with `Thread.Sleep`).
- Convert it to asynchronous using `Task.Delay`.

---

## 🔹 Task Parallel Library (TPL)

### What is TPL?

- Provides high-level APIs for parallelism.
- Uses `Task` objects to represent asynchronous operations.

### Example:

```csharp
using System;
using System.Threading.Tasks;

class Program
{
    static void Main()
    {
        Task task = Task.Run(() =>
        {
            Console.WriteLine("Task running...");
        });

        task.Wait(); // Wait for completion
    }
}
```

👉 **Exercise:**

- Create a task that calculates the sum of numbers from 1 to 1000.

---

## 🔹 Async and Await

### Async Methods

- Declared with `async` keyword.
- Return `Task` or `Task<T>`.

### Example:

```csharp
using System;
using System.Threading.Tasks;

class Program
{
    static async Task Main()
    {
        await PrintMessageAsync();
    }

    static async Task PrintMessageAsync()
    {
        await Task.Delay(2000);
        Console.WriteLine("Hello from async method!");
    }
}
```

👉 **Exercise:**

- Write an async method `DownloadDataAsync()` that simulates downloading data with `Task.Delay`.

---

## 🔹 Threads in C#

### Thread Class

- Represents a lightweight unit of execution.

### Example:

```csharp
using System;
using System.Threading;

class Program
{
    static void PrintNumbers()
    {
        for (int i = 1; i <= 5; i++)
        {
            Console.WriteLine(i);
            Thread.Sleep(500);
        }
    }

    static void Main()
    {
        Thread t = new Thread(PrintNumbers);
        t.Start();

        Console.WriteLine("Main thread continues...");
    }
}
```

👉 **Exercise:**

- Create two threads: one prints even numbers, the other prints odd numbers.

---

## 🔹 Parallel Programming

### Parallel.For

```csharp
using System;
using System.Threading.Tasks;

class Program
{
    static void Main()
    {
        Parallel.For(1, 6, i =>
        {
            Console.WriteLine($"Iteration {i}");
        });
    }
}
```

### Parallel.ForEach

```csharp
string[] names = { "Alice", "Bob", "Charlie" };

Parallel.ForEach(names, name =>
{
    Console.WriteLine($"Hello {name}");
});
```

👉 **Exercise:**

- Use `Parallel.For` to calculate squares of numbers from 1 to 10.

---

## 🔹 PLINQ (Parallel LINQ)

### Example:

```csharp
using System;
using System.Linq;

class Program
{
    static void Main()
    {
        var numbers = Enumerable.Range(1, 20);

        var evenSquares = numbers
            .AsParallel()
            .Where(n => n % 2 == 0)
            .Select(n => n * n);

        foreach (var square in evenSquares)
        {
            Console.WriteLine(square);
        }
    }
}
```

👉 **Exercise:**

- Use PLINQ to filter prime numbers from 1 to 100.

---

## 🔹 Synchronization

### Locking Shared Resources

```csharp
class Counter
{
    private int count = 0;
    private object lockObj = new object();

    public void Increment()
    {
        lock (lockObj)
        {
            count++;
        }
    }

    public int GetCount() => count;
}
```

👉 **Exercise:**

- Create a shared counter accessed by multiple threads.
- Use `lock` to prevent race conditions.

---

## 📘 Chapter Summary

In this chapter, you learned:

- The difference between **synchronous** and **asynchronous** programming
- How to use the **Task Parallel Library (TPL)**
- How to implement **async/await** methods
- How to create and manage **threads**
- How to use **Parallel.For**, **Parallel.ForEach**, and **PLINQ**
- How to synchronize shared resources with `lock`

👉 You also practiced exercises to reinforce learning.
