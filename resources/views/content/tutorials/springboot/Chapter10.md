# Chapter 10: API Security with OAuth2, JWT and RBAC

---

In the previous chapter, we introduced DTO Mapping and Data Transformation.

Our Insurance Policy Management System (IPMS) now has:

- Clean API Contracts
- Request DTOs
- Response DTOs
- Entity-DTO Mapping
- MapStruct Integration

However, there is another critical question.

Who should be allowed to access these APIs?

Can anyone create policies?

Can anyone approve claims?

Can anyone access customer information?

The answer is:

No.

Enterprise APIs must be secured to ensure that only authenticated and authorized users can access protected resources.

In this chapter, we will learn how to secure APIs using Spring Security, OAuth2, JWT (JSON Web Tokens), and Role-Based Access Control (RBAC).

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand API Security Fundamentals
- Differentiate Authentication and Authorization
- Understand OAuth2 Architecture
- Understand OpenID Connect
- Implement JWT Authentication
- Validate JWT Tokens
- Configure Spring Security
- Implement Role-Based Access Control (RBAC)
- Secure REST APIs
- Apply Enterprise Security Best Practices

---

# Why API Security Matters

Imagine an unsecured insurance API.

```http
GET /api/policies
```

Without security:

```text
Anyone Can Access Policies

Anyone Can View Customer Data

Anyone Can Modify Claims

Anyone Can Delete Policies
```

This is unacceptable in enterprise systems.

Security protects:

```text
Confidentiality

Integrity

Availability
```

---

# Security in Insurance Systems

Insurance applications handle sensitive data.

Examples:

```text
Policy Information

Customer Personal Data

Claim Information

Payment Information

Beneficiary Information
```

Unauthorized access can result in:

```text
Data Breach

Financial Loss

Compliance Violations

Reputation Damage
```

---

# API Security Overview

![API Security Overview](/images/tutorials/springboot/ch10-api-security-overview.png)

Security is applied before business logic is executed.

---

# Authentication vs Authorization

Many developers confuse these concepts.

They are different.

---

## Authentication

Authentication answers:

```text
Who Are You?
```

Examples:

```text
Username + Password

OAuth Login

JWT Token

Biometric Authentication
```

---

## Authorization

Authorization answers:

```text
What Are You Allowed To Do?
```

Examples:

```text
Create Policy

View Policy

Approve Claim

Delete Policy
```

---

# Authentication and Authorization Flow

Authentication occurs first.

Authorization occurs second.

---

# Spring Security Overview

Spring Security is the standard security framework for Spring Boot.

Provides:

```text
Authentication

Authorization

Session Management

CSRF Protection

Password Encryption

OAuth2 Support

JWT Support
```

---

# Spring Security Architecture

![Spring Security Architecture](/images/tutorials/springboot/ch10-spring-security-architecture.png)

Every request passes through the security filter chain.

---

# Adding Spring Security

## Maven Dependency

```xml
<dependency>
    <groupId>
        org.springframework.boot
    </groupId>

    <artifactId>
        spring-boot-starter-security
    </artifactId>
</dependency>
```

---

# Default Security Behavior

Once added:

```text
All Endpoints Become Protected
```

Spring automatically creates:

```text
Generated Password

Basic Authentication

Security Filters
```

---

# OAuth2 Fundamentals

Modern APIs rarely use username/password directly.

Instead they use:

```text
OAuth2
```

OAuth2 is an authorization framework.

It allows secure delegated access.

---

# OAuth2 Actors

OAuth2 includes:

```text
Resource Owner

Client Application

Authorization Server

Resource Server
```

---

# OAuth2 Architecture

![OAuth2 Architecture](/images/tutorials/springboot/ch10-oauth2-architecture.png)

OAuth2 separates authentication from resource access.

---

# What is OpenID Connect?

OAuth2 handles authorization.

OpenID Connect (OIDC) adds:

```text
Authentication
```

OIDC provides:

```text
Identity Information

User Profile

Login Support
```

Examples:

```text
Google Login

Microsoft Login

GitHub Login
```

---

# What is JWT?

JWT stands for:

```text
JSON Web Token
```

JWT enables stateless authentication.

Instead of storing sessions:

```text
Server Issues Token

Client Sends Token

Server Validates Token
```

---

# JWT Structure

A JWT contains three parts.

```text
Header
   .

Payload
   .

Signature
```

Example:

```text
xxxxx.yyyyy.zzzzz
```

---

# JWT Architecture

![JWT Architecture](/images/tutorials/springboot/ch10-jwt-architecture.png)

JWT removes the need for server-side session storage.

---

# JWT Header Example

```json
{
  "alg": "HS256",
  "typ": "JWT"
}
```

---

# JWT Payload Example

```json
{
  "sub": "john.doe",

  "roles": ["POLICY_ADMIN"],

  "exp": 1735689600
}
```

---

# JWT Signature

Signature ensures:

```text
Token Integrity

Tamper Detection
```

If payload changes:

```text
Signature Invalid
```

---

# JWT Authentication Flow

This is the most common architecture used by modern APIs.

---

# Login API Example

```http
POST /api/auth/login
```

Request:

```json
{
  "username": "agent01",
  "password": "password"
}
```

Response:

```json
{
  "accessToken": "eyJhbGciOi..."
}
```

---

# Sending JWT in Requests

Client sends:

```http
Authorization:
Bearer eyJhbGciOi...
```

---

# JWT Validation

Server validates:

```text
Signature

Expiration

Issuer

Audience

Claims
```

Only valid tokens are accepted.

---

# Role-Based Access Control (RBAC)

Authentication identifies users.

RBAC determines permissions.

---

## Example Roles

```text
ADMIN

POLICY_ADMIN

CLAIMS_ADMIN

AGENT

CUSTOMER
```

---

# RBAC Model

```text
Insurance Policy Management System

CUSTOMER
   ↓
View Own Policies

AGENT
   ↓
Create Policies

CLAIMS_ADMIN
   ↓
Approve Claims

ADMIN
   ↓
Full System Access
```

![RBAC Model](/images/tutorials/springboot/ch10-rbac-model.png)

Roles simplify authorization management.

---

# Insurance System Role Matrix

| Role         | Create Policy | Approve Claim | View Customer |
| ------------ | ------------- | ------------- | ------------- |
| ADMIN        | Yes           | Yes           | Yes           |
| POLICY_ADMIN | Yes           | No            | Yes           |
| CLAIMS_ADMIN | No            | Yes           | Yes           |
| AGENT        | Yes           | No            | Limited       |
| CUSTOMER     | No            | No            | Own Data      |

---

# Securing Endpoints

```java
@GetMapping("/policies")
```

Protect using:

```java
@PreAuthorize(
 "hasRole('POLICY_ADMIN')"
)
```

---

# RBAC Example

```java
@PreAuthorize(
    "hasRole('CLAIMS_ADMIN')")
public void approveClaim() {

}
```

Only claim administrators can execute this method.

---

# Security Configuration

```java
@Configuration
@EnableMethodSecurity
public class SecurityConfig {

    @Bean
    SecurityFilterChain securityFilterChain(
            HttpSecurity http)
            throws Exception {

        return http.build();
    }

}
```

Centralized security management.

---

# Security Filter Chain

```java
@Bean
SecurityFilterChain securityFilterChain(
        HttpSecurity http)
        throws Exception {

    return http.build();
}
```

---

# Security Processing Flow

![Security Processing Flow](/images/tutorials/springboot/ch10-security-processing-flow.png)

Every API request is validated before reaching controllers.

---

# Password Encryption

Passwords must never be stored in plain text.

Use:

```java
BCryptPasswordEncoder
```

---

## Example

```java
String encodedPassword =
    encoder.encode(password);
```

---

# Security Best Practices

✅ Use HTTPS everywhere

✅ Use JWT expiration

✅ Use strong password policies

✅ Encrypt sensitive data

✅ Apply RBAC

✅ Validate all tokens

✅ Use least-privilege access

✅ Rotate signing keys

---

# Common Security Mistakes

❌ Hardcoding secrets

❌ Exposing internal APIs

❌ Using plain-text passwords

❌ Missing token validation

❌ Excessive permissions

❌ Storing JWTs insecurely

---

# Interview Questions

1. Difference between Authentication and Authorization?

2. What is OAuth2?

3. What is OpenID Connect?

4. What is JWT?

5. Explain JWT structure.

6. What is RBAC?

7. Why use Spring Security?

8. What is a Security Filter Chain?

9. Why use BCrypt?

10. Why is JWT considered stateless?

---

# Practice Exercises

1. Add Spring Security to IPMS.

2. Create login endpoint.

3. Generate JWT token.

4. Validate JWT token.

5. Create ADMIN role.

6. Create AGENT role.

7. Secure policy APIs.

8. Secure claim approval APIs.

---

# Key Takeaways

- Security is mandatory for enterprise APIs.
- Authentication identifies users.
- Authorization controls access.
- OAuth2 enables delegated authorization.
- OpenID Connect adds identity support.
- JWT provides stateless authentication.
- RBAC simplifies permission management.
- Spring Security is the standard security framework for Spring Boot.

---

# Chapter Summary

In this chapter, you learned:

- Authentication
- Authorization
- Spring Security
- OAuth2
- OpenID Connect
- JWT
- RBAC
- Endpoint Security
- Password Encryption

Our Insurance Policy Management System can now authenticate users, authorize access, and secure APIs using enterprise-grade security standards.

In the next chapter, we will focus on Enterprise Integration using Feign Clients and Spring WebClient for communication with external systems.
