# Chapter 3: Inheritance, Polymorphism & Abstraction

---

# Introduction

As enterprise applications grow, developers often encounter duplicate code across multiple classes.

Consider the IPMS application.

Entities such as:

- Student
- Company
- Placement Drive
- Interview Panel Member
- Administrator

share several common characteristics.

Instead of duplicating code, Object-Oriented Programming provides powerful mechanisms for code reuse and extensibility.

In this chapter, we will learn:

- Inheritance
- Polymorphism
- Abstraction

These concepts are fundamental for designing scalable enterprise applications.

---

# What You Will Learn

By the end of this chapter, you will:

- Understand Inheritance
- Create Parent and Child Classes
- Use Method Overriding
- Understand IS-A Relationships
- Learn Runtime Polymorphism
- Learn Compile-Time Polymorphism
- Create Abstract Classes
- Implement Abstract Methods
- Apply Inheritance in IPMS
- Build Reusable Class Hierarchies

---

# Understanding Inheritance

Inheritance allows one class to acquire the properties and behaviors of another class.

---

# Benefits of Inheritance

- Code Reuse
- Maintainability
- Extensibility
- Reduced Duplication
- Better Design

---

# Real World Example

Consider:

```text
Person
│
├── Student
│
├── Administrator
│
└── Recruiter
```

All entities share:

- Name
- Email
- Phone Number

---

# Parent Class

```java
public class Person {

    protected String name;

    protected String email;

    protected String phone;
}
```

---

# Child Class

```java
public class Student extends Person {

    private double cgpa;
}
```

---

# Understanding extends

```java
extends
```

creates an inheritance relationship.

---

# Inheritance Hierarchy

![Inheritance Hierarchy](/images/tutorials/javafundamentals/ch03-inheritance-hierarchy.png)

---

# Creating Parent Class

```java
package com.ipms.person;

public class Person {

    protected Long id;

    protected String name;

    protected String email;
}
```

---

# Creating Student Class

```java
package com.ipms.student;

import com.ipms.person.Person;

public class Student extends Person {

    private double cgpa;
}
```

---

# Creating Recruiter Class

```java
package com.ipms.recruiter;

import com.ipms.person.Person;

public class Recruiter extends Person {

    private String designation;
}
```

---

# Accessing Parent Members

```java
Student student = new Student();

student.name = "John Doe";
```

---

# Understanding IS-A Relationship

Inheritance represents:

```text
IS-A
```

Examples:

```text
Student IS-A Person

Recruiter IS-A Person

Admin IS-A Person
```

---

# Example

```java
public class Employee {

}
```

```java
public class Manager extends Employee {

}
```

---

# Invalid Example

```text
Company IS-A Student
```

Invalid relationship.

---

# Constructor Inheritance

Parent constructors execute before child constructors.

---

# Parent Constructor

```java
public Person() {

    System.out.println("Person Constructor");
}
```

---

# Child Constructor

```java
public Student() {

    System.out.println("Student Constructor");
}
```

---

# Output

```text
Person Constructor

Student Constructor
```

---

# Understanding super Keyword

Used to access parent members.

---

# Calling Parent Constructor

```java
public Student() {

    super();
}
```

---

# Parent Parameterized Constructor

```java
public Person(
        String name,
        String email) {

    this.name = name;

    this.email = email;
}
```

---

# Child Constructor

```java
public Student(
        String name,
        String email,
        double cgpa) {

    super(name, email);

    this.cgpa = cgpa;
}
```

---

# Accessing Parent Method

```java
super.displayInfo();
```

---

# Method Overriding

A child class can redefine parent behavior.

---

# Parent Method

```java
public void displayRole() {

    System.out.println("Person");
}
```

---

# Child Method

```java
@Override
public void displayRole() {

    System.out.println("Student");
}
```

---

# Example

```java
public class Person {

    public void displayRole() {

        System.out.println("Person");
    }
}
```

---

```java
public class Student extends Person {

    @Override
    public void displayRole() {

        System.out.println("Student");
    }
}
```

---

# Executing

```java
Student student = new Student();

student.displayRole();
```

---

# Output

```text
Student
```

---

# Rules for Overriding

- Same method name
- Same parameters
- Same return type
- Cannot reduce visibility

---

# Understanding Polymorphism

Polymorphism means:

```text
Many Forms
```

---

# Types of Polymorphism

1. Compile-Time Polymorphism
2. Runtime Polymorphism

---

# Compile-Time Polymorphism

Achieved using:

```text
Method Overloading
```

---

# Example

```java
public class Calculator {

    public int add(
            int a,
            int b) {

        return a + b;
    }

    public int add(
            int a,
            int b,
            int c) {

        return a + b + c;
    }
}
```

---

# Using Overloaded Methods

```java
Calculator calculator =
        new Calculator();

calculator.add(10, 20);

calculator.add(10, 20, 30);
```

---

# Runtime Polymorphism

Achieved using:

```text
Method Overriding
```

---

# Example

```java
Person person =
        new Student();
```

---

# Dynamic Method Dispatch

```java
person.displayRole();
```

calls:

```java
Student.displayRole()
```

---

# Polymorphism Overview

![Polymorphism Overview](/images/tutorials/javafundamentals/ch03-polymorphism-overview.png)

---

# Example

```java
public class Person {

    public void login() {

        System.out.println("Person Login");
    }
}
```

---

```java
public class Student extends Person {

    @Override
    public void login() {

        System.out.println("Student Login");
    }
}
```

---

```java
public class Recruiter extends Person {

    @Override
    public void login() {

        System.out.println("Recruiter Login");
    }
}
```

---

# Runtime Execution

```java
Person person;

person = new Student();

person.login();

person = new Recruiter();

person.login();
```

---

# Output

```text
Student Login

Recruiter Login
```

---

# Understanding Abstraction

Abstraction focuses on:

```text
What an object does
```

instead of

```text
How it does it
```

---

# Benefits

- Simplifies Design
- Improves Maintainability
- Supports Extensibility
- Reduces Complexity

---

# Abstract Classes

An abstract class cannot be instantiated.

---

# Example

```java
public abstract class Person {

}
```

---

# Invalid

```java
Person person =
        new Person();
```

---

# Abstract Method

```java
public abstract void login();
```

---

# Abstract Class Example

```java
public abstract class Person {

    protected String name;

    public abstract void login();
}
```

---

# Student Implementation

```java
public class Student extends Person {

    @Override
    public void login() {

        System.out.println(
                "Student Login");
    }
}
```

---

# Recruiter Implementation

```java
public class Recruiter extends Person {

    @Override
    public void login() {

        System.out.println(
                "Recruiter Login");
    }
}
```

---

# Using Abstract Classes

```java
Person person =
        new Student();

person.login();
```

---

# Output

```text
Student Login
```

---

# Abstract Class with Concrete Methods

```java
public abstract class Person {

    public void displayInfo() {

        System.out.println("Person");
    }

    public abstract void login();
}
```

---

# Enterprise Example

```java
Person
│
├── Student
│
├── Recruiter
│
└── Administrator
```

---

# IPMS User Hierarchy

![IPMS User Hierarchy](/images/tutorials/javafundamentals/ch03-ipms-user-hierarchy.png)

---

# Creating Base User

```java
public abstract class User {

    protected Long userId;

    protected String name;

    protected String email;

    public abstract void login();
}
```

---

# Student User

```java
public class Student
        extends User {

    private double cgpa;

    @Override
    public void login() {

        System.out.println(
                "Student Login");
    }
}
```

---

# Recruiter User

```java
public class Recruiter
        extends User {

    private String company;

    @Override
    public void login() {

        System.out.println(
                "Recruiter Login");
    }
}
```

---

# Administrator User

```java
public class Administrator
        extends User {

    @Override
    public void login() {

        System.out.println(
                "Admin Login");
    }
}
```

---

# Testing Polymorphism

```java
User user;

user = new Student();

user.login();

user = new Recruiter();

user.login();

user = new Administrator();

user.login();
```

---

# Output

```text
Student Login

Recruiter Login

Admin Login
```

---

# Mini Project

Create User Management Module.

Requirements:

- Create abstract User class
- Create Student class
- Create Recruiter class
- Create Administrator class
- Override login()
- Demonstrate runtime polymorphism

---

# Best Practices

- Favor inheritance for IS-A relationships
- Keep inheritance hierarchies shallow
- Use @Override annotation
- Use abstraction for common behavior
- Avoid duplicate code
- Follow single responsibility principle

---

# Common Beginner Mistakes

| Mistake                      | Correct Approach      |
| ---------------------------- | --------------------- |
| Deep inheritance chains      | Keep hierarchy simple |
| Forgetting @Override         | Always use annotation |
| Instantiating abstract class | Create child object   |
| Wrong IS-A relationship      | Use proper hierarchy  |
| Duplicate methods            | Use inheritance       |

---

# Practice Exercises

1. Create Employee and Manager classes.
2. Create Vehicle hierarchy.
3. Implement method overriding.
4. Create abstract Payment class.
5. Implement CreditCardPayment.
6. Implement UPIPayment.
7. Demonstrate runtime polymorphism.

---

# Chapter Summary

In this chapter, you learned:

- Inheritance
- Parent and Child Classes
- IS-A Relationships
- Constructor Chaining
- super Keyword
- Method Overriding
- Compile-Time Polymorphism
- Runtime Polymorphism
- Abstract Classes
- Abstract Methods
- Enterprise Class Hierarchies

In the next chapter, we will learn:

- Interfaces
- Collections Framework
- Generics

These concepts form the foundation of enterprise Java application development.
