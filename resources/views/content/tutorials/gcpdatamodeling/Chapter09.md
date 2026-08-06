# Chapter 09: Modern Normalization

---

In the previous chapter, we explored Change Data Capture (CDC) and learned how to capture and process real-time data changes for streaming analytics.

In this chapter, we will dive into **Modern Normalization**, understand normalization forms and their evolution, and learn how to apply normalization techniques in modern data platforms.

Using our **Digital Banking Platform** case study, we will design normalized data models that balance performance, flexibility, and maintainability.

---

## 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand normalization and its purpose
- Explain normalization forms from 1NF to 6NF
- Understand the evolution to modern normalization
- Apply normalization in BigQuery environments
- Balance normalization with performance
- Implement denormalization strategies
- Recognize when to normalize vs denormalize
- Apply best practices for modern normalization

---

## What is Normalization?

Normalization is the process of **organizing data to reduce redundancy** and improve data integrity.

```text
Normalization = Organizing data structures to minimize redundancy
              + Ensuring data dependencies make sense
              + Improving data integrity
```

Think of normalization as:

```text
- Breaking down large tables into smaller ones
- Eliminating duplicate data
- Ensuring data consistency
- Making updates easier
```

---

## Real-World Banking Example

A bank needs to manage customer accounts efficiently:

```text
Unnormalized Design:
Customer Table: 50+ columns, repeated branch info, repeated customer details
Problems: Data duplication, update anomalies, large table size

Normalized Design:
Customer Table (core info)
Branch Table (branch details)
Address Table (addresses)
Account Table (accounts)
Results: Single source of truth, efficient updates, clean data
```

---

## Normalization Forms

### 1NF (First Normal Form)

```text
Requirements:
- Each table cell contains a single value
- Each column contains values of the same type
- Each column has a unique name
- The order of data doesn't matter
- No repeating groups
```

#### Banking Example - BEFORE (Not 1NF):
##### Customer_Accounts:
| Customer_ID | Name    | Accounts                      |
|-------------|---------|-------------------------------|
| C001        | John    | [A001, A002, A003]            |
| C002        | Mary    | [A004, A005]                  |

#### Banking Example - AFTER (1NF):
##### Customer:
| Customer_ID | Name    |
|-------------|---------|
| C001        | John    |
| C002        | Mary    |

##### Account:
| Account_ID | Customer_ID |
|------------|-------------|
| A001       | C001        |
| A002       | C001        |
| A003       | C001        |
| A004       | C002        |
| A005       | C002        |

### 2NF (Second Normal Form)

```text
Requirements:
- Already in 1NF
- All non-key columns are fully dependent on the entire primary key
- No partial dependencies

```
#### Banking Example - BEFORE (Not 2NF):
##### Transaction_Detail:
| Transaction_ID | Product_ID | Product_Name | Quantity | Price | Total |
|----------------|------------|--------------|----------|-------|-------|
| T001           | P001       | Savings      | 1        | 100   | 100   |
| T002           | P002       | Checking     | 2        | 50    | 100   |

#### Banking Example - AFTER (2NF):
##### Transaction:
| Transaction_ID | Product_ID | Quantity | Price | Total |
|----------------|------------|----------|-------|-------|
| T001           | P001       | 1        | 100   | 100   |
| T002           | P002       | 2        | 50    | 100   |

##### Product:
| Product_ID | Product_Name |
|------------|--------------|
| P001       | Savings      |
| P002       | Checking     |

### 3NF (Third Normal Form)

```text
Requirements:
- Already in 2NF
- No transitive dependencies
- Non-key columns depend only on the primary key
```

#### Banking Example - BEFORE (Not 3NF):
##### Transaction:
| Transaction_ID | Customer_ID | Branch_ID | Branch_Location | Amount |
|----------------|-------------|-----------|-----------------|--------|
| T001           | C001        | B001      | New York        | 100    |
| T002           | C002        | B002      | London          | 50     |

#### Banking Example - AFTER (3NF):
##### Transaction:
| Transaction_ID | Customer_ID | Branch_ID | Amount |
|----------------|-------------|-----------|--------|
| T001           | C001        | B001      | 100    |
| T002           | C002        | B002      | 50     |

##### Branch:
| Branch_ID | Branch_Location |
|-----------|-----------------|
| B001      | New York        |
| B002      | London          |

### BCNF (Boyce-Codd Normal Form)

```text
Requirements:
- Already in 3NF
- Every determinant is a candidate key
- No overlapping candidate keys
```

#### Banking Example:
Student_Class (Student_ID, Class_ID, Teacher_ID, ...)
BCNF ensures teacher determines class and class determines teacher

### 4NF (Fourth Normal Form)

```text
Requirements:
- Already in BCNF
- No multi-valued dependencies
- One-to-many relationships are properly separated
```

#### Banking Example:
Customer_Interest (Customer_ID, Product_Interest, Contact_Method)
4NF separates multi-valued attributes into separate tables

### 5NF (Fifth Normal Form)

```text
Requirements:
- Already in 4NF
- No join dependencies
- Tables can be reconstructed without data loss
```

#### Banking Example:
Splitting complex relationships into simpler components

### 6NF (Sixth Normal Form)

```text
Requirements:
- Already in 5NF
- Temporal data considerations
- Time-based attribute dependencies
```

#### Banking Example:
Historical data with effective dates
Customer_Address_History (Customer_ID, Address, Effective_Date, End_Date)

---

## Normalization Forms Comparison

| Form | Key Requirement | Banking Example |
|------|-----------------|-----------------|
| **1NF** | Atomic values, no repeating groups | Separate customer and accounts |
| **2NF** | Full dependency on primary key | Separate product from transaction |
| **3NF** | No transitive dependencies | Separate branch from transaction |
| **BCNF** | Determinants are candidate keys | Teacher-class dependencies |
| **4NF** | No multi-valued dependencies | Separate product interests |
| **5NF** | No join dependencies | Complex relationship decomposition |
| **6NF** | Temporal data handling | Historical address tracking |

---

![Normalization Forms Evolution](/images/tutorials/gcpdatamodeling/ch09-normalization-forms.png)

**Prompt:** Create a normalization forms evolution diagram showing the progression from 1NF to 6NF. Use a 6-step horizontal flow with purple gradient theme:

**Step 1: 1NF (First) - Purple #E1BEE7**
- Title: "1NF - Atomic Values"
- Description: "Each cell contains single value"
- Requirement: "No repeating groups"
- Banking Example: "Separate Customer & Account"
- Icon: ✅ One icon
- Badge: "Basic"

**Step 2: 2NF - Purple #CE93D8**
- Title: "2NF - Full Dependency"
- Description: "All columns depend on entire key"
- Requirement: "No partial dependencies"
- Banking Example: "Separate Product from Transaction"
- Icon: ✅ Two icon
- Badge: "Intermediate"

**Step 3: 3NF - Purple #AB47BC**
- Title: "3NF - No Transitive Dependencies"
- Description: "No indirect dependencies"
- Requirement: "Non-keys depend only on key"
- Banking Example: "Separate Branch from Transaction"
- Icon: ✅ Three icon
- Badge: "Standard"

**Step 4: BCNF - Purple #7B1FA2**
- Title: "BCNF - Determinants are Keys"
- Description: "Every determinant is candidate key"
- Requirement: "No overlapping candidate keys"
- Banking Example: "Teacher-Class dependency"
- Icon: ✅ Four icon
- Badge: "Advanced"

**Step 5: 4NF/5NF - Purple #4A148C**
- Title: "4NF/5NF - Advanced"
- Description: "No multi-valued dependencies"
- Requirement: "No join dependencies"
- Banking Example: "Multi-valued attributes"
- Icon: ✅ Five icon
- Badge: "Expert"

**Step 6: 6NF - Purple #311B92**
- Title: "6NF - Temporal Data"
- Description: "Time-based dependencies"
- Requirement: "Historical data handling"
- Banking Example: "Address history with dates"
- Icon: ✅ Six icon
- Badge: "State-of-Art"

Use horizontal arrows between steps. At bottom: Key takeaway: "Progressive normalization improves data integrity and reduces redundancy." Footer tags: Normalization, 1NF, 2NF, 3NF, BCNF, 6NF. Enterprise-style clean layout with rounded corners.

---

## Modern Normalization

### Evolution of Normalization

```text
Traditional Normalization (1970s-2000s):
- Focus on transaction processing
- Strict normalization (3NF)
- Data integrity first
- Performance trade-offs

Modern Normalization (Present):
- Balance normalization and performance
- Hybrid approaches
- Cloud-native capabilities
- Analytical workloads considered
```

### Modern Normalization Principles

```text
1. Right-Size Normalization
   - Not everything needs 3NF
   - Balance with performance
   - Consider query patterns

2. Hybrid Approaches
   - Normalized for OLTP
   - Denormalized for OLAP
   - Smart replication

3. Cloud-Native Normalization
   - Leverage cloud capabilities
   - Use managed services
   - Scale independently

4. Analytical Considerations
   - Query performance matters
   - Materialized views
   - Star schemas
```

---

## Normalization in BigQuery

### When to Normalize

```text
Use Normalization When:
- Data integrity is critical
- Frequent updates occur
- Storage space is limited
- Relationships are complex
- Transactional systems

Banking Examples:
- Customer master data
- Account relationships
- Transaction processing
- Regulatory reporting
```

### When Not to Normalize

```text
Avoid Normalization When:
- Analytical performance is priority
- Query patterns are fixed
- Data is historical
- Redundancy is acceptable
- Cost is a concern

Banking Examples:
- Data warehouse tables
- Reporting aggregates
- Real-time analytics
- Customer 360 views
```

### BigQuery Normalization Example

```sql
-- Normalized tables (3NF)
CREATE TABLE banking.customers (
  customer_id STRING NOT NULL,
  first_name STRING,
  last_name STRING,
  email STRING,
  phone STRING,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);

CREATE TABLE banking.addresses (
  address_id STRING NOT NULL,
  customer_id STRING NOT NULL,
  street_address STRING,
  city STRING,
  state STRING,
  zip_code STRING,
  country STRING,
  address_type STRING
);

CREATE TABLE banking.accounts (
  account_id STRING NOT NULL,
  customer_id STRING NOT NULL,
  account_type STRING,
  balance NUMERIC,
  open_date DATE,
  status STRING
);

-- Denormalized view for analytics
CREATE OR REPLACE VIEW banking.customer_360_view AS
SELECT
  c.customer_id,
  c.first_name,
  c.last_name,
  c.email,
  c.phone,
  a.street_address,
  a.city,
  a.state,
  a.zip_code,
  ac.account_id,
  ac.account_type,
  ac.balance,
  ac.open_date,
  ac.status
FROM banking.customers c
LEFT JOIN banking.addresses a ON c.customer_id = a.customer_id
LEFT JOIN banking.accounts ac ON c.customer_id = ac.customer_id;
```

---

## Denormalization Strategies

### Denormalization Techniques

```text
1. Pre-joined Tables
   - Combine related tables
   - Reduce joins in queries
   - Improve query performance

2. Summary Tables
   - Pre-calculated aggregates
   - Faster reporting
   - Lower query cost

3. Redundant Data
   - Store derived data
   - Avoid calculations
   - Faster access

4. Columnar Optimization
   - Use wide tables
   - Leverage columnar storage
   - Query only needed columns
```

### Banking Denormalization Example

```sql
-- Denormalized transaction fact table
CREATE OR REPLACE TABLE banking.fact_transactions AS
SELECT
  t.transaction_id,
  t.transaction_date,
  t.transaction_amount,
  t.transaction_type,
  c.customer_id,
  c.first_name,
  c.last_name,
  c.email,
  a.account_id,
  a.account_type,
  a.balance AS account_balance,
  b.branch_id,
  b.branch_name,
  b.city AS branch_city,
  m.merchant_name,
  m.merchant_category
FROM banking.transactions t
JOIN banking.customers c ON t.customer_id = c.customer_id
JOIN banking.accounts a ON t.account_id = a.account_id
JOIN banking.branches b ON a.branch_id = b.branch_id
LEFT JOIN banking.merchants m ON t.merchant_id = m.merchant_id;
```

---

## Normalization vs Denormalization

| Aspect | Normalized | Denormalized |
|--------|------------|--------------|
| **Data Redundancy** | Minimal | High |
| **Data Integrity** | High | Lower |
| **Update Performance** | Good | Poor |
| **Query Performance** | Variable | Excellent |
| **Storage Space** | Less | More |
| **Query Complexity** | Complex | Simple |
| **Maintenance** | Moderate | Higher |
| **Use Case** | OLTP | OLAP |

---

![Normalization vs Denormalization](/images/tutorials/gcpdatamodeling/ch09-normalization-vs-denormalization.png)

**Prompt:** Create a comparison diagram showing normalization vs denormalization. Use a 2-column structure with purple gradient theme:

**Left Column: Normalization - Purple #E1BEE7**
- Title: "Normalized Model"
- Icon: 📋 Clean data icon
- Structure: "Normalized Tables (3NF)"
- Tables: Customers (Core), Addresses, Accounts, Transactions
- Benefits: "Data Integrity", "No Redundancy", "Easy Updates"
- Drawbacks: "Complex Queries", "More Joins"
- Use Case: "OLTP, Core Banking"
- Visual: Multiple related tables with clean structure

**Right Column: Denormalization - Purple #CE93D8**
- Title: "Denormalized Model"
- Icon: 📊 Wide table icon
- Structure: "Wide Fact Tables"
- Tables: Customer_360_View, Transaction_Fact
- Benefits: "Simple Queries", "Fast Performance", "Less Joins"
- Drawbacks: "Data Redundancy", "Complex Updates"
- Use Case: "OLAP, Analytics"
- Visual: Single wide table with many columns

**Bottom Section: Hybrid Approach - Purple #AB47BC**
- Title: "Hybrid Approach - Best of Both"
- Use Normalized for: "Source Systems, Core Data"
- Use Denormalized for: "Analytics, Reporting, AI"
- Visual: Arrow flow from normalized to denormalized

At bottom: Key takeaway: "Balance normalization and denormalization based on use case." Footer tags: Normalization, Denormalization, Hybrid, Optimization. Enterprise-style clean layout with rounded corners.

---

![Banking Normalized Data Model](/images/tutorials/gcpdatamodeling/ch09-banking-normalized-model.png)

**Prompt:** Create a banking normalized data model diagram showing entity relationships. Use a 5-table structure with purple gradient theme showing relationships:

**Table 1: Customers (Top Center) - Purple #E1BEE7**
- Fields: customer_id (PK), first_name, last_name, email, phone, date_of_birth
- Icon: 👤 Person icon

**Table 2: Customer_Addresses (Left) - Purple #CE93D8**
- Fields: address_id (PK), customer_id (FK), street_address, city, state, zip_code, address_type
- Icon: 🏠 Address icon
- Relationship: Many-to-One from Customer_Addresses to Customers

**Table 3: Accounts (Right) - Purple #AB47BC**
- Fields: account_id (PK), customer_id (FK), account_type, balance, open_date, status
- Icon: 💳 Account icon
- Relationship: Many-to-One from Accounts to Customers

**Table 4: Transactions (Bottom Left) - Purple #7B1FA2**
- Fields: transaction_id (PK), account_id (FK), transaction_date, transaction_amount, transaction_type
- Icon: 💰 Transaction icon
- Relationship: Many-to-One from Transactions to Accounts

**Table 5: Merchants (Bottom Right) - Purple #4A148C**
- Fields: merchant_id (PK), merchant_name, merchant_category
- Icon: 🏪 Merchant icon
- Relationship: Many-to-One from Transactions to Merchants

Use relationship arrows between tables with cardinality indicators (1, *). Include key takeaway at bottom. Footer tags: Banking, Normalized Model, Relationships, Entity. Enterprise-style clean layout with rounded corners.

---

## Best Practices

| # | Best Practice |
|---|---------------|
| 1 | Normalize for OLTP, denormalize for OLAP |
| 2 | Use 3NF as default for transaction systems |
| 3 | Consider query patterns when normalizing |
| 4 | Use views for denormalized access |
| 5 | Implement data quality checks |
| 6 | Document normalization decisions |
| 7 | Balance storage cost with performance |
| 8 | Use appropriate data types |
| 9 | Consider future requirements |
| 10 | Regularly review and optimize |

---

## Common Mistakes

| # | Common Mistake | Better Approach |
|---|----------------|-----------------|
| 1 | Over-normalization | Balance with performance |
| 2 | Under-normalization | Ensure data integrity |
| 3 | Ignoring query patterns | Design for queries |
| 4 | No documentation | Document decisions |
| 5 | Rigid normalization | Allow evolution |
| 6 | Ignoring cost | Consider storage costs |
| 7 | No denormalized views | Create views for analytics |
| 8 | Not using appropriate types | Choose right data types |
| 9 | No indexing strategy | Use clustering effectively |
| 10 | Not planning for growth | Design for scale |

---

## Interview Questions

1. What is normalization and why is it important?

2. Explain 1NF, 2NF, and 3NF with examples.

3. What is the difference between 3NF and BCNF?

4. When would you use denormalization?

5. What are the advantages and disadvantages of normalization?

6. How does normalization impact query performance?

7. What is modern normalization?

8. How do you balance normalization and performance?

9. When would you use 4NF or 5NF?

10. What is 6NF and when is it used?

11. How does normalization apply to BigQuery?

12. What are the alternatives to strict normalization?

---

## Practice Exercises

1. Design a normalized banking customer model in 3NF.

2. Create a denormalized view for customer 360 analytics.

3. Compare query performance on normalized vs denormalized tables.

4. Design a temporal data model using 6NF principles.

5. Implement a hybrid approach for banking transactions.

6. Normalize a poorly designed banking table.

7. Create data quality checks for normalized tables.

8. Document normalization decisions for a banking domain.

9. Design a data model that supports both OLTP and OLAP.

10. Implement normalization with BigQuery best practices.

---

## Key Takeaways

| # | Takeaway |
|---|----------|
| 1 | Normalization reduces data redundancy and improves integrity |
| 2 | Modern normalization balances structure with performance |
| 3 | Different use cases require different approaches |
| 4 | Hybrid approaches combine normalization and denormalization |
| 5 | BigQuery supports both normalized and denormalized models |
| 6 | Consider query patterns in normalization decisions |
| 7 | Views provide denormalized access to normalized data |
| 8 | Continuous optimization is essential |

---

## Chapter Summary

In this chapter, you learned:

- ✅ What normalization is and why it matters
- ✅ Normalization forms from 1NF to 6NF
- ✅ Modern normalization principles
- ✅ Normalization in BigQuery
- ✅ Denormalization strategies
- ✅ Banking data model examples
- ✅ Normalization vs denormalization trade-offs
- ✅ Best practices and common mistakes

You now understand modern normalization techniques and how to apply them in data platforms.

---

## Next Chapter

👉 **Next Chapter: Keys, Relationships and Entity Lifecycle**