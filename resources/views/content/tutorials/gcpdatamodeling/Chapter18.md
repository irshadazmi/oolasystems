# Chapter 18: Hub, Link and Satellite Modeling

---

In the previous chapter, we introduced Data Vault modeling and learned about its core principles, architecture layers, and how it compares to traditional approaches like Kimball and Inmon.

In this chapter, we will dive deep into the **three core components of Data Vault** —Hubs, Links, and Satellites—understanding their detailed design, implementation patterns, and best practices for building enterprise data warehouses.

Using our **Digital Banking Platform** case study, we will implement complete Hub, Link, and Satellite structures that support scalable, auditable, and flexible data integration.

---

## 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Design and implement Hubs for business keys
- Create Links for relationship modeling
- Build Satellites for context and history tracking
- Understand hash key generation and management
- Implement effective dating in Satellites
- Apply best practices for each component type
- Design complete banking Data Vault models
- Query Data Vault structures effectively

---

## Hub Modeling

### What is a Hub?

A Hub is the **core identity component** of Data Vault, storing unique business keys from source systems.

```text
Hub = Business Key + Metadata + Unique Identity
```

### Hub Characteristics

```text
- Contains a business key from a source system
- Has a surrogate key (hash key in DV 2.0)
- Includes load timestamp (first seen)
- Records source system lineage
- Never updates existing rows (append-only)
- No foreign keys to other Hubs
- No descriptive attributes
```

### Hub Design Principles

```text
1. One Hub per Business Concept
   - Customer, Account, Transaction, Branch, Merchant

2. Business Key Must Be Unique
   - customer_id, account_id, branch_code

3. Use Hash Keys for Surrogates
   - SHA-256, MD5, consistent hashing

4. Track Source and Load Metadata
   - record_source, load_date

5. Keep It Simple
   - No context, just identity
```

### Hub Implementation

```sql
-- Standard Hub Implementation (Data Vault 2.0)
CREATE OR REPLACE TABLE banking.hub_customer (
  -- Hash Key (Surrogate)
  customer_hk STRING PRIMARY KEY,
  
  -- Business Key
  customer_id STRING NOT NULL,
  
  -- Metadata
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  
  -- Hash Key Generation
  CONSTRAINT unique_customer_id UNIQUE (customer_id)
);

-- Multiple Hubs for Banking Domain
CREATE OR REPLACE TABLE banking.hub_account (
  account_hk STRING PRIMARY KEY,
  account_id STRING NOT NULL,
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  CONSTRAINT unique_account_id UNIQUE (account_id)
);

CREATE OR REPLACE TABLE banking.hub_branch (
  branch_hk STRING PRIMARY KEY,
  branch_id STRING NOT NULL,
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  CONSTRAINT unique_branch_id UNIQUE (branch_id)
);

CREATE OR REPLACE TABLE banking.hub_merchant (
  merchant_hk STRING PRIMARY KEY,
  merchant_id STRING NOT NULL,
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  CONSTRAINT unique_merchant_id UNIQUE (merchant_id)
);

CREATE OR REPLACE TABLE banking.hub_transaction (
  transaction_hk STRING PRIMARY KEY,
  transaction_id STRING NOT NULL,
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  CONSTRAINT unique_transaction_id UNIQUE (transaction_id)
);
```

### Hub Loading Pattern

```sql
-- Hub Loading with Hash Key Generation
INSERT INTO banking.hub_customer (
  customer_hk,
  customer_id,
  load_date,
  record_source
)
SELECT
  SHA256(customer_id) AS customer_hk,
  customer_id,
  CURRENT_TIMESTAMP() AS load_date,
  'Core Banking System' AS record_source
FROM staging.customer_source
WHERE NOT EXISTS (
  SELECT 1
  FROM banking.hub_customer h
  WHERE h.customer_id = staging.customer_source.customer_id
);
```

### Banking Hub Examples

| Hub | Business Key | Source System | Description |
|-----|--------------|---------------|-------------|
| H_Customer | customer_id | Core Banking | Customer master identity |
| H_Account | account_id | Core Banking | Account master identity |
| H_Branch | branch_id | Branch System | Branch location identity |
| H_Merchant | merchant_id | Merchant System | Merchant identity |
| H_Transaction | transaction_id | Transaction System | Transaction identity |
| H_Product | product_id | Product System | Product identity |
| H_Employee | employee_id | HR System | Employee identity |

---

## Link Modeling

### What is a Link?

A Link defines **relationships between Hubs** , representing associations between business concepts.

```text
Link = Relationship + Association + Connectivity
```

### Link Characteristics

```text
- Connects two or more Hubs
- Contains foreign keys to Hubs
- Has a hash key (surrogate)
- Includes load timestamp
- Records source system lineage
- May include relationship attributes
- Models many-to-many relationships
- Never updates (append-only)
```

### Link Design Principles

```text
1. Link Granularity
   - Relationship at the correct level
   - No unnecessary detail

2. Relationship Types
   - Transactional, Hierarchical, Associative

3. Multiple Hub References
   - Can link 2+ Hubs

4. Role-Playing Links
   - Same Hubs in different roles

5. Keep It Focused
   - One relationship per Link
```

### Link Implementation

```sql
-- Standard Link Implementation
CREATE OR REPLACE TABLE banking.link_customer_account (
  -- Hash Key
  link_hk STRING PRIMARY KEY,
  
  -- Foreign Keys to Hubs
  customer_hk STRING NOT NULL,
  account_hk STRING NOT NULL,
  
  -- Relationship Attributes (Optional)
  relationship_type STRING,    -- 'PRIMARY', 'JOINT', 'BUSINESS'
  relationship_start_date DATE,
  relationship_end_date DATE,
  
  -- Metadata
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  
  -- Constraints
  CONSTRAINT fk_customer 
    FOREIGN KEY (customer_hk) 
    REFERENCES hub_customer(customer_hk),
  CONSTRAINT fk_account 
    FOREIGN KEY (account_hk) 
    REFERENCES hub_account(account_hk)
);

-- Transactional Link (Multiple Hubs)
CREATE OR REPLACE TABLE banking.link_transaction_party (
  link_hk STRING PRIMARY KEY,
  customer_hk STRING NOT NULL,
  account_hk STRING NOT NULL,
  merchant_hk STRING,
  branch_hk STRING,
  product_hk STRING,
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  transaction_amount NUMERIC,
  transaction_date DATE,
  CONSTRAINT fk_customer 
    FOREIGN KEY (customer_hk) 
    REFERENCES hub_customer(customer_hk),
  CONSTRAINT fk_account 
    FOREIGN KEY (account_hk) 
    REFERENCES hub_account(account_hk),
  CONSTRAINT fk_merchant 
    FOREIGN KEY (merchant_hk) 
    REFERENCES hub_merchant(merchant_hk)
);

-- Hierarchical Link
CREATE OR REPLACE TABLE banking.link_organization (
  link_hk STRING PRIMARY KEY,
  parent_branch_hk STRING NOT NULL,
  child_branch_hk STRING NOT NULL,
  relationship_type STRING,   -- 'REGION', 'AREA', 'BRANCH'
  load_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  record_source STRING NOT NULL,
  CONSTRAINT fk_parent 
    FOREIGN KEY (parent_branch_hk) 
    REFERENCES hub_branch(branch_hk),
  CONSTRAINT fk_child 
    FOREIGN KEY (child_branch_hk) 
    REFERENCES hub_branch(branch_hk)
);
```

### Link Loading Pattern

```sql
-- Link Loading from Staging
INSERT INTO banking.link_customer_account (
  link_hk,
  customer_hk,
  account_hk,
  relationship_type,
  relationship_start_date,
  load_date,
  record_source
)
SELECT
  SHA256(CONCAT(customer_id, '|', account_id)) AS link_hk,
  hc.customer_hk,
  ha.account_hk,
  st.relationship_type,
  st.relationship_start_date,
  CURRENT_TIMESTAMP() AS load_date,
  'Core Banking System' AS record_source
FROM staging.customer_account_source st
JOIN banking.hub_customer hc 
  ON st.customer_id = hc.customer_id
JOIN banking.hub_account ha 
  ON st.account_id = ha.account_id
WHERE NOT EXISTS (
  SELECT 1
  FROM banking.link_customer_account l
  WHERE l.customer_hk = hc.customer_hk
    AND l.account_hk = ha.account_hk
);
```

### Banking Link Examples

| Link | Hubs Connected | Relationship | Description |
|------|----------------|--------------|-------------|
| L_Customer_Account | Customer, Account | Ownership | Customer owns account |
| L_Account_Transaction | Account, Transaction | Association | Account has transaction |
| L_Customer_Branch | Customer, Branch | Service | Customer at branch |
| L_Transaction_Merchant | Transaction, Merchant | Association | Transaction with merchant |
| L_Customer_Product | Customer, Product | Enrollment | Customer has product |
| L_Account_Branch | Account, Branch | Location | Account at branch |

---

## Satellite Modeling

### What is a Satellite?

A Satellite provides **context and history** for Hubs and Links.

```text
Satellite = Attributes + Context + Historical Tracking
```

### Satellite Characteristics

```text
- Stores descriptive attributes
- References a Hub or Link (FK)
- Includes effective dating (SCD Type 2)
- Has hash key (FK to parent)
- Includes load timestamp
- Records source system lineage
- SCD Type 2 for historical tracking
- Appends new versions on change
- May track different attribute groups separately
```

### Satellite Design Principles

```text
1. Separate Concerns
   - One Satellite per source system
   - One Satellite per subject area

2. Track History
   - SCD Type 2 implementation
   - end_date for current status

3. Group Related Attributes
   - Keep related attributes together
   - Avoid overly broad Satellites

4. Manage Change
   - Capture change frequency
   - Optimize storage

5. Source Independence
   - One Satellite per source
   - Handle different source frequencies
```

### Satellite Implementation

```sql
-- Standard Satellite Implementation
CREATE OR REPLACE TABLE banking.sat_customer_info (
  -- Foreign Key to Hub
  customer_hk STRING NOT NULL,
  
  -- SCD Type 2 Columns
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,                    -- NULL if current
  
  -- Descriptive Attributes
  first_name STRING,
  last_name STRING,
  full_name STRING,
  email STRING,
  phone STRING,
  date_of_birth DATE,
  age INT,
  gender STRING,
  nationality STRING,
  
  -- Constraint
  CONSTRAINT fk_customer 
    FOREIGN KEY (customer_hk) 
    REFERENCES hub_customer(customer_hk)
);

-- Customer Address Satellite (SCD Type 2)
CREATE OR REPLACE TABLE banking.sat_customer_address (
  customer_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  street_address STRING,
  city STRING,
  state STRING,
  zip_code STRING,
  country STRING,
  address_type STRING,          -- 'HOME', 'WORK', 'MAILING'
  is_primary BOOLEAN,
  CONSTRAINT fk_customer 
    FOREIGN KEY (customer_hk) 
    REFERENCES hub_customer(customer_hk)
);

-- Customer Segment Satellite (Changes infrequently)
CREATE OR REPLACE TABLE banking.sat_customer_segment (
  customer_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  customer_segment STRING,      -- 'Premium', 'Gold', 'Silver', 'Bronze'
  risk_profile STRING,          -- 'Low', 'Medium', 'High'
  credit_score INT,
  customer_lifetime_value NUMERIC,
  CONSTRAINT fk_customer 
    FOREIGN KEY (customer_hk) 
    REFERENCES hub_customer(customer_hk)
);

-- Customer Preferences Satellite
CREATE OR REPLACE TABLE banking.sat_customer_preferences (
  customer_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  preferred_contact_method STRING,
  preferred_language STRING,
  marketing_opt_in BOOLEAN,
  communication_frequency STRING,
  CONSTRAINT fk_customer 
    FOREIGN KEY (customer_hk) 
    REFERENCES hub_customer(customer_hk)
);

-- Link Satellite for Relationship Details
CREATE OR REPLACE TABLE banking.sat_link_customer_account (
  link_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  account_role STRING,          -- 'PRIMARY', 'JOINT', 'AUTHORIZED'
  is_primary_owner BOOLEAN,
  ownership_percentage DECIMAL(5,2),
  authorization_level STRING,   -- 'FULL', 'VIEW_ONLY', 'LIMITED'
  CONSTRAINT fk_link 
    FOREIGN KEY (link_hk) 
    REFERENCES link_customer_account(link_hk)
);
```

### Satellite Loading Pattern

```sql
-- SCD Type 2 Satellite Loading
-- Step 1: Close current records that have changed
UPDATE banking.sat_customer_info
SET end_date = CURRENT_TIMESTAMP()
WHERE customer_hk IN (
    SELECT s.customer_hk
    FROM banking.sat_customer_info s
    JOIN staging.customer_source st 
      ON s.customer_hk = SHA256(st.customer_id)
    WHERE s.end_date IS NULL
      AND (
        s.first_name <> st.first_name
        OR s.last_name <> st.last_name
        OR s.email <> st.email
      )
);

-- Step 2: Insert new records
INSERT INTO banking.sat_customer_info (
  customer_hk,
  load_date,
  record_source,
  end_date,
  first_name,
  last_name,
  full_name,
  email,
  phone,
  date_of_birth,
  age,
  gender,
  nationality
)
SELECT
  SHA256(st.customer_id) AS customer_hk,
  CURRENT_TIMESTAMP() AS load_date,
  'Core Banking System' AS record_source,
  NULL AS end_date,
  st.first_name,
  st.last_name,
  st.full_name,
  st.email,
  st.phone,
  st.date_of_birth,
  st.age,
  st.gender,
  st.nationality
FROM staging.customer_source st
WHERE NOT EXISTS (
  SELECT 1
  FROM banking.sat_customer_info s
  WHERE s.customer_hk = SHA256(st.customer_id)
    AND s.end_date IS NULL
    AND s.first_name = st.first_name
    AND s.last_name = st.last_name
    AND s.email = st.email
);
```

---

## Hash Key Generation and Management

### Hash Key Strategies

```sql
-- Hash Key Generation Methods
-- Method 1: SHA-256 (Recommended)
SELECT SHA256(customer_id) AS customer_hk;

-- Method 2: MD5 (Legacy compatibility)
SELECT MD5(customer_id) AS customer_hk;

-- Method 3: Concatenated keys for Links
SELECT SHA256(CONCAT(customer_id, '|', account_id)) AS link_hk;

-- Method 4: Consistent hashing across systems
SELECT UPPER(
  SUBSTRING(
    TO_BASE64(SHA256(customer_id)), 
    1, 
    32
  )
) AS customer_hk;
```

### Hash Key Best Practices

```text
1. Use Consistent Hashing Algorithm
   - SHA-256 recommended
   - Same across all environments

2. Handle NULL Values
   - Use COALESCE or default values
   - Consistent handling

3. Use Delimiters for Links
   - Pipe character '|'
   - Consistent ordering

4. Store as STRING or BYTES
   - STRING for readability
   - BYTES for performance

5. Document Hash Key Logic
   - Maintain hash key definitions
   - Version control hashing rules
```

### Hash Key Utilities

```sql
-- Utility Functions for Hash Keys
CREATE OR REPLACE FUNCTION banking.generate_hub_key(
  business_key STRING
) AS (
  SHA256(business_key)
);

CREATE OR REPLACE FUNCTION banking.generate_link_key(
  business_keys ARRAY<STRING>,
  delimiter STRING DEFAULT '|'
) AS (
  SHA256(ARRAY_TO_STRING(ARRAY_SORT(business_keys), delimiter))
);

-- Usage
SELECT
  banking.generate_hub_key(customer_id) AS customer_hk,
  banking.generate_link_key(
    [customer_id, account_id], '|'
  ) AS link_hk
FROM staging.customer_account_source;
```

---

## Point-in-Time Querying

### Querying Current State

```sql
-- Get current customer information
SELECT
  h.customer_id,
  s.first_name,
  s.last_name,
  s.email,
  s.phone,
  s.customer_segment,
  s.risk_profile
FROM banking.hub_customer h
JOIN banking.sat_customer_info s 
  ON h.customer_hk = s.customer_hk
JOIN banking.sat_customer_segment seg
  ON h.customer_hk = seg.customer_hk
WHERE s.end_date IS NULL
  AND seg.end_date IS NULL;
```

### Querying Historical State

```sql
-- Get customer information as of a specific date
WITH customer_as_of_date AS (
  SELECT
    h.customer_id,
    s.first_name,
    s.last_name,
    s.email,
    s.phone,
    s.load_date AS info_effective_date,
    seg.customer_segment,
    seg.load_date AS segment_effective_date
  FROM banking.hub_customer h
  JOIN banking.sat_customer_info s 
    ON h.customer_hk = s.customer_hk
  JOIN banking.sat_customer_segment seg
    ON h.customer_hk = seg.customer_hk
  WHERE s.load_date <= '2024-01-01'
    AND (s.end_date IS NULL OR s.end_date > '2024-01-01')
    AND seg.load_date <= '2024-01-01'
    AND (seg.end_date IS NULL OR seg.end_date > '2024-01-01')
)
SELECT
  customer_id,
  first_name,
  last_name,
  email,
  phone,
  customer_segment,
  info_effective_date,
  segment_effective_date
FROM customer_as_of_date;
```

### Querying History

```sql
-- Get full history of customer changes
SELECT
  h.customer_id,
  s.first_name,
  s.last_name,
  s.email,
  s.load_date AS effective_from,
  s.end_date AS effective_to,
  s.record_source
FROM banking.hub_customer h
JOIN banking.sat_customer_info s 
  ON h.customer_hk = s.customer_hk
WHERE h.customer_id = 'C001'
ORDER BY s.load_date;
```

---

## Banking Data Vault Model - Complete

### Complete DV Model Structure

```sql
-- ============================================
-- HUBS
-- ============================================
CREATE OR REPLACE TABLE banking.hub_customer (
  customer_hk STRING PRIMARY KEY,
  customer_id STRING NOT NULL UNIQUE,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL
);

CREATE OR REPLACE TABLE banking.hub_account (
  account_hk STRING PRIMARY KEY,
  account_id STRING NOT NULL UNIQUE,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL
);

CREATE OR REPLACE TABLE banking.hub_branch (
  branch_hk STRING PRIMARY KEY,
  branch_id STRING NOT NULL UNIQUE,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL
);

CREATE OR REPLACE TABLE banking.hub_merchant (
  merchant_hk STRING PRIMARY KEY,
  merchant_id STRING NOT NULL UNIQUE,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL
);

-- ============================================
-- LINKS
-- ============================================
CREATE OR REPLACE TABLE banking.link_customer_account (
  link_hk STRING PRIMARY KEY,
  customer_hk STRING NOT NULL,
  account_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  relationship_type STRING,
  FOREIGN KEY (customer_hk) REFERENCES hub_customer(customer_hk),
  FOREIGN KEY (account_hk) REFERENCES hub_account(account_hk)
);

CREATE OR REPLACE TABLE banking.link_account_branch (
  link_hk STRING PRIMARY KEY,
  account_hk STRING NOT NULL,
  branch_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  FOREIGN KEY (account_hk) REFERENCES hub_account(account_hk),
  FOREIGN KEY (branch_hk) REFERENCES hub_branch(branch_hk)
);

-- ============================================
-- SATELLITES
-- ============================================
CREATE OR REPLACE TABLE banking.sat_customer_info (
  customer_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  first_name STRING,
  last_name STRING,
  full_name STRING,
  email STRING,
  phone STRING,
  date_of_birth DATE,
  gender STRING,
  FOREIGN KEY (customer_hk) REFERENCES hub_customer(customer_hk)
);

CREATE OR REPLACE TABLE banking.sat_customer_address (
  customer_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  street_address STRING,
  city STRING,
  state STRING,
  zip_code STRING,
  country STRING,
  address_type STRING,
  is_primary BOOLEAN,
  FOREIGN KEY (customer_hk) REFERENCES hub_customer(customer_hk)
);

CREATE OR REPLACE TABLE banking.sat_customer_segment (
  customer_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  customer_segment STRING,
  risk_profile STRING,
  credit_score INT,
  FOREIGN KEY (customer_hk) REFERENCES hub_customer(customer_hk)
);

CREATE OR REPLACE TABLE banking.sat_account_details (
  account_hk STRING NOT NULL,
  load_date TIMESTAMP NOT NULL,
  record_source STRING NOT NULL,
  end_date TIMESTAMP,
  account_type STRING,
  account_sub_type STRING,
  account_status STRING,
  open_date DATE,
  close_date DATE,
  currency STRING,
  balance NUMERIC,
  FOREIGN KEY (account_hk) REFERENCES hub_account(account_hk)
);
```

---

## Hub, Link, Satellite Best Practices

| # | Best Practice | Banking Example |
|---|---------------|-----------------|
| 1 | One Hub per business concept | H_Customer, H_Account |
| 2 | Use hash keys consistently | SHA-256 for all |
| 3 | One Satellite per source/domain | S_Customer_Info, S_Customer_Address |
| 4 | Separate volatile and stable attributes | Address vs Segment satellites |
| 5 | Use SCD Type 2 in all Satellites | end_date tracking |
| 6 | Model relationships at correct granularity | L_Customer_Account |
| 7 | Include metadata in all tables | load_date, record_source |
| 8 | Document business key definitions | Clear definitions |
| 9 | Implement referential integrity | Foreign key constraints |
| 10 | Use consistent naming | H_, L_, S_ prefixes |

---

## Common Mistakes

| # | Common Mistake | Better Approach |
|---|----------------|-----------------|
| 1 | Including context in Hubs | Keep Hubs lean |
| 2 | Not using hash keys | Use DV 2.0 hash keys |
| 3 | Multiple sources in one Satellite | One Satellite per source |
| 4 | No history tracking | Implement SCD Type 2 |
| 5 | Complex Links | Keep links focused |
| 6 | Inconsistent hash logic | Document and standardize |
| 7 | Missing metadata | Always include load_date |
| 8 | No referential integrity | Enforce constraints |
| 9 | Inconsistent naming | Follow standards |
| 10 | Not documenting decisions | Document thoroughly |

---

![Hub, Link, Satellite Detailed Structure](/images/tutorials/gcpdatamodeling/ch18-hub-link-satellite.png)

**Prompt:** Create a detailed Hub, Link, Satellite structure diagram showing the complete relationships. Use a 4-table structure with purple gradient theme:

**Center Left: Hub (Top Left) - Purple #E1BEE7**
- Title: "Hub - Business Identity"
- Fields: customer_hk (PK), customer_id (Business Key), load_date, record_source
- Icon: 🔑
- Characteristics: "Identity Only, No Context, Append-Only"
- Banking Example: "H_Customer - customer_id"

**Center Right: Link (Top Right) - Purple #CE93D8**
- Title: "Link - Relationships"
- Fields: link_hk (PK), customer_hk (FK), account_hk (FK), load_date, record_source, relationship_type
- Icon: 🔗
- Characteristics: "Relationships Only, Multiple Hubs, Append-Only"
- Banking Example: "L_Customer_Account"

**Bottom Left: Satellite (Hub) - Purple #AB47BC**
- Title: "Satellite - Hub Context"
- Fields: customer_hk (FK), load_date, record_source, end_date, first_name, last_name, email, phone
- Icon: 📋
- Characteristics: "SCD Type 2, Descriptive Attributes, Historical Tracking"
- Banking Example: "S_Customer_Info"

**Bottom Right: Satellite (Link) - Purple #7B1FA2**
- Title: "Satellite - Link Context"
- Fields: link_hk (FK), load_date, record_source, end_date, account_role, ownership_percentage
- Icon: 📋
- Characteristics: "SCD Type 2, Relationship Attributes, Historical Tracking"
- Banking Example: "S_Link_Customer_Account"

Use connector lines: Hub 1:M to Satellite, Hub M:M to Link, Link 1:M to Satellite. Include key takeaway at bottom: "Hubs store identity, Links store relationships, Satellites store context and history." Footer tags: Hub, Link, Satellite, Components. Enterprise-style clean layout with rounded corners.

---

![Data Vault Query Patterns](/images/tutorials/gcpdatamodeling/ch18-data-vault-query-patterns.png)

**Prompt:** Create a Data Vault query patterns diagram showing different query types. Use a 3-column structure with purple gradient theme:

**Column 1: Current View (Left) - Purple #E1BEE7**
- Title: "Current State Query"
- Icon: 📊
- Query Type: "Get current customer profile"
- Pattern: "Join Hub + Satellites WHERE end_date IS NULL"
- Example: "SELECT h.customer_id, s.first_name, s.last_name, s.email, seg.customer_segment FROM hub_customer h JOIN sat_customer_info s ON h.customer_hk = s.customer_hk JOIN sat_customer_segment seg ON h.customer_hk = seg.customer_hk WHERE s.end_date IS NULL AND seg.end_date IS NULL"
- Banking Use: "Current customer master"

**Column 2: Point-in-Time (Middle) - Purple #CE93D8**
- Title: "Point-in-Time Query"
- Icon: 📅
- Query Type: "Get customer profile as of specific date"
- Pattern: "Join Hub + Satellites WHERE load_date <= as_of_date AND (end_date IS NULL OR end_date > as_of_date)"
- Example: "SELECT h.customer_id, s.first_name, s.last_name, s.email, s.load_date AS effective_from FROM hub_customer h JOIN sat_customer_info s ON h.customer_hk = s.customer_hk WHERE s.load_date <= '2024-01-01' AND (s.end_date IS NULL OR s.end_date > '2024-01-01')"
- Banking Use: "Historical analysis, audits"

**Column 3: Change History (Right) - Purple #AB47BC**
- Title: "Change History Query"
- Icon: 🔄
- Query Type: "Get full change history"
- Pattern: "Join Hub + Satellites WHERE customer_id = value ORDER BY load_date"
- Example: "SELECT h.customer_id, s.first_name, s.last_name, s.email, s.load_date AS effective_from, s.end_date AS effective_to, s.record_source FROM hub_customer h JOIN sat_customer_info s ON h.customer_hk = s.customer_hk WHERE h.customer_id = 'C001' ORDER BY s.load_date"
- Banking Use: "Audit trail, compliance"

At bottom: Key takeaway: "Data Vault enables current, historical, and point-in-time queries with full auditability." Footer tags: Query Patterns, Current View, Point-in-Time, History. Enterprise-style clean layout with rounded corners.

---

## Interview Questions

1. What is a Hub in Data Vault and what does it store?

2. What is a Link in Data Vault and what does it store?

3. What is a Satellite in Data Vault and what does it store?

4. What are hash keys and why are they important?

5. How do you implement SCD Type 2 in Satellites?

6. What is the difference between Hub Satellites and Link Satellites?

7. How do you query current state from Data Vault?

8. How do you query point-in-time state?

9. What are the naming conventions for Data Vault components?

10. How do you handle changes in business keys?

11. What is the role of record_source in Data Vault?

12. How do you design Links for many-to-many relationships?

---

## Practice Exercises

1. Design a Hub for banking products.

2. Create a Link between customer and product.

3. Implement a Satellite for product details.

4. Design a complete banking Data Vault model.

5. Implement hash key generation in BigQuery.

6. Load data into all three component types.

7. Query current customer information.

8. Query historical customer information.

9. Implement SCD Type 2 for customer address.

10. Create a point-in-time view of customer profile.

---

## Key Takeaways

| # | Takeaway |
|---|----------|
| 1 | Hubs store business keys and identity |
| 2 | Links define relationships between Hubs |
| 3 | Satellites provide context and history |
| 4 | Hash keys enable parallel processing |
| 5 | SCD Type 2 is built into Satellites |
| 6 | Components are append-only |
| 7 | Full auditability is inherent |
| 8 | Query patterns support current, point-in-time, and history |

---

## Chapter Summary

In this chapter, you learned:

- ✅ Hub design and implementation
- ✅ Link design and implementation
- ✅ Satellite design and implementation
- ✅ Hash key generation and management
- ✅ SCD Type 2 in Satellites
- ✅ Query patterns for Data Vault
- ✅ Banking Data Vault examples
- ✅ Best practices and common mistakes

You now understand how to design and implement complete Hub, Link, and Satellite structures for enterprise data warehouses.

---

## Next Chapter

👉 **Next Chapter: Semi-Structured Data Modeling**