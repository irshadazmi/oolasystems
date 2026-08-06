# Chapter 6: Functional Programming, Lambda Expressions & Stream API

---

# Introduction

Java 8 introduced a major evolution in the Java programming language.

Before Java 8, developers primarily used:

- Classes
- Objects
- Loops
- Iterators

While these approaches remain important, modern enterprise applications increasingly leverage:

- Functional Programming
- Lambda Expressions
- Functional Interfaces
- Stream API

These features help developers write:

- Cleaner Code
- More Readable Code
- Less Boilerplate
- More Maintainable Applications

In this chapter, we will learn modern Java programming techniques and apply them to our Institute Placement Management System (IPMS).

---

# What You Will Learn

By the end of this chapter, you will:

- Understand Functional Programming
- Learn Lambda Expressions
- Create Functional Interfaces
- Use Built-in Functional Interfaces
- Work with Method References
- Use Stream API
- Perform Filtering
- Perform Mapping
- Perform Sorting
- Perform Aggregations
- Process Collections Efficiently
- Build Modern IPMS Features

---

# Understanding Functional Programming

Functional Programming focuses on:

- Functions
- Immutability
- Declarative Programming

Instead of:

```java id="a1"
for(int i=0;i<list.size();i++) {

}
```

we focus on:

```java id="a2"
students.stream()
```

---

# Traditional Programming

```java id="a3"
List<String> names =
        new ArrayList<>();

names.add("John Doe");

names.add("Sara Elise");

for(String name : names) {

    System.out.println(name);
}
```

---

# Functional Style

```java id="a4"
names.forEach(
        name ->
                System.out.println(name));
```

---

# Benefits

- Less Code
- Better Readability
- Easier Maintenance
- Better Collection Processing

---

# Functional Programming Overview

![Functional Programming Overview](/images/tutorials/javafundamentals/ch06-functional-programming-overview.png)

---

# Lambda Expressions

A Lambda Expression is an anonymous function.

---

# Traditional Approach

```java id="a5"
Runnable runnable =
        new Runnable() {

            @Override
            public void run() {

                System.out.println(
                        "Running");
            }
        };
```

---

# Lambda Approach

```java id="a6"
Runnable runnable =
        () ->
                System.out.println(
                        "Running");
```

---

# Lambda Syntax

```java id="a7"
(parameters) -> expression
```

---

# Example

```java id="a8"
(name) ->
        System.out.println(name);
```

---

# No Parameter Lambda

```java id="a9"
() ->
        System.out.println(
                "Welcome");
```

---

# Single Parameter Lambda

```java id="a10"
name ->
        System.out.println(name);
```

---

# Multiple Parameters

```java id="a11"
(a, b) ->
        a + b
```

---

# Lambda Returning Value

```java id="a12"
(a, b) ->
        a + b
```

---

# Example

```java id="a13"
Calculator calculator =
        (a, b) -> a + b;
```

---

# Functional Interfaces

A Functional Interface contains only one abstract method.

---

# Example

```java id="a14"
@FunctionalInterface
public interface Calculator {

    int add(
            int a,
            int b);
}
```

---

# Lambda Implementation

```java id="a15"
Calculator calculator =
        (a, b) -> a + b;
```

---

# Calling

```java id="a16"
System.out.println(
        calculator.add(10,20));
```

---

# Output

```text id="a17"
30
```

---

# Functional Interface Example

```java id="a18"
@FunctionalInterface
public interface Notification {

    void send(
            String message);
}
```

---

# Implementation

```java id="a19"
Notification notification =
        message ->
                System.out.println(
                        message);
```

---

# Using

```java id="a20"
notification.send(
        "Placement Drive Created");
```

---

# Built-in Functional Interfaces

Java provides several commonly used interfaces.

Package:

```text id="a21"
java.util.function
```

---

# Common Interfaces

| Interface | Method   |
| --------- | -------- |
| Predicate | test()   |
| Function  | apply()  |
| Consumer  | accept() |
| Supplier  | get()    |

---

# Predicate

Used for filtering.

---

```java id="a22"
Predicate<Integer> eligible =
        cgpa -> cgpa >= 7;
```

---

# Example

```java id="a23"
System.out.println(
        eligible.test(8));
```

---

# Output

```text id="a24"
true
```

---

# Function

Transforms data.

---

```java id="a25"
Function<String,Integer> length =
        name -> name.length();
```

---

# Example

```java id="a26"
System.out.println(
        length.apply(
                "John Doe"));
```

---

# Consumer

Consumes data.

---

```java id="a27"
Consumer<String> display =
        name ->
                System.out.println(
                        name);
```

---

# Example

```java id="a28"
display.accept(
        "Sara Elise");
```

---

# Supplier

Produces data.

---

```java id="a29"
Supplier<String> company =
        () -> "Google";
```

---

# Example

```java id="a30"
System.out.println(
        company.get());
```

---

# Method References

Method references provide cleaner syntax.

---

# Lambda

```java id="a31"
names.forEach(
        name ->
                System.out.println(name));
```

---

# Method Reference

```java id="a32"
names.forEach(
        System.out::println);
```

---

# Static Method Reference

```java id="a33"
ClassName::methodName
```

---

# Instance Method Reference

```java id="a34"
object::methodName
```

---

# Constructor Reference

```java id="a35"
Student::new
```

---

# Introduction to Streams

Streams process collections efficiently.

---

# Traditional Collection Processing

```java id="a36"
for(Student student
        : students) {

    if(student.getCgpa() >= 8) {

        System.out.println(
                student.getName());
    }
}
```

---

# Stream Approach

```java id="a37"
students.stream()
        .filter(
                student ->
                        student.getCgpa() >= 8)
        .forEach(
                student ->
                        System.out.println(
                                student.getName()));
```

---

# Stream Architecture

![Stream API Architecture](/images/tutorials/javafundamentals/ch06-stream-api-architecture.png)

---

# Creating Streams

From Collection

```java id="a38"
students.stream();
```

---

# From Array

```java id="a39"
Arrays.stream(numbers);
```

---

# From Values

```java id="a40"
Stream.of(
        1,2,3,4);
```

---

# Filtering Data

```java id="a41"
students.stream()
        .filter(
                student ->
                        student.getCgpa() >= 8)
        .forEach(
                System.out::println);
```

---

# Mapping Data

```java id="a42"
students.stream()
        .map(
                Student::getName)
        .forEach(
                System.out::println);
```

---

# Example Output

```text id="a43"
John Doe

Sara Elise
```

---

# Sorting Data

```java id="a44"
students.stream()
        .sorted(
                Comparator.comparing(
                        Student::getName))
        .forEach(
                System.out::println);
```

---

# Reverse Sorting

```java id="a45"
students.stream()
        .sorted(
                Comparator.comparing(
                        Student::getCgpa)
                        .reversed())
        .forEach(
                System.out::println);
```

---

# Limiting Records

```java id="a46"
students.stream()
        .limit(5)
        .forEach(
                System.out::println);
```

---

# Skipping Records

```java id="a47"
students.stream()
        .skip(5)
        .forEach(
                System.out::println);
```

---

# Collecting Results

```java id="a48"
List<Student> toppers =
        students.stream()
                .filter(
                        student ->
                                student.getCgpa() >= 8)
                .collect(
                        Collectors.toList());
```

---

# Counting Records

```java id="a49"
long count =
        students.stream()
                .count();
```

---

# Finding First Record

```java id="a50"
Optional<Student> student =
        students.stream()
                .findFirst();
```

---

# Finding Any Record

```java id="a51"
Optional<Student> student =
        students.stream()
                .findAny();
```

---

# Matching Records

```java id="a52"
boolean result =
        students.stream()
                .allMatch(
                        student ->
                                student.getCgpa() >= 7);
```

---

# anyMatch

```java id="a53"
boolean result =
        students.stream()
                .anyMatch(
                        student ->
                                student.getCgpa() >= 9);
```

---

# noneMatch

```java id="a54"
boolean result =
        students.stream()
                .noneMatch(
                        student ->
                                student.getCgpa() < 0);
```

---

# Aggregation

Sum

```java id="a55"
double total =
        students.stream()
                .mapToDouble(
                        Student::getCgpa)
                .sum();
```

---

# Average

```java id="a56"
double average =
        students.stream()
                .mapToDouble(
                        Student::getCgpa)
                .average()
                .orElse(0);
```

---

# Maximum

```java id="a57"
double highest =
        students.stream()
                .mapToDouble(
                        Student::getCgpa)
                .max()
                .orElse(0);
```

---

# Minimum

```java id="a58"
double lowest =
        students.stream()
                .mapToDouble(
                        Student::getCgpa)
                .min()
                .orElse(0);
```

---

# Grouping Data

```java id="a59"
Map<String,List<Student>>
studentsByBranch =
students.stream()
        .collect(
                Collectors.groupingBy(
                        Student::getBranch));
```

---

# Example

```java id="a60"
Map<String,List<Student>>
studentsByBranch =
students.stream()
        .collect(
                Collectors.groupingBy(
                        Student::getBranch));
```

---

# Partitioning Data

```java id="a61"
Map<Boolean,List<Student>>
result =
students.stream()
        .collect(
                Collectors.partitioningBy(
                        student ->
                                student.getCgpa() >= 8));
```

---

# Stream Pipeline

```java id="a62"
students.stream()
        .filter(
                student ->
                        student.getCgpa() >= 8)
        .sorted(
                Comparator.comparing(
                        Student::getName))
        .map(
                Student::getName)
        .forEach(
                System.out::println);
```

---

# Parallel Streams

Used for large datasets.

---

```java id="a63"
students.parallelStream()
        .forEach(
                System.out::println);
```

---

# Sequential Stream

```java id="a64"
students.stream()
        .forEach(
                System.out::println);
```

---

# IPMS Student Example

```java id="a65"
List<Student> students =
        new ArrayList<>();
```

---

```java id="a66"
students.add(
        new Student(
                101L,
                "John Doe",
                8.75));
```

---

```java id="a67"
students.add(
        new Student(
                102L,
                "Sara Elise",
                9.20));
```

---

# Eligible Students

```java id="a68"
students.stream()
        .filter(
                student ->
                        student.getCgpa() >= 8)
        .forEach(
                System.out::println);
```

---

# Placement Report

```java id="a69"
students.stream()
        .sorted(
                Comparator.comparing(
                        Student::getCgpa)
                        .reversed())
        .forEach(
                System.out::println);
```

---

# IPMS Stream Processing

![IPMS Stream Processing Architecture](/images/tutorials/javafundamentals/ch06-ipms-stream-processing.png)

---

# Mini Project

Build Student Analytics Module.

Requirements:

- Store Students
- Filter Eligible Students
- Sort by CGPA
- Generate Placement Reports
- Group by Branch
- Calculate Average CGPA
- Find Top Students

---

# Best Practices

- Prefer Streams for Collection Processing
- Use Method References
- Keep Lambdas Small
- Avoid Side Effects
- Use Parallel Streams Carefully
- Use Functional Interfaces

---

# Common Beginner Mistakes

| Mistake                    | Correct Approach         |
| -------------------------- | ------------------------ |
| Complex Lambdas            | Keep Lambdas Simple      |
| Overusing Parallel Streams | Use Only When Necessary  |
| Ignoring Optional          | Handle Properly          |
| Long Stream Pipelines      | Break Into Steps         |
| Using Streams Everywhere   | Use Appropriate Approach |

---

# Practice Exercises

1. Create Calculator Functional Interface.
2. Create Notification Functional Interface.
3. Use Predicate for Student Filtering.
4. Use Function for Name Transformation.
5. Use Consumer for Display.
6. Use Supplier for Company Data.
7. Filter Students by CGPA.
8. Sort Students by Name.
9. Calculate Average CGPA.
10. Generate Placement Analytics.

---

# Chapter Summary

In this chapter, you learned:

- Functional Programming
- Lambda Expressions
- Functional Interfaces
- Predicate
- Function
- Consumer
- Supplier
- Method References
- Stream API
- Filtering
- Mapping
- Sorting
- Aggregations
- Parallel Streams

In the next chapter, we will learn:

- Multithreading
- Concurrent Programming
- Executor Framework
- Synchronization

These concepts help build scalable and high-performance enterprise applications.
