# Chapter 3: API Contracts and OpenAPI Specification

---

In the previous chapter, we designed REST APIs for our Insurance Policy Management System (IPMS).

We identified resources such as:

- Policy Holder
- Policy
- Coverage
- Claim
- Premium Payment
- Agent
- Beneficiary

However, designing URIs alone is not enough.

Enterprise APIs require a formal contract that clearly defines:

- Available endpoints
- Request structures
- Response structures
- Error responses
- Security requirements
- API documentation

In this chapter, we will learn how to define API contracts using the OpenAPI Specification (formerly Swagger Specification) and adopt a Contract-First approach used by modern enterprises.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand API contracts
- Understand OpenAPI Specification
- Create OpenAPI documents
- Generate Swagger documentation
- Design APIs using Contract-First principles
- Define request and response schemas
- Understand Consumer Driven Contracts
- Create enterprise-grade API documentation

---

# What is an API Contract?

An API contract is a formal agreement between API providers and API consumers.

The contract defines:

- Available endpoints
- Request parameters
- Request payloads
- Response payloads
- Status codes
- Authentication mechanisms
- Error structures

Without a contract:

```text
Consumer guesses API behavior
```

With a contract:

```text
Consumer understands API behavior
before implementation begins
```

---

## OpenAPI Ecosystem Overview

![OpenAPI Ecosystem Overview](/images/tutorials/springboot/ch03-openapi-overview.png)

The OpenAPI Specification serves as the central contract between providers, consumers, developers, testers, and API governance teams.

---

# Why API Contracts Matter

Enterprise APIs are consumed by multiple teams.

Examples:

```text
Customer Mobile App

Broker Portal

Agent Portal

Claims Processing System

Partner Integrations

Regulatory Systems
```

A contract ensures all consumers have a consistent understanding of API behavior.

Benefits include:

- Faster development
- Better collaboration
- Reduced misunderstandings
- Automated documentation
- Automated testing
- Improved governance

---

# Introduction to OpenAPI Specification

OpenAPI Specification (OAS) is the industry standard for describing REST APIs.

It provides a machine-readable contract that can be used to:

- Generate documentation
- Generate SDKs
- Generate client code
- Generate server stubs
- Validate requests
- Validate responses

Current versions:

```text
OpenAPI 3.0.x
OpenAPI 3.1.x
```

---

# OpenAPI Example

A simple endpoint definition:

```yaml
paths:
  /policies/{policyNumber}:
    get:
      summary: Retrieve policy information
```

Although simple, this contract already defines:

- Endpoint
- HTTP Method
- Purpose

Additional information can be added progressively.

---

# OpenAPI Document Structure

An OpenAPI document consists of several sections.

## OpenAPI Structure

![OpenAPI Document Structure](/images/tutorials/springboot/ch03-openapi-document-structure.png)

Typical sections include:

```text
openapi

info

servers

paths

components

security

tags
```

---

# Info Section

Provides API metadata.

Example:

```yaml
openapi: 3.0.3

info:
  title: Insurance Policy API
  description: Insurance Policy Management System
  version: 1.0.0
```

---

# Server Section

Defines deployment endpoints.

Example:

```yaml
servers:
  - url: https://dev.api.ipms.com

  - url: https://test.api.ipms.com

  - url: https://api.ipms.com
```

---

# Paths Section

Defines API endpoints.

Example:

```yaml
paths:
  /policies:
    get:
      summary: Retrieve all policies
```

---

# Components Section

Defines reusable schemas.

Example:

```yaml
components:
  schemas:
    Policy:
      type: object
```

Reusable schemas reduce duplication and improve consistency.

---

# Designing Our First Policy Contract

Let us create a contract for retrieving a policy.

---

## Endpoint

```http
GET /policies/{policyNumber}
```

---

## Request Parameters

```yaml
parameters:
  - name: policyNumber
    in: path
    required: true
```

---

## Successful Response

```yaml
responses:
  "200":
    description: Policy retrieved successfully
```

---

## Policy Schema

```yaml
Policy:
  type: object

  properties:
    policyNumber:
      type: string

    policyType:
      type: string

    status:
      type: string

    coverageAmount:
      type: number
```

---

# Complete Insurance Policy API Example

```yaml
openapi: 3.0.3

info:
  title: Insurance Policy API
  version: 1.0.0

paths:
  /policies/{policyNumber}:
    get:
      summary: Get Policy

      parameters:
        - name: policyNumber
          in: path
          required: true
          schema:
            type: string

      responses:
        "200":
          description: Policy Retrieved

          content:
            application/json:
              schema:
                $ref: "#/components/schemas/Policy"

components:
  schemas:
    Policy:
      type: object

      properties:
        policyNumber:
          type: string

        policyType:
          type: string

        status:
          type: string

        coverageAmount:
          type: number
```

---

# Swagger and OpenAPI

Many people use the terms Swagger and OpenAPI interchangeably.

However, they are different.

| OpenAPI           | Swagger               |
| ----------------- | --------------------- |
| Specification     | Tooling Ecosystem     |
| Contract Standard | Documentation & Tools |
| Vendor Neutral    | SmartBear Toolset     |

Examples:

```text
OpenAPI Specification

Swagger UI

Swagger Editor

Swagger Codegen
```

---

# Swagger UI

Swagger UI provides interactive API documentation.

Features:

- Browse endpoints
- Execute API calls
- View responses
- Test APIs

Typical enterprise workflow:

```text
OpenAPI Contract
         ↓
Swagger UI
         ↓
Developer Portal
```

---

# Contract-First Development

Traditionally teams followed:

```text
Code First
```

Approach:

```text
Develop API
      ↓
Document API
```

Problems:

- Inconsistent contracts
- Documentation gaps
- Integration delays

---

## Contract-First Development

![Contract First Development](/images/tutorials/springboot/ch03-contract-first-development.png)

Modern organizations prefer:

```text
Design Contract
       ↓
Review Contract
       ↓
Approve Contract
       ↓
Implement API
       ↓
Test API
```

Benefits:

- Better governance
- Early stakeholder feedback
- Consistent API standards
- Faster development

---

# Insurance API Design Review Example

Before implementation, architects review:

```http
GET /policies/{policyNumber}

POST /policies

PUT /policies/{policyNumber}

DELETE /policies/{policyNumber}
```

The OpenAPI contract becomes the official source of truth.

---

# Request and Response Validation

Contracts help validate:

- Required fields
- Field types
- Allowed values
- Formats

Example:

```yaml
email:
  type: string
  format: email
```

Validation can be automated.

---

# Error Response Contracts

Enterprise APIs should standardize errors.

Example:

```json
{
  "timestamp": "2026-01-01T10:00:00Z",
  "status": 404,
  "error": "Not Found",
  "message": "Policy not found",
  "path": "/policies/LIFE-100001"
}
```

Documenting errors improves API usability.

---

# Consumer Driven Contracts (CDC)

Large organizations often have multiple consumers for the same API.

Examples:

```text
Customer Mobile App

Broker Portal

Claims Portal

Partner Systems
```

Different consumers may have different expectations.

---

## Consumer Driven Contracts

![Consumer Driven Contracts](/images/tutorials/springboot/ch03-consumer-driven-contracts.png)

Consumers define expectations that providers must satisfy.

Benefits:

- Reduced integration failures
- Faster testing
- Better collaboration
- Higher confidence during deployments

Popular tools:

```text
Pact

Spring Cloud Contract
```

---

# API Documentation Best Practices

✅ Document every endpoint

✅ Provide request examples

✅ Provide response examples

✅ Document error responses

✅ Include authentication details

✅ Keep documentation synchronized with implementation

---

# Common Documentation Mistakes

❌ Outdated documentation

❌ Missing examples

❌ Missing error contracts

❌ Undocumented breaking changes

❌ Documentation maintained separately from code

---

# Applying OpenAPI to Our Insurance APIs

The following APIs will eventually receive OpenAPI contracts:

```text
Policy Holder API

Policy API

Coverage API

Claims API

Premium Payment API

Agent API

Beneficiary API
```

In upcoming chapters, these contracts will be implemented using Spring Boot and automatically published through Swagger UI.

---

# Interview Questions

1. What is an API contract?

2. Why are API contracts important?

3. What is OpenAPI Specification?

4. Difference between OpenAPI and Swagger?

5. What is Contract-First Development?

6. What are the major sections of an OpenAPI document?

7. Why are reusable schemas important?

8. What are Consumer Driven Contracts?

9. What is Swagger UI used for?

10. Why should error responses be documented?

---

# Practice Exercises

1. Create an OpenAPI contract for:
   - Policy Holder API

2. Define request and response schemas for:
   - Claim API

3. Add standard error responses.

4. Design reusable schemas for:
   - Policy
   - Claim
   - Agent

5. Compare Code-First and Contract-First approaches.

---

# Key Takeaways

- API contracts define how consumers interact with APIs.
- OpenAPI is the industry standard for REST API contracts.
- Swagger provides tooling around OpenAPI.
- Contract-First development improves quality and governance.
- Reusable schemas improve consistency.
- Consumer Driven Contracts improve integration reliability.
- Documentation is a critical part of API design.

---

# Chapter Summary

In this chapter, you learned:

- API Contracts
- OpenAPI Specification
- Swagger
- Contract-First Development
- OpenAPI Document Structure
- Request and Response Schemas
- Consumer Driven Contracts
- API Documentation Best Practices

You now have formal API contracts for the Insurance Policy Management System and are ready to begin implementing APIs using Spring Boot.
