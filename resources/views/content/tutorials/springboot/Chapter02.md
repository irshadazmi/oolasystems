# Chapter 2: REST Architecture and API Design Principles

---

In the previous chapter, we explored the modern API landscape and learned why APIs have become the backbone of digital transformation initiatives.

In this chapter, we will focus on designing high-quality REST APIs using industry-standard best practices.

Before writing any code, it is important to understand how APIs should be structured, how resources should be modeled, and how consumers interact with APIs.

Using our Insurance Policy Management System (IPMS), we will design enterprise-grade REST APIs that are scalable, maintainable, and easy to consume.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand REST architectural principles
- Design resource-oriented APIs
- Create meaningful URI structures
- Use HTTP methods correctly
- Select appropriate HTTP status codes
- Understand idempotency
- Design pagination, filtering, and sorting
- Implement API versioning strategies
- Model business resources effectively

---

# What is REST?

REST stands for:

```text
Representational State Transfer
```

REST is an architectural style introduced by Roy Fielding in his doctoral dissertation.

REST is not a protocol.

REST is a set of architectural constraints that help create scalable distributed systems.

Most modern enterprise APIs are REST-based because REST is:

- Simple
- Lightweight
- Scalable
- Language agnostic
- Platform independent

---

# REST Architectural Constraints

A RESTful API follows several architectural constraints.

## Client-Server Architecture

The client and server remain independent.

Example:

```text
Mobile App
      ↓
 REST API
      ↓
 Policy Service
```

Benefits:

- Independent evolution
- Better scalability
- Separation of concerns

---

## Stateless Communication

Each request must contain all information required to process it.

Example:

```http
GET /api/policies/LIFE-100001
Authorization: Bearer token
```

The server should not depend on previous requests.

Benefits:

- Scalability
- Reliability
- Easier load balancing

---

## Uniform Interface

REST APIs should expose a consistent interface.

Examples:

```http
GET /policies
GET /policies/{policyNumber}
POST /policies
PUT /policies/{policyNumber}
DELETE /policies/{policyNumber}
```

Consumers should be able to predict API behavior.

---

## Resource-Oriented Design

REST focuses on resources rather than operations.

Bad Design:

```http
/createPolicy
/updatePolicy
/deletePolicy
```

Good Design:

```http
POST /policies
PUT /policies/{policyNumber}
DELETE /policies/{policyNumber}
```

---

# Resource Modeling

Resource modeling is one of the most important API design activities.

Before designing APIs, identify business entities.

For our Insurance Policy Management System:

```text
PolicyHolder
Policy
Coverage
Claim
PremiumPayment
Agent
Beneficiary
```

---

## Insurance Domain Model

Before designing APIs, architects must understand the business domain.

In our Insurance Policy Management System, the core business entities and their relationships drive API design.

A well-designed API reflects the business domain rather than the underlying database schema.

![Insurance Domain Model](/images/tutorials/springboot/ch02-insurance-domain-model.png)

The domain model identifies major business entities and their relationships.

---

## Resource Naming Guidelines

Use:

- Nouns
- Plural names
- Consistent naming

Examples:

```http
/policies
/policy-holders
/claims
/payments
/agents
```

Avoid:

```http
/getPolicies
/createPolicy
/deletePolicy
```

Resources represent data.

HTTP methods represent actions.

---

# URI Design Principles

Good URI design is essential for API usability.

---

## Collection Resource

Retrieve all policies:

```http
GET /policies
```

---

## Single Resource

Retrieve a specific policy:

```http
GET /policies/LIFE-100001
```

---

## Sub Resources

Retrieve claims for a policy:

```http
GET /policies/LIFE-100001/claims
```

Retrieve beneficiaries:

```http
GET /policies/LIFE-100001/beneficiaries
```

---

## URI Hierarchy

![REST Resource Hierarchy](/images/tutorials/springboot/ch02-rest-resource-hierarchy.png)

---

# HTTP Methods

HTTP methods define the action performed on a resource.

---

## GET

Retrieve data.

```http
GET /policies
```

```http
GET /policies/LIFE-100001
```

---

## POST

Create a new resource.

```http
POST /policies
```

Request:

```json
{
  "policyType": "Term Life",
  "coverageAmount": 500000
}
```

---

## PUT

Replace an existing resource.

```http
PUT /policies/LIFE-100001
```

---

## PATCH

Partially update a resource.

```http
PATCH /policies/LIFE-100001
```

Example:

```json
{
  "status": "SUSPENDED"
}
```

---

## DELETE

Delete a resource.

```http
DELETE /policies/LIFE-100001
```

---

## HTTP Method Summary

![HTTP Methods Overview](/images/tutorials/springboot/ch02-http-methods-overview.png)

---

# HTTP Status Codes

Status codes communicate request outcomes.

---

## 2xx Success

```http
200 OK
201 Created
204 No Content
```

---

## 4xx Client Errors

```http
400 Bad Request
401 Unauthorized
403 Forbidden
404 Not Found
409 Conflict
```

---

## 5xx Server Errors

```http
500 Internal Server Error
503 Service Unavailable
```

---

## Status Code Decision Tree

---

# Understanding Idempotency

Idempotency means:

```text
Multiple identical requests
produce the same result.
```

---

## Idempotent Methods

```http
GET
PUT
DELETE
```

Example:

```http
DELETE /policies/LIFE-100001
DELETE /policies/LIFE-100001
DELETE /policies/LIFE-100001
```

Result remains the same.

---

## Non-Idempotent Methods

```http
POST
```

Example:

```http
POST /policies
POST /policies
POST /policies
```

Each request creates a new resource.

---

## Idempotency Visualization

---

# Pagination

Large datasets should not be returned in a single response.

Bad:

```http
GET /policies
```

Returns:

```text
2 million records
```

Good:

```http
GET /policies?page=1&size=20
```

---

## Pagination Example

```http
GET /policies?page=2&size=10
```

Response:

```json
{
  "page": 2,
  "size": 10,
  "totalPages": 150,
  "totalRecords": 1500
}
```

---

# Filtering

Filtering reduces returned data.

Example:

```http
GET /policies?status=ACTIVE
```

```http
GET /policies?policyType=TERM
```

```http
GET /claims?status=APPROVED
```

---

# Sorting

Sorting organizes returned data.

Example:

```http
GET /policies?sort=startDate
```

Descending:

```http
GET /policies?sort=startDate,desc
```

---

## Search, Filter and Sort Flow

---

# API Versioning

APIs evolve over time.

Versioning prevents breaking existing consumers.

---

## URI Versioning

```http
/api/v1/policies
```

```http
/api/v2/policies
```

---

## Header Versioning

```http
Accept-Version: v2
```

---

## Versioning Strategy Comparison

![API Versioning Strategies](/images/tutorials/springboot/ch02-api-versioning-strategies.png)

---

# Designing Our First Insurance APIs

Using everything learned so far, we can design the primary resources for IPMS.

---

## Policy Holder APIs

```http
GET    /policy-holders

GET    /policy-holders/{id}

POST   /policy-holders

PUT    /policy-holders/{id}

DELETE /policy-holders/{id}
```

---

## Policy APIs

```http
GET    /policies

GET    /policies/{policyNumber}

POST   /policies

PUT    /policies/{policyNumber}

DELETE /policies/{policyNumber}
```

---

## Claims APIs

```http
GET    /claims

GET    /claims/{claimNumber}

POST   /claims

PUT    /claims/{claimNumber}

DELETE /claims/{claimNumber}
```

---

## Premium Payment APIs

```http
GET    /payments

GET    /payments/{paymentId}

POST   /payments
```

---

## Insurance API Resource Map

The following diagram summarizes all major REST resources that we have identified in the Insurance Policy Management System.

These resources will gradually evolve into OpenAPI specifications, Spring Boot controllers, DTOs, JPA entities, and eventually microservices.

![Insurance API Resource Map](/images/tutorials/springboot/ch02-insurance-api-resource-map.png)

---

# Best Practices

✅ Design APIs around business resources

✅ Use nouns, not verbs

✅ Use standard HTTP methods

✅ Return appropriate status codes

✅ Support pagination

✅ Use consistent naming conventions

✅ Plan versioning early

---

# Common Mistakes

❌ Designing APIs around database tables

❌ Using verbs in URIs

❌ Returning incorrect status codes

❌ Ignoring pagination

❌ Breaking backward compatibility

❌ Exposing internal implementation details

---

# Interview Questions

1. What are REST architectural constraints?

2. What is statelessness?

3. Explain idempotency.

4. Difference between PUT and PATCH?

5. Difference between POST and PUT?

6. Why should URIs use nouns instead of verbs?

7. What are common API versioning strategies?

8. Why is pagination important?

9. When should 201 Created be returned?

10. What makes a REST API consumer-friendly?

---

# Practice Exercises

1. Design REST APIs for Agent Management.

2. Design REST APIs for Beneficiary Management.

3. Create URIs for:
   - Policy Search
   - Claim Search
   - Premium History

4. Identify which APIs should support pagination.

5. Identify idempotent and non-idempotent operations.

---

# Key Takeaways

- REST is an architectural style.
- Resources are the foundation of REST APIs.
- URIs should represent business entities.
- HTTP methods represent actions.
- Status codes communicate outcomes.
- Idempotency improves reliability.
- Pagination improves scalability.
- Versioning protects consumers.
- Good API design simplifies future development.

---

# Chapter Summary

In this chapter, you learned:

- REST architectural principles
- Resource modeling
- URI design
- HTTP methods
- HTTP status codes
- Idempotency
- Pagination
- Filtering
- Sorting
- API versioning

You have now designed the APIs for our Insurance Policy Management System and are ready to formally define API contracts in the next chapter.
