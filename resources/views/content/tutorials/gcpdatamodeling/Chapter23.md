# Chapter 23: Fraud Detection and Relationship Analytics

---

In the previous chapter, we explored property graph modeling and learned how to design comprehensive graph data models for banking use cases.

In this chapter, we will apply graph modeling to **Fraud Detection and Relationship Analytics**—understanding how to identify suspicious patterns, detect fraud rings, and analyze complex relationships using graph databases.

Using our **Digital Banking Platform** case study, we will build graph-based fraud detection systems, implement relationship analytics, and uncover hidden patterns that traditional approaches miss.

---

## 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand fraud detection patterns in banking
- Apply graph analytics for fraud detection
- Detect fraud rings and suspicious networks
- Implement relationship analytics
- Use Cypher for fraud detection queries
- Build money laundering detection models
- Apply graph algorithms for anomaly detection
- Design comprehensive fraud detection systems

---

## Fraud Detection Landscape

### Types of Banking Fraud

```text
1. Transaction Fraud
   - Unauthorized transactions
   - Card-not-present fraud
   - ATM skimming
   - Account takeover

2. Identity Fraud
   - Synthetic identity creation
   - Stolen identity usage
   - Document forgery

3. Money Laundering
   - Structuring (smurfing)
   - Layering transactions
   - Shell company usage
   - Trade-based laundering

4. Organized Fraud
   - Fraud rings
   - Collusion networks
   - Insider fraud
   - Third-party fraud

5. Application Fraud
   - Loan application fraud
   - Credit card application fraud
   - Insurance fraud
```

### Traditional Fraud Detection Challenges

```text
Challenges:
- Silos: Data in different systems
- Relationships: Hard to track connections
- Scale: Millions of transactions
- Time: Need real-time detection
- Evolution: Fraud patterns change
- False Positives: Many false alarms

Traditional Approach Limitations:
- Focus on individual transactions
- Miss network patterns
- Limited relationship analysis
- Batch processing
- Reactive, not proactive
```

---

## Graph-Based Fraud Detection

### Why Graph for Fraud Detection?

```text
Graph databases excel at fraud detection because:

1. Relationship Focus
   - Fraud is about connections
   - Identify networks and rings
   - Track money flow patterns

2. Pattern Recognition
   - Identify suspicious patterns
   - Detect anomalies
   - Find hidden connections

3. Real-Time Analysis
   - Query relationships quickly
   - Real-time alerts
   - Immediate action

4. Visual Analysis
   - Visualize fraud networks
   - Interactive exploration
   - Pattern discovery
```

### Key Fraud Detection Patterns

```text
1. Circular Transactions
   - Money circulating between accounts
   - Laundering indicator

2. Structured Transactions
   - Multiple small transactions
   - Avoiding detection thresholds

3. Connected Fraud Rings
   - Multiple customers working together
   - Shared accounts/merchants

4. Anomalous Connections
   - Unexpected relationships
   - Unusual behavior patterns

5. Multi-Hop Relationships
   - Indirect connections
   - Hidden networks
```

---

## Fraud Detection Graph Model

### Complete Fraud Detection Model

```cypher
-- Fraud Detection Property Graph Model
-- Nodes
CREATE (c1:Customer {
  customer_id: 'C001',
  name: 'John Doe',
  risk_score: 0.15,
  fraud_risk: 'Low'
})

CREATE (c2:Customer {
  customer_id: 'C002',
  name: 'Suspicious User',
  risk_score: 0.85,
  fraud_risk: 'High'
})

CREATE (a1:Account {
  account_id: 'A001',
  type: 'Checking',
  balance: 100000.00,
  flagged: true
})

CREATE (a2:Account {
  account_id: 'A002',
  type: 'Savings',
  balance: 15000.00
})

CREATE (t1:Transaction {
  transaction_id: 'T001',
  amount: 50000.00,
  date: '2024-01-15',
  type: 'Wire Transfer'
})

CREATE (t2:Transaction {
  transaction_id: 'T002',
  amount: 25000.00,
  date: '2024-01-14',
  type: 'Cash Withdrawal'
})

CREATE (m1:Merchant {
  merchant_id: 'M001',
  name: 'Offshore Holdings',
  category: 'Financial Services',
  flagged: true
})

CREATE (m2:Merchant {
  merchant_id: 'M002',
  name: 'Legit Merchant Inc.',
  category: 'Retail'
})

-- Relationships
CREATE (c1)-[:OWNS {since_date: '2020-01-01'}]->(a2)
CREATE (c2)-[:OWNS {since_date: '2024-01-01'}]->(a1)
CREATE (c2)-[:OWNS {since_date: '2023-01-01'}]->(a2)

CREATE (a1)-[:HAS_TRANSACTION]->(t1)
CREATE (a2)-[:HAS_TRANSACTION]->(t2)

CREATE (t1)-[:WITH_MERCHANT]->(m1)
CREATE (t2)-[:WITH_MERCHANT]->(m2)

CREATE (c1)-[:ASSOCIATED_WITH {
  relationship_type: 'Suspected Link',
  confidence: 0.75,
  detected_date: '2024-01-15'
}]->(c2)

CREATE (a1)-[:SHARES_TRANSACTION {count: 15}]->(a2)
```

---

## Fraud Detection Queries

### 1. Finding Suspicious Customers

```cypher
-- Find high-risk customers
MATCH (c:Customer)
WHERE c.risk_score > 0.7
  OR c.fraud_risk = 'High'
RETURN c.customer_id, c.name, c.risk_score, c.fraud_risk
ORDER BY c.risk_score DESC;

-- Find customers with suspicious accounts
MATCH (c:Customer)-[:OWNS]->(a:Account)
WHERE a.flagged = true
RETURN c.customer_id, c.name, c.risk_score, a.account_id, a.balance;
```

### 2. Transaction Pattern Analysis

```cypher
-- Find circular transactions (fraud indicator)
MATCH (c1:Customer)-[:OWNS]->(a1:Account)
      -[:HAS_TRANSACTION]->(t1:Transaction)
      -[:WITH_MERCHANT]->(m:Merchant)
      <-[:WITH_MERCHANT]-(t2:Transaction)
      <-[:HAS_TRANSACTION]-(a2:Account)
      <-[:OWNS]-(c2:Customer)
WHERE c1 <> c2
  AND t1.date = t2.date
  AND t1.amount = t2.amount
RETURN c1.name AS sender, c2.name AS receiver, m.name AS merchant, t1.amount;

-- Find suspicious transaction structures (structuring)
MATCH (c:Customer)-[:OWNS]->(a:Account)
      -[:HAS_TRANSACTION]->(t:Transaction)
WHERE t.amount < 10000  -- Threshold avoidance
  AND t.date >= '2024-01-01'
  AND t.date < '2024-02-01'
WITH c, a, COUNT(t) AS tx_count, SUM(t.amount) AS total
WHERE tx_count > 50  -- High frequency for small amounts
RETURN c.name, a.account_id, tx_count, total;
```

### 3. Network Analysis

```cypher
-- Find customers connected through suspicious accounts
MATCH (c1:Customer)-[:OWNS]->(a:Account)
      -[:SHARES_TRANSACTION]->(a2:Account)
      <-[:OWNS]-(c2:Customer)
WHERE c1 <> c2
RETURN c1.name AS customer1, c2.name AS customer2, 
       a.account_id AS shared_account;

-- Find fraud rings with multi-hop relationships
MATCH path = (c:Customer)-[:OWNS|ASSOCIATED_WITH*1..3]-(connected)
WHERE c.risk_score > 0.6
RETURN c.name, 
       [n IN NODES(path) | n.name] AS path_nodes,
       LENGTH(path) AS depth,
       CUSTOMER_DEGREE(c) AS network_size
ORDER BY network_size DESC;
```

### 4. Money Laundering Detection

```cypher
-- Find money laundering paths
MATCH path = (s:Customer)-[:OWNS]->(:Account)
            -[:HAS_TRANSACTION]->(:Transaction)
            -[:WITH_MERCHANT]->(:Merchant {flagged: true})
            <-[:WITH_MERCHANT]-(:Transaction)
            <-[:HAS_TRANSACTION]-(:Account)
            <-[:OWNS]-(r:Customer)
WHERE s <> r
  AND ALL(t IN RELATIONSHIPS(path) WHERE t.amount > 50000)
RETURN path, s.name AS source, r.name AS receiver, 
       SUM(t.amount) AS total_amount
ORDER BY total_amount DESC;

-- Find suspicious merchant categories
MATCH (c:Customer)-[:OWNS]->(a:Account)
      -[:HAS_TRANSACTION]->(t:Transaction)
      -[:WITH_MERCHANT]->(m:Merchant)
WHERE m.category IN ['Casino', 'Offshore', 'Crypto', 'Money Services']
  AND t.amount > 5000
RETURN m.name, m.category, COUNT(t) AS tx_count, SUM(t.amount) AS total
ORDER BY total DESC;
```

### 5. Anomaly Detection

```cypher
-- Find anomalous transaction patterns
MATCH (c:Customer)-[:OWNS]->(a:Account)
      -[:HAS_TRANSACTION]->(t:Transaction)
WITH c, a, 
     COUNT(t) AS tx_count, 
     SUM(t.amount) AS total,
     AVG(t.amount) AS avg_tx
WHERE tx_count > 100
  AND total > 1000000
  AND avg_tx > 10000
RETURN c.name, a.account_id, tx_count, total, avg_tx
ORDER BY total DESC;

-- Find unusual account relationships
MATCH (a1:Account)-[:SHARES_TRANSACTION]-(a2:Account)
WITH a1, a2, COUNT(a1) AS connection_count
WHERE connection_count > 50
  AND a1 <> a2
RETURN a1.account_id, a2.account_id, connection_count;
```

---

## Relationship Analytics

### Customer Network Analysis

```cypher
-- Build customer relationship network
MATCH (c1:Customer)-[:ASSOCIATED_WITH|FAMILY_OF|BUSINESS_PARTNER]-(c2:Customer)
WHERE c1 <> c2
RETURN c1.name AS customer1, 
       c2.name AS customer2,
       TYPE(RELATIONSHIP(c1)) AS relationship_type,
       c1.risk_score AS risk1,
       c2.risk_score AS risk2;

-- Find central nodes in the network (influential customers)
MATCH (c:Customer)
RETURN c.name, 
       CUSTOMER_DEGREE(c) AS degree,
       CUSTOMER_CLOSENESS(c) AS closeness,
       CUSTOMER_BETWEENNESS(c) AS betweenness
ORDER BY degree DESC
LIMIT 10;
```

### Transaction Network Analysis

```cypher
-- Analyze transaction network
MATCH (a1:Account)-[:HAS_TRANSACTION]->(:Transaction)
      -[:WITH_MERCHANT]->(m:Merchant)
      <-[:WITH_MERCHANT]-(:Transaction)
      <-[:HAS_TRANSACTION]-(a2:Account)
WITH a1, a2, m, COUNT(*) AS tx_count, SUM(t.amount) AS total_amount
WHERE tx_count > 10
RETURN a1.account_id, a2.account_id, m.name, tx_count, total_amount
ORDER BY tx_count DESC;

-- Find money flow patterns
MATCH path = (s:Customer)-[:OWNS]->(:Account)
            -[:HAS_TRANSACTION]->(:Transaction)
            -[:WITH_MERCHANT]->(:Merchant)
            <-[:WITH_MERCHANT]-(:Transaction)
            <-[:HAS_TRANSACTION]-(:Account)
            <-[:OWNS]-(r:Customer)
WHERE s <> r
  AND ALL(t IN RELATIONSHIPS(path) WHERE t.amount > 10000)
RETURN s.name AS source, r.name AS receiver, 
       SUM(t.amount) AS total_amount,
       LENGTH(path) AS path_length
ORDER BY total_amount DESC;
```

---

## Graph Algorithms for Fraud Detection

### Community Detection

```cypher
-- Detect fraud communities
CALL gds.louvain.stream('fraud_graph')
YIELD nodeId, communityId
RETURN communityId, COLLECT(nodeId) AS nodes, COUNT(nodeId) AS size
ORDER BY size DESC
LIMIT 5;

-- Analyze community suspiciousness
CALL gds.pageRank.stream('fraud_graph')
YIELD nodeId, score
WHERE score > 0.5
RETURN nodeId, score
ORDER BY score DESC;
```

### Path Finding

```cypher
-- Find shortest suspicious paths
MATCH (c1:Customer {risk_score: 0.8}),
      (c2:Customer {risk_score: 0.8}),
      path = shortestPath((c1)-[:OWNS|HAS_TRANSACTION|WITH_MERCHANT*..5]-(c2))
WHERE c1 <> c2
RETURN path, LENGTH(path) AS path_length
ORDER BY path_length ASC;
```

### Centrality Analysis

```cypher
-- Find central nodes in fraud network
CALL gds.pageRank.stream('fraud_graph')
YIELD nodeId, score
MATCH (n) WHERE ID(n) = nodeId
RETURN LABELS(n) AS type, n.name AS name, score
ORDER BY score DESC
LIMIT 10;

-- Find highly connected nodes (hub customers)
CALL gds.degree.stream('fraud_graph')
YIELD nodeId, degree
MATCH (n) WHERE ID(n) = nodeId
RETURN n.name AS node, LABELS(n) AS type, degree
ORDER BY degree DESC
LIMIT 10;
```

---

## Real-Time Fraud Detection Pipeline

### Streaming Fraud Detection

```sql
-- BigQuery real-time fraud detection
CREATE OR REPLACE TABLE banking.fraud_alerts_realtime
PARTITION BY DATE(alert_timestamp)
CLUSTER BY customer_id, risk_level
AS
WITH transaction_features AS (
  SELECT
    transaction_id,
    customer_id,
    transaction_amount,
    merchant_category,
    event_timestamp,
    -- Statistical features
    AVG(transaction_amount) OVER (
      PARTITION BY customer_id
      ORDER BY event_timestamp
      ROWS BETWEEN 10 PRECEDING AND 1 PRECEDING
    ) AS avg_amount,
    COUNT(*) OVER (
      PARTITION BY customer_id
      ORDER BY event_timestamp
      ROWS BETWEEN 10 PRECEDING AND 1 PRECEDING
    ) AS tx_count
  FROM banking.streaming_transactions
)
SELECT
  transaction_id,
  customer_id,
  transaction_amount,
  merchant_category,
  event_timestamp,
  CASE
    WHEN transaction_amount > 3 * avg_amount THEN 'UNUSUAL_AMOUNT'
    WHEN merchant_category IN ('CASINO', 'OFFSHORE') THEN 'RISKY_MERCHANT'
    WHEN tx_count > 10 THEN 'HIGH_VELOCITY'
    ELSE 'NORMAL'
  END AS alert_type,
  CURRENT_TIMESTAMP() AS alert_timestamp
FROM transaction_features
WHERE transaction_amount > 3 * avg_amount
   OR merchant_category IN ('CASINO', 'OFFSHORE')
   OR tx_count > 10;
```

### Fraud Alerting Workflow

```text
1. Transaction Event
   ↓
2. Feature Extraction
   - Amount, merchant, location, time
   - Historical patterns
   - Customer behavior
   ↓
3. Rule-Based Detection
   - Thresholds (amount, velocity)
   - Blacklists (merchants, countries)
   - Pattern matching
   ↓
4. Graph-Based Analysis
   - Connection patterns
   - Network relationships
   - Centrality metrics
   ↓
5. ML Anomaly Detection
   - Isolation Forest
   - Autoencoders
   - Graph neural networks
   ↓
6. Alert Generation
   - Risk scoring
   - Priority levels
   - Action recommendations
   ↓
7. Investigation & Response
   - Case management
   - Transaction blocking
   - Customer notification
```

---

## Fraud Detection Best Practices

| # | Best Practice | Implementation |
|---|---------------|----------------|
| 1 | Use graph for relationship analysis | Fraud ring detection |
| 2 | Implement real-time detection | Streaming pipeline |
| 3 | Combine rules and ML | Hybrid approach |
| 4 | Monitor false positive rates | Continuous tuning |
| 5 | Maintain historical data | Temporal analysis |
| 6 | Visualize fraud networks | Graph visualization |
| 7 | Implement explainable AI | Decision transparency |
| 8 | Regular model updates | Adapt to new patterns |

---

## Common Mistakes

| # | Common Mistake | Better Approach |
|---|----------------|-----------------|
| 1 | Ignoring relationships | Use graph analytics |
| 2 | Only using rules | Combine with ML |
| 3 | No real-time detection | Implement streaming |
| 4 | High false positives | Tune thresholds |
| 5 | No explainability | Document decisions |
| 6 | Static rules | Regular updates |
| 7 | Not linking fraud events | Connect patterns |
| 8 | No investigation workflow | Define response |

---

![Fraud Detection Graph](/images/tutorials/gcpdatamodeling/ch23-fraud-detection-graph.png)

**Prompt:** Create a fraud detection graph diagram showing suspicious patterns and connections. Use a 6-node structure with purple gradient theme:

**Node 1: Customer A (Top Left) - Purple #E1BEE7**
- Label: ":Customer"
- Name: "John Smith"
- Properties: risk_score: 0.85, fraud_risk: "High"
- Icon: 👤
- Highlight: Red border (Suspicious)

**Node 2: Customer B (Top Right) - Purple #CE93D8**
- Label: ":Customer"
- Name: "Jane Doe"
- Properties: risk_score: 0.20, fraud_risk: "Low"
- Icon: 👤
- Highlight: Normal

**Node 3: Account A (Center Left) - Purple #AB47BC**
- Label: ":Account"
- Account: "A001"
- Properties: balance: 150000.00, flagged: true
- Icon: 💳
- Highlight: Red border (Flagged)

**Node 4: Account B (Center Right) - Purple #7B1FA2**
- Label: ":Account"
- Account: "A002"
- Properties: balance: 50000.00
- Icon: 💳
- Highlight: Normal

**Node 5: Merchant (Bottom Center) - Purple #4A148C**
- Label: ":Merchant"
- Name: "Offshore Holdings"
- Properties: category: "Financial", flagged: true
- Icon: 🏪
- Highlight: Red border (Flagged)

**Node 6: Transaction (Bottom) - Purple #311B92**
- Label: ":Transaction"
- Amount: 50000.00
- Date: 2024-01-15
- Icon: 💰
- Highlight: Red (Suspicious)

**Relationships:**
- Customer A → Account A: OWNS (Suspicious) - Red dashed
- Customer A → Account B: OWNS (Normal) - Green
- Customer B → Account B: OWNS (Normal) - Green
- Account A → Transaction: HAS_TRANSACTION - Red
- Transaction → Merchant: WITH_MERCHANT - Red
- Customer A → Customer B: ASSOCIATED_WITH (Suspected Money Mule) - Red dashed

**Visual Elements:**
- Fraud ring highlighted with dashed red circle
- Suspicious pattern with bold red arrows
- Risk scores displayed
- Amounts on transactions
- Warning icons on flagged nodes

At bottom: Key takeaway: "Graph databases reveal hidden fraud rings and suspicious patterns invisible to traditional systems." Footer tags: Fraud Detection, Graph, Suspicious, Banking. Enterprise-style clean layout with rounded corners.

---

![Fraud Detection Pipeline](/images/tutorials/gcpdatamodeling/ch23-fraud-detection-pipeline.png)

**Prompt:** Create a fraud detection pipeline diagram showing the end-to-end process. Use a 5-layer structure with purple gradient theme:

**Layer 1: Data Sources (Top) - Purple #E1BEE7**
- Transaction Events, Customer Data, Account Data, Merchant Data, External Data
- Icons for each source
- Description: "Real-time data streams"

**Layer 2: Feature Extraction - Purple #CE93D8**
- Statistical Features: amount, frequency, velocity
- Behavioral Features: patterns, history, preferences
- Network Features: connections, centrality, relationships
- Icons for feature types
- Description: "Feature engineering for fraud detection"

**Layer 3: Detection Layer - Purple #AB47BC**
- Rule Engine: Thresholds, blacklists, patterns
- ML Models: Isolation Forest, Autoencoders, GNN
- Graph Analysis: Community detection, centrality, path analysis
- Icons for detection methods
- Description: "Fraud detection algorithms"

**Layer 4: Risk Scoring - Purple #7B1FA2**
- Risk Score Calculation, Priority Assignment, Confidence Scoring
- Icons for scoring
- Description: "Risk assessment and prioritization"

**Layer 5: Actions (Bottom) - Purple #4A148C**
- Real-time Alerts, Transaction Blocking, Case Creation, Customer Notification
- Icons for actions
- Description: "Immediate response actions"

Use downward arrows between layers. Include timing labels (Sub-second). At bottom: Key takeaway: "End-to-end fraud detection pipeline enables real-time identification and prevention." Footer tags: Fraud Detection, Pipeline, Real-Time, Prevention. Enterprise-style clean layout with rounded corners.

---

![Money Laundering Detection](/images/tutorials/gcpdatamodeling/ch23-money-laundering-detection.png)

**Prompt:** Create a money laundering detection diagram showing the flow of funds through suspicious entities. Use a 5-node structure with purple gradient theme:

**Node 1: Source Customer (Left) - Purple #E1BEE7**
- Label: ":Customer"
- Name: "Source Entity"
- Icon: 👤
- Highlight: Normal

**Node 2: Layer 1 Account (Center Left) - Purple #CE93D8**
- Label: ":Account"
- Account: "A001"
- Properties: balance: 100000.00
- Icon: 💳
- Highlight: Yellow (Suspicious)

**Node 3: Layer 2 Account (Center) - Purple #AB47BC**
- Label: ":Account"
- Account: "A002"
- Properties: balance: 95000.00
- Icon: 💳
- Highlight: Orange (Suspicious)

**Node 4: Layer 3 Account (Center Right) - Purple #7B1FA2**
- Label: ":Account"
- Account: "A003"
- Properties: balance: 90000.00
- Icon: 💳
- Highlight: Red (Suspicious)

**Node 5: Destination Customer (Right) - Purple #4A148C**
- Label: ":Customer"
- Name: "Destination Entity"
- Icon: 👤
- Highlight: Normal

**Money Flow:**
- Source Customer → Account A: TRANSFER {amount: 100000.00} - Blue
- Account A → Account B: TRANSFER {amount: 95000.00} - Blue dashed
- Account B → Account C: TRANSFER {amount: 90000.00} - Blue dashed
- Account C → Destination Customer: TRANSFER {amount: 85000.00} - Blue dashed

**Suspicious Indicators:**
- Amount decreasing by 5% each transfer (layering)
- Multiple transfers within same day
- Accounts opened recently
- No business relationship between entities

At bottom: Key takeaway: "Money laundering detection identifies layering patterns and suspicious fund flows." Footer tags: Money Laundering, AML, Suspicious, Banking. Enterprise-style clean layout with rounded corners.

---

## Interview Questions

1. How do graph databases help with fraud detection?

2. What are the common fraud patterns in banking?

3. How do you detect fraud rings using graphs?

4. What is money laundering and how is it detected?

5. How do you implement real-time fraud detection?

6. What graph algorithms are used for fraud detection?

7. How do you balance false positives and false negatives?

8. What is community detection and how does it help?

9. How do you identify suspicious transactions?

10. What is the role of ML in fraud detection?

11. How do you handle evolving fraud patterns?

12. What are the challenges in fraud detection?

---

## Practice Exercises

1. Design a fraud detection graph model.

2. Implement suspicious customer detection queries.

3. Build fraud ring detection with Cypher.

4. Create real-time fraud detection pipeline.

5. Implement money laundering detection.

6. Apply community detection algorithms.

7. Visualize fraud networks.

8. Build anomaly detection queries.

9. Implement streaming fraud detection.

10. Design fraud alerting system.

---

## Key Takeaways

| # | Takeaway |
|---|----------|
| 1 | Graph databases excel at fraud detection |
| 2 | Fraud is about relationships and patterns |
| 3 | Graph analytics reveals hidden connections |
| 4 | Real-time detection is critical |
| 5 | Combine rules, ML, and graph analytics |
| 6 | Money laundering follows predictable patterns |
| 7 | Visualization aids investigation |
| 8 | Continuous monitoring and adaptation |

---

## Chapter Summary

In this chapter, you learned:

- ✅ Fraud detection patterns in banking
- ✅ Graph-based fraud detection
- ✅ Fraud ring detection
- ✅ Money laundering detection
- ✅ Relationship analytics
- ✅ Graph algorithms for fraud
- ✅ Real-time detection pipelines
- ✅ Best practices and common mistakes

You now understand how to implement comprehensive graph-based fraud detection and relationship analytics systems.

---

## Next Chapter

👉 **Next Chapter: AI-Ready Data Modeling**

---

**End of Chapter 23**

---

## Diagram Prompts Summary

### Diagram 1: Fraud Detection Graph
**Filename:** `ch23-fraud-detection-graph.png`

**Prompt:**
> Create a fraud detection graph diagram showing suspicious patterns and connections. Use a 6-node structure with purple gradient theme. Node 1: Customer A (Top Left) - Purple #E1BEE7 with Label ":Customer", Name "John Smith", Properties: risk_score: 0.85, fraud_risk: "High", Icon 👤, Highlight: Red border (Suspicious). Node 2: Customer B (Top Right) - Purple #CE93D8 with Label ":Customer", Name "Jane Doe", Properties: risk_score: 0.20, fraud_risk: "Low", Icon 👤, Highlight: Normal. Node 3: Account A (Center Left) - Purple #AB47BC with Label ":Account", Account "A001", Properties: balance: 150000.00, flagged: true, Icon 💳, Highlight: Red border (Flagged). Node 4: Account B (Center Right) - Purple #7B1FA2 with Label ":Account", Account "A002", Properties: balance: 50000.00, Icon 💳, Highlight: Normal. Node 5: Merchant (Bottom Center) - Purple #4A148C with Label ":Merchant", Name "Offshore Holdings", Properties: category: "Financial", flagged: true, Icon 🏪, Highlight: Red border (Flagged). Node 6: Transaction (Bottom) - Purple #311B92 with Label ":Transaction", Amount: 50000.00, Date: 2024-01-15, Icon 💰, Highlight: Red (Suspicious). Relationships: Customer A → Account A: OWNS (Suspicious) Red dashed, Customer A → Account B: OWNS (Normal) Green, Customer B → Account B: OWNS (Normal) Green, Account A → Transaction: HAS_TRANSACTION Red, Transaction → Merchant: WITH_MERCHANT Red, Customer A → Customer B: ASSOCIATED_WITH (Suspected Money Mule) Red dashed. Visual Elements: Fraud ring highlighted with dashed red circle, Suspicious pattern with bold red arrows, Risk scores displayed, Amounts on transactions, Warning icons on flagged nodes. At bottom: Key takeaway. Footer tags: Fraud Detection, Graph, Suspicious, Banking. Enterprise-style clean layout.

### Diagram 2: Fraud Detection Pipeline
**Filename:** `ch23-fraud-detection-pipeline.png`

**Prompt:**
> Create a fraud detection pipeline diagram showing the end-to-end process. Use a 5-layer structure with purple gradient theme. Layer 1: Data Sources (Top) - Purple #E1BEE7 with Transaction Events, Customer Data, Account Data, Merchant Data, External Data. Icons for each source. Description: "Real-time data streams". Layer 2: Feature Extraction - Purple #CE93D8 with Statistical Features (amount, frequency, velocity), Behavioral Features (patterns, history, preferences), Network Features (connections, centrality, relationships). Icons for feature types. Description: "Feature engineering for fraud detection". Layer 3: Detection Layer - Purple #AB47BC with Rule Engine (Thresholds, blacklists, patterns), ML Models (Isolation Forest, Autoencoders, GNN), Graph Analysis (Community detection, centrality, path analysis). Icons for detection methods. Description: "Fraud detection algorithms". Layer 4: Risk Scoring - Purple #7B1FA2 with Risk Score Calculation, Priority Assignment, Confidence Scoring. Icons for scoring. Description: "Risk assessment and prioritization". Layer 5: Actions (Bottom) - Purple #4A148C with Real-time Alerts, Transaction Blocking, Case Creation, Customer Notification. Icons for actions. Description: "Immediate response actions". Use downward arrows between layers. Include timing labels (Sub-second). At bottom: Key takeaway. Footer tags: Fraud Detection, Pipeline, Real-Time, Prevention. Enterprise-style clean layout.

### Diagram 3: Money Laundering Detection
**Filename:** `ch23-money-laundering-detection.png`

**Prompt:**
> Create a money laundering detection diagram showing the flow of funds through suspicious entities. Use a 5-node structure with purple gradient theme. Node 1: Source Customer (Left) - Purple #E1BEE7 with Label ":Customer", Name "Source Entity", Icon 👤, Highlight Normal. Node 2: Layer 1 Account (Center Left) - Purple #CE93D8 with Label ":Account", Account "A001", Properties: balance: 100000.00, Icon 💳, Highlight Yellow (Suspicious). Node 3: Layer 2 Account (Center) - Purple #AB47BC with Label ":Account", Account "A002", Properties: balance: 95000.00, Icon 💳, Highlight Orange (Suspicious). Node 4: Layer 3 Account (Center Right) - Purple #7B1FA2 with Label ":Account", Account "A003", Properties: balance: 90000.00, Icon 💳, Highlight Red (Suspicious). Node 5: Destination Customer (Right) - Purple #4A148C with Label ":Customer", Name "Destination Entity", Icon 👤, Highlight Normal. Money Flow: Source Customer → Account A: TRANSFER {amount: 100000.00} Blue, Account A → Account B: TRANSFER {amount: 95000.00} Blue dashed, Account B → Account C: TRANSFER {amount: 90000.00} Blue dashed, Account C → Destination Customer: TRANSFER {amount: 85000.00} Blue dashed. Suspicious Indicators: Amount decreasing by 5% each transfer (layering), Multiple transfers within same day, Accounts opened recently, No business relationship between entities. At bottom: Key takeaway. Footer tags: Money Laundering, AML, Suspicious, Banking. Enterprise-style clean layout with rounded corners.