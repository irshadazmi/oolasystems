# Chapter 8: Persistence Layer with Spring Data JPA and Hibernate

---

In the previous chapter, we implemented request validation and exception handling for our Insurance Policy Management System (IPMS).

Our APIs can now:

- Validate requests
- Return standardized errors
- Handle exceptions gracefully

However, our data is still not stored anywhere.

In this chapter, we will introduce the persistence layer using Spring Data JPA and Hibernate.

By the end of this chapter, our APIs will be capable of storing and retrieving insurance policies from a relational database.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand JPA
- Understand Hibernate
- Create Entities
- Create Repositories
- Perform CRUD operations
- Configure database connectivity
- Understand entity relationships
- Manage transactions

---

# Why Persistence Matters

Without persistence:

```text
Create Policy
      ↓
Application Restarts
      ↓
Data Lost
```

Persistence ensures data survives application restarts.

For our Insurance Policy Management System we must store:

```text
Policy Holders

Policies

Claims

Premium Payments

Agents

Beneficiaries
```

---

# JPA and Hibernate Overview

Many developers confuse JPA and Hibernate.

They are not the same.

---

## What is JPA?

JPA stands for:

```text
Java Persistence API
```

JPA is a specification.

It defines:

- Entity mapping
- Persistence operations
- Relationships
- Query mechanisms

---

## What is Hibernate?

Hibernate is:

```text
JPA Implementation
```

It provides the actual persistence engine.

---

## JPA-Hibernate Architecture

![JPA Hibernate Architecture](/images/tutorials/springboot/ch08-jpa-hibernate-architecture.png)

---

# Persistence Architecture

Our application architecture now becomes:

```text
Controller
      ↓
Service
      ↓
Repository
      ↓
Hibernate
      ↓
Database
```

This follows the layered architecture introduced in Chapter05.

---

# Database Configuration

Spring Boot simplifies database configuration.

---

## application.yml

```yaml
spring:
  datasource:
    url: jdbc:mysql://localhost:3306/ipms

    username: root

    password: password

  jpa:
    hibernate:
      ddl-auto: update

    show-sql: true
```

---

# Creating Our First Entity

The first entity will be:

```text
Policy
```

which we introduced in earlier chapters.

---

# Policy Entity

```java
@Entity

@Table(name = "policies")

public class Policy {

    @Id

    private String policyNumber;

    private String policyType;

    private String status;

    private BigDecimal coverageAmount;

}
```

---

# Understanding Entity Annotations

## @Entity

Marks the class as a database entity.

```java
@Entity
public class Policy {
}
```

---

## @Table

Maps entity to database table.

```java
@Table(name = "policies")
```

---

## @Id

Defines the primary key.

```java
@Id
private String policyNumber;
```

---

# Entity Lifecycle

Every entity goes through a lifecycle.

---

## Entity Lifecycle

![Entity Lifecycle](/images/tutorials/springboot/ch08-entity-lifecycle.png)

---

States include:

```text
Transient

Persistent

Detached

Removed
```

Understanding these states helps diagnose persistence issues.

---

# Policy Entity Model

Our Policy entity contains:

```text
Policy Number

Policy Type

Status

Coverage Amount
```

---

## Policy Entity Model

![Policy Entity Model](/images/tutorials/springboot/ch08-policy-entity-model.png)

---

# Creating Repository Layer

Repositories abstract database access.

Without repositories:

```java
Connection connection =
        DriverManager.getConnection(...);
```

With Spring Data JPA:

```java
policyRepository.save(policy);
```

---

# Policy Repository

```java
@Repository

public interface PolicyRepository
        extends JpaRepository<
                Policy,
                String> {

}
```

Spring automatically generates CRUD operations.

---

# CRUD Operations

The repository automatically provides:

```java
save()

findById()

findAll()

deleteById()

existsById()
```

No implementation required.

---

# Saving a Policy

```java
Policy policy = new Policy();

policy.setPolicyNumber("LIFE-100001");

policyRepository.save(policy);
```

Hibernate generates SQL automatically.

---

# Generated SQL

```sql
insert into policies
(
  policy_number,
  policy_type
)
values
(
  'LIFE-100001',
  'TERM'
);
```

---

# Repository Flow

## Repository Processing Flow

![Repository Flow](/images/tutorials/springboot/ch08-jpa-repository-flow.png)

---

# Query Methods

Spring Data JPA generates queries automatically.

---

## Find By Status

```java
List<Policy>
findByStatus(String status);
```

Spring generates SQL automatically.

---

## Find By Policy Type

```java
List<Policy>
findByPolicyType(String policyType);
```

No SQL required.

---

# Integrating Repository into Service Layer

Service:

```java
@Service
@RequiredArgsConstructor
public class PolicyService {

    private final PolicyRepository
            repository;

}
```

---

# Create Policy Service

```java
public PolicyResponse createPolicy(
        PolicyRequest request) {

    Policy policy = mapper.toEntity(request);

    repository.save(policy);

    return mapper.toResponse(policy);
}
```

This is our first real database operation.

---

# Entity Relationships

Insurance systems contain relationships.

Examples:

```text
Policy Holder
      ↓
Policies

Policy
      ↓
Claims

Policy
      ↓
Beneficiaries
```

---

# Common Relationships

## One-To-Many

```java
@OneToMany
```

Example:

```text
Policy Holder
      ↓
Multiple Policies
```

---

## Many-To-One

```java
@ManyToOne
```

Example:

```text
Many Policies
      ↓
One Policy Holder
```

---

## Entity Relationships

![Entity Relationships](/images/tutorials/springboot/ch08-entity-relationships.png)

---

# Policy Holder Entity

```java
@Entity
public class PolicyHolder {

    @Id
    private Long id;

    private String fullName;

}
```

---

# Policy Entity Relationship

```java
@ManyToOne

@JoinColumn(
        name = "policy_holder_id")

private PolicyHolder policyHolder;
```

Hibernate automatically manages foreign keys.

---

# Transactions

Database operations should be atomic.

Example:

```text
Create Policy
      ↓
Create Payment Schedule
      ↓
Create Beneficiaries
```

Either:

```text
All Succeed
```

or

```text
All Fail
```

---

# Transaction Management

Spring provides:

```java
@Transactional
```

---

## Transaction Example

```java
@Transactional

public void createPolicy() {

    savePolicy();

    saveBeneficiary();

    savePayment();

}
```

---

# Transaction Processing Flow

![Transaction Management Flow](/images/tutorials/springboot/ch08-transaction-management-flow.png)

---

# Optimistic Locking

Multiple users may update the same policy.

Example:

```text
User A Updates Policy
User B Updates Policy
```

Potential conflict.

---

## Version Field

```java
@Version

private Long version;
```

Hibernate prevents accidental overwrites.

---

# Best Practices

✅ Use repositories for persistence

✅ Keep entities focused on data

✅ Use transactions for business operations

✅ Model relationships carefully

✅ Use optimistic locking

✅ Keep service layer responsible for orchestration

---

# Common Mistakes

❌ Business logic inside entities

❌ Database access inside controllers

❌ Missing transactions

❌ Eager loading everywhere

❌ Exposing entities directly to APIs

---

# Interview Questions

1. What is JPA?

2. What is Hibernate?

3. Difference between JPA and Hibernate?

4. What is an Entity?

5. What is JpaRepository?

6. What is @Transactional?

7. Difference between @OneToMany and @ManyToOne?

8. What is optimistic locking?

9. What is entity lifecycle?

10. Why use repositories?

---

# Practice Exercises

1. Create Claim entity.

2. Create ClaimRepository.

3. Add PolicyHolder relationship.

4. Create custom query methods.

5. Add transaction management.

---

# Key Takeaways

- JPA is a specification.
- Hibernate is a JPA implementation.
- Entities map Java objects to database tables.
- Repositories simplify database access.
- Spring Data JPA generates CRUD operations automatically.
- Relationships model business domains.
- Transactions ensure data consistency.
- Persistence is the foundation of enterprise applications.

---

# Chapter Summary

In this chapter, you learned:

- JPA
- Hibernate
- Entity Mapping
- Repositories
- CRUD Operations
- Relationships
- Transactions
- Optimistic Locking

Our Insurance Policy Management System can now persist and retrieve data from a database. In the next chapter, we will focus on DTO Mapping, Data Transformation, and API Response Modeling.
