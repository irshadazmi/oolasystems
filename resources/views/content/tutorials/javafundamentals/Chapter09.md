# Chapter 9: Capstone Project – Institute Placement Management System (IPMS)

---

# Introduction

Throughout this tutorial, we have learned:

- Java Fundamentals
- Object-Oriented Programming
- Inheritance
- Polymorphism
- Abstraction
- Interfaces
- Collections
- Generics
- Exception Handling
- File Handling
- Functional Programming
- Stream API
- Multithreading
- SOLID Principles
- Design Patterns

In this final chapter, we will apply all these concepts to build a complete enterprise-style application called:

```text
Institute Placement Management System (IPMS)
```

This capstone project demonstrates how Java is used in real-world enterprise software development.

---

# Project Overview

IPMS helps educational institutions manage placement activities.

---

# Business Objectives

The system should:

- Register Students
- Manage Companies
- Manage Placement Drives
- Process Applications
- Track Interviews
- Generate Reports
- Send Notifications
- Provide Analytics

---

# Stakeholders

| Stakeholder   | Responsibilities  |
| ------------- | ----------------- |
| Student       | Apply for Jobs    |
| Recruiter     | Conduct Hiring    |
| TPO           | Manage Placements |
| Administrator | Manage System     |

---

# System Features

## Student Management

- Student Registration
- Profile Management
- Resume Upload
- Skills Management
- Academic Records

---

## Company Management

- Company Registration
- Job Posting
- Hiring Criteria
- Drive Scheduling

---

## Placement Drive Management

- Create Drive
- Publish Drive
- Accept Applications
- Schedule Interviews

---

## Reports

- Student Reports
- Placement Reports
- Company Reports
- Analytics Reports

---

# System Architecture Overview

![IPMS Architecture Overview](/images/tutorials/javafundamentals/ch09-ipms-system-architecture.png)

---

# High Level Architecture

```text
Presentation Layer

Business Layer

Data Layer

File System
```

---

# Technology Stack

| Component   | Technology         |
| ----------- | ------------------ |
| Language    | Java 17            |
| IDE         | IntelliJ IDEA      |
| Build Tool  | Maven              |
| Database    | MySQL/PostgreSQL   |
| Reporting   | Java APIs          |
| Concurrency | Executor Framework |

---

# Project Structure

```text
ipms
│
├── controller
│
├── service
│
├── repository
│
├── model
│
├── dto
│
├── util
│
├── exception
│
└── report
```

---

# Domain Model

The domain model represents core business entities.

---

# Core Entities

- Student
- Company
- PlacementDrive
- Application
- Interview
- User

---

# Domain Model Diagram

![IPMS Domain Model](/images/tutorials/javafundamentals/ch09-ipms-domain-model.png)

---

# Student Entity

```java
public class Student {

    private Long studentId;

    private String name;

    private String email;

    private double cgpa;

    private String branch;
}
```

---

# Example Student

```java
Student student =
        new Student();

student.setStudentId(101L);

student.setName(
        "John Doe");

student.setCgpa(8.75);
```

---

# Another Student

```java
Student student2 =
        new Student();

student2.setStudentId(102L);

student2.setName(
        "Sara Elise");

student2.setCgpa(9.20);
```

---

# Company Entity

```java
public class Company {

    private Long companyId;

    private String companyName;

    private String location;
}
```

---

# Example

```java
Company company =
        new Company();

company.setCompanyName(
        "TechNova Solutions");
```

---

# Placement Drive Entity

```java
public class PlacementDrive {

    private Long driveId;

    private String driveName;

    private LocalDate driveDate;
}
```

---

# Application Entity

```java
public class Application {

    private Long applicationId;

    private Student student;

    private PlacementDrive drive;
}
```

---

# User Hierarchy

Using Inheritance.

---

```java
public abstract class User {

    protected String name;

    protected String email;
}
```

---

# Student User

```java
public class Student
        extends User {

}
```

---

# Recruiter User

```java
public class Recruiter
        extends User {

}
```

---

# Administrator User

```java
public class Administrator
        extends User {

}
```

---

# Applying Interfaces

---

# Notification Interface

```java
public interface NotificationService {

    void send(
            String message);
}
```

---

# Email Notification

```java
public class EmailService
        implements NotificationService {

    @Override
    public void send(
            String message) {

        System.out.println(message);
    }
}
```

---

# SMS Notification

```java
public class SmsService
        implements NotificationService {

    @Override
    public void send(
            String message) {

        System.out.println(message);
    }
}
```

---

# Repository Layer

Repository handles data access.

---

# Student Repository

```java
public interface StudentRepository {

    void save(
            Student student);

    Student findById(
            Long id);
}
```

---

# Implementation

```java
public class StudentRepositoryImpl
        implements StudentRepository {

}
```

---

# Service Layer

Business Logic Layer.

---

# Student Service

```java
public class StudentService {

    private StudentRepository
            repository;
}
```

---

# Register Student

```java
public void registerStudent(
        Student student) {

    repository.save(student);
}
```

---

# Controller Layer

Handles requests.

---

# Student Controller

```java
public class StudentController {

    private StudentService
            service;
}
```

---

# Create Student

```java
public void createStudent(
        Student student) {

    service.registerStudent(
            student);
}
```

---

# Layered Architecture

![IPMS Layered Architecture](/images/tutorials/javafundamentals/ch09-ipms-layered-architecture.png)

---

# Applying Collections

---

# Student List

```java
List<Student> students =
        new ArrayList<>();
```

---

# Company List

```java
List<Company> companies =
        new ArrayList<>();
```

---

# Skill Set

```java
Set<String> skills =
        new HashSet<>();
```

---

# Company Map

```java
Map<Long, Company> companies =
        new HashMap<>();
```

---

# Applying Generics

```java
public interface Repository<T> {

    void save(T entity);

    T findById(Long id);
}
```

---

# Student Repository

```java
public class StudentRepository
        implements Repository<Student> {

}
```

---

# Exception Handling

---

# Custom Exception

```java
public class InvalidCgpaException
        extends Exception {

    public InvalidCgpaException(
            String message) {

        super(message);
    }
}
```

---

# Validation

```java
if(student.getCgpa() < 0 ||
        student.getCgpa() > 10) {

    throw new InvalidCgpaException(
            "Invalid CGPA");
}
```

---

# File Export

Generate reports.

---

# CSV Export

```java
BufferedWriter writer =
        new BufferedWriter(
                new FileWriter(
                        "students.csv"));
```

---

# Write Student

```java
writer.write(
        "101,John Doe,8.75");
```

---

# Analytics using Stream API

---

# Eligible Students

```java
students.stream()
        .filter(
                student ->
                        student.getCgpa() >= 7)
        .forEach(
                System.out::println);
```

---

# Top Students

```java
students.stream()
        .sorted(
                Comparator.comparing(
                        Student::getCgpa)
                        .reversed());
```

---

# Average CGPA

```java
double average =
        students.stream()
                .mapToDouble(
                        Student::getCgpa)
                .average()
                .orElse(0);
```

---

# Placement Analytics

![IPMS Analytics Processing](/images/tutorials/javafundamentals/ch09-ipms-analytics-processing.png)

---

# Applying Multithreading

---

# Notification Task

```java
Runnable notificationTask =
        () ->
                System.out.println(
                        "Email Sent");
```

---

# Executor Service

```java
ExecutorService executor =
        Executors.newFixedThreadPool(5);
```

---

# Execute Task

```java
executor.submit(
        notificationTask);
```

---

# Generate Report

```java
Callable<String> reportTask =
        () -> "Report Generated";
```

---

# Future Result

```java
Future<String> result =
        executor.submit(
                reportTask);
```

---

# Applying SOLID Principles

---

# SRP

```text
StudentService

CompanyService

ReportService
```

---

# OCP

```text
ReportGenerator
```

Extended by:

```text
PdfReportGenerator

ExcelReportGenerator
```

---

# DIP

```text
StudentService
```

depends upon:

```text
StudentRepository
```

---

# Applying Design Patterns

---

# Singleton

```java
ConfigurationManager
```

---

# Factory

```java
NotificationFactory
```

---

# Builder

```java
StudentBuilder
```

---

# Strategy

```java
EligibilityStrategy
```

---

# Notification Factory

```java
NotificationService service =
        NotificationFactory
                .create("EMAIL");
```

---

# Student Builder

```java
Student student =
        new StudentBuilder()
                .name("John Doe")
                .cgpa(8.75)
                .build();
```

---

# Eligibility Strategy

```java
EligibilityStrategy strategy =
        new CgpaStrategy();
```

---

# Placement Workflow

![Placement Workflow](/images/tutorials/javafundamentals/ch09-placement-workflow.png)

---

# Sample Data

## Students

| ID  | Name          | CGPA |
| --- | ------------- | ---- |
| 101 | John Doe      | 8.75 |
| 102 | Sara Elise    | 9.20 |
| 103 | Michael Brown | 7.85 |
| 104 | Emily Carter  | 8.10 |

---

## Companies

| ID  | Company            |
| --- | ------------------ |
| 1   | TechNova Solutions |
| 2   | GlobalSoft Systems |
| 3   | FutureTech Labs    |

---

# Placement Eligibility Logic

```java
public boolean eligible(
        Student student) {

    return student.getCgpa() >= 7;
}
```

---

# Sample Execution Flow

```text
Student Registers
        ↓

Profile Validation
        ↓

Placement Drive Published
        ↓

Student Applies
        ↓

Eligibility Check
        ↓

Interview Scheduled
        ↓

Result Declared
```

---

# Future Enhancements

- Spring Boot REST APIs
- MySQL Integration
- Hibernate ORM
- JWT Security
- Docker Deployment
- Microservices
- Kafka Integration
- Cloud Deployment

---

# Mini Project Deliverables

Students should implement:

- Student Module
- Company Module
- Placement Drive Module
- Report Module
- Notification Module
- Analytics Module

---

# Best Practices

- Follow SOLID Principles
- Use Design Patterns
- Validate Inputs
- Handle Exceptions
- Use Collections Effectively
- Apply Generics
- Use Streams for Analytics
- Use Executor Framework for Background Tasks

---

# Learning Outcomes

After completing IPMS, students will be able to:

- Design Enterprise Applications
- Implement OOP Concepts
- Use Collections and Generics
- Handle Exceptions
- Process Data using Streams
- Build Concurrent Applications
- Apply SOLID Principles
- Apply Design Patterns

---

# Course Summary

Congratulations!

You have successfully completed:

- Java Fundamentals
- OOP
- Collections
- Generics
- Exception Handling
- File Handling
- Functional Programming
- Stream API
- Multithreading
- SOLID Principles
- Design Patterns

and applied them to build a complete enterprise-grade project:

```text
Institute Placement Management System (IPMS)
```

This project serves as a strong foundation before learning:

- JDBC
- Spring Framework
- Spring Boot
- Hibernate
- Microservices
- Cloud-Native Java Development

Keep building, experimenting, and coding every day.

---
