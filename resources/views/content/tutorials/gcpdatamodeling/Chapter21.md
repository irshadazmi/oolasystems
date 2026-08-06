# Chapter 21: Introduction to Graph Databases

---

In the previous chapter, we explored streaming and event modeling and learned how to design data models for real-time processing and event-driven architectures.

In this chapter, we will dive into **Graph Databases**—understanding their unique approach to data modeling, when to use them, and how they complement traditional relational and analytical models.

Using our **Digital Banking Platform** case study, we will explore how graph databases can model complex relationships, detect fraud rings, and power recommendation engines.

---

## 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand graph databases and their purpose
- Differentiate graph databases from relational databases
- Recognize when to use graph vs relational approaches
- Understand property graph and RDF graph models
- Identify graph use cases in banking
- Understand Google Cloud's graph capabilities
- Apply graph database best practices
- Design banking graph models

---

## What is a Graph Database?

A graph database is a **NoSQL database** designed to treat relationships between data as equally important as the data itself, using graph structures for semantic queries.

```text
Graph Database = Nodes (Entities) + Edges (Relationships) + Properties (Attributes)
```

Think of a graph database as:

```text
- A map of connected information
- Relationships are first-class citizens
- Traversing connections is fast and natural
- Perfect for interconnected data
```

---

## Real-World Banking Example

A bank needs to detect fraud rings involving multiple customers and merchants:

```text
Relational Approach:
Customer table → Account table → Transaction table → Merchant table
Multiple joins required
Complex queries for connected fraud patterns

Graph Approach:
Customers connected to Accounts
Accounts connected to Transactions
Transactions connected to Merchants
Traverse connections naturally
Find fraud rings quickly
```

---

## Graph vs Relational Databases

| Aspect | Relational Database | Graph Database |
|--------|---------------------|----------------|
| **Data Model** | Tables, rows, columns | Nodes, edges, properties |
| **Relationships** | Foreign keys, joins | First-class citizens |
| **Query Language** | SQL | Cypher, Gremlin, SPARQL |
| **Performance** | Good for structured data | Excellent for connected data |
| **Schema** | Fixed schema | Flexible schema |
| **Complexity** | Complex joins for deep queries | Simple traversals |
| **Use Case** | Transactional, reporting | Connected data, networks |
| **Banking Use** | Customer master | Fraud detection, recommendations |

---

## Graph Database Models

### Property Graph Model

```text
Most common graph model
Components:
- Nodes (vertices) - Entities
- Edges (relationships) - Connections
- Properties - Attributes on nodes and edges
- Labels - Node types
- Relationship types - Edge types

Banking Example:
Node: Customer {name, age, segment}
Node: Account {type, balance}
Edge: OWNS {since_date}
Edge: TRANSACTED_WITH {amount, date}
```

### RDF Graph Model

```text
Resource Description Framework
Components:
- Subjects (resources)
- Predicates (properties)
- Objects (values or resources)
- Triples (subject-predicate-object)

Banking Example:
(Customer:John) - (hasAccount) -> (Account:A001)
(Account:A001) - (hasBalance) -> (15000)
```

---

## Graph Database Use Cases in Banking

### 1. Fraud Detection

```text
Problem: Identify complex fraud patterns
Graph Solution:
- Connect customers, accounts, transactions, merchants
- Detect money laundering rings
- Find suspicious patterns
- Identify fraud clusters

Banking Example:
- Connected fraud rings
- Money laundering detection
- Account takeover patterns
- Synthetic identity fraud
```

### 2. Customer 360

```text
Problem: Complete view of customer relationships
Graph Solution:
- Connect customers, accounts, products
- Relationship networks
- Referral patterns
- Influencer identification

Banking Example:
- Customer relationship network
- Joint account holders
- Family connections
- Business relationships
```

### 3. Anti-Money Laundering (AML)

```text
Problem: Detect suspicious money movements
Graph Solution:
- Track money flow patterns
- Identify suspicious structures
- Find hidden relationships
- Compliance reporting

Banking Example:
- Money laundering detection
- Beneficial ownership
- Shell company identification
- Transaction pattern analysis
```

### 4. Recommendation Systems

```text
Problem: Suggest relevant products
Graph Solution:
- Customer preferences
- Product connections
- Similar customer segments
- Purchase patterns

Banking Example:
- Product recommendations
- Cross-selling opportunities
- Customer segment analysis
- Personalized offers
```

---

## Graph Database Concepts

### Nodes (Vertices)

```text
Definition: Entities in a graph
Purpose: Store entity information
Characteristics:
- Have labels (types)
- Have properties (attributes)
- Can have multiple labels
- Unique identifiers

Banking Examples:
- Customer Node (label: Customer)
- Account Node (label: Account)
- Transaction Node (label: Transaction)
- Merchant Node (label: Merchant)
```

### Edges (Relationships)

```text
Definition: Connections between nodes
Purpose: Define relationships
Characteristics:
- Have types (relationship types)
- Have properties (attributes)
- Are directional or undirected
- Can connect any nodes

Banking Examples:
- OWNS (Customer → Account)
- TRANSACTED_WITH (Account → Merchant)
- PART_OF (Transaction → Account)
- REFERRED (Customer → Customer)
```

### Properties

```text
Definition: Attributes of nodes and edges
Purpose: Store descriptive data
Characteristics:
- Key-value pairs
- Various data types
- Flexible schema
- Can be indexed

Banking Examples:
- Customer: {name, age, segment}
- Account: {type, balance, status}
- OWNS Edge: {since_date, is_primary}
```

---

## Cypher Query Language (Neo4j)

### Basic Cypher Queries

```cypher
-- Creating nodes
CREATE (c:Customer {
  customer_id: 'C001',
  name: 'John Doe',
  segment: 'Premium',
  age: 35
})

-- Creating relationships
MATCH (c:Customer {customer_id: 'C001'})
CREATE (a:Account {
  account_id: 'A001',
  type: 'Savings',
  balance: 15000
})
CREATE (c)-[:OWNS {since_date: '2020-01-01'}]->(a)

-- Querying nodes
MATCH (c:Customer {segment: 'Premium'})
RETURN c.name, c.age

-- Querying relationships
MATCH (c:Customer)-[:OWNS]->(a:Account)
WHERE a.balance > 10000
RETURN c.name, a.balance

-- Finding paths (Fraud Detection)
MATCH path = (c1:Customer)-[:OWNS]->(a:Account)
            -[:TRANSACTED_WITH]->(m:Merchant)
            <-[:TRANSACTED_WITH]-(a2:Account)
            <-[:OWNS]-(c2:Customer)
WHERE c1 <> c2
RETURN path
```

---

## Google Cloud Graph Services

### Neo4j on Google Cloud

```text
Neo4j is a leading graph database
Available on Google Cloud Marketplace
Options:
- Neo4j Enterprise (Production)
- Neo4j Community (Development)
- Neo4j Aura (Managed cloud)

Key Features:
- ACID transactions
- Cypher query language
- High performance
- Scalable architecture
```

### BigQuery Graph Analytics

```text
BigQuery supports graph analytics via:
- SQL-based graph queries
- Recursive CTEs
- Graph algorithms
- Integration with third-party tools

Example: Graph analysis in BigQuery
WITH RECURSIVE customer_network AS (
  SELECT customer_id, name, 1 AS depth
  FROM customers
  WHERE customer_id = 'C001'
  UNION ALL
  SELECT c.customer_id, c.name, n.depth + 1
  FROM customers c
  JOIN customer_relationships r ON c.customer_id = r.related_customer_id
  JOIN customer_network n ON r.customer_id = n.customer_id
  WHERE n.depth < 3
)
SELECT * FROM customer_network;
```

---

![Graph Database Concepts](/images/tutorials/gcpdatamodeling/ch21-graph-database-concepts.png)

**Prompt:** Create a graph database concepts diagram showing nodes, edges, and properties. Use a 4-section structure with purple gradient theme:

**Section 1: Nodes (Top Left) - Purple #E1BEE7**
- Title: "Nodes - Entities"
- Icon: ⚪
- Definition: "Entities in a graph"
- Characteristics: Have labels (types), Have properties (attributes), Can have multiple labels, Unique identifiers
- Banking Example: "Customer Node {name, age, segment}"
- Visual: Circle with label "Customer"

**Section 2: Edges (Top Right) - Purple #CE93D8**
- Title: "Edges - Relationships"
- Icon: 🔗
- Definition: "Connections between nodes"
- Characteristics: Have types, Have properties, Directional, Connect any nodes
- Banking Example: "OWNS {since_date, is_primary}"
- Visual: Arrow connecting two nodes

**Section 3: Properties (Bottom Left) - Purple #AB47BC**
- Title: "Properties - Attributes"
- Icon: 📋
- Definition: "Attributes of nodes and edges"
- Characteristics: Key-value pairs, Various data types, Flexible schema, Can be indexed
- Banking Example: "Customer: {name, age, segment}"
- Visual: Property list with key-value pairs

**Section 4: Graph Structure (Bottom Right) - Purple #7B1FA2**
- Title: "Graph Structure - Connections"
- Icon: 🌐
- Description: "Connected data network"
- Visual: Network of connected nodes
- Banking Example: "Customer → Account → Transaction → Merchant"

At bottom: Key takeaway: "Graph databases treat relationships as first-class citizens, enabling powerful connected data analytics." Footer tags: Graph Database, Nodes, Edges, Properties. Enterprise-style clean layout with rounded corners.

---

## Graph Modeling Patterns

### Pattern 1: Simple Relationship

```cypher
-- Customer owns Account
(Customer) -[:OWNS]-> (Account)
```

### Pattern 2: Path with Multiple Relationships

```cypher
-- Customer → Account → Transaction → Merchant
(Customer) -[:OWNS]-> (Account) 
          -[:HAS_TRANSACTION]-> (Transaction) 
          -[:WITH_MERCHANT]-> (Merchant)
```

### Pattern 3: Relationship with Properties

```cypher
-- Account Transaction with Amount
(Account) -[:TRANSACTED {amount: 1500, date: '2024-01-15'}]-> (Merchant)
```

### Pattern 4: Hierarchical Structure

```cypher
-- Organization hierarchy
(Branch) -[:PART_OF]-> (Region) -[:PART_OF]-> (Bank)
```

### Pattern 5: Network Structure

```cypher
-- Customer network
(Customer) -[:REFERRED]-> (Customer)
           -[:FAMILY_OF]-> (Customer)
           -[:BUSINESS_PARTNER_OF]-> (Customer)
```

---

## Banking Graph Data Model

### Complete Banking Graph Model

```cypher
-- Create Nodes
CREATE (c:Customer {
  customer_id: 'C001',
  name: 'John Doe',
  email: 'john@email.com',
  segment: 'Premium',
  risk_score: 0.15
})

CREATE (a:Account {
  account_id: 'A001',
  type: 'Savings',
  balance: 15000.00,
  status: 'Active'
})

CREATE (t:Transaction {
  transaction_id: 'TXN001',
  amount: 1500.00,
  date: '2024-01-15',
  type: 'Purchase'
})

CREATE (m:Merchant {
  merchant_id: 'M001',
  name: 'Amazon',
  category: 'Retail'
})

CREATE (b:Branch {
  branch_id: 'B001',
  name: 'Downtown Branch',
  region: 'Northeast'
})

-- Create Relationships
CREATE (c)-[:OWNS {
  since_date: '2020-01-01',
  is_primary: true
}]->(a)

CREATE (a)-[:TRANSACTED {
  amount: 1500.00,
  date: '2024-01-15',
  type: 'Purchase'
}]->(t)

CREATE (t)-[:WITH_MERCHANT]->(m)

CREATE (c)-[:ASSOCIATED_WITH {
  relationship_type: 'Primary'
}]->(b)

-- Fraud Detection Query
MATCH (c1:Customer)-[:OWNS]->(a1:Account)
      -[:TRANSACTED]->(t:Transaction)
      -[:WITH_MERCHANT]->(m:Merchant)
      <-[:WITH_MERCHANT]-(t2:Transaction)
      <-[:TRANSACTED]-(a2:Account)
      <-[:OWNS]-(c2:Customer)
WHERE c1 <> c2
  AND t.date >= '2024-01-01'
RETURN c1.name, c2.name, m.name, t.amount, t2.amount
```

---

## Graph vs Relational Decision Framework

### When to Use Graph Databases

```text
✅ Connected data is central
✅ Relationships are the focus
✅ Queries involve traversals
✅ Schema evolves frequently
✅ Performance on connected queries matters
✅ Complex relationship patterns need detection
✅ Data is highly interconnected

Banking Examples:
- Fraud detection networks
- Customer relationship networks
- Money laundering detection
- Recommendation engines
```

### When Not to Use Graph Databases

```text
❌ Simple data without complex relationships
❌ Mostly transactional workloads
❌ Data is not highly connected
❌ Need for complex aggregations
❌ Team lacks graph expertise

Banking Examples:
- Core banking transactions
- Simple CRUD operations
- Reporting and BI (use relational)
- Archival data
```

### Hybrid Approach

```text
Use Both When:
- Need transaction processing and relationship analytics
- Want best of both worlds
- Can replicate data between systems

Banking Example:
- Relational: Core banking, transactions
- Graph: Fraud detection, recommendations
- Sync between systems as needed
```

---

## Graph Database Best Practices

| # | Best Practice | Banking Example |
|---|---------------|-----------------|
| 1 | Model relationships first | Relationship-centric design |
| 2 | Use descriptive relationship types | OWNS, TRANSACTED_WITH |
| 3 | Keep node properties focused | Customer attributes only |
| 4 | Use indexes for frequent queries | customer_id index |
| 5 | Denormalize when needed | Pre-compute paths |
| 6 | Plan for graph evolution | Flexible schema |
| 7 | Use appropriate graph algorithms | PageRank for influence |
| 8 | Monitor query performance | Profile complex queries |
| 9 | Document graph model | Visual graph diagrams |
| 10 | Implement data quality checks | Validate graph structure |

---

## Common Mistakes

| # | Common Mistake | Better Approach |
|---|----------------|-----------------|
| 1 | Treating graph like relational | Embrace graph thinking |
| 2 | Over-normalizing relationships | Keep relationships simple |
| 3 | No indexes on key properties | Index frequently queried |
| 4 | Complex node properties | Keep focused |
| 5 | Ignoring relationship direction | Use meaningful direction |
| 6 | Not modeling relationships | Model them explicitly |
| 7 | No data quality checks | Validate graph integrity |
| 8 | Using graph for simple data | Use relational instead |
| 9 | Not documenting model | Document thoroughly |
| 10 | Ignoring performance | Profile and optimize |

---

## Interview Questions

1. What is a graph database?

2. How does a graph database differ from a relational database?

3. What are the key components of a graph database?

4. What is a property graph?

5. What is an RDF graph?

6. What is Cypher query language?

7. When would you use a graph database vs a relational database?

8. What are graph use cases in banking?

9. What is the difference between nodes and edges?

10. How do you model relationships in a graph?

11. What is the role of Neo4j in graph databases?

12. How does Google Cloud support graph databases?

---

## Practice Exercises

1. Design a graph model for banking relationships.

2. Create nodes for customers, accounts, and merchants.

3. Define relationships between nodes.

4. Write Cypher queries to find customer connections.

5. Model a fraud detection graph.

6. Query customer relationship networks.

7. Implement a recommendation graph.

8. Use graph algorithms for fraud detection.

9. Model money laundering patterns.

10. Integrate graph data with BigQuery.

---

## Key Takeaways

| # | Takeaway |
|---|----------|
| 1 | Graph databases excel at connected data |
| 2 | Relationships are first-class citizens |
| 3 | Nodes are entities, edges are relationships |
| 4 | Properties provide context |
| 5 | Cypher is the query language for Neo4j |
| 6 | Graph databases are ideal for fraud detection |
| 7 | Use graph for relationship-heavy use cases |
| 8 | Hybrid approaches combine graph and relational |

---

## Chapter Summary

In this chapter, you learned:

- ✅ What graph databases are and their purpose
- ✅ Differences between graph and relational databases
- ✅ Property graph and RDF graph models
- ✅ Key graph concepts (nodes, edges, properties)
- ✅ Cypher query language
- ✅ Graph use cases in banking
- ✅ Google Cloud graph services
- ✅ Best practices and common mistakes

You now understand the fundamentals of graph databases and when to use them for connected data analytics.

---

## Next Chapter

👉 **Next Chapter: Property Graph Modeling**