# Chapter 12: Resilience Patterns with Resilience4j

---

In the previous chapter, we learned how to integrate our Insurance Policy Management System (IPMS) with external services using Feign Clients and WebClient.

Our system can now:

- Call External APIs
- Integrate with Payment Gateways
- Consume Partner Services
- Communicate with Notification Systems

However, there is a critical challenge.

What happens when an external service becomes slow?

What happens when a payment provider is unavailable?

What happens when a partner API continuously fails?

Without protection, a single failing dependency can impact the entire application.

In this chapter, we will learn how to build resilient APIs using Resilience4j and implement patterns such as Retry, Circuit Breaker, Bulkhead, Rate Limiting, Timeouts, and Fallbacks.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand Resilience in Distributed Systems
- Implement Retry Pattern
- Implement Circuit Breaker Pattern
- Implement Bulkhead Pattern
- Implement Rate Limiting
- Configure Timeouts
- Implement Fallback Mechanisms
- Protect External Integrations
- Monitor Resilience Metrics
- Apply Enterprise Resilience Best Practices

---

# Why Resilience Matters

Modern applications depend on multiple services.

Example:

```text
Customer
    ↓
Policy Service
    ↓
Payment Service
    ↓
Notification Service
```

If any dependency fails:

```text
Slow Response

Timeout

System Failure

Poor User Experience
```

Resilience patterns help applications survive failures gracefully.

---

# Failure Scenarios in Insurance Systems

Examples:

```text
Payment Gateway Unavailable

Customer Service Down

Email Service Slow

Partner API Timeout

Database Latency
```

Without resilience:

```text
One Failure
      ↓
Cascading Failure
      ↓
System Outage
```

---

# Resilience Architecture Overview

![Resilience Architecture Overview](/images/tutorials/springboot/ch12-resilience-architecture-overview.png)

Resilience patterns isolate failures and protect critical business operations.

---

# What is Resilience4j?

Resilience4j is a lightweight fault-tolerance library for Java applications.

Provides:

```text
Retry

Circuit Breaker

Bulkhead

Rate Limiter

Time Limiter

Fallback
```

Designed for:

```text
Spring Boot

Microservices

Cloud Native Applications
```

---

# Adding Resilience4j

## Maven Dependency

```xml
<dependency>
    <groupId>
        io.github.resilience4j
    </groupId>

    <artifactId>
        resilience4j-spring-boot3
    </artifactId>
</dependency>
```

---

# Retry Pattern

Temporary failures often recover automatically.

Example:

```text
Payment Gateway Timeout
      ↓
Retry Request
      ↓
Success
```

---

# Retry Architecture

```text
Application
      ↓
Call Service
      ↓
Failure
      ↓
Retry
      ↓
Retry
      ↓
Success
```

---

# Retry Example

```java
@Retry(
    name = "paymentService"
)
public PaymentResponse process() {

}
```

---

# Retry Configuration

```yaml
resilience4j:
  retry:
    instances:
      paymentService:
        max-attempts: 3
```

---

# Why Retry Carefully?

Too many retries may cause:

```text
Increased Load

Duplicate Requests

Resource Exhaustion
```

Use retries only for transient failures.

---

# Circuit Breaker Pattern

Suppose an external service is continuously failing.

Without protection:

```text
Request
Request
Request
Request
Request
```

All fail.

System resources become exhausted.

---

# Circuit Breaker Overview

Circuit Breaker stops calls to unhealthy services.

---

# Circuit Breaker Architecture

![Circuit Breaker Architecture](/images/tutorials/springboot/ch12-circuit-breaker-architecture.png)

Circuit breakers prevent repeated calls to failing services.

---

# Circuit Breaker States

Three states exist.

---

## Closed State

```text
Normal Operation
```

Requests pass through.

---

## Open State

```text
Failures Exceeded Threshold
```

Requests are blocked.

---

## Half Open State

```text
Testing Recovery
```

Limited requests are allowed.

---

# Circuit Breaker Example

```java
@CircuitBreaker(
    name = "paymentService"
)
public PaymentResponse process() {

}
```

---

# Circuit Breaker Configuration

```yaml
resilience4j:
  circuitbreaker:
    instances:
      paymentService:
        failure-rate-threshold: 50
```

---

# Timeout Management

Slow services are often worse than failed services.

Example:

```text
Request Sent
      ↓
Waiting...
      ↓
Waiting...
      ↓
Timeout
```

---

# Time Limiter

Resilience4j provides:

```text
Time Limiter
```

to restrict execution duration.

---

# Time Limiter Example

```java
@TimeLimiter(
    name = "paymentService"
)
public CompletableFuture<
        PaymentResponse> process() {

}
```

---

# Bulkhead Pattern

Ships use bulkheads to prevent flooding.

Software uses the same concept.

---

# Problem

Suppose:

```text
Notification Service
```

becomes overloaded.

Without isolation:

```text
Entire Application Slows Down
```

---

# Bulkhead Architecture

![Bulkhead Architecture](/images/tutorials/springboot/ch12-bulkhead-architecture.png)

Bulkheads isolate resources and prevent failure propagation.

---

# Bulkhead Example

```java
@Bulkhead(
    name = "notificationService"
)
public void sendEmail() {

}
```

---

# Rate Limiting

External APIs often impose limits.

Example:

```text
100 Requests / Minute
```

Exceeding limits may result in:

```text
429 Too Many Requests
```

---

# Rate Limiter

Controls request volume.

```text
Protects APIs

Prevents Abuse

Avoids Throttling
```

---

# Rate Limiter Example

```java
@RateLimiter(
    name = "paymentService"
)
public PaymentResponse process() {

}
```

---

# Fallback Mechanism

Fallbacks provide alternative responses.

Example:

```text
Payment Service Down
      ↓
Return Friendly Message
```

instead of:

```text
500 Internal Server Error
```

---

# Fallback Example

```java
@CircuitBreaker(
    name = "paymentService",
    fallbackMethod = "fallback"
)
public PaymentResponse process() {

}
```

---

# Fallback Method

```java
public PaymentResponse fallback(
        Exception ex) {

    return new PaymentResponse(
        "SERVICE_UNAVAILABLE");
}
```

---

# Fallback Processing Flow

![Fallback Processing Flow](/images/tutorials/springboot/ch12-fallback-processing-flow.png)

Fallbacks improve user experience during failures.

---

# Combining Patterns

Enterprise applications commonly combine:

```text
Retry
      +
Circuit Breaker
      +
Timeout
      +
Fallback
```

for maximum protection.

---

# Insurance Payment Example

```text
Policy Purchase
       ↓
Payment Gateway
       ↓
Timeout
       ↓
Retry
       ↓
Failure
       ↓
Circuit Breaker Opens
       ↓
Fallback Response
```

System remains operational.

---

# Monitoring Resilience

Resilience patterns should be monitored.

Metrics include:

```text
Retry Count

Failure Rate

Circuit Breaker State

Timeout Count

Rate Limit Violations
```

---

# Monitoring Architecture

![Resilience Monitoring Architecture](/images/tutorials/springboot/ch12-resilience-monitoring-architecture.png)

Observability is critical for resilience management.

---

# Best Practices

✅ Use Circuit Breakers for external services

✅ Configure sensible retry counts

✅ Apply timeouts everywhere

✅ Use bulkheads for isolation

✅ Implement meaningful fallbacks

✅ Monitor resilience metrics

✅ Test failure scenarios regularly

---

# Common Mistakes

❌ Unlimited retries

❌ Missing timeouts

❌ No fallback strategy

❌ Ignoring monitoring

❌ Sharing resources across services

❌ Using circuit breakers everywhere unnecessarily

---

# Interview Questions

1. What is Resilience4j?

2. What is the Retry Pattern?

3. What is a Circuit Breaker?

4. Explain Circuit Breaker states.

5. What is a Bulkhead?

6. Why use Rate Limiting?

7. What is a Time Limiter?

8. What is a Fallback Method?

9. Why is resilience important in microservices?

10. How do you monitor resilience patterns?

---

# Practice Exercises

1. Add Resilience4j to IPMS.

2. Implement Retry for Payment Service.

3. Configure Circuit Breaker.

4. Implement Time Limiter.

5. Configure Bulkhead for Notification Service.

6. Add Rate Limiting.

7. Create Fallback Methods.

8. Monitor Circuit Breaker Metrics.

---

# Key Takeaways

- Distributed systems must expect failures.
- Resilience4j provides enterprise-grade fault tolerance.
- Retry handles transient failures.
- Circuit Breakers prevent cascading failures.
- Bulkheads isolate resources.
- Rate Limiting controls traffic.
- Timeouts prevent resource exhaustion.
- Fallbacks improve user experience.
- Monitoring is essential for resilience.

---

# Chapter Summary

In this chapter, you learned:

- Resilience4j
- Retry Pattern
- Circuit Breaker
- Bulkhead
- Rate Limiting
- Time Limiter
- Fallback Mechanisms
- Resilience Monitoring

Our Insurance Policy Management System can now handle failures gracefully and remain available even when external services become slow or unavailable.

In the next chapter, we will focus on Microservices API Design, Service Decomposition, API Gateway, and Service Discovery.
