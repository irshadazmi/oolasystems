# Chapter 17: Observability, Logging and Monitoring

---

In the previous chapter, we optimized our Insurance Policy Management System (IPMS) for performance using caching, Redis, database tuning, and connection pooling.

Our APIs are now:

- Faster
- More Scalable
- Better Optimized

However, operating enterprise systems in production introduces another challenge.

How do we know when something goes wrong?

How do we identify slow APIs?

How do we troubleshoot failures across multiple microservices?

How do we monitor system health in real time?

This is where observability becomes critical.

Modern cloud-native applications rely on:

```text
Logging

Metrics

Tracing

Monitoring

Alerting
```

to gain visibility into system behavior.

In this chapter, we will learn how to implement observability using structured logging, distributed tracing, Prometheus, Grafana, and modern monitoring practices.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand Observability Fundamentals
- Implement Structured Logging
- Use Correlation IDs
- Understand Distributed Tracing
- Monitor APIs using Metrics
- Configure Prometheus
- Create Grafana Dashboards
- Implement Health Checks
- Monitor Microservices Effectively
- Design an Observable IPMS Platform

---

# Why Observability Matters

Consider the following scenario.

A customer reports:

```text
Unable to Submit Claim
```

The request passes through:

```text
API Gateway
      ↓
Claim Service
      ↓
Policy Service
      ↓
Payment Service
      ↓
Database
```

Where did the failure occur?

Without observability:

```text
Difficult Troubleshooting

Long Resolution Times

Poor User Experience
```

With observability:

```text
Quick Root Cause Analysis

Faster Recovery

Better Reliability
```

---

# What is Observability?

Observability is the ability to understand the internal state of a system using external outputs.

These outputs typically include:

```text
Logs

Metrics

Traces
```

Together they provide complete visibility into application behavior.

---

# Three Pillars of Observability

```text
Logs
      ↓
Metrics
      ↓
Traces
```

Each pillar answers different questions.

| Pillar  | Answers              |
| ------- | -------------------- |
| Logs    | What happened?       |
| Metrics | How much?            |
| Traces  | Where did it happen? |

---

# Observability Overview

![Observability Overview](/images/tutorials/springboot/ch17-observability-overview.png)

---

# Understanding Logs

Logs capture application events.

Example:

```text
Policy Created

Claim Submitted

Payment Failed

Authentication Error
```

Logs help developers understand system behavior.

---

# Traditional Logging Problems

Typical logs:

```text
2025-06-15 Created Policy
```

Problems:

```text
Difficult Searching

No Context

Poor Analysis
```

Enterprise systems use structured logging.

---

# Structured Logging

Structured logs use JSON format.

Example:

```json
{
  "timestamp": "2025-06-15T10:15:00",
  "level": "INFO",
  "service": "policy-service",
  "policyNumber": "LIFE-100001",
  "message": "Policy Created"
}
```

Benefits:

```text
Searchable

Machine Readable

Analytics Friendly
```

---

# Logging Levels

Common logging levels:

```text
TRACE

DEBUG

INFO

WARN

ERROR
```

---

## TRACE

Detailed diagnostic information.

---

## DEBUG

Developer troubleshooting information.

---

## INFO

Normal business operations.

Example:

```text
Policy Created
```

---

## WARN

Potential issues.

Example:

```text
Payment Retry Initiated
```

---

## ERROR

Application failures.

Example:

```text
Database Connection Failed
```

---

# Correlation IDs

In microservices, one request may span multiple services.

Example:

```text
Gateway
   ↓
Policy Service
   ↓
Claim Service
   ↓
Notification Service
```

A Correlation ID tracks the request.

Example:

```text
X-Correlation-ID:
ABC123XYZ
```

Every service logs the same identifier.

---

# Structured Logging Architecture

![Structured Logging Architecture](/images/tutorials/springboot/ch17-structured-logging-architecture.png)

---

# Spring Boot Logging

Default logging framework:

```text
Logback
```

Example:

```java
private static final Logger logger =
LoggerFactory.getLogger(
PolicyService.class);

logger.info(
"Policy created: {}",
policyNumber);
```

---

# Log Aggregation

In production, logs are collected centrally.

Example:

```text
Policy Service
Claim Service
Payment Service
Notification Service
```

send logs to:

```text
Central Logging Platform
```

Examples:

```text
ELK Stack

OpenSearch

Loki
```

---

# Understanding Distributed Tracing

Tracing follows a request as it moves through services.

Example:

```text
Customer Request
      ↓
Gateway
      ↓
Policy Service
      ↓
Claim Service
      ↓
Database
```

A trace records every step.

---

# Trace Components

---

## Trace

Entire request journey.

---

## Span

Individual operation.

Example:

```text
Gateway Call

Database Query

Kafka Publish
```

---

## Parent Span

Originating operation.

---

## Child Span

Nested operation.

---

# Distributed Tracing Architecture

![Distributed Tracing Architecture](/images/tutorials/springboot/ch17-distributed-tracing-architecture.png)

---

# OpenTelemetry

OpenTelemetry is the industry standard for observability.

Provides:

```text
Tracing

Metrics

Logs
```

Benefits:

```text
Vendor Neutral

Cloud Native

Open Standard
```

---

# Jaeger

Jaeger visualizes traces.

Example:

```text
Request Duration

Slow Service

Database Latency
```

Benefits:

```text
Root Cause Analysis

Performance Optimization
```

---

# Understanding Metrics

Metrics provide numerical measurements.

Examples:

```text
Request Count

Error Rate

Response Time

CPU Usage

Memory Usage
```

Metrics help identify trends and anomalies.

---

# Application Metrics

Spring Boot provides metrics through:

```text
Spring Boot Actuator
```

Example endpoint:

```http
/actuator/metrics
```

---

# Health Checks

Health checks indicate application status.

Example:

```http
/actuator/health
```

Response:

```json
{
  "status": "UP"
}
```

---

# Types of Health Checks

---

## Liveness Check

Determines if application is alive.

---

## Readiness Check

Determines if application can accept traffic.

---

## Startup Check

Determines successful startup.

---

# Prometheus

Prometheus collects metrics from applications.

Flow:

```text
Application
      ↓
Metrics Endpoint
      ↓
Prometheus
```

Prometheus stores time-series data.

---

# Prometheus Metrics Examples

```text
http_requests_total

jvm_memory_used_bytes

system_cpu_usage

hikaricp_connections
```

---

# Grafana

Grafana visualizes metrics.

Provides:

```text
Dashboards

Charts

Alerts
```

Common dashboards:

```text
API Performance

JVM Metrics

Database Metrics

System Metrics
```

---

# Prometheus-Grafana Architecture

![Prometheus Grafana Architecture](/images/tutorials/springboot/ch17-prometheus-grafana-architecture.png)

---

# Alerting

Monitoring without alerting is incomplete.

Examples:

```text
High CPU Usage

High Error Rate

Slow Response Time

Database Failure
```

Alerts notify operations teams immediately.

---

# Golden Signals

Google SRE identifies four key signals.

---

## Latency

Request processing time.

---

## Traffic

Request volume.

---

## Errors

Failed requests.

---

## Saturation

Resource utilization.

---

# Monitoring Dashboards

A production dashboard should include:

```text
API Response Time

Request Rate

Error Rate

CPU Usage

Memory Usage

Database Performance

Cache Hit Ratio
```

---

# IPMS Observability Architecture

The complete observability solution for IPMS includes:

```text
Logs
Metrics
Traces
Dashboards
Alerts
```

across all services.

---

# IPMS Observability Architecture

![IPMS Observability Architecture](/images/tutorials/springboot/ch17-ipms-observability-architecture.png)

---

# Best Practices

✅ Use structured JSON logging

✅ Implement correlation IDs

✅ Collect application metrics

✅ Monitor health endpoints

✅ Use distributed tracing

✅ Create actionable dashboards

✅ Configure alerts

✅ Monitor business metrics

---

# Common Mistakes

❌ Logging sensitive information

❌ Excessive DEBUG logging

❌ No centralized logging

❌ Ignoring trace data

❌ Monitoring only infrastructure

❌ Missing alert thresholds

❌ No health checks

---

# Interview Questions

1. What is observability?

2. What are the three pillars of observability?

3. What is structured logging?

4. What is a correlation ID?

5. What is distributed tracing?

6. What is OpenTelemetry?

7. What is Jaeger?

8. What is Prometheus?

9. What is Grafana?

10. Difference between monitoring and observability?

11. What are health checks?

12. What are Golden Signals?

---

# Practice Exercises

1. Enable Spring Boot Actuator.

2. Configure structured logging.

3. Add correlation IDs.

4. Implement OpenTelemetry tracing.

5. Configure Prometheus scraping.

6. Create Grafana dashboards.

7. Configure alerts for high error rates.

8. Monitor JVM metrics.

---

# Key Takeaways

- Observability provides visibility into system behavior.
- Logs, Metrics, and Traces form the three pillars of observability.
- Structured logging improves troubleshooting.
- Correlation IDs track requests across services.
- Distributed tracing visualizes request journeys.
- Prometheus collects metrics.
- Grafana visualizes operational data.
- Health checks improve reliability.
- Monitoring and alerting enable proactive operations.

---

# Chapter Summary

In this chapter, you learned:

- Observability Fundamentals
- Structured Logging
- Correlation IDs
- Distributed Tracing
- OpenTelemetry
- Jaeger
- Metrics Collection
- Prometheus
- Grafana
- Health Checks
- Alerting and Monitoring

Our Insurance Policy Management System is now observable, measurable, and production-ready.

In the next chapter, we will focus on API Governance, Enterprise Standards, Lifecycle Management, Security Governance, Version Governance, and Enterprise API Review Processes.
