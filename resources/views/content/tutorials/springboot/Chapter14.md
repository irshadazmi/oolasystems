# Chapter 14: Event-Driven APIs with Kafka

---

In the previous chapter, we transformed our Insurance Policy Management System (IPMS) into a Microservices Architecture.

Our system now has:

- Independent Services
- API Gateway
- Service Discovery
- Database per Service
- Bounded Contexts

However, a new challenge emerges.

How should microservices communicate?

Should every service call every other service using REST APIs?

As the number of services grows, synchronous communication creates tight coupling and reduces resilience.

Modern enterprise systems solve this problem using:

```text
Event-Driven Architecture
```

In this chapter, we will learn how Apache Kafka enables scalable event-driven communication between microservices.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand Event-Driven Architecture
- Understand Apache Kafka
- Understand Producers and Consumers
- Understand Topics and Partitions
- Design Event Contracts
- Implement Event-Driven Communication
- Understand Consumer Groups
- Understand Event Sourcing Concepts
- Understand CQRS Fundamentals
- Design Insurance Event Flows

---

# Why Event-Driven Architecture?

Consider the following process.

```text
Policy Created
      ↓
Generate Payment Schedule
      ↓
Notify Customer
      ↓
Update Analytics
      ↓
Audit Logging
```

Using synchronous APIs:

```text
Policy Service
      ↓
Payment Service
      ↓
Notification Service
      ↓
Analytics Service
```

Each service depends on the next.

Problems:

```text
Tight Coupling

Cascading Failures

Slow Response Times

Difficult Scalability
```

---

# What is Event-Driven Architecture?

In Event-Driven Architecture (EDA):

```text
Service Produces Event
      ↓
Event Broker
      ↓
Interested Services Consume Event
```

Services do not directly call each other.

---

# Event-Driven Architecture Overview

![Event Driven Architecture Overview](/images/tutorials/springboot/ch14-event-driven-architecture-overview.png)

Events enable loose coupling between services.

---

# What is an Event?

An event represents something that happened.

Examples:

```text
Policy Created

Policy Updated

Claim Submitted

Claim Approved

Premium Paid

Customer Registered
```

Events describe facts.

---

# Event Examples

```json
{
  "eventType": "POLICY_CREATED",

  "policyNumber": "LIFE-100001",

  "policyType": "TERM"
}
```

---

# What is Apache Kafka?

Apache Kafka is a distributed event streaming platform.

Kafka provides:

```text
High Throughput

Scalability

Fault Tolerance

Event Streaming

Durability
```

---

# Why Kafka?

Kafka is widely used because it supports:

```text
Millions of Events

Distributed Processing

Replayability

High Availability
```

---

# Kafka Core Components

Kafka consists of:

```text
Producer

Topic

Partition

Broker

Consumer

Consumer Group
```

---

# Kafka Architecture

![Kafka Architecture](/images/tutorials/springboot/ch14-kafka-architecture.png)

Kafka acts as the central event backbone.

---

# Kafka Producer

A Producer publishes events.

Example:

```text
Policy Service
      ↓
POLICY_CREATED Event
      ↓
Kafka Topic
```

---

# Producer Example

```java
kafkaTemplate.send(
    "policy-events",
    event
);
```

---

# Kafka Consumer

Consumers subscribe to topics.

Example:

```text
Notification Service

Analytics Service

Audit Service
```

can all consume the same event.

---

# Consumer Example

```java
@KafkaListener(
    topics = "policy-events")
public void consume(
        PolicyCreatedEvent event) {

}
```

---

# Kafka Topics

Topics are logical channels used to organize events.

Examples:

```text
policy-events

claim-events

payment-events

notification-events
```

---

# Topic Example

```text
policy-events
     ↓
POLICY_CREATED

POLICY_UPDATED

POLICY_CANCELLED
```

---

# Kafka Partitions

Topics are divided into partitions.

Benefits:

```text
Parallel Processing

Scalability

High Throughput
```

Example:

```text
policy-events

Partition 0

Partition 1

Partition 2
```

---

# Consumer Groups

Multiple consumers can work together.

```text
Consumer Group
      ↓
Consumer 1

Consumer 2

Consumer 3
```

Kafka distributes partitions automatically.

---

# Message Flow

Consider a new policy creation.

```text
Customer Creates Policy
```

What happens next?

---

# Kafka Message Flow

![Kafka Message Flow](/images/tutorials/springboot/ch14-kafka-message-flow.png)

Multiple services react independently.

---

# Event Contracts

Events should be treated as contracts.

Example:

```json
{
  "eventType": "POLICY_CREATED",

  "policyNumber": "LIFE-100001",

  "policyType": "TERM",

  "coverageAmount": 1000000
}
```

---

# Why Event Contracts Matter

Contracts ensure:

```text
Consistency

Compatibility

Reliability
```

Consumers depend on event structure.

---

# Event Versioning

Events evolve over time.

Example:

```json
{
  "eventVersion": 2
}
```

Versioning prevents breaking consumers.

---

# Insurance Domain Events

Typical IPMS events:

```text
POLICY_CREATED

POLICY_UPDATED

CLAIM_SUBMITTED

CLAIM_APPROVED

CLAIM_REJECTED

PAYMENT_RECEIVED

CUSTOMER_REGISTERED
```

---

# Event-Driven IPMS Architecture

![Event Driven IPMS Architecture](/images/tutorials/springboot/ch14-event-driven-ipms-architecture.png)

Kafka becomes the communication backbone.

---

# Benefits of Event-Driven APIs

✅ Loose Coupling

✅ High Scalability

✅ Independent Services

✅ Better Resilience

✅ Asynchronous Processing

✅ Real-Time Communication

---

# Challenges of Event-Driven Systems

⚠ Event Ordering

⚠ Duplicate Messages

⚠ Event Schema Evolution

⚠ Debugging Complexity

⚠ Distributed Transactions

---

# Introduction to Event Sourcing

Traditional systems store:

```text
Current State
```

Example:

```text
Policy Status = ACTIVE
```

---

# Event Sourcing Stores

```text
Policy Created

Premium Paid

Policy Updated

Claim Submitted
```

All events are retained.

---

# Traditional vs Event Sourcing

Traditional:

```text
Current State Only
```

Event Sourcing:

```text
Complete History
```

---

# Benefits of Event Sourcing

```text
Auditability

Traceability

Replayability
```

---

# CQRS Overview

CQRS stands for:

```text
Command Query Responsibility Segregation
```

CQRS separates:

```text
Write Operations

Read Operations
```

---

# Traditional Architecture

```text
Reads
   ↓
Same Model
   ↑
Writes
```

---

# CQRS Architecture

![CQRS Overview](/images/tutorials/springboot/ch14-cqrs-overview.png)

Commands and Queries use different models.

---

# CQRS Benefits

```text
Better Scalability

Optimized Queries

Independent Read Models
```

---

# Kafka in Microservices

Kafka is often used for:

```text
Event Streaming

Audit Logging

Notifications

Analytics

System Integration
```

---

# Spring Boot Kafka Integration

Dependency:

```xml
<dependency>
    <groupId>
        org.springframework.kafka
    </groupId>

    <artifactId>
        spring-kafka
    </artifactId>
</dependency>
```

---

# Producer Configuration

```yaml
spring:
  kafka:
    bootstrap-servers: localhost:9092
```

---

# Sending Events

```java
kafkaTemplate.send(
    "policy-events",
    event);
```

---

# Receiving Events

```java
@KafkaListener(
        topics = "policy-events")
public void consume(
        PolicyCreatedEvent event) {

}
```

---

# Best Practices

✅ Design stable event contracts

✅ Version events

✅ Keep events immutable

✅ Use meaningful topic names

✅ Use consumer groups

✅ Monitor Kafka clusters

✅ Handle duplicate events

✅ Secure Kafka communication

---

# Common Mistakes

❌ Using events for everything

❌ Breaking event schemas

❌ Ignoring versioning

❌ Large event payloads

❌ Missing monitoring

❌ Tight coupling through events

---

# Interview Questions

1. What is Event-Driven Architecture?

2. What is Kafka?

3. What is a Kafka Topic?

4. What is a Partition?

5. What is a Producer?

6. What is a Consumer?

7. What is a Consumer Group?

8. What is Event Sourcing?

9. What is CQRS?

10. Why use Kafka in microservices?

---

# Practice Exercises

1. Create Kafka Producer.

2. Create Kafka Consumer.

3. Publish POLICY_CREATED event.

4. Create policy-events topic.

5. Create claim-events topic.

6. Implement event versioning.

7. Design IPMS event contracts.

8. Create CQRS read model.

---

# Key Takeaways

- Event-Driven Architecture enables loose coupling.
- Kafka is a distributed event streaming platform.
- Producers publish events.
- Consumers subscribe to events.
- Topics organize event streams.
- Partitions provide scalability.
- Consumer Groups enable parallel processing.
- Event Contracts ensure compatibility.
- Event Sourcing preserves history.
- CQRS separates read and write models.

---

# Chapter Summary

In this chapter, you learned:

- Event-Driven Architecture
- Kafka Fundamentals
- Producers
- Consumers
- Topics
- Partitions
- Consumer Groups
- Event Contracts
- Event Sourcing
- CQRS

Our Insurance Policy Management System can now communicate using scalable, resilient, event-driven patterns powered by Apache Kafka.

In the next chapter, we will learn how to containerize and deploy our Spring Boot applications using Docker and Kubernetes.
