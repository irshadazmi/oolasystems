# Chapter 5: Exception Handling, File Handling & Java APIs

---

# Introduction

Enterprise applications must be resilient and capable of handling unexpected situations gracefully.

Examples:

- Invalid user input
- Missing files
- Database failures
- Network interruptions
- Security issues
- System resource limitations

Without proper error handling, applications can crash unexpectedly and lead to poor user experiences.

Java provides powerful mechanisms for:

- Exception Handling
- File Handling
- Standard APIs

These capabilities help developers build reliable and maintainable applications.

In this chapter, we will learn how to handle runtime errors, work with files, and utilize important Java APIs while continuing development of our Institute Placement Management System (IPMS).

---

# What You Will Learn

By the end of this chapter, you will:

- Understand Exceptions
- Differentiate Checked and Unchecked Exceptions
- Use try-catch-finally
- Handle Multiple Exceptions
- Create Custom Exceptions
- Work with Files and Directories
- Read and Write Files
- Use Buffered Streams
- Understand Serialization
- Use Java Date and Time APIs
- Build Error Handling for IPMS

---

# Understanding Exceptions

An exception is an event that disrupts normal program execution.

---

# Examples

- Divide by Zero
- Invalid Input
- File Not Found
- Network Failure
- Database Error

---

# Exception Flow

![Exception Handling Flow](/images/tutorials/javafundamentals/ch05-exception-handling-flow.png)

---

# Example Without Exception Handling

```java
public class Main {

    public static void main(String[] args) {

        int result = 10 / 0;

        System.out.println(result);
    }
}
```

---

# Output

```text
Exception in thread "main"
java.lang.ArithmeticException
```

---

# Understanding Exception Hierarchy

Java exceptions derive from:

```text
Throwable
```

---

# Hierarchy

```text
Throwable
│
├── Error
│
└── Exception
     │
     ├── Checked Exceptions
     │
     └── Runtime Exceptions
```

---

# Checked Exceptions

Checked exceptions are verified during compilation.

Examples:

- IOException
- FileNotFoundException
- SQLException

---

# Example

```java
FileReader reader =
        new FileReader("students.txt");
```

Compiler requires exception handling.

---

# Unchecked Exceptions

Occur at runtime.

Examples:

- ArithmeticException
- NullPointerException
- ArrayIndexOutOfBoundsException

---

# Example

```java
String name = null;

System.out.println(
        name.length());
```

---

# try-catch Block

Used to handle exceptions.

---

# Example

```java
public class Main {

    public static void main(String[] args) {

        try {

            int result = 10 / 0;

        } catch (ArithmeticException ex) {

            System.out.println(
                    ex.getMessage());
        }
    }
}
```

---

# Output

```text
/ by zero
```

---

# Multiple Catch Blocks

```java
try {

}
catch(ArithmeticException ex) {

}
catch(NullPointerException ex) {

}
```

---

# Example

```java
try {

    String name = null;

    System.out.println(
            name.length());

}
catch(ArithmeticException ex) {

}
catch(NullPointerException ex) {

    System.out.println(
            "Null value detected");
}
```

---

# finally Block

Executes regardless of exception occurrence.

---

# Example

```java
try {

    System.out.println(
            "Processing");

}
finally {

    System.out.println(
            "Cleanup");
}
```

---

# Output

```text
Processing

Cleanup
```

---

# Complete Example

```java
try {

    int result = 100 / 10;

}
catch(Exception ex) {

    System.out.println(
            ex.getMessage());

}
finally {

    System.out.println(
            "Completed");
}
```

---

# throw Keyword

Used to create exceptions manually.

---

```java
throw new RuntimeException(
        "Invalid Data");
```

---

# Example

```java
double cgpa = -1;

if(cgpa < 0) {

    throw new RuntimeException(
            "Invalid CGPA");
}
```

---

# throws Keyword

Used in method declarations.

---

```java
public void save()
        throws IOException {

}
```

---

# Example

```java
public static void process()
        throws Exception {

    throw new Exception(
            "Processing Failed");
}
```

---

# Custom Exceptions

Enterprise applications often require custom exceptions.

---

# Example

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

# Using Custom Exception

```java
if(cgpa < 0 || cgpa > 10) {

    throw new InvalidCgpaException(
            "Invalid CGPA");
}
```

---

# IPMS Example

```java
public class StudentService {

    public void validateCgpa(
            double cgpa)
            throws InvalidCgpaException {

        if(cgpa < 0 ||
                cgpa > 10) {

            throw new InvalidCgpaException(
                    "Invalid CGPA");
        }
    }
}
```

---

# File Handling

Enterprise applications frequently read and write files.

Examples:

- Reports
- Logs
- Configuration Files
- Data Imports
- Data Exports

---

# Java File API

Main class:

```java
java.io.File
```

---

# Creating File Object

```java
File file =
        new File(
                "students.txt");
```

---

# Checking File Exists

```java
if(file.exists()) {

    System.out.println(
            "File Found");
}
```

---

# Creating Directory

```java
File directory =
        new File(
                "reports");

directory.mkdir();
```

---

# File Operations Overview

![File Handling Architecture](/images/tutorials/javafundamentals/ch05-file-handling-architecture.png)

---

# Writing Files

Using FileWriter.

---

```java
FileWriter writer =
        new FileWriter(
                "students.txt");
```

---

# Writing Data

```java
writer.write(
        "John Doe");
```

---

# Closing File

```java
writer.close();
```

---

# Complete Example

```java
FileWriter writer =
        new FileWriter(
                "students.txt");

writer.write(
        "John Doe");

writer.close();
```

---

# Reading Files

Using FileReader.

---

```java
FileReader reader =
        new FileReader(
                "students.txt");
```

---

# Example

```java
int data;

while((data =
        reader.read()) != -1) {

    System.out.print(
            (char)data);
}
```

---

# BufferedWriter

Improves performance.

---

```java
BufferedWriter writer =
        new BufferedWriter(
                new FileWriter(
                        "students.txt"));
```

---

# Example

```java
writer.write(
        "Sara Elise");

writer.newLine();

writer.close();
```

---

# BufferedReader

Efficient file reading.

---

```java
BufferedReader reader =
        new BufferedReader(
                new FileReader(
                        "students.txt"));
```

---

# Example

```java
String line;

while((line =
        reader.readLine())
        != null) {

    System.out.println(line);
}
```

---

# Writing Multiple Records

```java
BufferedWriter writer =
        new BufferedWriter(
                new FileWriter(
                        "students.txt"));
```

---

```java
writer.write(
        "John Doe");

writer.newLine();

writer.write(
        "Sara Elise");
```

---

# Serialization

Serialization converts objects into byte streams.

---

# Benefits

- Persistence
- Data Transfer
- Caching

---

# Serializable Interface

```java
public class Student
        implements Serializable {

}
```

---

# Example

```java
public class Student
        implements Serializable {

    private Long id;

    private String name;
}
```

---

# Writing Object

```java
ObjectOutputStream output =
        new ObjectOutputStream(
                new FileOutputStream(
                        "student.dat"));
```

---

```java
output.writeObject(
        student);
```

---

# Reading Object

```java
ObjectInputStream input =
        new ObjectInputStream(
                new FileInputStream(
                        "student.dat"));
```

---

```java
Student student =
        (Student)
        input.readObject();
```

---

# Java Date and Time API

Introduced in Java 8.

Package:

```text
java.time
```

---

# LocalDate

```java
LocalDate today =
        LocalDate.now();
```

---

# Output

```text
2026-06-21
```

---

# LocalTime

```java
LocalTime time =
        LocalTime.now();
```

---

# LocalDateTime

```java
LocalDateTime now =
        LocalDateTime.now();
```

---

# Creating Date

```java
LocalDate driveDate =
        LocalDate.of(
                2026,
                7,
                15);
```

---

# Date Formatting

```java
DateTimeFormatter formatter =
        DateTimeFormatter.ofPattern(
                "dd-MM-yyyy");
```

---

```java
String formatted =
        driveDate.format(
                formatter);
```

---

# Parsing Date

```java
LocalDate date =
        LocalDate.parse(
                "15-07-2026",
                formatter);
```

---

# Date Operations

```java
LocalDate today =
        LocalDate.now();
```

---

```java
today.plusDays(10);
```

---

```java
today.minusMonths(1);
```

---

# Period Calculation

```java
Period period =
        Period.between(
                startDate,
                endDate);
```

---

# Example

```java
System.out.println(
        period.getDays());
```

---

# IPMS Placement Drive Example

```java
LocalDate driveDate =
        LocalDate.of(
                2026,
                8,
                10);
```

---

```java
System.out.println(
        driveDate);
```

---

# Student File Export

```java
BufferedWriter writer =
        new BufferedWriter(
                new FileWriter(
                        "students.csv"));
```

---

```java
writer.write(
        "101,John Doe,8.75");
```

---

```java
writer.write(
        "102,Sara Elise,9.20");
```

---

# Student File Import

```java
BufferedReader reader =
        new BufferedReader(
                new FileReader(
                        "students.csv"));
```

---

```java
String line;

while((line =
        reader.readLine())
        != null) {

    System.out.println(
            line);
}
```

---

# Logging Example

```java
BufferedWriter logWriter =
        new BufferedWriter(
                new FileWriter(
                        "application.log",
                        true));
```

---

```java
logWriter.write(
        "Student Registered");
```

---

# IPMS Error Handling Architecture

![IPMS Error Handling Architecture](/images/tutorials/javafundamentals/ch05-ipms-error-handling-architecture.png)

---

# Mini Project

Build Student File Management Module.

Requirements:

- Student Registration
- Validate CGPA
- Custom Exceptions
- Export Students to CSV
- Import Students from CSV
- Generate Logs
- Placement Drive Scheduling

---

# Best Practices

- Catch specific exceptions
- Avoid empty catch blocks
- Always close resources
- Use Buffered Streams
- Create custom exceptions
- Log important events
- Validate user input

---

# Common Beginner Mistakes

| Mistake                              | Correct Approach          |
| ------------------------------------ | ------------------------- |
| Catching Exception everywhere        | Catch specific exceptions |
| Ignoring exceptions                  | Handle properly           |
| Not closing files                    | Use try-with-resources    |
| Using RuntimeException unnecessarily | Create custom exceptions  |
| Hardcoded file paths                 | Use configuration         |

---

# Practice Exercises

1. Handle ArithmeticException.
2. Handle NullPointerException.
3. Create custom exception.
4. Read text file.
5. Write text file.
6. Create CSV export.
7. Create CSV import.
8. Serialize Student object.
9. Deserialize Student object.
10. Schedule placement drives using LocalDate.

---

# Chapter Summary

In this chapter, you learned:

- Exception Handling
- Checked Exceptions
- Unchecked Exceptions
- try-catch-finally
- throw and throws
- Custom Exceptions
- File Handling
- Buffered Streams
- Serialization
- Date and Time API
- Enterprise Error Handling

In the next chapter, we will learn:

- Functional Programming
- Lambda Expressions
- Functional Interfaces
- Stream API

These features introduced in modern Java significantly improve productivity and code readability.
