# Chapter 16: API Performance and Caching

---

In the previous chapter, we containerized our Insurance Policy Management System (IPMS) using Docker and deployed it on Kubernetes.

Our platform can now:

- Run in Containers
- Scale using Kubernetes
- Use ConfigMaps and Secrets
- Perform Rolling Updates
- Support Cloud-Native Deployments

However, another critical challenge remains.

How do we ensure APIs remain fast as the number of users grows?

How do we reduce database load?

How do we improve response times for frequently requested data?

Enterprise systems solve these challenges using:

```text
Performance Optimization

Caching

Database Tuning

Connection Pooling
```

In this chapter, we will learn how to optimize API performance and implement caching strategies using Redis and Spring Boot.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand API Performance Fundamentals
- Identify Performance Bottlenecks
- Understand Caching Concepts
- Implement Caching Strategies
- Use Redis as a Distributed Cache
- Configure Spring Boot Caching
- Optimize Database Performance
- Configure Connection Pooling
- Perform Performance Testing
- Design High-Performance APIs

---

# Why API Performance Matters

Modern users expect APIs to respond quickly.

Consider a Policy Search API.

```text
Customer Portal
      ↓
Policy API
      ↓
Database
```

If every request queries the database:

```text
Higher Latency

Increased Database Load

Reduced Scalability
```

Poor performance impacts:

- User Experience
- Business Productivity
- Infrastructure Cost
- Customer Satisfaction

---

# Performance Challenges in Insurance Systems

Common performance challenges include:

```text
Large Policy Volumes

Complex Claims Queries

Premium Calculation Logic

External Service Calls

Database Bottlenecks
```

Without optimization:

```text
Slow APIs

Timeouts

System Overload
```

---

# API Performance Metrics

Performance is measured using:

```text
Response Time

Latency

Throughput

Availability

Error Rate
```

---

## Response Time

Time taken to complete a request.

Example:

```text
Request Sent
      ↓
Response Received

250 ms
```

---

## Throughput

Number of requests processed.

Example:

```text
1000 Requests/Second
```

---

## Latency

Delay before processing begins.

Lower latency improves user experience.

---

## Availability

Percentage of uptime.

Example:

```text
99.99%
```

---

# API Performance Overview

![API Performance Overview](/images/tutorials/springboot/ch16-api-performance-overview.png)

Performance optimization requires improvements across multiple layers.

---

# Request Processing Lifecycle

Every request passes through several layers.

```text
Client
   ↓
API Gateway
   ↓
Controller
   ↓
Service
   ↓
Database
```

Performance issues may occur at any layer.

---

# Common Performance Bottlenecks

Typical bottlenecks include:

```text
Slow Database Queries

Network Latency

External API Calls

Serialization Overhead

Insufficient Resources
```

Identifying bottlenecks is the first step toward optimization.

---

# What is Caching?

Caching stores frequently used data in a faster storage layer.

Instead of:

```text
API
 ↓
Database
```

we use:

```text
API
 ↓
Cache
 ↓
Database
```

Frequently requested data is returned from cache.

---

# Why Caching Works

Suppose a policy is requested thousands of times.

Without caching:

```text
Every Request
      ↓
Database Query
```

With caching:

```text
First Request
      ↓
Database

Subsequent Requests
      ↓
Cache
```

Result:

```text
Faster Response

Reduced Database Load
```

---

# Benefits of Caching

Caching provides:

```text
Lower Latency

Higher Throughput

Improved Scalability

Reduced Database Load

Better User Experience
```

---

# Caching Strategies

Caching can occur at multiple levels.

---

# Caching Strategies Overview

![Caching Strategies](/images/tutorials/springboot/ch16-caching-strategies.png)

Different caching layers work together to improve performance.

---

# Client-Side Caching

Browsers and mobile applications can cache responses.

Example:

```http
Cache-Control: max-age=3600
```

Benefits:

```text
Reduced Network Calls

Faster User Experience
```

---

# CDN Caching

Static content can be cached at edge locations.

Examples:

```text
Images

Documents

Reports

Static Assets
```

---

# API Gateway Caching

Gateways can cache responses.

Example:

```text
API Gateway
      ↓
Cache
      ↓
Backend Service
```

Repeated requests bypass backend processing.

---

# Application Caching

Most enterprise applications implement application-level caching.

Examples:

```text
Policy Details

Customer Information

Reference Data

Product Catalogs
```

---

# Database Caching

Database engines also provide caching.

Examples:

```text
Query Cache

Buffer Pool

Execution Plans
```

---

# Cache Patterns

Enterprise systems use common cache patterns.

---

## Cache Aside Pattern

Most popular approach.

Flow:

```text
Request
   ↓
Cache Lookup

Cache Miss
   ↓
Database
   ↓
Update Cache
```

Applications manage cache explicitly.

---

## Read Through Cache

Cache automatically loads data.

```text
Application
      ↓
Cache
      ↓
Database
```

---

## Write Through Cache

Data is written to:

```text
Cache
  +
Database
```

simultaneously.

---

## Write Behind Cache

Application updates cache first.

Database updates later asynchronously.

---

## Refresh Ahead Cache

Cache proactively refreshes data before expiration.

---

# Redis Fundamentals

Redis is the most popular distributed caching solution.

Redis stands for:

```text
Remote Dictionary Server
```

Redis stores data in memory.

This makes Redis extremely fast.

---

# Why Redis?

Redis provides:

```text
High Performance

Distributed Caching

Scalability

Persistence Options

Multiple Data Structures
```

---

# Redis Data Structures

Redis supports:

```text
Strings

Lists

Hashes

Sets

Sorted Sets
```

---

# Redis Architecture

![Redis Architecture](/images/tutorials/springboot/ch16-redis-architecture.png)

Redis acts as a high-speed cache between applications and databases.

---

# Spring Boot Redis Integration

Spring Boot provides built-in Redis support.

---

## Maven Dependency

```xml
<dependency>
    <groupId>
        org.springframework.boot
    </groupId>

    <artifactId>
        spring-boot-starter-data-redis
    </artifactId>
</dependency>
```

---

# Redis Configuration

```yaml
spring:
  data:
    redis:
      host: localhost
      port: 6379
```

---

# Enabling Caching

```java
@SpringBootApplication
@EnableCaching
public class Application {

}
```

---

# Spring Cache Annotations

Spring provides several caching annotations.

---

## @Cacheable

Stores data in cache.

```java
@Cacheable("policies")
public PolicyResponse getPolicy(
        String policyNumber) {

}
```

First request:

```text
Database Access
```

Subsequent requests:

```text
Redis Cache
```

---

## @CachePut

Updates cache after execution.

```java
@CachePut("policies")
```

---

## @CacheEvict

Removes cache entries.

```java
@CacheEvict(
    value = "policies",
    key = "#policyNumber")
```

Used when policies are updated or deleted.

---

# Policy API Caching Example

Example:

```text
GET /api/policies/LIFE-100001
```

Flow:

```text
Client
   ↓
Policy Service
   ↓
Redis Cache

Cache Miss
   ↓
Database
```

---

# Database Optimization

Caching alone is not sufficient.

Databases must also be optimized.

---

# Database Optimization Overview

![Database Optimization](/images/tutorials/springboot/ch16-database-optimization.png)

Proper indexing and query design significantly improve performance.

---

# Database Indexing

Indexes improve query speed.

Without Index:

```text
Full Table Scan
```

With Index:

```text
Direct Lookup
```

---

## Example

```sql
CREATE INDEX idx_policy_status
ON policies(status);
```

Queries execute faster.

---

# Query Optimization

Poor queries cause slow APIs.

Bad:

```sql
SELECT *
FROM policies;
```

Good:

```sql
SELECT policy_number,
       status
FROM policies;
```

Retrieve only required columns.

---

# Pagination

Avoid returning large datasets.

Bad:

```http
GET /policies
```

Good:

```http
GET /policies?page=0&size=20
```

Benefits:

```text
Lower Memory Usage

Faster Responses
```

---

# N+1 Query Problem

Common Hibernate performance issue.

Example:

```text
1 Policy Query

100 Customer Queries
```

Result:

```text
101 Queries
```

Solutions:

```text
Fetch Join

Entity Graph

Batch Fetching
```

---

# Connection Pooling

Creating database connections is expensive.

Connection pooling reuses connections.

---

# HikariCP

Spring Boot's default connection pool.

Benefits:

```text
Faster Database Access

Reduced Resource Usage

Improved Throughput
```

---

# HikariCP Configuration

```yaml
spring:
  datasource:
    hikari:
      maximum-pool-size: 20
      minimum-idle: 5
```

---

# Performance Testing

Optimization should be validated using testing.

---

# Types of Performance Testing

---

## Load Testing

Expected workload.

Example:

```text
1000 Users
```

---

## Stress Testing

Beyond normal capacity.

Example:

```text
5000 Users
```

---

## Spike Testing

Sudden traffic increases.

Example:

```text
Black Friday

Insurance Campaign Launch
```

---

## Endurance Testing

Long-duration testing.

Example:

```text
24 Hours Continuous Load
```

---

# Performance Testing Tools

Common tools include:

```text
Apache JMeter

Gatling

k6
```

---

# Monitoring Performance

Performance should be continuously monitored.

Key metrics:

```text
Response Time

Cache Hit Ratio

Database Query Time

CPU Usage

Memory Usage
```

---

# IPMS Performance Architecture

A high-performance Insurance Policy Management System uses:

```text
API Gateway
      ↓
Policy Service
      ↓
Redis Cache
      ↓
MySQL Database

Kafka Events
```

---

# IPMS Performance Architecture

![IPMS Performance Architecture](/images/tutorials/springboot/ch16-ipms-performance-architecture.png)

Caching and database optimization significantly improve scalability.

---

# Best Practices

✅ Cache frequently accessed data

✅ Use Redis for distributed caching

✅ Implement pagination

✅ Optimize database queries

✅ Use indexes appropriately

✅ Configure connection pools

✅ Load test before production

✅ Monitor cache hit ratios

---

# Common Mistakes

❌ Caching everything

❌ Ignoring cache invalidation

❌ Missing database indexes

❌ Returning huge result sets

❌ Using SELECT \*

❌ No performance testing

❌ Ignoring slow query logs

---

# Interview Questions

1. What is caching?

2. Why is Redis used?

3. What is Cache Aside Pattern?

4. Difference between Redis and Database?

5. What is connection pooling?

6. What is HikariCP?

7. What is the N+1 Query Problem?

8. Why are indexes important?

9. How do you optimize API performance?

10. What metrics indicate API health?

---

# Practice Exercises

1. Configure Redis in Spring Boot.

2. Cache Policy API responses.

3. Implement cache eviction.

4. Create database indexes.

5. Configure HikariCP.

6. Optimize a slow query.

7. Load test the Policy API.

8. Measure cache hit ratio.

---

# Key Takeaways

- API performance directly impacts user experience.
- Caching reduces latency and database load.
- Redis is a popular distributed caching solution.
- Spring Boot provides built-in caching support.
- Database optimization improves scalability.
- HikariCP improves database connectivity performance.
- Load testing validates production readiness.
- Continuous monitoring ensures long-term performance.

---

# Chapter Summary

In this chapter, you learned:

- API Performance Fundamentals
- Performance Metrics
- Caching Strategies
- Cache Patterns
- Redis Fundamentals
- Spring Boot Caching
- Database Optimization
- Connection Pooling
- Performance Testing
- Monitoring Metrics

Our Insurance Policy Management System can now deliver fast and scalable APIs.

In the next chapter, we will focus on Observability, Structured Logging, Distributed Tracing, Metrics Collection, Prometheus, Grafana, and Production Monitoring.
