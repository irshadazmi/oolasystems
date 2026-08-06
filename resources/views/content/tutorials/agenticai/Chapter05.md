```markdown
# Chapter 5: Multi-Agent Systems

---

In the previous chapter, we explored workflow thinking and how to design intelligent, adaptive workflows that combine AI agents with business processes. We learned how to orchestrate sequences of tasks, handle errors, and incorporate human‑in‑the‑loop patterns. However, we focused primarily on workflows where a single agent or a central orchestrator manages the entire process.

In real‑world enterprise environments, complex business problems often require the collaboration of multiple specialised agents. No single agent can possess all the knowledge, skills, or permissions needed to handle every aspect of a banking operation. This is where **multi‑agent systems** come into play.

Multi‑agent systems consist of multiple autonomous agents that interact, coordinate, and collaborate to achieve individual or shared goals. By dividing complex tasks among specialised agents, organisations can build systems that are more scalable, flexible, resilient, and capable of handling diverse and evolving requirements.

In this chapter, we will explore the foundations of multi‑agent systems, including why they are needed, how agents communicate and coordinate, and how to design effective multi‑agent architectures. We will continue using the banking domain to ground our examples, with a focus on fraud detection, loan processing, and customer service scenarios that require multiple agents working together.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Explain the rationale for multi‑agent systems and when to use them
- Design multi‑agent architectures with clear roles and responsibilities
- Understand agent communication protocols and message passing
- Differentiate between cooperative and competitive agent interactions
- Implement handoff patterns for seamless agent collaboration
- Apply consensus and conflict resolution mechanisms in multi‑agent systems
- Recognise common multi‑agent patterns in banking and financial services
- Design a complete multi‑agent system for a banking use case

---

# Why Multi-Agent Systems?

While single agents are powerful, they have inherent limitations that become apparent in complex enterprise environments.

---

## Limitations of Single Agents

**1. Knowledge Boundaries** – A single agent cannot be an expert in every domain. Banking involves diverse areas: fraud detection, credit assessment, regulatory compliance, customer service, and more. A single agent trained on all these domains would be either too large, too slow, or insufficiently specialised.

**2. Scalability Constraints** – As the workload grows, a single agent becomes a bottleneck. Processing thousands of transactions, handling millions of customer queries, or managing complex multi‑step processes requires parallelisation that a single agent cannot provide.

**3. Security and Permissions** – In banking, different systems and data have different access controls. A single agent with access to everything is a security risk. Different agents can be granted different permissions based on their roles.

**4. Resilience** – A single agent is a single point of failure. If it crashes or becomes unavailable, the entire system stops. Multiple agents provide redundancy and fault tolerance.

**5. Complexity** – As more capabilities are added to a single agent, it becomes increasingly complex to develop, test, deploy, and maintain. Modularisation into specialised agents makes the system more manageable.

---

## Benefits of Multi-Agent Systems

| Benefit | Description |
|---------|-------------|
| **Specialisation** | Each agent focuses on a specific domain, becoming more effective and efficient. |
| **Scalability** | Workload can be distributed across multiple agents running in parallel. |
| **Flexibility** | Agents can be added, removed, or updated independently without affecting the whole system. |
| **Resilience** | Failure of one agent does not bring down the entire system. |
| **Security** | Agents can have limited permissions, reducing the attack surface. |
| **Modularity** | Each agent can be developed, tested, and deployed independently. |
| **Collaboration** | Agents can combine their expertise to solve problems that no single agent could handle alone. |

---

## Banking Analogy

Think of a bank's operations:

- **Customer Service** handles client interactions
- **Fraud Department** monitors and investigates suspicious activity
- **Underwriting** assesses loan applications
- **Compliance** ensures regulatory adherence
- **Risk Management** oversees overall portfolio risk

Each department has specialised expertise, tools, and permissions. They work together to serve customers and protect the bank. Similarly, in a multi‑agent system, each agent plays a role analogous to these departments, collaborating to achieve business outcomes.

---

# Multi-Agent System Architecture

A multi‑agent system (MAS) consists of multiple agents that interact through a shared environment. Understanding the architecture is crucial for designing effective systems.

![Multi-Agent System Architecture](/images/tutorials//agenticai/ch05-mas-architecture.png)

*Diagram Placeholder 1: Multi-Agent System Architecture*

---

## Core Components

### 1. Individual Agents

Each agent is an autonomous entity with its own:

- **Knowledge Base** – Domain-specific information and rules
- **Reasoning Engine** – Decision-making capabilities
- **Action Capabilities** – Ability to perform tasks and invoke services
- **Communication Interface** – Ability to send and receive messages

**Banking Example:** A Credit Assessment Agent that specialises in evaluating creditworthiness using credit scores, income data, and employment history.

---

### 2. Communication Infrastructure

Agents need a way to exchange information. This includes:

- **Message Bus** – A middleware that routes messages between agents (e.g., Kafka, RabbitMQ)
- **Message Formats** – Structured formats for communication (e.g., JSON, XML, FIPA ACL)
- **Protocols** – Rules for how agents exchange messages (e.g., request-response, publish-subscribe)

**Banking Example:** Agents publish events to a Kafka topic; other agents subscribe to relevant events.

---

### 3. Coordination Mechanisms

Agents need to coordinate their actions to avoid conflicts and ensure progress:

- **Orchestrator Agent** – A central agent that coordinates the workflow
- **Shared Blackboard** – A common repository where agents can read and write information
- **Distributed Consensus** – Mechanisms for agents to agree on decisions

**Banking Example:** An Orchestrator Agent coordinates a loan application: it calls the Credit Assessment Agent, then the Fraud Detection Agent, then the Compliance Agent, and finally makes a decision.

---

### 4. Environment

The environment includes all external systems, data sources, and services that agents interact with:

- **Databases** – Customer information, transaction data, account data
- **External APIs** – Credit bureaus, payment networks, regulatory systems
- **User Interfaces** – Web portals, mobile apps, branch systems
- **Human Agents** – Bank employees who provide oversight or handle escalations

**Banking Example:** A Fraud Detection Agent queries the transaction database, calls an external fraud scoring API, and updates the customer service portal with alerts.

---

## Interaction Patterns

Agents can interact in several ways, depending on the nature of the task and the relationship between agents.

---

### 1. Direct Communication

Agents send messages directly to each other.

**Banking Example:** A Customer Service Agent sends a query to the Account Information Agent to retrieve a customer's balance.

```text
Agent A → Message → Agent B
```

**Pros:** Simple, fast, low overhead.
**Cons:** Agents need to know about each other; tight coupling.

---

### 2. Publish-Subscribe

Agents publish events to a topic, and other agents subscribe to events they are interested in.

**Banking Example:** A Transaction Processing Agent publishes a "transaction‑completed" event; the Fraud Detection Agent subscribes to it and runs its checks.

```text
Publisher → Topic → Subscribers
```

**Pros:** Decoupled, scalable, flexible.
**Cons:** No guaranteed delivery; complex to debug.

---

### 3. Shared Blackboard

Agents read from and write to a shared repository, without knowing about each other.

**Banking Example:** A Customer Onboarding Workflow uses a shared database. The KYC Agent writes verification results; the Account Creation Agent reads them.

```text
Agent A → Blackboard → Agent B
```

**Pros:** Loose coupling; centralised state.
**Cons:** Single point of failure; may become a bottleneck.

---

### 4. Orchestration

A central orchestrator controls the flow of work, invoking agents as needed.

**Banking Example:** A Loan Origination Orchestrator calls the Document Collection Agent, Credit Assessment Agent, and Underwriting Agent in sequence.

**Pros:** Centralised control; easy to monitor and debug.
**Cons:** Single point of failure; potential bottleneck.

---

# Agent Roles and Responsibilities

In a multi‑agent system, agents are typically assigned specific roles. Defining clear roles is essential for effective collaboration.

---

## Common Agent Roles in Banking

| Role | Responsibility | Example |
|------|----------------|---------|
| **Orchestrator** | Coordinates workflow, delegates tasks, aggregates results | Loan processing orchestrator |
| **Specialist** | Performs specific domain tasks | Credit assessment, fraud detection, document verification |
| **Interface** | Communicates with external systems or users | Customer service agent, API gateway agent |
| **Monitor** | Observes system state and alerts for anomalies | Compliance monitoring agent, risk monitoring agent |
| **Learner** | Updates models and knowledge based on feedback | Model retraining agent, feedback collection agent |
| **Gatekeeper** | Manages access and permissions | Authentication agent, authorisation agent |

---

## Designing Agent Roles

When designing roles for a multi‑agent system, consider:

- **Domain Expertise** – What specific knowledge and skills does the agent need?
- **Data Access** – What data does the agent need to access? What permissions are required?
- **Interactions** – Which other agents does this agent need to communicate with?
- **Autonomy** – How independent should this agent be? Can it make decisions on its own?
- **Scalability** – Can the role be scaled horizontally (e.g., multiple instances)?

**Banking Example:** A Fraud Detection Agent needs access to transaction data, a fraud scoring model, and the ability to block transactions. It interacts with the Alert Agent and the Compliance Agent. It operates autonomously for low‑risk transactions but escalates high‑risk cases.

---

# Communication Protocols

Agents must communicate using well‑defined protocols to ensure interoperability and reliability.

---

## Message Structure

A typical agent message includes:

- **Sender** – Agent identifier
- **Receiver** – Agent identifier (or topic)
- **Message Type** – e.g., request, response, query, notification
- **Content** – The actual data being transmitted
- **Timestamp** – When the message was sent
- **Correlation ID** – To link requests and responses
- **Conversation ID** – To group messages in a conversation

**Banking Example (JSON):**

```json
{
  "sender": "fraud-detection-agent",
  "receiver": "alert-agent",
  "message_type": "notification",
  "correlation_id": "txn-12345",
  "timestamp": "2026-07-30T10:15:00Z",
  "content": {
    "alert_type": "suspicious_transaction",
    "severity": "high",
    "transaction_id": "TXN-98765",
    "amount": 15000,
    "risk_score": 0.92,
    "recommendation": "block_transaction"
  }
}
```

---

## Communication Patterns

### 1. Request-Response

The sender sends a request and expects a response. This is the most common pattern for synchronous interactions.

**Banking Example:** A Customer Service Agent requests account balance from the Account Information Agent and waits for the response.

```text
Agent A → Request → Agent B
Agent A ← Response ← Agent B
```

---

### 2. Query-Reply

Similar to request-response but used for information retrieval. The sender queries a knowledge base and receives a reply.

**Banking Example:** A Compliance Agent queries a regulatory knowledge base for AML rules and receives the relevant rule set.

---

### 3. Publish-Subscribe

The sender publishes an event without knowing who will receive it. Subscribers receive events they are interested in.

**Banking Example:** A Fraud Detection Agent publishes a "fraud‑alert" event; the Alert Agent and Compliance Agent both subscribe.

```text
Agent A → Event → Topic → Agent B, Agent C
```

---

### 4. Broadcast

The sender sends a message to all agents in the system.

**Banking Example:** A System Status Agent broadcasts a "system‑shutdown" notification to all agents.

---

### 5. Negotiation

Agents exchange messages to reach an agreement or resolve a conflict.

**Banking Example:** A Customer Service Agent and a Fraud Detection Agent negotiate whether to approve a transaction when there is conflicting information.

---

# Cooperative vs. Competitive Agents

Agents can interact cooperatively or competitively, depending on whether their goals are aligned.

---

## Cooperative Agents

Agents work together to achieve a shared goal. They share information, coordinate actions, and help each other.

**Banking Example:** In a loan processing system, the Credit Assessment Agent, Document Verification Agent, and Compliance Agent all work together to approve a loan. They share data and coordinate to ensure a complete and accurate assessment.

**Characteristics:**
- Shared goals
- Information sharing
- Mutual assistance
- Conflict resolution through consensus

---

## Competitive Agents

Agents have conflicting or independent goals and may compete for resources or outcomes.

**Banking Example:** Multiple agents may be bidding for compute resources during peak hours, competing for priority. Or, a fraud detection agent and a customer service agent may have conflicting goals—the fraud agent wants to block suspicious transactions, while the customer service agent wants to minimise friction for the customer.

**Characteristics:**
- Conflicting or independent goals
- Limited information sharing
- Competition for resources
- Negotiation and compromise

---

## Hybrid Systems

In practice, most systems are hybrid—agents cooperate on some tasks and compete on others. The key is to design mechanisms that balance cooperation and competition appropriately.

---

# Handoff Patterns

Handoffs occur when one agent transfers a task or conversation to another agent. This is essential for seamless collaboration.

---

## Pattern 1: Escalation Handoff

The current agent escalates to another agent when it cannot handle the task.

**Banking Example:** A Customer Service Agent escalates a complaint to a Customer Resolution Agent when the issue requires special handling.

```text
Agent A → Escalate → Agent B
```

---

## Pattern 2: Delegation Handoff

The current agent delegates a subtask to another agent and continues with other work.

**Banking Example:** A Loan Processing Agent delegates document verification to a Document Verification Agent and proceeds with other steps.

```text
Agent A → Delegate → Agent B → Response → Agent A
```

---

## Pattern 3: Referral Handoff

The current agent refers the user to another agent for specialised assistance.

**Banking Example:** A General Customer Service Agent refers a customer to a Wealth Management Agent for investment advice.

```text
Agent A → Refer → Agent B → User Interaction
```

---

## Pattern 4: Shared Context Handoff

Agents share context so that the receiving agent can continue seamlessly.

**Banking Example:** A customer is transferred from a chatbot to a human agent. The chatbot provides the human agent with the conversation history, customer details, and the current issue.

```text
Agent A → Context + Task → Agent B
```

---

# Consensus and Conflict Resolution

In multi‑agent systems, agents may disagree. Mechanisms are needed to reach consensus or resolve conflicts.

---

## Consensus Mechanisms

### 1. Voting

Agents vote on a decision, and the majority (or weighted majority) decides.

**Banking Example:** Three agents (Credit Assessment, Fraud Detection, Compliance) vote on whether to approve a high‑risk loan. If two out of three vote "approve", the loan is approved.

---

### 2. Weighted Voting

Agents have different weights based on their expertise or reliability.

**Banking Example:** The Credit Assessment Agent has a weight of 0.5 (most important), Fraud Detection 0.3, Compliance 0.2.

---

### 3. Arbitration

A designated mediator (or a senior agent) resolves the conflict.

**Banking Example:** An Underwriting Supervisor Agent reviews the conflicting assessments from the Credit Assessment and Fraud Detection Agents and makes the final decision.

---

### 4. Consensus with Fallback

If consensus cannot be reached, the system escalates to a human.

**Banking Example:** If the agents cannot agree on a loan approval decision, the case is escalated to a human underwriter.

---

## Conflict Resolution Strategies

### 1. Compromise

Agents adjust their positions to reach a mutually acceptable outcome.

**Banking Example:** The Fraud Detection Agent wants to block a transaction; the Customer Service Agent wants to approve it. They compromise: the transaction is approved but flagged for review.

---

### 2. Persuasion

One agent tries to convince another to change its position, using evidence or reasoning.

**Banking Example:** The Credit Assessment Agent provides additional data to convince the Compliance Agent that the applicant is not a money laundering risk.

---

### 3. Escalation

The conflict is escalated to a higher authority (another agent or a human).

**Banking Example:** The agents escalate a disputed transaction to a Fraud Investigator Agent.

---

### 4. Supervised Learning

The agents learn from past conflicts and develop shared models to minimise future disagreements.

**Banking Example:** Over time, the Credit Assessment and Fraud Detection Agents learn to calibrate their scoring so that they are less likely to disagree.

---

# Multi-Agent Patterns in Banking

Several common patterns emerge in banking multi‑agent systems.

---

## Pattern 1: Customer Service Multi‑Agent System

**Agents:**
- **Interface Agent** – Handles initial customer interaction
- **Intent Classifier Agent** – Determines the customer's intent
- **Specialist Agents** – Account Info, Transaction History, Loan Status, Fraud
- **Resolution Agent** – Handles complaints and escalations
- **Learning Agent** – Learns from interactions to improve responses

**Workflow:**
```
Customer → Interface Agent → Intent Classifier → Specialist Agent → Response
```

**Use Case:** A customer contacts the bank via chat with a query. The Interface Agent receives it, the Intent Classifier determines it's a balance inquiry, and the Account Info Agent retrieves and returns the balance.

---

## Pattern 2: Fraud Detection Multi‑Agent System

**Agents:**
- **Transaction Monitor Agent** – Monitors incoming transactions
- **Scoring Agent** – Applies fraud scoring models
- **Rule Engine Agent** – Applies business rules (velocity checks, geography)
- **Alert Agent** – Generates alerts for suspicious activity
- **Investigation Agent** – Gathers evidence and analyses patterns
- **Reporting Agent** – Generates compliance reports (SARs)

**Workflow:**
```
Transaction → Monitor Agent → Scoring Agent + Rule Engine → Alert Agent → Investigation Agent → Reporting Agent
```

**Use Case:** A transaction is processed; the Scoring Agent and Rule Engine Agent evaluate it; if suspicious, the Alert Agent is triggered; the Investigation Agent collects evidence; the Reporting Agent files a SAR.

---

## Pattern 3: Loan Processing Multi‑Agent System

**Agents:**
- **Orchestrator Agent** – Coordinates the entire process
- **Document Collection Agent** – Gathers and validates documents
- **Credit Assessment Agent** – Evaluates creditworthiness
- **Fraud Detection Agent** – Checks for fraud indicators
- **Compliance Agent** – Ensures regulatory compliance
- **Underwriting Agent** – Makes the final decision
- **Notification Agent** – Communicates with the customer

**Workflow:**
```
Application → Orchestrator → Document Collection → Credit Assessment → Fraud Detection → Compliance → Underwriting → Notification
```

**Use Case:** A loan application is processed. The Orchestrator coordinates all the agents, each performing its specialised role, and the Underwriting Agent makes the decision.

---

## Pattern 4: Compliance Multi‑Agent System

**Agents:**
- **Monitor Agent** – Continuously monitors transactions and customer data
- **Screen Agent** – Screens against watchlists and sanction lists
- **Rule Engine Agent** – Applies regulatory rules
- **Alert Agent** – Generates alerts for potential violations
- **Reporting Agent** – Generates regulatory reports
- **Audit Agent** – Maintains audit trails

**Workflow:**
```
Transaction/Customer → Monitor Agent → Screen Agent + Rule Engine → Alert Agent → Reporting Agent → Audit Agent
```

**Use Case:** A new customer is onboarded. The Screen Agent checks watchlists; the Rule Engine applies AML rules; if any violations are found, the Alert Agent is triggered; the Reporting Agent files necessary reports; the Audit Agent logs everything.

---

# Designing a Multi-Agent System for Banking

Let's design a complete multi‑agent system for a banking use case.

---

## Use Case: Customer Onboarding with Fraud and Compliance

**Business Goal:** Onboard new customers quickly while detecting fraud and ensuring compliance.

**Agents:**

1. **Orchestrator Agent** – Coordinates the entire onboarding process.
2. **Customer Interface Agent** – Collects customer information and documents.
3. **Document Verification Agent** – Validates submitted documents (e.g., ID, proof of address).
4. **KYC Screening Agent** – Performs Know Your Customer checks.
5. **Fraud Detection Agent** – Detects potential fraud indicators.
6. **Compliance Agent** – Ensures regulatory compliance (AML, sanctions).
7. **Account Creation Agent** – Creates the account in the core banking system.
8. **Notification Agent** – Communicates with the customer at each step.
9. **Learning Agent** – Updates models and processes based on outcomes.

**Workflow:**

```text
Customer Submits Data
       ↓
Orchestrator
       ↓
  ┌────┼────┐
  ↓    ↓    ↓
Doc   KYC  Fraud
Verif Screen Detect
  ↓    ↓    ↓
  └────┼────┘
       ↓
Compliance
       ↓
Account Creation
       ↓
Notification
       ↓
Learning
```

**Interaction Details:**

- The Orchestrator Agent sends tasks to the Document Verification, KYC Screening, and Fraud Detection Agents in parallel.
- Each agent returns a result (pass/fail/flag) to the Orchestrator.
- The Orchestrator then invokes the Compliance Agent for a final check.
- If all checks pass, the Orchestrator invokes the Account Creation Agent.
- The Notification Agent informs the customer of the status.
- The Learning Agent collects data on outcomes (e.g., whether onboarded customers later turned out to be fraudulent) and updates models.

---

# Best Practices for Multi-Agent Systems

✅ **Clearly define agent roles and responsibilities** – Each agent should have a well‑defined scope and purpose.

✅ **Design for loose coupling** – Agents should not depend on the internal details of other agents.

✅ **Use standard communication protocols** – This ensures interoperability and easier integration.

✅ **Implement robust error handling** – Agents should handle failures gracefully and not bring down the entire system.

✅ **Monitor agent interactions** – Observability is critical for debugging and optimisation.

✅ **Plan for scalability** – Design agents to be horizontally scalable (multiple instances).

✅ **Secure agent communications** – Use encryption and authentication to protect sensitive data.

✅ **Test the system as a whole** – Individual agents may work fine but interact in unexpected ways.

✅ **Design for graceful degradation** – If an agent fails, the system should continue to function (perhaps with reduced capabilities).

✅ **Implement feedback loops** – Agents should learn from their interactions to continuously improve.

---

# Common Mistakes

❌ **Creating agents that are too large** – Agents that do too much become monolithic and lose the benefits of multi‑agent design.

❌ **Ignoring communication overhead** – Excessive messaging can become a bottleneck.

❌ **Not handling agent failures** – Assuming agents will always work leads to fragile systems.

❌ **Over‑engineering the system** – Adding more agents than necessary increases complexity without benefit.

❌ **Neglecting security** – Agent communications can be intercepted or tampered with.

❌ **Not testing agent interactions** – Testing agents in isolation is not enough; integration testing is essential.

---

# Interview Questions

1. Why are multi‑agent systems important in banking? Give examples.

2. Describe the core components of a multi‑agent system architecture.

3. What are the different interaction patterns in multi‑agent systems? When would you use each?

4. Explain the difference between cooperative and competitive agents. Give banking examples.

5. What are handoff patterns? Describe four types with examples.

6. How do agents reach consensus or resolve conflicts? Describe the mechanisms.

7. Design a multi‑agent system for fraud detection in a bank. Define the agents, their roles, and interactions.

8. What are the benefits and challenges of multi‑agent systems compared to single‑agent systems?

9. How do you ensure security in a multi‑agent system?

10. How would you test a multi‑agent system to ensure it works correctly?

---

# Practice Exercises

1. Design a multi‑agent system for a customer service department. Define the agents, their roles, and the communication protocols.

2. Implement a handoff pattern where a chatbot escalates a complex query to a human agent. Describe the context that needs to be shared.

3. Design a consensus mechanism for three agents (Credit Assessment, Fraud Detection, Compliance) that decide on loan approvals.

4. Draw a complete multi‑agent workflow for a credit card application process, including all agents and interactions.

5. Analyse a banking process of your choice and design a multi‑agent system to automate it. Justify your design decisions.

---

# Key Takeaways

- Multi‑agent systems are essential for complex, large‑scale banking applications that require specialisation, scalability, and resilience.
- A well‑designed multi‑agent architecture includes clearly defined agents, a robust communication infrastructure, and effective coordination mechanisms.
- Agents can interact through direct communication, publish‑subscribe, shared blackboard, or orchestration.
- Roles (orchestrator, specialist, interface, monitor, learner, gatekeeper) help in organising agents.
- Handoff patterns (escalation, delegation, referral, shared context) enable seamless collaboration.
- Consensus and conflict resolution mechanisms (voting, arbitration, compromise, escalation) are needed for agent disagreements.
- Banking patterns like customer service, fraud detection, loan processing, and compliance illustrate multi‑agent design principles.

---

# Chapter Summary

In this chapter, you learned:

- The rationale for multi‑agent systems and their benefits over single agents in banking
- The core components of a multi‑agent system: individual agents, communication infrastructure, coordination mechanisms, and environment
- Different interaction patterns (direct, pub‑sub, blackboard, orchestration) and their trade‑offs
- Common agent roles and how to design them for banking use cases
- Communication protocols and message structures for agent interactions
- Handoff patterns that enable seamless task transfer between agents
- Consensus and conflict resolution mechanisms for handling disagreements
- Common multi‑agent patterns in banking: customer service, fraud detection, loan processing, and compliance
- Best practices and common mistakes in designing multi‑agent systems

You now understand how to design and implement multi‑agent systems that leverage specialisation, collaboration, and coordination to solve complex banking problems. This knowledge prepares you to build systems that are scalable, resilient, and capable of handling the diverse and evolving demands of modern banking. In the next chapter, we will explore agent design patterns—reusable solutions to common problems in agentic AI.