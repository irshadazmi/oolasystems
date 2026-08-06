# Chapter 8: SOLID Principles & Design Patterns

---

# Introduction

As software systems grow, maintaining and extending code becomes increasingly difficult.

Enterprise applications often suffer from:

- Tight Coupling
- Duplicate Code
- Complex Dependencies
- Difficult Testing
- Poor Maintainability

To solve these problems, software engineers use:

- SOLID Principles
- Design Patterns

These concepts help developers build applications that are:

- Maintainable
- Scalable
- Flexible
- Testable
- Extensible

In this chapter, we will learn the five SOLID principles and several commonly used design patterns while applying them to our Institute Placement Management System (IPMS).

---

# What You Will Learn

By the end of this chapter, you will:

- Understand SOLID Principles
- Apply Single Responsibility Principle
- Apply Open Closed Principle
- Apply Liskov Substitution Principle
- Apply Interface Segregation Principle
- Apply Dependency Inversion Principle
- Understand Design Patterns
- Implement Singleton Pattern
- Implement Factory Pattern
- Implement Builder Pattern
- Implement Strategy Pattern
- Apply Enterprise Design Practices

---

# Understanding SOLID

SOLID is a collection of five design principles.

---

# SOLID Overview

```text id="s1"
S - Single Responsibility Principle

O - Open Closed Principle

L - Liskov Substitution Principle

I - Interface Segregation Principle

D - Dependency Inversion Principle
```

---

# SOLID Principles Overview

![SOLID Principles Overview](/images/tutorials/javafundamentals/ch08-solid-principles-overview.png)

---

# Single Responsibility Principle (SRP)

A class should have only one reason to change.

---

# Poor Design

```java id="s2"
public class StudentService {

    public void registerStudent() {

    }

    public void sendEmail() {

    }

    public void generateReport() {

    }
}
```

---

# Problems

- Multiple Responsibilities
- Difficult Maintenance
- Difficult Testing

---

# Better Design

```java id="s3"
public class StudentService {

    public void registerStudent() {

    }
}
```

---

```java id="s4"
public class EmailService {

    public void sendEmail() {

    }
}
```

---

```java id="s5"
public class ReportService {

    public void generateReport() {

    }
}
```

---

# IPMS Example

```java id="s6"
StudentService
```

Responsible for:

```text id="s7"
Student Operations
```

---

```java id="s8"
NotificationService
```

Responsible for:

```text id="s9"
Notifications
```

---

# Open Closed Principle (OCP)

Software entities should be:

```text id="s10"
Open for Extension

Closed for Modification
```

---

# Poor Design

```java id="s11"
public class ReportGenerator {

    public void generate(
            String type) {

        if(type.equals("PDF")) {

        }
        else if(type.equals("EXCEL")) {

        }
    }
}
```

---

# Better Design

```java id="s12"
public interface ReportGenerator {

    void generate();
}
```

---

# PDF Report

```java id="s13"
public class PdfReportGenerator
        implements ReportGenerator {

    @Override
    public void generate() {

    }
}
```

---

# Excel Report

```java id="s14"
public class ExcelReportGenerator
        implements ReportGenerator {

    @Override
    public void generate() {

    }
}
```

---

# Usage

```java id="s15"
ReportGenerator report =
        new PdfReportGenerator();
```

---

# Liskov Substitution Principle (LSP)

Subclasses should be replaceable by parent classes.

---

# Example

```java id="s16"
User user =
        new Student();
```

---

# Valid Substitution

```java id="s17"
User user =
        new Recruiter();
```

---

# Invalid Design

```java id="s18"
class Bird {

    void fly() {

    }
}
```

---

```java id="s19"
class Penguin
        extends Bird {

}
```

---

Penguins cannot fly.

LSP violation.

---

# Better Design

```java id="s20"
interface Bird {

}
```

---

```java id="s21"
interface FlyingBird
        extends Bird {

    void fly();
}
```

---

# Interface Segregation Principle (ISP)

Clients should not depend on methods they do not use.

---

# Poor Design

```java id="s22"
public interface Worker {

    void work();

    void eat();

    void drive();
}
```

---

# Problems

Not every worker drives.

---

# Better Design

```java id="s23"
public interface Workable {

    void work();
}
```

---

```java id="s24"
public interface Eatable {

    void eat();
}
```

---

```java id="s25"
public interface Drivable {

    void drive();
}
```

---

# Dependency Inversion Principle (DIP)

Depend upon abstractions, not concrete classes.

---

# Poor Design

```java id="s26"
public class StudentService {

    private EmailService emailService =
            new EmailService();
}
```

---

# Better Design

```java id="s27"
public interface NotificationService {

    void send();
}
```

---

```java id="s28"
public class EmailService
        implements NotificationService {

    @Override
    public void send() {

    }
}
```

---

```java id="s29"
public class StudentService {

    private NotificationService
            notificationService;
}
```

---

# SOLID in IPMS

![SOLID in IPMS](/images/tutorials/javafundamentals/ch08-solid-ipms-architecture.png)

---

# Introduction to Design Patterns

Design Patterns are proven reusable solutions to common software design problems.

---

# Categories

- Creational
- Structural
- Behavioral

---

# Pattern Classification

```text id="s30"
Creational

Structural

Behavioral
```

---

# Common Enterprise Patterns

- Singleton
- Factory
- Builder
- Strategy

---

# Singleton Pattern

Ensures only one object exists.

---

# Use Cases

- Configuration
- Logging
- Cache
- Settings

---

# Singleton Example

```java id="s31"
public class ConfigurationManager {

    private static
    ConfigurationManager instance;

    private ConfigurationManager() {

    }

    public static
    ConfigurationManager
    getInstance() {

        if(instance == null) {

            instance =
                    new ConfigurationManager();
        }

        return instance;
    }
}
```

---

# Usage

```java id="s32"
ConfigurationManager config =
        ConfigurationManager
                .getInstance();
```

---

# Singleton Architecture

![Singleton Pattern](/images/tutorials/javafundamentals/ch08-singleton-pattern.png)

---

# Factory Pattern

Creates objects without exposing creation logic.

---

# Example Interface

```java id="s33"
public interface NotificationService {

    void send();
}
```

---

# Email Service

```java id="s34"
public class EmailService
        implements NotificationService {

    @Override
    public void send() {

    }
}
```

---

# SMS Service

```java id="s35"
public class SmsService
        implements NotificationService {

    @Override
    public void send() {

    }
}
```

---

# Factory Class

```java id="s36"
public class NotificationFactory {

    public static
    NotificationService create(
            String type) {

        if(type.equals("EMAIL")) {

            return new EmailService();
        }

        return new SmsService();
    }
}
```

---

# Usage

```java id="s37"
NotificationService service =
        NotificationFactory
                .create("EMAIL");
```

---

# Builder Pattern

Used for constructing complex objects.

---

# Student Object

```java id="s38"
public class Student {

    private Long id;

    private String name;

    private String email;

    private double cgpa;
}
```

---

# Builder Example

```java id="s39"
Student student =
        new StudentBuilder()
                .id(101L)
                .name("John Doe")
                .email("john@example.com")
                .cgpa(8.75)
                .build();
```

---

# Benefits

- Readability
- Flexibility
- Immutability Support

---

# Strategy Pattern

Allows interchangeable algorithms.

---

# Example

Placement Eligibility Calculation.

---

# Strategy Interface

```java id="s40"
public interface EligibilityStrategy {

    boolean eligible(
            Student student);
}
```

---

# CGPA Strategy

```java id="s41"
public class CgpaStrategy
        implements EligibilityStrategy {

    @Override
    public boolean eligible(
            Student student) {

        return student.getCgpa() >= 7;
    }
}
```

---

# Backlog Strategy

```java id="s42"
public class BacklogStrategy
        implements EligibilityStrategy {

    @Override
    public boolean eligible(
            Student student) {

        return student.getBacklogs() == 0;
    }
}
```

---

# Using Strategy

```java id="s43"
EligibilityStrategy strategy =
        new CgpaStrategy();
```

---

# Execute Strategy

```java id="s44"
strategy.eligible(student);
```

---

# Design Pattern Overview

![Design Pattern Overview](/images/tutorials/javafundamentals/ch08-design-pattern-overview.png)

---

# IPMS Student Registration Design

```java id="s45"
StudentController
        ->
StudentService
        ->
StudentRepository
```

---

# IPMS Notification Design

```java id="s46"
NotificationFactory
        ->
EmailService
        ->
SmsService
```

---

# IPMS Report Generation

```java id="s47"
ReportGenerator
        ->
PdfReportGenerator
        ->
ExcelReportGenerator
```

---

# Applying SOLID and Patterns Together

```java id="s48"
Controller
```

uses

```java id="s49"
Services
```

which depend upon

```java id="s50"
Interfaces
```

implemented by

```java id="s51"
Concrete Classes
```

---

# Enterprise Architecture Example

```text id="s52"
Controller

Service

Repository

Database
```

---

# Benefits of SOLID

- Better Maintainability
- Better Testing
- Better Extensibility
- Loose Coupling
- Clean Architecture

---

# Benefits of Design Patterns

- Reusable Solutions
- Consistent Architecture
- Faster Development
- Easier Maintenance

---

# Mini Project

Build Student Placement Module.

Requirements:

- Apply SRP
- Apply DIP
- Create Notification Factory
- Create Configuration Singleton
- Create Eligibility Strategy
- Generate Reports

---

# Best Practices

- Follow SOLID Principles
- Program to Interfaces
- Favor Composition
- Use Design Patterns Carefully
- Keep Classes Focused
- Minimize Coupling

---

# Common Beginner Mistakes

| Mistake                  | Correct Approach        |
| ------------------------ | ----------------------- |
| Large Classes            | Apply SRP               |
| Direct Dependencies      | Apply DIP               |
| Hardcoded Logic          | Use Strategy Pattern    |
| Multiple Object Creation | Use Factory             |
| Global Variables         | Use Singleton Carefully |

---

# Practice Exercises

1. Implement SRP.
2. Implement OCP.
3. Implement ISP.
4. Implement DIP.
5. Create Singleton Class.
6. Create Factory Pattern.
7. Create Builder Pattern.
8. Create Strategy Pattern.
9. Create Notification Module.
10. Create Placement Eligibility Engine.

---

# Chapter Summary

In this chapter, you learned:

- SOLID Principles
- SRP
- OCP
- LSP
- ISP
- DIP
- Singleton Pattern
- Factory Pattern
- Builder Pattern
- Strategy Pattern
- Enterprise Application Design

In the next chapter, we will build the complete IPMS Capstone Project by applying all concepts learned throughout this tutorial.

---
