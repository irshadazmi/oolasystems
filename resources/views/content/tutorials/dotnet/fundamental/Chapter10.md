# Chapter 10: Mini Project – Console-based Expense Tracker

---

In this chapter, we build a **Console-based Expense Tracker** application in C#.  
This project integrates concepts from previous chapters: variables, data types, control flow, methods, OOP, data structures, LINQ, and async programming.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Apply programming fundamentals in a real-world project
- Design classes and objects for expense management
- Use collections (Lists, Dictionaries) to store data
- Implement CRUD operations (Add, View, Update, Delete)
- Use LINQ for querying and reporting expenses
- Apply async methods for saving/loading data
- Practice modular design and encapsulation

---

## 🔹 Project Overview

The **Expense Tracker** will allow users to:

- Add new expenses (amount, category, description, date)
- View all expenses
- Search/filter expenses by category or date
- Calculate totals and summaries
- Save and load expenses asynchronously (simulated with files)

---

## 🔹 Step 1: Define the Expense Class

```csharp
using System;

class Expense
{
    public int Id { get; set; }
    public double Amount { get; set; }
    public string Category { get; set; }
    public string Description { get; set; }
    public DateTime Date { get; set; }

    public override string ToString()
    {
        return $"[{Id}] {Date.ToShortDateString()} - {Category} - {Description} - ${Amount}";
    }
}
```

👉 **Exercise:**

- Add a property `PaymentMode` (Cash/Card/UPI).
- Update `ToString()` to include it.

---

## 🔹 Step 2: Expense Manager Class

```csharp
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

class ExpenseManager
{
    private List<Expense> expenses = new List<Expense>();
    private int nextId = 1;

    public void AddExpense(double amount, string category, string description, DateTime date)
    {
        Expense e = new Expense
        {
            Id = nextId++,
            Amount = amount,
            Category = category,
            Description = description,
            Date = date
        };
        expenses.Add(e);
        Console.WriteLine("Expense added successfully!");
    }

    public void ViewExpenses()
    {
        foreach (var e in expenses)
        {
            Console.WriteLine(e);
        }
    }

    public void DeleteExpense(int id)
    {
        var expense = expenses.FirstOrDefault(e => e.Id == id);
        if (expense != null)
        {
            expenses.Remove(expense);
            Console.WriteLine("Expense deleted.");
        }
        else
        {
            Console.WriteLine("Expense not found.");
        }
    }

    public void SummaryByCategory()
    {
        var summary = expenses.GroupBy(e => e.Category)
                              .Select(g => new { Category = g.Key, Total = g.Sum(e => e.Amount) });

        foreach (var s in summary)
        {
            Console.WriteLine($"{s.Category}: ${s.Total}");
        }
    }

    public async Task SaveToFileAsync(string filePath)
    {
        var lines = expenses.Select(e => $"{e.Id},{e.Amount},{e.Category},{e.Description},{e.Date}");
        await System.IO.File.WriteAllLinesAsync(filePath, lines);
        Console.WriteLine("Expenses saved to file.");
    }

    public async Task LoadFromFileAsync(string filePath)
    {
        if (System.IO.File.Exists(filePath))
        {
            var lines = await System.IO.File.ReadAllLinesAsync(filePath);
            foreach (var line in lines)
            {
                var parts = line.Split(',');
                expenses.Add(new Expense
                {
                    Id = int.Parse(parts[0]),
                    Amount = double.Parse(parts[1]),
                    Category = parts[2],
                    Description = parts[3],
                    Date = DateTime.Parse(parts[4])
                });
            }
            Console.WriteLine("Expenses loaded from file.");
        }
    }
}
```

👉 **Exercise:**

- Add a method `SearchByDate(DateTime date)` to filter expenses by date.

---

## 🔹 Step 3: Program Entry Point

```csharp
using System;

class Program
{
    static async System.Threading.Tasks.Task Main()
    {
        ExpenseManager manager = new ExpenseManager();
        bool exit = false;

        while (!exit)
        {
            Console.WriteLine("\n--- Expense Tracker ---");
            Console.WriteLine("1. Add Expense");
            Console.WriteLine("2. View Expenses");
            Console.WriteLine("3. Delete Expense");
            Console.WriteLine("4. Summary by Category");
            Console.WriteLine("5. Save to File");
            Console.WriteLine("6. Load from File");
            Console.WriteLine("7. Exit");
            Console.Write("Choose an option: ");

            int choice = int.Parse(Console.ReadLine());

            switch (choice)
            {
                case 1:
                    Console.Write("Amount: ");
                    double amount = double.Parse(Console.ReadLine());
                    Console.Write("Category: ");
                    string category = Console.ReadLine();
                    Console.Write("Description: ");
                    string description = Console.ReadLine();
                    Console.Write("Date (yyyy-mm-dd): ");
                    DateTime date = DateTime.Parse(Console.ReadLine());
                    manager.AddExpense(amount, category, description, date);
                    break;

                case 2:
                    manager.ViewExpenses();
                    break;

                case 3:
                    Console.Write("Enter Expense ID to delete: ");
                    int id = int.Parse(Console.ReadLine());
                    manager.DeleteExpense(id);
                    break;

                case 4:
                    manager.SummaryByCategory();
                    break;

                case 5:
                    await manager.SaveToFileAsync("expenses.txt");
                    break;

                case 6:
                    await manager.LoadFromFileAsync("expenses.txt");
                    break;

                case 7:
                    exit = true;
                    break;

                default:
                    Console.WriteLine("Invalid choice.");
                    break;
            }
        }
    }
}
```

---

## 🔹 Sample Run

```
--- Expense Tracker ---
1. Add Expense
2. View Expenses
3. Delete Expense
4. Summary by Category
5. Save to File
6. Load from File
7. Exit
Choose an option: 1
Amount: 100
Category: Food
Description: Lunch
Date (yyyy-mm-dd): 2026-04-28
Expense added successfully!
```

---

## 📘 Chapter Summary

In this chapter, you built a **Console-based Expense Tracker** that demonstrated:

- **Classes and Objects** for modeling expenses
- **Lists and LINQ** for storing and querying data
- **CRUD operations** for managing expenses
- **Async methods** for saving and loading data
- **Encapsulation and modular design**

👉 This project consolidates all fundamentals into a practical application.
