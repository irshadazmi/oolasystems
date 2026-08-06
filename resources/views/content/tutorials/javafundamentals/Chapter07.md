# Chapter 7: Multithreading & Concurrent Programming

---

# Introduction

Modern enterprise applications often need to perform multiple tasks simultaneously.

Examples:

- Processing multiple user requests
- Generating reports
- Sending notifications
- Importing files
- Processing payments
- Running background jobs

Executing all tasks sequentially can reduce application performance and responsiveness.

Java provides powerful support for:

- Multithreading
- Concurrent Programming
- Thread Pools
- Task Scheduling
- Synchronization

In this chapter, we will learn how to build scalable and responsive applications using Java concurrency features and apply them to our Institute Placement Management System (IPMS).

---

# What You Will Learn

By the end of this chapter, you will:

- Understand Processes and Threads
- Create Threads
- Implement Runnable
- Use Thread Lifecycle
- Work with Synchronization
- Avoid Race Conditions
- Use Executor Framework
- Create Thread Pools
- Work with Callable and Future
- Use Concurrent Collections
- Build Background Processing Features
- Apply Concurrency in IPMS

---

# Understanding Processes

A process is an executing program.

Examples:

- Chrome Browser
- IntelliJ IDEA
- VS Code
- Java Application

Each process has:

- Memory
- Resources
- Threads

---

# Understanding Threads

A thread is the smallest unit of execution within a process.

---

# Example

```text id="t1"
IPMS Application
│
├── Student Registration Thread
├── Placement Report Thread
├── Notification Thread
└── Background Processing Thread
```

---

# Benefits of Multithreading

- Better Performance
- Improved Responsiveness
- Efficient Resource Utilization
- Parallel Processing
- Scalability

---

# Process vs Thread

| Feature       | Process   | Thread |
| ------------- | --------- | ------ |
| Memory        | Separate  | Shared |
| Communication | Expensive | Easy   |
| Creation Cost | High      | Low    |
| Performance   | Slower    | Faster |

---

# Multithreading Overview

![Multithreading Overview](/images/tutorials/javafundamentals/ch07-multithreading-overview.png)

---

# Creating Threads

Java provides multiple approaches.

---

# Approach 1: Extending Thread

```java id="t2"
public class StudentThread
        extends Thread {

    @Override
    public void run() {

        System.out.println(
                "Processing Student");
    }
}
```

---

# Starting Thread

```java id="t3"
StudentThread thread =
        new StudentThread();

thread.start();
```

---

# Output

```text id="t4"
Processing Student
```

---

# Understanding start()

```java id="t5"
thread.start();
```

Creates a new thread.

---

# Incorrect Approach

```java id="t6"
thread.run();
```

Executes in current thread.

---

# Approach 2: Runnable Interface

Recommended approach.

---

# Example

```java id="t7"
public class ReportTask
        implements Runnable {

    @Override
    public void run() {

        System.out.println(
                "Generating Report");
    }
}
```

---

# Creating Thread

```java id="t8"
Thread thread =
        new Thread(
                new ReportTask());

thread.start();
```

---

# Lambda Version

```java id="t9"
Thread thread =
        new Thread(
                () ->
                        System.out.println(
                                "Generating Report"));
```

---

# Thread Lifecycle

A thread passes through multiple states.

---

# States

```text id="t10"
NEW

RUNNABLE

RUNNING

WAITING

TIMED_WAITING

TERMINATED
```

---

# Thread Lifecycle Diagram

![Thread Lifecycle](/images/tutorials/javafundamentals/ch07-thread-lifecycle.png)

---

# Example

```java id="t11"
Thread thread =
        new Thread(
                () ->
                        System.out.println(
                                "Running"));
```

---

```java id="t12"
System.out.println(
        thread.getState());
```

---

# Output

```text id="t13"
NEW
```

---

# Sleep Method

Pauses thread execution.

---

```java id="t14"
Thread.sleep(2000);
```

---

# Example

```java id="t15"
try {

    Thread.sleep(1000);

}
catch(Exception ex) {

}
```

---

# Joining Threads

Waits for thread completion.

---

```java id="t16"
thread.join();
```

---

# Example

```java id="t17"
Thread reportThread =
        new Thread(
                () ->
                        System.out.println(
                                "Generating Report"));

reportThread.start();

reportThread.join();

System.out.println(
        "Completed");
```

---

# Thread Priority

Controls execution preference.

---

```java id="t18"
thread.setPriority(
        Thread.MAX_PRIORITY);
```

---

# Priority Values

```text id="t19"
MIN_PRIORITY = 1

NORM_PRIORITY = 5

MAX_PRIORITY = 10
```

---

# Race Condition

Occurs when multiple threads modify shared data simultaneously.

---

# Example

```java id="t20"
private int count = 0;
```

---

```java id="t21"
count++;
```

---

# Problem

Multiple threads can update count incorrectly.

---

# Synchronization

Prevents concurrent access to shared resources.

---

# Synchronized Method

```java id="t22"
public synchronized void increment() {

    count++;
}
```

---

# Example

```java id="t23"
public class Counter {

    private int count = 0;

    public synchronized void increment() {

        count++;
    }
}
```

---

# Synchronized Block

```java id="t24"
synchronized(this) {

    count++;
}
```

---

# Example

```java id="t25"
public void increment() {

    synchronized(this) {

        count++;
    }
}
```

---

# Synchronization Architecture

![Synchronization Architecture](/images/tutorials/javafundamentals/ch07-synchronization-architecture.png)

---

# Deadlock

Occurs when threads wait indefinitely for each other.

---

# Example

```text id="t26"
Thread A waits for Thread B

Thread B waits for Thread A
```

---

# Avoiding Deadlocks

- Lock Ordering
- Timeout Strategies
- Reduce Shared Resources

---

# Executor Framework

Introduced to simplify thread management.

---

# Benefits

- Thread Reuse
- Better Performance
- Simplified Code
- Thread Pooling

---

# Creating Executor Service

```java id="t27"
ExecutorService executor =
        Executors.newFixedThreadPool(5);
```

---

# Submitting Tasks

```java id="t28"
executor.submit(
        () ->
                System.out.println(
                        "Task Executed"));
```

---

# Shutting Down

```java id="t29"
executor.shutdown();
```

---

# Fixed Thread Pool

```java id="t30"
ExecutorService executor =
        Executors.newFixedThreadPool(10);
```

---

# Cached Thread Pool

```java id="t31"
ExecutorService executor =
        Executors.newCachedThreadPool();
```

---

# Single Thread Executor

```java id="t32"
ExecutorService executor =
        Executors.newSingleThreadExecutor();
```

---

# Executor Architecture

![Executor Framework Architecture](/images/tutorials/javafundamentals/ch07-executor-framework-architecture.png)

---

# Callable Interface

Runnable cannot return results.

Callable can.

---

# Example

```java id="t33"
Callable<String> task =
        () -> "Completed";
```

---

# Submitting Callable

```java id="t34"
Future<String> future =
        executor.submit(task);
```

---

# Getting Result

```java id="t35"
String result =
        future.get();
```

---

# Output

```text id="t36"
Completed
```

---

# Future Interface

Represents asynchronous result.

---

# Example

```java id="t37"
Future<Integer> result =
        executor.submit(
                () -> 100);
```

---

# Check Completion

```java id="t38"
result.isDone();
```

---

# Concurrent Collections

Thread-safe collections.

---

# Examples

- ConcurrentHashMap
- CopyOnWriteArrayList
- BlockingQueue

---

# ConcurrentHashMap

```java id="t39"
ConcurrentHashMap<Long,String>
students =
new ConcurrentHashMap<>();
```

---

# Example

```java id="t40"
students.put(
        101L,
        "John Doe");
```

---

```java id="t41"
students.put(
        102L,
        "Sara Elise");
```

---

# CopyOnWriteArrayList

```java id="t42"
CopyOnWriteArrayList<String>
students =
new CopyOnWriteArrayList<>();
```

---

# BlockingQueue

Useful for producer-consumer scenarios.

---

```java id="t43"
BlockingQueue<String> queue =
        new LinkedBlockingQueue<>();
```

---

# Adding Elements

```java id="t44"
queue.put(
        "Placement Drive");
```

---

# Reading Elements

```java id="t45"
String value =
        queue.take();
```

---

# Scheduled Tasks

Execute tasks periodically.

---

# Example

```java id="t46"
ScheduledExecutorService scheduler =
        Executors.newScheduledThreadPool(2);
```

---

# Schedule Task

```java id="t47"
scheduler.schedule(
        () ->
                System.out.println(
                        "Reminder"),
        5,
        TimeUnit.SECONDS);
```

---

# Repeated Task

```java id="t48"
scheduler.scheduleAtFixedRate(
        () ->
                System.out.println(
                        "Generating Report"),
        0,
        10,
        TimeUnit.SECONDS);
```

---

# IPMS Student Registration Task

```java id="t49"
Runnable registrationTask =
        () ->
                System.out.println(
                        "Student Registered");
```

---

# IPMS Placement Report Task

```java id="t50"
Callable<String> reportTask =
        () -> "Report Generated";
```

---

# Execute Tasks

```java id="t51"
ExecutorService executor =
        Executors.newFixedThreadPool(3);

executor.submit(
        registrationTask);

executor.submit(
        reportTask);
```

---

# Notification Processing

```java id="t52"
executor.submit(
        () ->
                System.out.println(
                        "Email Sent"));
```

---

# Bulk Student Processing

```java id="t53"
students.parallelStream()
        .forEach(
                System.out::println);
```

---

# IPMS Concurrent Processing Architecture

![IPMS Concurrent Processing Architecture](/images/tutorials/javafundamentals/ch07-ipms-concurrent-processing.png)

---

# Mini Project

Build Placement Processing Engine.

Requirements:

- Student Registration Task
- Report Generation Task
- Email Notification Task
- Executor Framework
- Callable Tasks
- Scheduled Reports
- Concurrent Collections

---

# Best Practices

- Prefer Executor Framework
- Use Thread Pools
- Minimize Shared State
- Use Concurrent Collections
- Avoid Excessive Synchronization
- Shutdown Executors Properly

---

# Common Beginner Mistakes

| Mistake                            | Correct Approach            |
| ---------------------------------- | --------------------------- |
| Creating too many threads          | Use Thread Pool             |
| Ignoring synchronization           | Protect shared resources    |
| Not shutting down executors        | Call shutdown()             |
| Using ArrayList in concurrent code | Use Concurrent Collections  |
| Blocking unnecessarily             | Use asynchronous processing |

---

# Practice Exercises

1. Create Thread using Thread class.
2. Create Runnable implementation.
3. Create Callable implementation.
4. Use ExecutorService.
5. Create Fixed Thread Pool.
6. Create Scheduled Task.
7. Implement Counter using synchronization.
8. Use ConcurrentHashMap.
9. Process Student data concurrently.
10. Build Placement Processing Engine.

---

# Chapter Summary

In this chapter, you learned:

- Processes and Threads
- Thread Lifecycle
- Runnable
- Callable
- Synchronization
- Race Conditions
- Executor Framework
- Thread Pools
- Future
- Concurrent Collections
- Scheduled Tasks
- Concurrent Processing

In the next chapter, we will learn:

- SOLID Principles
- Design Patterns
- Enterprise Application Design

These concepts help build maintainable, scalable and professional Java applications.
