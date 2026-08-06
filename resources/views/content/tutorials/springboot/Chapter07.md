# Chapter 7: Validation and Exception Handling

---

In the previous chapter, we built REST APIs for our Insurance Policy Management System (IPMS).

Our APIs can now:

- Create Policies
- Retrieve Policies
- Update Policies
- Delete Policies

However, they are not yet production ready.

Consider the following request:

```json
{
  "policyType": "",
  "coverageAmount": -1000
}
```

Should the system accept it?

Of course not.

Enterprise APIs must validate incoming data and provide meaningful error responses when something goes wrong.

In this chapter, we will learn how to build robust APIs using Bean Validation and Global Exception Handling.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Validate API requests
- Use Bean Validation annotations
- Create custom validation rules
- Handle exceptions globally
- Build standardized error responses
- Improve API usability
- Build production-ready APIs

---

# Why Validation Matters

Without validation:

```json
{
  "policyType": "",
  "coverageAmount": -5000
}
```

could enter the system.

This may lead to:

- Data corruption
- Business failures
- Regulatory issues
- Customer dissatisfaction

Validation ensures only valid data enters the application.

---

# Validation Flow

![Validation Flow](/images/tutorials/springboot/ch07-validation-flow.png)

Every request should pass through validation before business processing begins.

---

# Adding Validation Dependency

Spring Boot uses Jakarta Bean Validation.

Maven dependency:

```xml
<dependency>
    <groupId>org.springframework.boot</groupId>

    <artifactId>
        spring-boot-starter-validation
    </artifactId>
</dependency>
```

---

# PolicyRequest DTO

From Chapter06:

```java
public class PolicyRequest {

    private String policyType;

    private BigDecimal coverageAmount;

}
```

Currently nothing prevents invalid values.

---

# Bean Validation

Spring integrates Bean Validation automatically.

---

## PolicyRequest with Validation

```java
public class PolicyRequest {

    @NotBlank
    private String policyType;

    @NotNull
    @Positive
    private BigDecimal coverageAmount;

}
```

Now Spring validates requests automatically.

---

# Common Validation Annotations

## Bean Validation Annotations

![Bean Validation Annotations](/images/tutorials/springboot/ch07-bean-validation-annotations.png)

These annotations cover most enterprise validation requirements.

---

## @NotNull

Ensures value exists.

```java
@NotNull
private BigDecimal coverageAmount;
```

Invalid:

```json
{
  "coverageAmount": null
}
```

---

## @NotBlank

Ensures string contains data.

```java
@NotBlank
private String policyType;
```

Invalid:

```json
{
  "policyType": ""
}
```

---

## @Size

Validates length.

```java
@Size(min = 5, max = 50)
private String policyType;
```

---

## @Email

Useful for Policy Holder APIs.

```java
@Email
private String email;
```

---

## @Positive

```java
@Positive
private BigDecimal premiumAmount;
```

Valid:

```text
12000
```

Invalid:

```text
-12000
```

---

# Enabling Validation in Controllers

Spring performs validation when:

```java
@Valid
```

is used.

---

## Controller Example

```java
@PostMapping
public PolicyResponse createPolicy(

        @Valid

        @RequestBody
        PolicyRequest request) {

    return policyService.createPolicy(request);
}
```

If validation fails, Spring throws an exception automatically.

---

# Example Invalid Request

```json
{
  "policyType": "",
  "coverageAmount": -1000
}
```

Result:

```text
Validation Failed
```

---

# Default Validation Response

Spring returns a default error.

However, enterprise APIs usually require a custom format.

---

# Standard Error Response

A consistent error structure improves usability.

---

## Error Response Model

```java
public class ErrorResponse {

    private String timestamp;

    private int status;

    private String error;

    private String message;

    private String path;

}
```

---

## Standard Error Response

![Standard Error Response](/images/tutorials/springboot/ch07-standard-error-response.png)

---

## Example Error Response

```json
{
  "timestamp": "2026-01-01T10:00:00Z",
  "status": 400,
  "error": "Validation Failed",
  "message": "coverageAmount must be positive",
  "path": "/api/v1/policies"
}
```

---

# Exception Handling

Exceptions are inevitable.

Examples:

```text
Policy Not Found

Database Error

Validation Failure

Unauthorized Access

External Service Failure
```

The goal is not to eliminate exceptions.

The goal is to handle them properly.

---

# Traditional Approach

Many beginners use:

```java
try {

}
catch(Exception ex) {

}
```

inside every controller.

Problems:

- Repeated code
- Poor maintainability
- Inconsistent responses

---

# Global Exception Handling

Spring provides:

```java
@RestControllerAdvice
```

to centralize exception management.

---

## Global Exception Architecture

![Global Exception Handling](/images/tutorials/springboot/ch07-global-exception-handling.png)

---

# Creating Global Exception Handler

```java
@RestControllerAdvice
public class GlobalExceptionHandler {

}
```

This class intercepts exceptions from all controllers.

---

# Handling Policy Not Found

Custom exception:

```java
public class PolicyNotFoundException
        extends RuntimeException {

    public PolicyNotFoundException(
            String message) {

        super(message);
    }
}
```

---

## Throwing Exception

```java
Policy policy =
        repository.findById(policyNumber)
                  .orElseThrow(() ->
                      new PolicyNotFoundException(
                          "Policy not found"));
```

---

## Handling Exception

```java
@ExceptionHandler(
        PolicyNotFoundException.class)

public ResponseEntity<ErrorResponse>
handlePolicyNotFound(
        PolicyNotFoundException ex) {

    ErrorResponse error =
            buildErrorResponse(
                HttpStatus.NOT_FOUND,
                ex.getMessage());

    return ResponseEntity
            .status(HttpStatus.NOT_FOUND)
            .body(error);
}
```

---

# Handling Validation Errors

Spring throws:

```text
MethodArgumentNotValidException
```

for validation failures.

---

## Validation Exception Handler

```java
@ExceptionHandler(
        MethodArgumentNotValidException.class)

public ResponseEntity<ErrorResponse>
handleValidationException(
        MethodArgumentNotValidException ex) {

    ErrorResponse error =
            buildErrorResponse(
                HttpStatus.BAD_REQUEST,
                "Validation Failed");

    return ResponseEntity
            .badRequest()
            .body(error);
}
```

---

# Exception Processing Flow

![Exception Processing Flow](/images/tutorials/springboot/ch07-exception-processing-flow.png)

---

# Common HTTP Status Codes

| Status | Meaning               |
| ------ | --------------------- |
| 200    | Success               |
| 201    | Created               |
| 400    | Validation Failure    |
| 401    | Unauthorized          |
| 403    | Forbidden             |
| 404    | Resource Not Found    |
| 500    | Internal Server Error |

---

# Generic Exception Handler

Catch unexpected exceptions.

```java
@ExceptionHandler(Exception.class)

public ResponseEntity<ErrorResponse>
handleGenericException(
        Exception ex) {

    ErrorResponse error =
            buildErrorResponse(
                HttpStatus.INTERNAL_SERVER_ERROR,
                "Unexpected Error");

    return ResponseEntity
            .status(HttpStatus.INTERNAL_SERVER_ERROR)
            .body(error);
}
```

---

# Complete Error Handling Strategy

For IPMS:

```text
Validation Failure
      ↓
400 Bad Request

Policy Not Found
      ↓
404 Not Found

Authentication Failure
      ↓
401 Unauthorized

Unexpected Error
      ↓
500 Internal Server Error
```

---

# Best Practices

✅ Validate requests at API boundary

✅ Use DTO validation

✅ Return meaningful messages

✅ Use global exception handling

✅ Standardize error responses

✅ Log exceptions

---

# Common Mistakes

❌ No validation

❌ Generic exception messages

❌ Stack traces returned to clients

❌ Duplicate try-catch blocks

❌ Inconsistent error structures

---

# Interview Questions

1. Why is validation important?

2. What is Bean Validation?

3. Difference between @NotNull and @NotBlank?

4. What does @Valid do?

5. What is @RestControllerAdvice?

6. What is @ExceptionHandler?

7. Why use custom exceptions?

8. Why standardize error responses?

9. What is MethodArgumentNotValidException?

10. Why avoid try-catch in controllers?

---

# Practice Exercises

1. Add validation to PolicyRequest.

2. Create ClaimRequest validation.

3. Create PolicyNotFoundException.

4. Implement GlobalExceptionHandler.

5. Standardize error responses.

---

# Key Takeaways

- Validation protects application integrity.
- Bean Validation simplifies request validation.
- @Valid triggers automatic validation.
- Global exception handling centralizes error processing.
- Standardized error responses improve usability.
- Production APIs must validate and handle errors consistently.

---

# Chapter Summary

In this chapter, you learned:

- Bean Validation
- Validation Annotations
- Request Validation
- Custom Exceptions
- Global Exception Handling
- Error Response Standardization

Your APIs are now significantly more robust and production-ready. In the next chapter, we will implement persistence using Spring Data JPA and Hibernate.
