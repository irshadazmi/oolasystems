# Chapter 8: LINQ Deep Dive – Querying and Transforming Data

---

In this chapter, we explore **Language Integrated Query (LINQ)** in C#.  
LINQ provides a powerful, declarative way to query and transform data directly within C# code. It works with collections, databases, XML, and JSON.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand the basics of **LINQ** and its advantages
- Learn **query syntax** and **method syntax**
- Perform filtering, projection, ordering, and grouping
- Explore **deferred execution** and **immediate execution**
- Use LINQ with **Objects, Entities, XML, and JSON**
- Practice hands-on exercises to reinforce learning

---

## 🔹 Introduction to LINQ

### What is LINQ?

- **Language Integrated Query** (LINQ) is a set of features in C# that allows querying data in a consistent way.
- Works with **in-memory collections**, **databases (via EF Core)**, **XML**, and **JSON**.

### Advantages:

- Declarative, readable queries.
- Strongly typed with IntelliSense support.
- Reduces boilerplate code.

---

## 🔹 LINQ Syntax

### Query Syntax (SQL-like)

```csharp
int[] numbers = { 1, 2, 3, 4, 5, 6 };

var evenNumbers = from n in numbers
                  where n % 2 == 0
                  select n;

foreach (var num in evenNumbers)
{
    Console.WriteLine(num);
}
```

### Method Syntax (Fluent style)

```csharp
var evenNumbers = numbers.Where(n => n % 2 == 0);

foreach (var num in evenNumbers)
{
    Console.WriteLine(num);
}
```

👉 **Exercise:**

- Write a LINQ query to select all odd numbers from an array using both syntaxes.

---

## 🔹 LINQ to Objects

### Example:

```csharp
List<string> names = new List<string> { "Alice", "Bob", "Charlie", "David" };

var filteredNames = names.Where(name => name.StartsWith("A"));

foreach (var name in filteredNames)
{
    Console.WriteLine(name);
}
```

👉 **Exercise:**

- Filter students with marks greater than 75 from a list of integers.

---

## 🔹 LINQ to Entities

### Example (Entity Framework Core):

```csharp
using (var context = new AppDbContext())
{
    var employees = context.Employees
                           .Where(e => e.Salary > 50000)
                           .OrderBy(e => e.Name)
                           .ToList();

    foreach (var emp in employees)
    {
        Console.WriteLine($"{emp.Name} - {emp.Salary}");
    }
}
```

👉 **Exercise:**

- Query employees from a database where `Department = "IT"` and order them by salary.

---

## 🔹 LINQ to XML

### Example:

```csharp
using System.Xml.Linq;

XDocument doc = XDocument.Load("students.xml");

var students = from s in doc.Descendants("student")
               where (int)s.Element("marks") > 75
               select new
               {
                   Name = (string)s.Element("name"),
                   Marks = (int)s.Element("marks")
               };

foreach (var student in students)
{
    Console.WriteLine($"{student.Name} - {student.Marks}");
}
```

👉 **Exercise:**

- Load an XML file of books and query all books published after 2020.

---

## 🔹 LINQ to JSON

### Example (Newtonsoft.Json):

```csharp
using Newtonsoft.Json.Linq;

string json = @"{
  'students': [
    { 'name': 'Alice', 'marks': 85 },
    { 'name': 'Bob', 'marks': 65 }
  ]
}";

JObject obj = JObject.Parse(json);

var highScorers = obj["students"]
    .Where(s => (int)s["marks"] > 70)
    .Select(s => (string)s["name"]);

foreach (var name in highScorers)
{
    Console.WriteLine(name);
}
```

👉 **Exercise:**

- Parse a JSON string of products and query all products with price greater than 100.

---

## 🔹 Other LINQ Operations

### Projection (Select)

```csharp
var squares = numbers.Select(n => n * n);
```

### Ordering

```csharp
var orderedNames = names.OrderBy(n => n);
```

### Grouping

```csharp
var grouped = from s in names
              group s by s[0] into g
              select new { Initial = g.Key, Names = g };
```

### Deferred vs Immediate Execution

```csharp
var query = numbers.Where(n => n > 3); // Deferred
var result = numbers.Where(n => n > 3).ToList(); // Immediate
```

---

## 📘 Chapter Summary

In this chapter, you learned:

- The basics of **LINQ** and its syntax styles
- How to filter, project, order, and group data
- The difference between **deferred** and **immediate execution**
- How to apply LINQ to **Objects, Entities, XML, and JSON**

👉 You also practiced exercises to reinforce learning.
