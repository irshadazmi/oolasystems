# Chapter 11: Enterprise Integration with Feign and WebClient

---

In the previous chapter, we secured our APIs using Spring Security, OAuth2, JWT, and RBAC.

Our Insurance Policy Management System (IPMS) can now:

- Authenticate Users
- Authorize Requests
- Secure Endpoints
- Protect Sensitive Data

However, enterprise applications rarely operate in isolation.

Insurance systems must communicate with:

- Payment Gateways
- Notification Services
- Identity Providers
- Government Systems
- Banking Systems
- Partner Insurance Providers

In this chapter, we will learn how Spring Boot applications integrate with external systems using Feign Clients and Spring WebClient.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand Enterprise Integration
- Understand Synchronous Communication
- Implement Feign Clients
- Implement WebClient
- Consume External APIs
- Configure Timeouts
- Handle Integration Errors
- Apply Integration Best Practices
- Design Insurance Service Integrations

---

# Why Enterprise Integration Matters

Modern enterprise systems are interconnected.

Example:

```text
Customer Purchases Policy
            ↓
Payment Gateway
            ↓
Policy Service
            ↓
Notification Service
            ↓
Customer Receives Confirmation
```

A single business transaction may involve multiple systems.

---

# Integration in Insurance Systems

Common integrations include:

```text
Payment Providers

SMS Providers

Email Providers

Identity Providers

KYC Verification Systems

Government Databases

Partner Insurance Systems
```

---

# Enterprise Integration Overview

![Enterprise Integration Overview](/images/tutorials/springboot/ch11-enterprise-integration-overview.png)

Enterprise systems constantly exchange information with external services.

---

# Integration Patterns

Two major communication styles exist.

```text
Synchronous Communication

Asynchronous Communication
```

---

# Synchronous Communication

Request-response model.

```text
Service A
     ↓ Request
Service B
     ↓ Response
Service A
```

Caller waits for response.

---

# Examples

```text
Policy Service
      ↓
Customer Service

Claim Service
      ↓
Policy Service

Payment Service
      ↓
Bank API
```

---

# Spring Integration Options

Spring Boot provides:

```text
RestTemplate (Legacy)

Feign Client

WebClient
```

---

# Evolution of Spring Clients

```text
RestTemplate
      ↓

Feign Client
      ↓

WebClient
```

Modern applications prefer:

```text
Feign

WebClient
```

---

# What is OpenFeign?

Feign is a declarative HTTP client.

Instead of writing:

```java
HttpURLConnection
```

or

```java
RestTemplate
```

we simply define an interface.

---

# Feign Architecture

![Feign Architecture](/images/tutorials/springboot/ch11-feign-architecture.png)

Feign automatically generates the client implementation.

---

# Adding OpenFeign

## Maven Dependency

```xml
<dependency>
    <groupId>
        org.springframework.cloud
    </groupId>

    <artifactId>
        spring-cloud-starter-openfeign
    </artifactId>
</dependency>
```

---

# Enable Feign

```java
@SpringBootApplication

@EnableFeignClients

public class Application {

}
```

---

# Creating a Feign Client

```java
@FeignClient(
    name = "customer-service",
    url = "${customer.api.url}"
)
public interface CustomerClient {

    @GetMapping(
        "/customers/{id}"
    )
    CustomerResponse getCustomer(
        @PathVariable Long id);

}
```

---

# Feign Request Flow

```java
CustomerResponse customer =
        customerClient.getCustomer(1L);
```

Feign automatically:

```text
Builds Request

Calls Remote API

Converts Response

Returns DTO
```

---

# Service Layer Example

```java
@Service
@RequiredArgsConstructor
public class PolicyService {

    private final CustomerClient
            customerClient;

}
```

---

# Policy Creation Example

```java
CustomerResponse customer =
    customerClient.getCustomer(
        request.getCustomerId());
```

External data is retrieved seamlessly.

---

# Feign Advantages

```text
Simple

Readable

Declarative

Minimal Boilerplate

Spring Integration
```

---

# What is WebClient?

WebClient is Spring's modern reactive HTTP client.

Introduced as a replacement for:

```text
RestTemplate
```

---

# WebClient Architecture

![WebClient Architecture](/images/tutorials/springboot/ch11-webclient-architecture.png)

WebClient supports synchronous and reactive communication.

---

# Adding WebFlux

```xml
<dependency>
    <groupId>
        org.springframework.boot
    </groupId>

    <artifactId>
        spring-boot-starter-webflux
    </artifactId>
</dependency>
```

---

# Creating WebClient

```java
@Bean
public WebClient webClient() {

    return WebClient.builder()
            .build();
}
```

---

# Calling External API

```java
webClient.get()
    .uri("/customers/{id}", id)
    .retrieve()
    .bodyToMono(
        CustomerResponse.class);
```

---

# Response Handling

```java
Mono<CustomerResponse>
```

Represents:

```text
Future Response
```

without blocking threads.

---

# Feign vs WebClient

| Feature             | Feign       | WebClient  |
| ------------------- | ----------- | ---------- |
| Programming Style   | Declarative | Fluent API |
| Learning Curve      | Easy        | Moderate   |
| Reactive Support    | No          | Yes        |
| Boilerplate         | Very Low    | Low        |
| Enterprise Adoption | Very High   | Very High  |

---

# Choosing Between Feign and WebClient

Use Feign when:

```text
Simple Service Integration

Microservice Communication

Synchronous APIs
```

Use WebClient when:

```text
Reactive Applications

Streaming APIs

High Throughput Workloads
```

---

# Integration Error Handling

External services may fail.

Examples:

```text
Timeout

Network Failure

Server Error

Authentication Error

Rate Limiting
```

---

# Error Handling Architecture

![Integration Error Handling](/images/tutorials/springboot/ch11-integration-error-handling.png)

Integration failures must be handled gracefully.

---

# Feign Exception Handling

```java
try {

    customerClient.getCustomer(id);

}
catch (Exception ex) {

}
```

---

# WebClient Error Handling

```java
webClient.get()

.retrieve()

.onStatus(
    HttpStatusCode::isError,
    response -> ...
)
```

---

# Timeouts

External services should never block indefinitely.

---

# Connect Timeout

```yaml
feign:
  client:
    config:
      default:
        connectTimeout: 5000
```

---

# Read Timeout

```yaml
feign:
  client:
    config:
      default:
        readTimeout: 10000
```

---

# Why Timeouts Matter

Without timeout:

```text
Request Hangs
```

With timeout:

```text
Request Fails Fast
```

Better user experience.

---

# Integration Security

External API calls often require:

```text
API Keys

OAuth2 Tokens

JWT Tokens

Mutual TLS
```

---

# Secured Integration Flow

![Secured Integration Flow](/images/tutorials/springboot/ch11-secured-integration-flow.png)

Security must extend beyond internal APIs.

---

# Insurance Integration Example

Policy Purchase:

```text
Customer
      ↓
Policy Service
      ↓
Payment Gateway
      ↓
Payment Success
      ↓
Policy Created
      ↓
Notification Service
      ↓
Email Sent
```

---

# Insurance Integration Architecture

![Insurance Integration Architecture](/images/tutorials/springboot/ch11-insurance-integration-architecture.png)

A single business operation often involves multiple external services.

---

# Best Practices

✅ Use Feign for simple service-to-service communication

✅ Use WebClient for reactive integrations

✅ Configure timeouts

✅ Handle external failures gracefully

✅ Secure external communications

✅ Centralize integration configurations

✅ Log requests and responses carefully

---

# Common Mistakes

❌ No timeout configuration

❌ Ignoring API failures

❌ Hardcoding endpoint URLs

❌ Exposing API keys

❌ Excessive retry attempts

❌ Tight coupling with external APIs

---

# Interview Questions

1. What is Feign Client?

2. What is WebClient?

3. Difference between Feign and WebClient?

4. Why is RestTemplate deprecated?

5. What is reactive communication?

6. Why are timeouts important?

7. How do you handle integration failures?

8. What is Mono?

9. When should WebClient be preferred?

10. How do you secure external API calls?

---

# Practice Exercises

1. Create a Customer Feign Client.

2. Integrate with a Payment API.

3. Configure connection timeout.

4. Configure read timeout.

5. Create a WebClient bean.

6. Call a Customer API using WebClient.

7. Handle external service failures.

8. Secure API integrations with JWT.

---

# Key Takeaways

- Enterprise systems require external integrations.
- Feign simplifies synchronous API communication.
- WebClient is Spring's modern HTTP client.
- Reactive communication improves scalability.
- Timeouts are essential.
- External failures must be handled gracefully.
- Secure communication is mandatory.
- Integration architecture is a core enterprise skill.

---

# Chapter Summary

In this chapter, you learned:

- Enterprise Integration
- Feign Client
- WebClient
- Synchronous Communication
- External API Consumption
- Timeout Configuration
- Error Handling
- Secure Integrations

Our Insurance Policy Management System can now communicate with external systems and partner services using modern Spring integration technologies.

In the next chapter, we will focus on Resilience Patterns using Resilience4j, including Retry, Circuit Breaker, Bulkhead, and Rate Limiting.
