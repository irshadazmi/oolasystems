# Chapter 5: Spring Boot Architecture

---

In the previous chapters, we designed APIs, defined contracts using OpenAPI, and documented them using Swagger.

Now it is time to start implementation.

In this chapter, we will build the architectural foundation of our Insurance Policy Management System (IPMS) using Spring Boot.

Rather than focusing on coding immediately, we will first understand how enterprise Spring Boot applications are structured and how responsibilities are distributed across layers.

This architecture will serve as the foundation for all subsequent chapters.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand Spring Boot architecture
- Understand layered architecture
- Understand Controller-Service-Repository pattern
- Understand Dependency Injection
- Understand DTOs and Entities
- Understand request processing flow
- Organize enterprise Spring Boot projects
- Design maintainable applications

---

# Why Architecture Matters

As applications grow, complexity increases.

Without architecture:

```text
Controller
      ↓
Database
```

applications quickly become:

- Difficult to maintain
- Difficult to test
- Difficult to scale

Enterprise applications therefore use layered architecture.

---

# Spring Boot Layered Architecture

## Layered Architecture Overview

![Spring Boot Layered Architecture](/images/tutorials/springboot/ch05-springboot-layered-architecture.png)

The application is divided into logical layers.

Each layer has a specific responsibility.

Benefits include:

- Separation of concerns
- Maintainability
- Testability
- Scalability

---

# Insurance Policy Management System

Throughout the remainder of this tutorial we will implement:

```text
PolicyHolder
Policy
Coverage
Claim
PremiumPayment
Agent
Beneficiary
```

using the layered architecture.

---

# The Layers Explained

## Presentation Layer

Also known as:

```text
Controller Layer
```

Responsibilities:

- Receive HTTP requests
- Validate requests
- Invoke business services
- Return responses

Example:

```http
GET /policies/LIFE-100001
```

---

## Business Layer

Also known as:

```text
Service Layer
```

Responsibilities:

- Business rules
- Validation logic
- Orchestration
- Transaction boundaries

Examples:

```text
Create Policy

Submit Claim

Calculate Premium

Process Renewal
```

---

## Persistence Layer

Also known as:

```text
Repository Layer
```

Responsibilities:

- Database access
- CRUD operations
- Query execution

Technologies:

```text
Spring Data JPA

Hibernate
```

---

## Database Layer

Stores application data.

Examples:

```text
Policy

Claim

Payment

Agent
```

---

# Controller-Service-Repository Pattern

Enterprise Spring Boot applications commonly use:

```text
Controller
      ↓
Service
      ↓
Repository
      ↓
Database
```

---

## CSR Pattern Overview

![Controller Service Repository Pattern](/images/tutorials/springboot/ch05-controller-service-repository.png)

Each layer communicates only with the layer immediately below it.

This reduces coupling.

---

# Building Our First Domain Model

From previous chapters:

```text
Policy
```

OpenAPI Contract:

```http
GET /policies/{policyNumber}
```

Now we create domain objects.

---

## Policy Entity

```java
public class Policy {

    private String policyNumber;

    private String policyType;

    private String status;

    private BigDecimal coverageAmount;
}
```

This object represents business data.

---

# DTOs vs Entities

Many beginners expose database entities directly.

Enterprise applications avoid this.

---

## Entity

Represents:

```text
Database Structure
```

Example:

```java
@Entity
public class Policy {
}
```

---

## DTO

Represents:

```text
API Contract
```

Example:

```java
public class PolicyResponse {
}
```

---

## Why DTOs?

Benefits:

- Security
- Encapsulation
- Versioning
- Flexibility

---

# Dependency Injection

One of the most important Spring concepts is:

```text
Dependency Injection (DI)
```

Instead of creating objects manually:

```java
PolicyService service =
        new PolicyService();
```

Spring creates and injects them automatically.

---

## Dependency Injection

![Dependency Injection](/images/tutorials/springboot/ch05-dependency-injection.png)

Spring manages object creation through the IoC container.

Benefits:

- Loose coupling
- Easier testing
- Better maintainability

---

# Spring Stereotype Annotations

Spring identifies components using annotations.

---

## Controller

```java
@RestController
public class PolicyController {
}
```

---

## Service

```java
@Service
public class PolicyService {
}
```

---

## Repository

```java
@Repository
public interface PolicyRepository {
}
```

---

# Request Processing Flow

Consider:

```http
GET /policies/LIFE-100001
```

How does Spring process this request?

---

## Request Flow

![Request Processing Flow](/images/tutorials/springboot/ch05-request-processing-flow.png)

The request moves through multiple layers before a response is returned.

---

# Example Flow

Step 1:

```http
GET /policies/LIFE-100001
```

Step 2:

```text
PolicyController
```

Step 3:

```text
PolicyService
```

Step 4:

```text
PolicyRepository
```

Step 5:

```text
Database
```

Step 6:

```json
{
  "policyNumber": "LIFE-100001",
  "status": "ACTIVE"
}
```

---

# Project Structure

A clean project structure improves maintainability.

---

## IPMS Project Structure

![IPMS Project Structure](/images/tutorials/springboot/ch05-ipms-project-structure.png)

Recommended structure:

```text
com.sunlife.ipms

├── controller
├── service
├── repository
├── entity
├── dto
├── mapper
├── config
├── exception
├── security
└── util
```

---

# Why Package by Layer?

Advantages:

- Easy to understand
- Familiar to most developers
- Suitable for small and medium applications

---

# Future Evolution

As the application grows:

```text
Policy Module

Claim Module

Payment Module
```

we may evolve toward:

```text
Package by Feature
```

architecture.

We will revisit this in the Microservices chapter.

---

# Best Practices

✅ Keep controllers thin

✅ Put business logic in services

✅ Keep repositories focused on data access

✅ Use DTOs for APIs

✅ Use constructor injection

✅ Maintain clear package structure

---

# Common Mistakes

❌ Business logic in controllers

❌ Database access in controllers

❌ Exposing entities directly

❌ Circular dependencies

❌ Large service classes

---

# Interview Questions

1. What is layered architecture?

2. What is Dependency Injection?

3. Difference between Service and Repository?

4. Why use DTOs?

5. Why avoid exposing entities?

6. What is IoC?

7. What are stereotype annotations?

8. Why keep controllers thin?

9. What is constructor injection?

10. What are advantages of layered architecture?

---

# Practice Exercises

1. Design Controller, Service, and Repository layers for Claims.

2. Create DTOs for Premium Payment APIs.

3. Design a package structure for Agent Management.

4. Identify responsibilities of each layer.

5. Refactor a tightly coupled design into a layered architecture.

---

# Key Takeaways

- Spring Boot applications use layered architecture.
- Controllers handle requests.
- Services contain business logic.
- Repositories manage persistence.
- DTOs separate API contracts from entities.
- Dependency Injection promotes loose coupling.
- Clean project structure improves maintainability.
- Architecture decisions impact scalability and quality.

---

# Chapter Summary

In this chapter, you learned:

- Spring Boot Layered Architecture
- Controller-Service-Repository Pattern
- DTOs and Entities
- Dependency Injection
- Request Processing Flow
- Project Structure

You now have the architectural foundation required to begin building real Spring Boot APIs in the next chapter.
