# Chapter 08: Change Data Capture (CDC)

---

In the previous chapter, we explored Medallion architecture and learned how to progressively refine data from raw to business-ready across Bronze, Silver, and Gold layers.

In this chapter, we will dive into **Change Data Capture (CDC)**, understand how to capture and process real-time data changes, and implement CDC pipelines for streaming analytics on Google Cloud.

Using our **Digital Banking Platform** case study, we will implement CDC to enable real-time fraud detection, customer 360 updates, and regulatory reporting.

---

## 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand what Change Data Capture is and why it matters
- Explain different CDC methods and approaches
- Implement CDC using Debezium and Datastream
- Design CDC pipelines on Google Cloud
- Process CDC events with Dataflow and Pub/Sub
- Understand event ordering and deduplication
- Handle schema evolution
- Apply best practices for CDC implementation
- Implement CDC for banking use cases

---

## What is Change Data Capture?

Change Data Capture (CDC) is a technique for **capturing and streaming changes** made to a database in real-time.

```text
CDC = Capture changes + Stream changes + Process changes
```

Think of CDC as:

```text
- Database change log as a stream
- Real-time data replication
- Event-driven architecture
- Continuous data synchronization
```

---

## Real-World Banking Example

A bank needs to detect fraud in real-time:

```text
Traditional Approach (Batch):
Transaction occurs → Daily batch → Fraud detection → Next day
Fraud detected too late!

CDC Approach (Real-time):
Transaction occurs → CDC captures change → Stream processes → Real-time detection
Fraud detected immediately!
```

---

## CDC Use Cases

### Banking Use Cases

```text
1. Real-time Fraud Detection
   - Monitor transactions as they occur
   - Immediate fraud flagging
   - Block suspicious activities

2. Customer 360 Updates
   - Update customer profiles in real-time
   - Sync across systems
   - Consistent view

3. Regulatory Compliance
   - Real-time AML monitoring
   - Immediate reporting
   - Audit trail

4. Operational Analytics
   - Real-time dashboards
   - Live metrics
   - Instant insights

5. Data Replication
   - Sync across regions
   - Disaster recovery
   - Multi-cloud
```

### Cross-Industry Use Cases

```text
- E-commerce: Real-time inventory updates
- Healthcare: Patient record synchronization
- Retail: Supply chain visibility
- Manufacturing: IoT data integration
- Telecommunications: Usage monitoring
```

---

## CDC Methods

### Log-Based CDC

```text
Method: Read database transaction logs
Tools: Debezium, Oracle GoldenGate, AWS DMS
Characteristics:
- Low impact on source
- No schema changes needed
- Captures all changes
- Supports rollback

Banking Example:
- Read PostgreSQL WAL logs
- Stream to Pub/Sub
- Process with Dataflow
```

### Trigger-Based CDC

```text
Method: Database triggers capture changes
Tools: Custom implementations
Characteristics:
- High impact on source
- Requires schema changes
- Fine-grained control
- Custom logic possible

Banking Example:
- Triggers on transaction table
- Write to audit table
- Stream to analytics
```

### Query-Based CDC

```text
Method: Periodic queries for changes
Tools: Apache Sqoop, Custom scripts
Characteristics:
- Higher latency
- Lower complexity
- Good for batch
- Resource intensive

Banking Example:
- Hourly query for new records
- Incremental extraction
- Batch processing
```

---

## CDC Method Comparison

| Aspect | Log-Based | Trigger-Based | Query-Based |
|--------|-----------|---------------|-------------|
| **Performance Impact** | Low | High | Medium |
| **Latency** | Real-time | Real-time | Batch |
| **Schema Changes** | None Required | Required | None Required |
| **Change Capture** | All Changes | Custom | Incremental |
| **Complexity** | High | Medium | Low |
| **Scalability** | High | Medium | High |
| **Cost** | Low | Medium | Low |
| **Use Case** | Real-time | Custom Logic | Batch |

---

## CDC Architecture on Google Cloud

### Core Components

```text
1. Source Database
   - Cloud SQL (PostgreSQL, MySQL)
   - Cloud Spanner
   - AlloyDB
   - On-premise databases

2. CDC Tool
   - Datastream (Google Cloud)
   - Debezium (Open Source)
   - Striim (Partner)

3. Messaging
   - Cloud Pub/Sub
   - Apache Kafka

4. Processing
   - Cloud Dataflow
   - Cloud Dataproc

5. Storage
   - BigQuery
   - Cloud Storage
   - Delta Lake
```

---

![CDC Architecture](/images/tutorials/gcpdatamodeling/ch08-cdc-architecture.png)

**Prompt:** Create a comprehensive CDC architecture diagram showing end-to-end flow. Use a 5-layer structure with purple gradient theme:

**Layer 1: Source Systems (Top) - Purple #F3E5F5**
- Cloud SQL (PostgreSQL/MySQL)
- Cloud Spanner
- AlloyDB
- On-premise Databases
- Applications
- Use database/server icons

**Layer 2: CDC Capture - Purple #E1BEE7**
- Datastream (Google Cloud)
- Debezium (Open Source)
- Change Events
- Database Logs (WAL, Binlog)
- Use capture/stream icons

**Layer 3: Message Queue - Purple #CE93D8**
- Cloud Pub/Sub
- Topics: transactions, customers, accounts
- Message Ordering
- Message Retention
- Use queue/message icons

**Layer 4: Processing - Purple #AB47BC**
- Cloud Dataflow (Streaming)
- Real-time Transformations
- Enrichment
- Validation
- Use processing/flow icons

**Layer 5: Storage & Consumption (Bottom) - Purple #7B1FA2**
- BigQuery (Analytics)
- Cloud Storage (Archive)
- Vertex AI (ML)
- Real-time Dashboards
- Use storage/analytics icons

Use downward arrows between layers. Include data flow labels and key takeaways. Footer tags: CDC, Streaming, Real-time, Change Data Capture. Enterprise-style clean layout with rounded corners and consistent iconography.

---

## Google Cloud Datastream

### Overview

```text
Datastream is Google Cloud's fully managed CDC service.
Purpose: Capture changes from databases in real-time
Features:
- Serverless
- Change data capture
- Schema evolution support
- Multiple sources
- Exactly-once delivery
- Low latency
```

### Supported Sources

```text
Databases:
- Cloud SQL for MySQL
- Cloud SQL for PostgreSQL
- Cloud SQL for SQL Server
- AlloyDB
- Oracle (via connector)

Destinations:
- Cloud Storage
- BigQuery
- Cloud Pub/Sub
```

### Datastream Configuration

```yaml
# Datastream Configuration Example
datastream_stream:
  name: "banking-transactions-stream"
  source:
    type: "mysql"
    connection: "mysql-source-connection"
    database: "banking_db"
    tables:
      - "transactions"
      - "customers"
      - "accounts"
  destination:
    type: "bigquery"
    dataset: "banking_bronze"
  backfill:
    enabled: true
    parallelism: 16
    max_parallel_workers: 10
  schedule:
    frequency: "realtime"
```

---

## Debezium CDC

### Overview

```text
Debezium is a distributed CDC platform.
Purpose: Stream database changes to Apache Kafka
Features:
- Open source
- Multiple database support
- Exactly-once semantics
- Schema evolution
- Community supported
```

### Debezium with Google Cloud

```yaml
# Debezium PostgreSQL Connector
{
  "name": "banking-pg-connector",
  "config": {
    "connector.class": "io.debezium.connector.postgresql.PostgresConnector",
    "database.hostname": "banking-postgres",
    "database.port": "5432",
    "database.user": "debezium",
    "database.password": "password",
    "database.dbname": "banking_db",
    "database.server.name": "banking",
    "table.include.list": "public.transactions,public.customers",
    "plugin.name": "pgoutput",
    "publication.autocreate.mode": "filtered",
    "slot.name": "banking_slot"
  }
}

# Debezium to Pub/Sub
- Debezium → Kafka → Kafka to Pub/Sub connector → Cloud Pub/Sub → Dataflow
```

---

## CDC Data Processing with Dataflow

### Real-time Processing Pipeline

```java
// Dataflow pipeline for CDC processing
public class CDCPipeline {
  
  public static void main(String[] args) {
    
    Pipeline pipeline = Pipeline.create(options);
    
    // 1. Read from Pub/Sub
    PCollection<String> cdcEvents = pipeline
      .apply("Read from Pub/Sub", 
        PubsubIO.readStrings()
          .fromSubscription("projects/banking/subscriptions/cdc-subscription"));
    
    // 2. Parse CDC events
    PCollection<Transaction> transactions = cdcEvents
      .apply("Parse CDC Events", 
        ParDo.of(new ParseCDCEventFn()));
    
    // 3. Enrich transactions
    PCollection<EnrichedTransaction> enriched = transactions
      .apply("Enrich Data", 
        ParDo.of(new EnrichmentFn()));
    
    // 4. Validate transactions
    PCollection<ValidatedTransaction> validated = enriched
      .apply("Validate", 
        ParDo.of(new ValidationFn()));
    
    // 5. Write to BigQuery
    validated
      .apply("Write to BigQuery", 
        BigQueryIO.writeTableRows()
          .to("banking.silver_transactions")
          .withWriteDisposition(WriteDisposition.WRITE_APPEND));
    
    pipeline.run();
  }
}
```

---

## Event Ordering and Deduplication

### Challenges

```text
CDC Event Challenges:
1. Out-of-order events
2. Duplicate events
3. Late-arriving events
4. Schema evolution
5. Backfill events
```

### Solutions

```sql
-- Handling duplicates with row number
CREATE OR REPLACE TABLE banking.silver_transactions AS
SELECT
  * EXCEPT(row_num)
FROM (
  SELECT
    *,
    ROW_NUMBER() OVER (
      PARTITION BY transaction_id 
      ORDER BY event_timestamp DESC
    ) AS row_num
  FROM banking.bronze_transactions
)
WHERE row_num = 1;

-- Handling out-of-order with window functions
SELECT
  transaction_id,
  customer_id,
  transaction_amount,
  LAST_VALUE(transaction_amount) OVER (
    PARTITION BY transaction_id
    ORDER BY event_timestamp
    ROWS BETWEEN UNBOUNDED PRECEDING AND UNBOUNDED FOLLOWING
  ) AS final_amount
FROM banking.bronze_transactions;
```

---

## Schema Evolution

### Handling Schema Changes

```sql
-- Schema evolution example
-- Original schema
CREATE TABLE banking.silver_transactions (
  transaction_id STRING,
  customer_id INT64,
  transaction_amount NUMERIC,
  transaction_date DATE
);

-- Add new column (works with CDC)
ALTER TABLE banking.silver_transactions
ADD COLUMN merchant_category STRING;

-- Handle missing data for existing records
UPDATE banking.silver_transactions
SET merchant_category = 'UNKNOWN'
WHERE merchant_category IS NULL;
```

### CDC Schema Evolution Strategies

| Strategy | Description | Use Case |
|----------|-------------|----------|
| **Backward Compatibility** | New columns optional | Safe evolution |
| **Forward Compatibility** | Handle missing columns | Safe read |
| **Schema Registry** | Versioned schemas | Enterprise use |
| **Late Binding** | Apply schema at read | Flexibility |
| **Continuous Evolution** | Incremental changes | Agility |

---

## CDC Best Practices

| # | Best Practice |
|---|---------------|
| 1 | Start with a clear business case for real-time |
| 2 | Choose the right CDC method for your use case |
| 3 | Use managed services when possible |
| 4 | Handle schema evolution from day one |
| 5 | Implement event ordering and deduplication |
| 6 | Monitor CDC pipeline health |
| 7 | Plan for backfill scenarios |
| 8 | Secure CDC infrastructure |
| 9 | Test CDC failover scenarios |
| 10 | Document CDC data flow |

---

## CDC Implementation Example

### Banking CDC Pipeline

```sql
-- 1. Source table (Cloud SQL)
CREATE TABLE banking_db.transactions (
  transaction_id VARCHAR(36) PRIMARY KEY,
  customer_id VARCHAR(36),
  account_id VARCHAR(36),
  transaction_amount DECIMAL(15,2),
  transaction_type VARCHAR(50),
  transaction_date TIMESTAMP,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);

-- 2. CDC captures changes and streams to Pub/Sub

-- 3. Dataflow processes and writes to BigQuery

-- 4. Bronze layer in BigQuery
CREATE OR REPLACE TABLE banking.bronze_transactions
PARTITION BY DATE(transaction_date)
AS
SELECT
  transaction_id,
  customer_id,
  account_id,
  transaction_amount,
  transaction_type,
  transaction_date,
  -- Add CDC metadata
  _event_timestamp AS cdc_timestamp,
  _event_type AS cdc_operation,
  CURRENT_TIMESTAMP() AS ingested_at
FROM cdc_stream;

-- 5. Silver layer with quality checks
CREATE OR REPLACE TABLE banking.silver_transactions
PARTITION BY DATE(transaction_date)
CLUSTER BY customer_id
AS
SELECT
  transaction_id,
  customer_id,
  account_id,
  transaction_amount,
  transaction_type,
  transaction_date,
  -- Quality flags
  CASE
    WHEN transaction_amount > 0 
      AND transaction_date IS NOT NULL
      AND customer_id IS NOT NULL
    THEN 'VALID'
    ELSE 'INVALID'
  END AS data_quality_status
FROM banking.bronze_transactions
WHERE ROW_NUMBER() OVER (
  PARTITION BY transaction_id 
  ORDER BY cdc_timestamp DESC
) = 1;  -- Deduplicate
```

---

![CDC Pipeline in Banking](/images/tutorials/gcpdatamodeling/ch08-cdc-banking-pipeline.png)

**Prompt:** Create a banking CDC pipeline diagram showing real-time fraud detection. Use a 4-layer structure with purple gradient theme:

**Layer 1: Source Applications (Top) - Purple #F3E5F5**
- Mobile Banking, ATM Transactions, Online Banking, POS Payments
- With app icons showing transaction generation

**Layer 2: CDC Capture - Purple #E1BEE7**
- Database Changes (Transactions Table)
- Datastream/Debezium Capture
- Change Events Flow
- "Real-time Capture"

**Layer 3: Stream Processing - Purple #CE93D8**
- Cloud Pub/Sub (Message Queue)
- Cloud Dataflow (Stream Processing)
- Real-time Fraud Detection, Enrichment, Validation
- "Real-time Processing"

**Layer 4: Outcomes (Bottom) - Purple #AB47BC**
- Fraud Alert (Real-time), Customer 360 Update, Regulatory Report, Analytics Dashboard
- With outcome icons

Use downward arrows showing flow. Include timing labels (Milliseconds). At bottom: Key takeaway: "CDC enables real-time fraud detection and immediate business action." Footer tags: CDC, Fraud Detection, Real-time, Banking. Enterprise-style clean layout with rounded corners.

---

![CDC Methods Comparison](/images/tutorials/gcpdatamodeling/ch08-cdc-methods-comparison.png)

**Prompt:** Create a CDC methods comparison diagram showing Log-Based, Trigger-Based, and Query-Based approaches. Use a 3-column structure with purple gradient theme:

**Column 1: Log-Based CDC (Left) - Purple #E1BEE7**
- Title: "Log-Based CDC"
- Icon: 📝
- How it works: "Reads database transaction logs (WAL/Binlog)"
- Tools: "Debezium, Datastream, GoldenGate"
- Advantages: "Low Impact, No Schema Changes, Real-time"
- Disadvantages: "Complex Setup, Requires Permissions"
- Banking Use: "Production Transaction Monitoring"

**Column 2: Trigger-Based CDC (Middle) - Purple #CE93D8**
- Title: "Trigger-Based CDC"
- Icon: 🔄
- How it works: "Database triggers capture changes"
- Tools: "Custom Implementation"
- Advantages: "Fine-grained Control, Custom Logic"
- Disadvantages: "High Impact, Requires Schema Changes"
- Banking Use: "Audit Logging"

**Column 3: Query-Based CDC (Right) - Purple #AB47BC**
- Title: "Query-Based CDC"
- Icon: 🔍
- How it works: "Periodic queries for changes"
- Tools: "Apache Sqoop, Custom Scripts"
- Advantages: "Simple Setup, No Changes"
- Disadvantages: "Higher Latency, Resource Intensive"
- Banking Use: "Batch Reporting"

At bottom: Comparison matrix with key differences. Footer tags: CDC Methods, Comparison, Log-Based, Trigger-Based, Query-Based. Enterprise-style clean layout with rounded corners.

---

## Common Mistakes

| # | Common Mistake | Better Approach |
|---|----------------|-----------------|
| 1 | Ignoring schema evolution | Plan for schema changes |
| 2 | No event ordering | Implement ordering |
| 3 | Duplicate events | Deduplicate |
| 4 | No monitoring | Implement monitoring |
| 5 | Batch-only mindset | Design for streaming |
| 6 | No backfill planning | Plan backfill strategy |
| 7 | Ignoring security | Secure CDC pipeline |
| 8 | No fallback plan | Have fallback strategy |
| 9 | Over-engineering | Start simple |
| 10 | No documentation | Document thoroughly |

---

## Interview Questions

1. What is Change Data Capture (CDC)?

2. What are the different CDC methods?

3. How does log-based CDC work?

4. What is Google Cloud Datastream?

5. What is Debezium and how does it work?

6. How do you handle event ordering in CDC?

7. How do you handle duplicate events?

8. What is schema evolution in CDC?

9. How do you implement CDC on Google Cloud?

10. What are the benefits of CDC over batch ETL?

11. How do you handle CDC failures?

12. What are the challenges of CDC implementation?

---

## Practice Exercises

1. Set up Datastream for a Cloud SQL PostgreSQL database.

2. Configure a CDC pipeline from Cloud SQL to Pub/Sub.

3. Create a Dataflow pipeline to process CDC events.

4. Implement event deduplication in Dataflow.

5. Handle schema evolution in your CDC pipeline.

6. Monitor CDC pipeline health and latency.

7. Implement a backfill strategy.

8. Create a real-time fraud detection pipeline.

9. Design a failover strategy for CDC.

10. Implement data quality checks in CDC pipeline.

---

## Key Takeaways

| # | Takeaway |
|---|----------|
| 1 | CDC enables real-time data integration |
| 2 | Different CDC methods serve different needs |
| 3 | Log-based CDC is preferred for production |
| 4 | Google Cloud provides managed CDC solutions |
| 5 | Schema evolution must be handled |
| 6 | Event ordering and deduplication are critical |
| 7 | Monitoring is essential for CDC pipelines |
| 8 | CDC enables real-time analytics and AI |

---

## Chapter Summary

In this chapter, you learned:

- ✅ What Change Data Capture is and why it matters
- ✅ Different CDC methods (Log-Based, Trigger-Based, Query-Based)
- ✅ Google Cloud Datastream
- ✅ Debezium CDC
- ✅ CDC architecture on Google Cloud
- ✅ Event ordering and deduplication
- ✅ Schema evolution strategies
- ✅ CDC for fraud detection
- ✅ Best practices and common mistakes

You now understand how to implement CDC pipelines for real-time data integration and analytics.

---

## Next Chapter

👉 **Next Chapter: Modern Normalization**