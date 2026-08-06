# Chapter 9: DTO Mapping and Data Transformation

---

In the previous chapter, we introduced persistence using Spring Data JPA and Hibernate.

Our Insurance Policy Management System (IPMS) can now:

- Store Policies
- Retrieve Policies
- Manage Relationships
- Handle Transactions

However, there is an important problem.

Should we expose database entities directly through APIs?

The answer is:

No.

Enterprise applications use DTOs (Data Transfer Objects) to separate internal database models from external API contracts.

In this chapter, we will learn how to transform data between Entities and DTOs and build clean API contracts.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand DTOs
- Separate API contracts from database models
- Implement Request DTOs
- Implement Response DTOs
- Perform Entity-DTO mapping
- Use MapStruct
- Build transformation pipelines
- Follow enterprise API design practices

---

# Why DTOs Matter

Suppose we expose the Policy entity directly.

```java
@Entity
public class Policy {

    private String policyNumber;

    private String policyType;

    private String status;

    private BigDecimal coverageAmount;

    private LocalDateTime createdAt;

    private LocalDateTime updatedAt;

    private Long version;
}
```

Should API consumers see:

```text
createdAt

updatedAt

version
```

Probably not.

These are internal implementation details.

DTOs help hide them.

---

# DTO Mapping Overview

![DTO Mapping Overview](/images/tutorials/springboot/ch09-dto-mapping-overview.png)

DTOs create a clean separation between APIs and persistence.

---

# What is a DTO?

DTO stands for:

```text
Data Transfer Object
```

Its purpose is:

```text
Transfer Data
Between Layers
Without Exposing Internal Models
```

DTOs contain only the fields needed by the client.

---

# Request DTO

Used for incoming requests.

Example:

```java
public class PolicyRequest {

    private String policyType;

    private BigDecimal coverageAmount;

}
```

Client sends:

```json
{
  "policyType": "TERM",
  "coverageAmount": 1000000
}
```

---

# Response DTO

Returned to API consumers.

```java
public class PolicyResponse {

    private String policyNumber;

    private String policyType;

    private String status;

    private BigDecimal coverageAmount;

}
```

---

# Request and Response Separation

![Request Response Separation](/images/tutorials/springboot/ch09-request-response-separation.png)

Enterprise APIs rarely use the same object for both requests and responses.

---

# Why Not Return Entities?

Example:

```java
@GetMapping("/{policyNumber}")
public Policy getPolicy() {
    return policy;
}
```

Problems:

❌ Internal fields exposed

❌ Tight coupling

❌ Serialization issues

❌ Security concerns

❌ Relationship loading problems

---

# Entity vs DTO

## Policy Entity

```java
@Entity
public class Policy {

    private String policyNumber;

    private String policyType;

    private String status;

    private BigDecimal coverageAmount;

    private LocalDateTime createdAt;

    private LocalDateTime updatedAt;

    private Long version;
}
```

---

## PolicyResponse DTO

```java
public class PolicyResponse {

    private String policyNumber;

    private String policyType;

    private String status;

    private BigDecimal coverageAmount;

}
```

Notice how internal fields are hidden.

---

# Manual Mapping

The simplest approach.

---

## Entity to DTO

```java
public PolicyResponse toResponse(
        Policy policy) {

    PolicyResponse response =
            new PolicyResponse();

    response.setPolicyNumber(
            policy.getPolicyNumber());

    response.setPolicyType(
            policy.getPolicyType());

    response.setStatus(
            policy.getStatus());

    response.setCoverageAmount(
            policy.getCoverageAmount());

    return response;
}
```

---

# DTO to Entity

```java
public Policy toEntity(
        PolicyRequest request) {

    Policy policy = new Policy();

    policy.setPolicyType(
            request.getPolicyType());

    policy.setCoverageAmount(
            request.getCoverageAmount());

    return policy;
}
```

---

# Transformation Flow

![Entity DTO Transformation Flow](/images/tutorials/springboot/ch09-entity-dto-transformation-flow.png)

Every API request and response passes through a transformation layer.

---

# Mapper Component

Create a dedicated mapper.

```java
@Component
public class PolicyMapper {

}
```

Responsibilities:

```text
Entity → DTO

DTO → Entity
```

Only.

No business logic.

---

# Introducing MapStruct

Manual mapping becomes repetitive.

Example:

```text
Policy
Claim
Beneficiary
Payment
Agent
```

Hundreds of DTOs may exist.

MapStruct automates mapping.

---

# MapStruct Dependency

```xml
<dependency>
    <groupId>org.mapstruct</groupId>

    <artifactId>mapstruct</artifactId>

    <version>1.5.5.Final</version>
</dependency>
```

---

# MapStruct Mapper

```java
@Mapper(
    componentModel = "spring"
)
public interface PolicyMapper {

    PolicyResponse toResponse(
            Policy policy);

    Policy toEntity(
            PolicyRequest request);

}
```

MapStruct generates implementation automatically.

---

# MapStruct Architecture

![MapStruct Architecture](/images/tutorials/springboot/ch09-mapstruct-architecture.png)

Compile-time code generation provides excellent performance.

---

# Service Layer with Mapper

```java
@Service
@RequiredArgsConstructor
public class PolicyService {

    private final PolicyRepository repository;

    private final PolicyMapper mapper;

}
```

---

# Create Policy Example

```java
public PolicyResponse createPolicy(
        PolicyRequest request) {

    Policy entity =
            mapper.toEntity(request);

    repository.save(entity);

    return mapper.toResponse(entity);
}
```

---

# Nested DTO Mapping

Real-world insurance systems contain relationships.

Example:

```text
Policy
   ↓
Policy Holder
```

---

## PolicyHolderResponse

```java
public class PolicyHolderResponse {

    private String fullName;

    private String email;

}
```

---

## PolicyResponse

```java
public class PolicyResponse {

    private String policyNumber;

    private PolicyHolderResponse
            policyHolder;

}
```

MapStruct handles nested mappings automatically.

---

# Data Transformation Pipeline

![API Data Transformation Pipeline](/images/tutorials/springboot/ch09-api-data-transformation-pipeline.png)

This is the standard architecture used in enterprise systems.

---

# API Contract Stability

Suppose the database changes:

```java
private LocalDateTime
        lastPremiumProcessedAt;
```

Should clients break?

No.

Because clients use DTOs.

DTOs provide:

```text
Contract Stability
```

---

# Common Mapping Strategies

## Manual Mapping

Advantages:

```text
Simple

No Dependencies
```

Disadvantages:

```text
Boilerplate Code
```

---

## ModelMapper

Advantages:

```text
Quick Setup
```

Disadvantages:

```text
Reflection Based

Slower
```

---

## MapStruct

Advantages:

```text
Compile-Time Generation

High Performance

Type Safe
```

Preferred for enterprise applications.

---

# Best Practices

✅ Use DTOs for all APIs

✅ Never expose entities

✅ Keep mappers focused

✅ Use MapStruct for large projects

✅ Separate request and response models

✅ Version DTOs carefully

---

# Common Mistakes

❌ Returning entities directly

❌ Business logic inside mappers

❌ Reusing entities as DTOs

❌ Massive DTO classes

❌ Tight API-database coupling

---

# Interview Questions

1. What is a DTO?

2. Why use DTOs?

3. Difference between Entity and DTO?

4. Why avoid exposing entities?

5. What is MapStruct?

6. What is ModelMapper?

7. Why is MapStruct faster?

8. What is nested DTO mapping?

9. Where should mapping logic reside?

10. Why separate request and response DTOs?

---

# Practice Exercises

1. Create PolicyMapper.

2. Create ClaimMapper.

3. Convert manual mapping to MapStruct.

4. Add nested DTO mapping.

5. Create AgentResponse DTO.

---

# Key Takeaways

- DTOs separate APIs from database models.
- Entities should never be exposed directly.
- Request and Response DTOs serve different purposes.
- Mapping centralizes data transformation.
- MapStruct is the preferred enterprise solution.
- DTOs provide API stability and security.

---

# Chapter Summary

In this chapter, you learned:

- DTOs
- Entity-DTO Mapping
- Request DTOs
- Response DTOs
- Manual Mapping
- MapStruct
- Data Transformation

Our Insurance Policy Management System now has a clean separation between persistence and API contracts. In the next chapter, we will focus on API Security, Authentication, Authorization, and JWT-based access control.
