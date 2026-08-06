# Chapter 4: Interfaces, Collections & Generics

---

# Introduction

Enterprise applications rarely consist of isolated classes.

Modern systems require:

- Flexible architectures
- Loose coupling
- Reusable components
- Dynamic data management
- Type safety

Java provides three powerful features that help achieve these goals:

- Interfaces
- Collections Framework
- Generics

In this chapter, we will learn how to design flexible enterprise applications using interfaces and how to manage large collections of data efficiently using Java Collections and Generics.

Throughout this chapter, we will continue building components of our Institute Placement Management System (IPMS).

---

# What You Will Learn

By the end of this chapter, you will:

- Understand Interfaces
- Create and Implement Interfaces
- Use Multiple Interface Implementation
- Understand Default Methods
- Learn Java Collections Framework
- Use List
- Use Set
- Use Map
- Learn Collection Iteration Techniques
- Understand Generics
- Create Generic Classes
- Create Generic Methods
- Apply Collections in IPMS

---

# Understanding Interfaces

An interface defines a contract that implementing classes must follow.

An interface specifies:

- What a class must do
- Not how it should do it

---

# Why Interfaces?

Benefits:

- Loose Coupling
- Extensibility
- Testability
- Reusability
- Enterprise Architecture Support

---

# Real World Example

Consider a login system.

Users:

- Student
- Recruiter
- Administrator

All must support:

```text id="kgw0ht"
login()
logout()
```

---

# Interface Definition

```java id="tkq2wj"
public interface Loginable {

    void login();

    void logout();
}
```

---

# Implementing Interface

```java id="zpk7b0"
public class Student
        implements Loginable {

    @Override
    public void login() {

        System.out.println(
                "Student Login");
    }

    @Override
    public void logout() {

        System.out.println(
                "Student Logout");
    }
}
```

---

# Recruiter Implementation

```java id="r3ktvl"
public class Recruiter
        implements Loginable {

    @Override
    public void login() {

        System.out.println(
                "Recruiter Login");
    }

    @Override
    public void logout() {

        System.out.println(
                "Recruiter Logout");
    }
}
```

---

# Interface Overview

![Interface Overview](/images/tutorials/javafundamentals/ch04-interface-overview.png)

---

# Using Interfaces

```java id="gzyqei"
Loginable user =
        new Student();

user.login();
```

---

# Output

```text id="w7cpc7"
Student Login
```

---

# Multiple Interface Implementation

Java supports multiple interfaces.

---

# Interface 1

```java id="l6uz5x"
public interface Loginable {

    void login();
}
```

---

# Interface 2

```java id="7m8sjj"
public interface Reportable {

    void generateReport();
}
```

---

# Implementing Multiple Interfaces

```java id="jrtx5l"
public class Administrator
        implements Loginable,
                   Reportable {

    @Override
    public void login() {

    }

    @Override
    public void generateReport() {

    }
}
```

---

# Interface Inheritance

Interfaces can extend other interfaces.

---

```java id="o9pdqt"
public interface UserActions
        extends Loginable {

    void updateProfile();
}
```

---

# Default Methods

Introduced in Java 8.

---

```java id="4xpncb"
public interface Loginable {

    default void logout() {

        System.out.println(
                "Logout Successful");
    }
}
```

---

# Static Methods in Interfaces

```java id="7j2v57"
public interface Validator {

    static boolean isValidEmail(
            String email) {

        return email.contains("@");
    }
}
```

---

# Functional Interfaces

Contains only one abstract method.

---

```java id="y2ld0e"
@FunctionalInterface
public interface Notification {

    void send(String message);
}
```

---

# Collections Framework

Collections Framework helps manage groups of objects.

---

# Why Collections?

Arrays have limitations:

- Fixed Size
- Difficult Insertions
- Difficult Deletions

Collections solve these problems.

---

# Collections Framework Overview

![Collections Framework](/images/tutorials/javafundamentals/ch04-collections-framework.png)

---

# Main Collection Types

| Collection | Purpose         |
| ---------- | --------------- |
| List       | Ordered Data    |
| Set        | Unique Data     |
| Map        | Key Value Data  |
| Queue      | FIFO Processing |

---

# List Interface

List stores ordered elements.

Duplicates allowed.

---

# Creating ArrayList

```java id="gcd8js"
List<String> students =
        new ArrayList<>();
```

---

# Adding Elements

```java id="2g8vdk"
students.add("John Doe");

students.add("Sara Elise");

students.add("Michael Brown");
```

---

# Accessing Elements

```java id="1k60j5"
System.out.println(
        students.get(0));
```

---

# Output

```text id="59woxh"
John Doe
```

---

# Iterating List

```java id="c14l6w"
for(String student : students) {

    System.out.println(student);
}
```

---

# Removing Elements

```java id="r1mz4z"
students.remove(
        "Michael Brown");
```

---

# LinkedList

```java id="1r0pwv"
List<String> drives =
        new LinkedList<>();
```

---

# List Example

```java id="gphg31"
List<String> companies =
        new ArrayList<>();

companies.add("Google");

companies.add("Microsoft");

companies.add("Amazon");
```

---

# Set Interface

Stores unique elements.

Duplicates not allowed.

---

# Creating HashSet

```java id="18lhk7"
Set<String> skills =
        new HashSet<>();
```

---

# Adding Values

```java id="n1wut0"
skills.add("Java");

skills.add("Spring Boot");

skills.add("Java");
```

---

# Output

```text id="1gn3zz"
Java

Spring Boot
```

---

# Set Example

```java id="0zxgxm"
Set<String> technologies =
        new HashSet<>();
```

---

# TreeSet

Stores sorted values.

---

```java id="vwpb4z"
Set<String> cities =
        new TreeSet<>();
```

---

# Map Interface

Stores key-value pairs.

---

# Creating HashMap

```java id="fcl6m3"
Map<Long, String> students =
        new HashMap<>();
```

---

# Adding Data

```java id="rk7w1h"
students.put(
        101L,
        "John Doe");

students.put(
        102L,
        "Sara Elise");
```

---

# Retrieving Data

```java id="ot4l3n"
System.out.println(
        students.get(101L));
```

---

# Output

```text id="hl0qj4"
John Doe
```

---

# Iterating Map

```java id="y8sfbv"
for(Map.Entry<Long,String> entry
        : students.entrySet()) {

    System.out.println(
            entry.getKey());

    System.out.println(
            entry.getValue());
}
```

---

# Collection Iteration

Three common approaches:

- For Loop
- Enhanced For Loop
- Iterator

---

# Iterator Example

```java id="stjlwm"
Iterator<String> iterator =
        students.iterator();

while(iterator.hasNext()) {

    System.out.println(
            iterator.next());
}
```

---

# Collection Comparison

| Collection | Ordered   | Duplicate   |
| ---------- | --------- | ----------- |
| ArrayList  | Yes       | Yes         |
| LinkedList | Yes       | Yes         |
| HashSet    | No        | No          |
| TreeSet    | Sorted    | No          |
| HashMap    | Key Value | Keys Unique |

---

# Understanding Generics

Generics provide:

- Type Safety
- Compile-Time Checking
- Better Readability

---

# Before Generics

```java id="k49mwp"
List students =
        new ArrayList();
```

---

# Problem

```java id="m9yiv6"
students.add("John Doe");

students.add(100);
```

---

# With Generics

```java id="x4a5ut"
List<String> students =
        new ArrayList<>();
```

---

# Type Safety

```java id="8w3ydl"
students.add("John Doe");
```

---

```java id="0dzw0k"
students.add(100);
```

Compilation Error.

---

# Generic List

```java id="g3txy4"
List<Student> students =
        new ArrayList<>();
```

---

# Generic Map

```java id="l2y2ka"
Map<Long, Student> students =
        new HashMap<>();
```

---

# Generic Method

```java id="s7z2ko"
public static <T> void print(
        T value) {

    System.out.println(value);
}
```

---

# Calling Generic Method

```java id="3mxfme"
print("John Doe");

print(100);

print(true);
```

---

# Generic Class

```java id="g1n3ny"
public class Box<T> {

    private T value;

    public T getValue() {

        return value;
    }

    public void setValue(
            T value) {

        this.value = value;
    }
}
```

---

# Using Generic Class

```java id="3gbc18"
Box<String> box =
        new Box<>();
```

---

```java id="6jz3d2"
box.setValue(
        "Java");
```

---

# Generic Repository Example

```java id="g4wvkp"
public interface Repository<T> {

    void save(T entity);

    T findById(Long id);
}
```

---

# Student Repository

```java id="2pxh5l"
public class StudentRepository
        implements Repository<Student> {

}
```

---

# IPMS Student Collection

```java id="yd8n8u"
List<Student> students =
        new ArrayList<>();
```

---

# Adding Students

```java id="59ckjw"
students.add(
        new Student(
                101L,
                "John Doe",
                8.75));
```

---

```java id="6xdk6k"
students.add(
        new Student(
                102L,
                "Sara Elise",
                9.20));
```

---

# Processing Students

```java id="v31t4h"
for(Student student
        : students) {

    System.out.println(
            student.getName());
}
```

---

# IPMS Company Registry

```java id="1zsnzu"
Map<Long,String> companies =
        new HashMap<>();
```

---

```java id="o2lwmx"
companies.put(
        1L,
        "Google");
```

---

```java id="n4nxxk"
companies.put(
        2L,
        "Microsoft");
```

---

# IPMS Skill Repository

```java id="33cvgx"
Set<String> skills =
        new HashSet<>();
```

---

```java id="gr6xwq"
skills.add("Java");

skills.add("Spring Boot");

skills.add("Java");
```

---

# IPMS Collection Architecture

![IPMS Collection Architecture](/images/tutorials/javafundamentals/ch04-ipms-collection-architecture.png)

---

# Mini Project

Build Student Registry Module.

Requirements:

- Store Students using ArrayList
- Store Companies using HashMap
- Store Skills using HashSet
- Create Repository Interface
- Create Generic Repository

---

# Best Practices

- Program to Interfaces
- Use ArrayList by default
- Use Set for uniqueness
- Use Map for lookups
- Always use Generics
- Avoid raw collections

---

# Common Beginner Mistakes

| Mistake                    | Correct Approach         |
| -------------------------- | ------------------------ |
| Using raw collections      | Use Generics             |
| Using arrays everywhere    | Use Collections          |
| Duplicates in Set          | Understand Set behavior  |
| Wrong collection selection | Choose proper collection |
| No interfaces              | Program to interfaces    |

---

# Practice Exercises

1. Create Loginable interface.
2. Create Reportable interface.
3. Implement Student class.
4. Implement Recruiter class.
5. Create Student List.
6. Create Company Map.
7. Create Skill Set.
8. Create Generic Repository.
9. Create Generic Box.
10. Build Student Registry Module.

---

# Chapter Summary

In this chapter, you learned:

- Interfaces
- Multiple Interface Implementation
- Default Methods
- Functional Interfaces
- Collections Framework
- List
- Set
- Map
- Collection Iteration
- Generics
- Generic Classes
- Generic Methods
- Enterprise Repository Design

In the next chapter, we will learn:

- Exception Handling
- File Handling
- Java APIs

These concepts are essential for building robust enterprise applications.
