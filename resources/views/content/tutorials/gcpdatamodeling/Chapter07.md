# Chapter 07: Medallion Architecture

---

In the previous chapter, we explored Lakehouse architecture and learned how it combines the flexibility of data lakes with the performance of data warehouses.

In this chapter, we will dive deep into the **Medallion Architecture**, understand each layer in detail, and learn how to implement data quality, governance, and progressive data refinement at each stage.

Using our **Digital Banking Platform** case study, we will implement a complete medallion architecture that transforms raw banking data into business-ready insights.

---

## 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand the Medallion architecture and its layers
- Explain the purpose of Bronze, Silver, and Gold layers
- Implement data quality checks at each layer
- Design data pipelines between layers
- Understand governance and lineage
- Apply best practices for medallion implementation
- Implement medallion architecture on Google Cloud
- Design for scalability and performance

---

## What is Medallion Architecture?

Medallion architecture is a **data design pattern** that organizes data into progressively refined layers, ensuring data quality and business readiness.

```text
Medallion = Bronze (Raw) → Silver (Cleaned) → Gold (Curated)
```

Think of medallion architecture as:

```text
- Raw materials (Bronze)
- Refined materials (Silver)
- Finished products (Gold)
```

Each layer adds value and quality:

```text
Bronze: Store everything as-is
Silver: Clean, validate, standardize
Gold: Aggregate, model, optimize for business
```

---

## Real-World Banking Example

A bank implements medallion architecture for fraud detection:

```text
Bronze Layer (Raw):
- All transaction logs from core banking
- ATM transaction feeds
- Online banking events
- External fraud lists

Silver Layer (Cleaned):
- Validated and deduplicated transactions
- Standardized date formats
- Enriched with customer data
- Quality-checked data

Gold Layer (Curated):
- Customer transaction patterns
- Risk scores and flags
- Fraud detection features
- Real-time dashboards
```

---

## The Three Layers in Detail

### Bronze Layer (Raw Data)

```text
Purpose: Store raw data as ingested
Characteristics:
- Immutable data
- Original format preserved
- Complete history
- No transformations
- All data sources

Key Principles:
- Store everything
- Keep original format
- Maintain data lineage
- No data loss
- Append-only

Banking Examples:
- Raw transaction logs
- Customer data dumps
- Account opening forms
- External data feeds
```

### Silver Layer (Cleaned Data)

```text
Purpose: Validate, clean, and standardize data
Characteristics:
- Data quality checks
- Standardized formats
- Deduplication
- Data enrichment
- Schema enforcement

Key Principles:
- Validate data quality
- Standardize formats
- Remove duplicates
- Enrich with context
- Implement business rules

Banking Examples:
- Validated transactions
- Standardized customer records
- Enriched account data
- Historical data
```

### Gold Layer (Curated Data)

```text
Purpose: Business-ready aggregated data
Characteristics:
- Aggregated data
- Business definitions
- Performance optimized
- Ready for analytics
- Governed data

Key Principles:
- Business-focused views
- Aggregated and modeled
- Performance optimized
- Governed access
- Self-service ready

Banking Examples:
- Customer 360 views
- Transaction summaries
- Risk metrics
- Regulatory reports
```

---

## Layer Comparison

| Aspect | Bronze | Silver | Gold |
|--------|--------|--------|------|
| **Data State** | Raw | Cleaned | Curated |
| **Transformations** | None | Validation, Standardization | Aggregation, Modeling |
| **Data Quality** | Unknown | Validated | Governed |
| **Schema** | Flexible | Enforced | Optimized |
| **Immutability** | Immutable | Append-only | Mutable |
| **Access** | Data Engineers | Data Engineers | Business Users |
| **Retention** | Long-term | Long-term | Business-defined |
| **Use Cases** | Audit, Reprocessing | ETL, Enrichment | BI, ML, Reports |

---

![Medallion Architecture Detailed](/images/tutorials/gcpdatamodeling/ch07-medallion-architecture.png)

**Prompt:** Create a detailed Medallion Architecture diagram showing Bronze, Silver, and Gold layers with complete details. Use a 3-layer vertical structure with purple gradient theme:

**Layer 1: Bronze (Raw Data) - Top - Purple #F3E5F5**
- Title: "Bronze Layer - Raw Data"
- Storage: Cloud Storage (Parquet/Avro/JSON)
- Process: Raw Ingestion
- Characteristics: Immutable, Original Format, Complete History, No Transformations
- Banking Example: "Raw Transaction Logs, Customer Dumps"
- Quality: "No Quality Checks"
- Icon: 📥 Raw data icon

**Layer 2: Silver (Cleaned Data) - Middle - Purple #CE93D8**
- Title: "Silver Layer - Cleaned Data"
- Storage: Delta Lake / Iceberg / BigQuery
- Process: Validate, Cleanse, Standardize, Enrich
- Characteristics: Data Quality, Standardized Formats, Deduplicated, Enriched
- Banking Example: "Validated Transactions, Standardized Customer Records"
- Quality: "Data Quality Checks Applied"
- Icon: 🔄 Clean data icon

**Layer 3: Gold (Curated Data) - Bottom - Purple #7B1FA2**
- Title: "Gold Layer - Curated Data"
- Storage: BigQuery (Optimized Tables)
- Process: Aggregate, Model, Optimize
- Characteristics: Aggregated, Business Definitions, Performance Optimized, Governed
- Banking Example: "Customer 360, Risk Metrics, Financial Reports"
- Quality: "Governed and Certified"
- Icon: 📊 Curated data icon

Use downward arrows between layers showing data progression and quality improvement. Include data flow labels (Raw → Cleaned → Curated). At bottom: Key takeaway: "Medallion architecture provides progressive data refinement from raw to business-ready." Footer tags: Bronze, Silver, Gold, Quality. Enterprise-style clean layout with rounded corners and consistent iconography.

---

## Data Flow Between Layers

### Bronze to Silver Transformation

```sql
-- Create bronze table for raw transactions
CREATE OR REPLACE EXTERNAL TABLE banking.bronze_transactions
OPTIONS (
  format = 'PARQUET',
  uris = ['gs://banking-lake/bronze/transactions/*']
);

-- Transform bronze to silver with quality checks
CREATE OR REPLACE TABLE banking.silver_transactions
PARTITION BY DATE(transaction_date)
CLUSTER BY customer_id
AS
SELECT
  -- Standardize data types
  CAST(transaction_id AS STRING) AS transaction_id,
  CAST(customer_id AS INT64) AS customer_id,
  CAST(account_id AS INT64) AS account_id,
  -- Clean dates
  SAFE.DATE(transaction_date) AS transaction_date,
  -- Validate amounts
  CASE
    WHEN transaction_amount > 0 THEN transaction_amount
    ELSE NULL
  END AS transaction_amount,
  -- Standardize text
  UPPER(TRIM(transaction_type)) AS transaction_type,
  UPPER(TRIM(merchant_category)) AS merchant_category,
  -- Data quality flags
  CASE
    WHEN transaction_amount > 0 
      AND transaction_date IS NOT NULL 
      AND customer_id IS NOT NULL
    THEN 'VALID'
    ELSE 'INVALID'
  END AS data_quality_status
FROM banking.bronze_transactions
WHERE transaction_date IS NOT NULL
  AND customer_id IS NOT NULL;
```

### Silver to Gold Transformation

```sql
-- Transform silver to gold with business aggregations
CREATE OR REPLACE TABLE banking.gold_customer_daily_summary
PARTITION BY date
CLUSTER BY customer_id
AS
SELECT
  customer_id,
  DATE(transaction_date) AS date,
  COUNT(*) AS transaction_count,
  SUM(transaction_amount) AS total_amount,
  AVG(transaction_amount) AS avg_amount,
  COUNT(DISTINCT merchant_category) AS distinct_merchants,
  -- Business metrics
  SUM(CASE 
    WHEN transaction_amount > 1000 THEN transaction_amount 
    ELSE 0 
  END) AS high_value_amount,
  COUNT(CASE 
    WHEN transaction_amount > 1000 THEN 1 
    ELSE NULL 
  END) AS high_value_count,
  -- Risk metrics
  AVG(transaction_amount) AS avg_daily_spend,
  STDDEV(transaction_amount) AS spend_volatility
FROM banking.silver_transactions
WHERE data_quality_status = 'VALID'
GROUP BY customer_id, DATE(transaction_date);
```

---

## Data Quality Implementation

### Quality Dimensions

| Dimension | Bronze | Silver | Gold |
|-----------|--------|--------|------|
| **Completeness** | Not Checked | Required Fields Checked | All Fields Checked |
| **Accuracy** | Not Checked | Range Validations | Business Rules |
| **Consistency** | Not Checked | Standardized Formats | Standardized Values |
| **Timeliness** | Not Checked | Freshness Checks | Business SLAs |
| **Uniqueness** | Not Checked | Deduplication | Unique Keys |
| **Validity** | Not Checked | Schema Validation | Business Validation |

### Quality Check Implementation

```sql
-- Comprehensive quality checks in silver layer
CREATE OR REPLACE TABLE banking.silver_transactions_qc
AS
SELECT
  *,
  -- Completeness
  CASE 
    WHEN transaction_id IS NULL THEN 'MISSING_ID'
    WHEN customer_id IS NULL THEN 'MISSING_CUSTOMER'
    WHEN account_id IS NULL THEN 'MISSING_ACCOUNT'
    WHEN transaction_date IS NULL THEN 'MISSING_DATE'
    WHEN transaction_amount IS NULL THEN 'MISSING_AMOUNT'
    ELSE 'COMPLETE'
  END AS completeness_status,
  
  -- Validity
  CASE
    WHEN transaction_amount <= 0 THEN 'INVALID_AMOUNT'
    WHEN transaction_date > CURRENT_DATE() THEN 'FUTURE_DATE'
    WHEN transaction_date < DATE_SUB(CURRENT_DATE(), INTERVAL 10 YEAR) THEN 'OLD_DATE'
    ELSE 'VALID'
  END AS validity_status,
  
  -- Consistency
  CASE
    WHEN UPPER(transaction_type) NOT IN ('PAYMENT', 'TRANSFER', 'WITHDRAWAL', 'DEPOSIT')
      THEN 'INVALID_TYPE'
    ELSE 'CONSISTENT'
  END AS consistency_status,
  
  -- Overall quality score
  CASE
    WHEN completeness_status = 'COMPLETE' 
      AND validity_status = 'VALID' 
      AND consistency_status = 'CONSISTENT'
    THEN 1.0
    WHEN completeness_status = 'COMPLETE' 
      AND validity_status = 'VALID'
    THEN 0.7
    ELSE 0.0
  END AS quality_score
FROM banking.bronze_transactions;
```

---

## Data Governance in Medallion

### Bronze Layer Governance

```text
Objectives:
- Preserve data lineage
- Maintain audit trail
- Track data sources
- Ensure data retention

Implementation:
- Data Catalog for metadata
- Retention policies
- Lifecycle management
- Data tagging
```

### Silver Layer Governance

```text
Objectives:
- Enforce data quality
- Maintain data standards
- Track data transformations
- Enable data lineage

Implementation:
- Data quality rules
- Transformation logs
- Schema enforcement
- Data lineage tracking
```

### Gold Layer Governance

```text
Objectives:
- Business definitions
- Access control
- Data certification
- Regulatory compliance

Implementation:
- Business glossary
- Row-level security
- Column-level security
- Compliance rules
```

---

![Data Quality and Governance](/images/tutorials/gcpdatamodeling/ch07-data-quality-governance.png)

**Prompt:** Create a data quality and governance diagram showing the progressive improvement across layers. Use a 3-layer vertical structure with purple gradient theme:

**Layer 1: Bronze (Raw) - Top - Purple #F3E5F5**
- Title: "Bronze Layer Governance"
- Focus: "Data Lineage & Retention"
- Activities: Track Data Sources, Maintain Audit Trail, Preserve Raw Data, Long-term Retention
- Quality: "Unknown Quality"
- Banking Example: "Transaction Logs"
- Icon: 📋 Logging icon

**Layer 2: Silver (Cleaned) - Middle - Purple #CE93D8**
- Title: "Silver Layer Governance"
- Focus: "Quality & Standards"
- Activities: Data Quality Checks, Standardization, Deduplication, Enrichment
- Quality: "Validated Quality"
- Banking Example: "Cleaned Transactions"
- Icon: ✅ Quality icon

**Layer 3: Gold (Curated) - Bottom - Purple #7B1FA2**
- Title: "Gold Layer Governance"
- Focus: "Access & Compliance"
- Activities: Business Definitions, Access Control, Data Certification, Regulatory Compliance
- Quality: "Business-Ready Quality"
- Banking Example: "Customer 360, Risk Metrics"
- Icon: 🏛️ Governance icon

Use arrows between layers showing quality improvement. Include quality scores: Bronze (0%), Silver (70%), Gold (100%). At bottom: Key takeaway: "Progressive governance improves data quality and trust across layers." Footer tags: Quality, Governance, Lineage, Compliance. Enterprise-style clean layout with rounded corners.

---

## Pipeline Orchestration

### Bronze to Silver Pipeline

```yaml
Pipeline: bronze_to_silver
Schedule: Hourly
Source: Cloud Storage (Bronze)
Destination: BigQuery (Silver)
Transformations:
  - Schema validation
  - Data type conversion
  - Date standardization
  - Amount validation
  - Deduplication
  - Quality scoring
Orchestration: Dataform
```

### Silver to Gold Pipeline

```yaml
Pipeline: silver_to_gold
Schedule: Daily
Source: BigQuery (Silver)
Destination: BigQuery (Gold)
Transformations:
  - Aggregations
  - Business calculations
  - Dimensional modeling
  - Performance optimization
  - Access controls
Orchestration: Dataform
```

### Complete Pipeline Example

```sql
-- Dataform pipeline: bronze_to_silver
-- Step 1: Validate bronze data
SELECT
  *,
  CASE 
    WHEN transaction_date IS NULL THEN 'INVALID_DATE'
    WHEN customer_id IS NULL THEN 'INVALID_CUSTOMER'
    WHEN transaction_amount IS NULL THEN 'INVALID_AMOUNT'
    ELSE 'VALID'
  END AS validation_status
FROM ${ref('bronze_transactions')}
WHERE validation_status = 'VALID';

-- Step 2: Clean and standardize
CREATE TABLE ${ref('silver_transactions')} AS
SELECT
  transaction_id,
  customer_id,
  account_id,
  SAFE.PARSE_DATE('%Y-%m-%d', transaction_date) AS transaction_date,
  CAST(transaction_amount AS NUMERIC) AS transaction_amount,
  UPPER(TRIM(transaction_type)) AS transaction_type,
  UPPER(TRIM(merchant_category)) AS merchant_category,
  CURRENT_TIMESTAMP() AS processed_at
FROM ${ref('bronze_transactions_cleaned')};
```

---

## Performance Optimization

### Bronze Layer Optimization

```text
Strategies:
- Use Cloud Storage with appropriate storage class
- Implement partition by date
- Use compression (Parquet)
- Set lifecycle policies
- Archive older data
```

### Silver Layer Optimization

```text
Strategies:
- Use Delta Lake/Iceberg for ACID
- Implement partitioning
- Apply clustering
- Use data skipping
- Optimize file sizes
```

### Gold Layer Optimization

```text
Strategies:
- Use BigQuery for performance
- Implement date partitioning
- Apply clustering on keys
- Use materialized views
- Enable caching
```

---

![Pipeline Orchestration Flow](/images/tutorials/gcpdatamodeling/ch07-pipeline-orchestration.png)

**Prompt:** Create a pipeline orchestration diagram showing the data flow from source to consumption across medallion layers. Use a 5-step horizontal flow with purple gradient theme:

**Step 1: Data Sources (Left) - Purple #E1BEE7**
- Cloud SQL, Spanner, Cloud Storage, External APIs, Streaming
- Source icons

**Step 2: Bronze Layer - Purple #CE93D8**
- Title: "Bronze - Raw Data"
- Process: Raw Ingestion
- Storage: Cloud Storage
- Tool: Dataflow/Dataproc
- "Append-Only Storage"

**Step 3: Silver Layer - Purple #AB47BC**
- Title: "Silver - Cleaned Data"
- Process: Validate, Cleanse, Enrich
- Storage: Delta Lake/BigQuery
- Tool: Dataform/Dataflow
- "Quality Checks"

**Step 4: Gold Layer - Purple #7B1FA2**
- Title: "Gold - Curated Data"
- Process: Aggregate, Model, Optimize
- Storage: BigQuery
- Tool: Dataform
- "Business-ready"

**Step 5: Consumption (Right) - Purple #4A148C**
- Title: "Analytics & AI"
- BI (Looker), ML (Vertex AI), APIs, Dashboards
- Consumption icons

Use horizontal flow arrows between steps. Include scheduling information (Real-time, Hourly, Daily). At bottom: Key takeaway: "Orchestrated pipelines ensure reliable and timely data delivery across layers." Footer tags: Pipeline, Orchestration, Automation, Reliability. Enterprise-style clean layout with rounded corners and consistent iconography.

---

## Medallion Best Practices

| # | Best Practice |
|---|---------------|
| 1 | Start with clear business requirements |
| 2 | Design for incremental processing |
| 3 | Implement data quality from day one |
| 4 | Use appropriate storage for each layer |
| 5 | Maintain data lineage across layers |
| 6 | Automate pipeline orchestration |
| 7 | Monitor data quality continuously |
| 8 | Implement access controls at each layer |
| 9 | Document data transformations |
| 10 | Continuously optimize performance |

---

## Common Mistakes

| # | Common Mistake | Better Approach |
|---|----------------|-----------------|
| 1 | Skipping silver layer | Always validate and clean |
| 2 | No data quality checks | Implement quality gates |
| 3 | Over-aggregating in silver | Keep detailed data |
| 4 | Not documenting transformations | Document thoroughly |
| 5 | Ignoring governance | Implement from start |
| 6 | No monitoring | Implement observability |
| 7 | Complex ETL in bronze | Keep bronze raw |
| 8 | Not using appropriate tools | Use right tools for each layer |
| 9 | No incremental processing | Design for incremental |
| 10 | Not managing costs | Monitor and optimize |

---

## Interview Questions

1. What is Medallion architecture?

2. What are the three layers in Medallion architecture?

3. What is the purpose of the Bronze layer?

4. What happens in the Silver layer?

5. What is the Gold layer used for?

6. How do you implement data quality in Medallion?

7. What is the difference between Bronze and Silver layers?

8. How do you handle data governance in Medallion?

9. What are the best practices for Medallion implementation?

10. How does Medallion support regulatory compliance?

11. What tools would you use for each layer?

12. How do you handle incremental updates?

---

## Practice Exercises

1. Design a bronze table structure for banking transactions.

2. Create silver layer transformations with quality checks.

3. Implement gold layer aggregations for customer analytics.

4. Set up data lineage tracking across layers.

5. Implement data quality monitoring.

6. Design a pipeline from bronze to silver to gold.

7. Implement row-level security on gold tables.

8. Create a data catalog for all three layers.

9. Optimize performance for gold layer queries.

10. Design a disaster recovery strategy.

---

## Key Takeaways

| # | Takeaway |
|---|----------|
| 1 | Medallion provides progressive data refinement |
| 2 | Bronze stores raw, immutable data |
| 3 | Silver validates and cleanses data |
| 4 | Gold delivers business-ready insights |
| 5 | Data quality improves across layers |
| 6 | Governance is essential at each layer |
| 7 | Automation is key for scalability |
| 8 | Documentation ensures maintainability |

---

## Chapter Summary

In this chapter, you learned:

- ✅ Medallion architecture and its layers
- ✅ Bronze layer - raw data ingestion
- ✅ Silver layer - data validation and cleansing
- ✅ Gold layer - business-ready analytics
- ✅ Data quality implementation
- ✅ Governance across layers
- ✅ Pipeline orchestration
- ✅ Performance optimization
- ✅ Best practices and common mistakes

You now understand how to implement a complete medallion architecture on Google Cloud.

---

## Next Chapter

👉 **Next Chapter: Change Data Capture (CDC)**