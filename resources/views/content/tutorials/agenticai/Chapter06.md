# Chapter 6: Agent Design Patterns

---

In the previous chapter, we explored multi‑agent systems, learning how multiple specialised agents can collaborate to solve complex banking problems. We examined architectures, communication protocols, handoff patterns, and consensus mechanisms. However, we focused on the structural aspects of how agents interact—not on how individual agents reason and act internally.

Now it is time to delve into the **design patterns** that govern the internal behaviour of AI agents. Just as software engineering has reusable patterns (like Singleton, Observer, or Factory) that solve common problems, agentic AI has its own set of proven patterns for structuring agent logic, decision‑making, and interaction with tools and humans.

Agent design patterns provide reusable templates for building agents that are robust, efficient, and maintainable. They encapsulate best practices for handling common challenges such as:

- How to integrate reasoning and action
- How to plan multi‑step tasks
- How to use tools effectively
- How to handle errors and retries
- How to organise multiple agents in a hierarchy

In this chapter, we will survey the most important agent design patterns, explain their mechanics, and provide banking‑specific examples. By the end, you will be able to choose and apply the right pattern for your use case, combining them as needed to build sophisticated banking agents.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Define what an agent design pattern is and why it matters
- Identify and explain the key agent design patterns: Reflection, Tool‑Calling, Chain‑of‑Thought, ReAct, Plan‑and‑Execute, Hierarchical, and Swarm
- Choose the appropriate pattern for a given banking use case
- Implement patterns such as ReAct and Plan‑and‑Execute in a practical setting
- Combine multiple patterns to build complex agents
- Recognise the strengths and limitations of each pattern
- Apply best practices and avoid common pitfalls when using design patterns

---

# What are Agent Design Patterns?

An **agent design pattern** is a reusable architectural blueprint for structuring the internal logic of an AI agent. It defines how the agent:

- Processes inputs (perception)
- Reasons and plans
- Uses tools and external resources
- Handles errors and edge cases
- Learns from feedback

Design patterns abstract away the low‑level details and provide a higher‑level framework that can be adapted to many different domains. They are not rigid implementations but rather guidelines that can be tailored to specific requirements.

**Why use design patterns?**

- **Proven solutions** – They have been tested in real‑world applications and are known to work.
- **Reduced complexity** – They break down complex agent behaviour into manageable steps.
- **Improved maintainability** – They lead to clearer, more modular code.
- **Faster development** – Teams can start from a known pattern rather than reinventing the wheel.
- **Better communication** – Patterns provide a shared vocabulary for discussing agent architecture.

---

## Relationship to Other Patterns

Agent design patterns can be combined and layered. For example:

- A **ReAct** agent can be used as the reasoning engine inside a **Hierarchical** agent.
- A **Plan‑and‑Execute** pattern can use **Tool‑Calling** for subtasks.
- **Reflection** can be added to any pattern to improve output quality.

In banking, you might have a **Hierarchical** agent with a top‑level orchestrator that delegates to **ReAct** agents for subtasks like fraud investigation or document verification.

---

# Overview of Key Agent Design Patterns

Let us survey the major patterns, each with a brief description and a banking use case.

---

## Pattern 1: Reflection / Self‑Correction

**Description:** The agent generates an output, then critiques its own output and revises it based on the critique. This iterative process improves quality and reduces hallucinations.

**Mechanism:** 
1. Generate initial response
2. Evaluate against criteria (e.g., accuracy, completeness, safety)
3. Revise based on evaluation
4. Repeat until satisfactory or until max iterations

**Banking Use Case:** A customer service agent drafts a response to a complex query about mortgage rates, then checks it against policy documents and regulatory guidelines, revising it to ensure compliance before sending.

---

## Pattern 2: Tool‑Calling Agent

**Description:** The agent uses external tools (APIs, databases, calculators) to accomplish tasks. It decides which tool to call, with what parameters, and incorporates the results into its reasoning.

**Mechanism:** 
1. Parse user request
2. Identify required tools and parameters
3. Call tools and collect results
4. Integrate results into response

**Banking Use Case:** A loan agent calls a credit bureau API to fetch a credit score, then calls a document storage API to retrieve uploaded pay stubs, then calls a risk model to compute approval score.

---

## Pattern 3: Chain‑of‑Thought (CoT) Reasoning

**Description:** The agent explicitly generates intermediate reasoning steps before producing a final answer. This improves transparency and accuracy, especially for multi‑step problems.

**Mechanism:** 
1. Present the problem
2. Generate step‑by‑step reasoning
3. Produce final answer based on reasoning

**Banking Use Case:** A wealth management agent explains its investment recommendation by breaking down risk tolerance, asset allocation, market trends, and tax implications step by step.

---

## Pattern 4: ReAct (Reason + Act)

**Description:** This pattern alternates between reasoning steps and acting steps. The agent thinks about what to do, performs an action, observes the result, and thinks again—iteratively until the task is complete.

**Mechanism:** 
- Loop until done:
  1. Reason: decide what to do next (based on current state and history)
  2. Act: take an action (e.g., call an API, query a database, generate a response)
  3. Observe: receive feedback from the environment
  4. Repeat

**Banking Use Case:** A fraud investigation agent: it reasons that it needs to check recent transactions, acts by querying the transaction database, observes the results, reasons that it should also check geolocation, acts by calling a geolocation service, and so on, until it determines if fraud occurred.

---

## Pattern 5: Plan‑and‑Execute

**Description:** The agent first creates a detailed plan (a sequence of steps) and then executes the plan step by step, possibly adapting if failures occur. It separates planning from execution.

**Mechanism:**
1. **Plan**: Decompose the goal into sub‑tasks with dependencies.
2. **Execute**: For each sub‑task, perform actions, monitor progress, and handle errors.
3. **Re‑plan** if needed (e.g., if a step fails or new information emerges).

**Banking Use Case:** A loan processing agent creates a plan: (1) collect documents, (2) verify income, (3) run credit check, (4) assess debt‑to‑income ratio, (5) make decision. It then executes each step, and if income verification fails, it re‑plans to request new documents.

---

## Pattern 6: Hierarchical Agents

**Description:** Agents are organised in a hierarchy, with higher‑level agents (managers, supervisors) delegating tasks to lower‑level agents (workers, specialists). The manager breaks down goals and assigns sub‑tasks, while workers perform specific actions.

**Mechanism:**
- **Manager** receives high‑level goal, decomposes into sub‑goals, and delegates.
- **Workers** execute assigned sub‑goals and report results back.
- The manager may also monitor progress and re‑assign tasks.

**Banking Use Case:** A top‑level "Fraud Supervisor" agent receives an alert and delegates to a "Transaction Analyzer" agent, a "Customer Profiler" agent, and a "Geolocation Checker" agent. It then synthesises their findings to decide if fraud has occurred.

---

## Pattern 7: Swarm / Ensemble

**Description:** Multiple agents (often with different models or strategies) work on the same problem independently, and their outputs are aggregated (e.g., by voting or averaging) to produce a final result. This improves robustness and reduces bias.

**Mechanism:**
- Multiple agents receive the same input.
- Each generates a decision or output.
- An aggregator combines outputs (majority vote, weighted average, etc.) to produce a final answer.

**Banking Use Case:** A credit scoring system uses three different risk models (a linear model, a tree‑based model, and a neural network) as separate agents. They independently score an applicant, and the final score is the average, reducing model‑specific errors.

---

# Choosing the Right Pattern

Choosing the right pattern depends on the nature of the task:

| Pattern | Best Suited For |
|---------|-----------------|
| **Reflection** | Tasks requiring high accuracy and compliance (regulatory responses, report generation) |
| **Tool‑Calling** | Tasks that require external data or actions (retrieving information, updating systems) |
| **Chain‑of‑Thought** | Tasks that require explainability (investment advice, loan decisions) |
| **ReAct** | Tasks that involve dynamic, multi‑step interactions (fraud investigation, customer support) |
| **Plan‑and‑Execute** | Tasks that can be decomposed into a known sequence of steps (loan processing, onboarding) |
| **Hierarchical** | Tasks that require specialisation and coordination (complex workflows with multiple experts) |
| **Swarm** | Tasks where consensus reduces risk (high‑stakes decisions like large loan approvals) |

Often, a combination is used. For example, a hierarchical agent may use ReAct for each worker, and the manager may use Plan‑and‑Execute.

---

# In‑Depth Look at Key Patterns

We will now examine the most important patterns in detail, providing banking examples and implementation guidance.

---

## ReAct Pattern in Detail

ReAct (Reasoning + Acting) is one of the most popular agent patterns because it elegantly interleaves thinking and doing. It is particularly effective for tasks that require gathering information from multiple sources and making decisions based on that information.

![ReAct Pattern](/images/tutorials//agenticai/ch06-react-pattern.png)

*Diagram Placeholder 1: ReAct Pattern*

### Workflow

1. **Observation**: The agent receives the initial input (user query, event, etc.).
2. **Thought**: The agent reasons about the current state and decides what to do next. It may generate a "thought" text describing its reasoning.
3. **Action**: The agent takes an action, which could be:
   - Calling an API to retrieve data
   - Querying a database
   - Searching a knowledge base
   - Asking a clarifying question
   - Generating a partial response
4. **Observation**: The agent receives the result of the action (e.g., API response, search results).
5. **Loop**: Steps 2–4 repeat until the agent has enough information to produce a final answer.
6. **Final Answer**: The agent outputs the final response.

### Banking Example: Fraud Investigation

```
Input: "Investigate transaction TXN-98765 flagged for fraud."

Thought 1: I need to check the transaction details.
Action 1: call transaction_api.get_details(TXN-98765)
Observation 1: Amount $15,000, Merchant "XYZ Corp", Location "NY", Time "2026-07-30T10:15:00Z"

Thought 2: The amount is high and merchant is unfamiliar. I should check the customer's typical spending pattern.
Action 2: call customer_api.get_spending_pattern(customer_id)
Observation 2: Average transaction is $500, rarely exceeds $5,000.

Thought 3: This is unusual. I should also check if the merchant is known for fraud.
Action 3: call fraud_database.check_merchant("XYZ Corp")
Observation 3: Merchant has no prior fraud reports but is newly registered.

Thought 4: There is a moderate risk. I should also verify the customer's location at the time of transaction.
Action 4: call geolocation_api.check(customer_phone, time)
Observation 4: Customer was in California at that time, not NY.

Thought 5: This is clearly fraudulent (customer in different state, unusual amount). I will block the transaction and alert the customer.
Final Answer: Blocked transaction, sent alert, filed SAR.
```

### Advantages

- **Transparent**: The reasoning chain is visible, aiding explainability.
- **Flexible**: Can handle a wide variety of tasks by dynamically choosing actions.
- **Adaptive**: Can adjust based on intermediate results.

### Disadvantages

- **Verbose**: May generate many steps, increasing token usage.
- **Can loop**: May get stuck in loops if not carefully designed with limits.
- **Latency**: Each iteration adds time.

---

## Plan‑and‑Execute Pattern

This pattern separates planning from execution, making it ideal for tasks with a clear sequence of steps. It is often used for workflows that are well‑understood but may require adaptation.

![Plan-and-Execute Pattern](/images/tutorials//agenticai/ch06-plan-execute-pattern.png)

*Diagram Placeholder 2: Plan‑and‑Execute Pattern*

### Workflow

1. **Goal Definition**: The agent receives a high‑level goal.
2. **Planning Phase**: The agent generates a plan—a sequence of sub‑tasks, each with inputs, outputs, and dependencies.
3. **Execution Phase**: The agent executes each sub‑task in order (or in parallel if independent).
4. **Monitoring**: The agent checks results; if a sub‑task fails or yields unexpected results, it may re‑plan.
5. **Completion**: Once all sub‑tasks are done, the agent produces the final outcome.

### Banking Example: Loan Origination

```
Goal: Process a loan application for customer CUST-101, amount $50,000.

Plan:
1. Collect required documents (pay stubs, tax returns, ID).
2. Verify income against pay stubs.
3. Run credit check via bureau API.
4. Calculate debt‑to‑income ratio.
5. Assess risk and make approval decision.
6. Generate offer letter if approved.

Execution:
- Step 1: Call document collection agent to request documents from customer. Wait for upload.
- Step 2: Verify income by comparing numbers on pay stubs with employer‑provided data. (If mismatch, re‑plan: request corrected documents.)
- Step 3: Call credit bureau API; get score 720.
- Step 4: DTI = 28%, within limit.
- Step 5: Risk assessment = low, approve.
- Step 6: Generate offer letter and send.

Re‑planning: If documents are not provided within 48 hours, re‑plan to send a reminder.
```

### Advantages

- **Structured**: The plan provides a clear roadmap, making the process easy to understand and monitor.
- **Efficient**: Can execute steps in parallel where possible.
- **Error‑resilient**: Re‑planning handles failures gracefully.

### Disadvantages

- **Planning overhead**: Generating a good plan can be complex and may require substantial reasoning.
- **Inflexible**: If the domain is highly dynamic, a fixed plan may become outdated quickly.
- **Requires good decomposability**: Not all tasks can be easily broken into discrete steps.

---

## Hierarchical Agents Pattern

Hierarchical agents are a natural extension for complex banking environments where different expertise domains are needed. This pattern mirrors human organisational structures.

![Hierarchical Agents](/images/tutorials//agenticai/ch06-hierarchical-agents.png)

*Diagram Placeholder 3: Hierarchical Agents*

### Structure

- **Top‑level (Manager/Orchestrator)**: Receives high‑level goals, decomposes them, delegates to specialists, and aggregates results.
- **Mid‑level (Supervisors)**: May manage groups of workers for a specific domain.
- **Bottom‑level (Workers)**: Perform concrete actions: call APIs, run models, generate reports.

### Banking Example: Customer Onboarding with Compliance

- **Orchestrator Agent**: Receives the request to onboard a new customer.
- **Delegates to three specialist teams**:
  - **Document Verification Supervisor**: Manages workers to validate ID, proof of address, etc.
  - **KYC/AML Supervisor**: Manages workers to screen against sanctions lists, PEP lists, and run AML checks.
  - **Fraud Detection Supervisor**: Manages workers to run fraud models on the customer's provided data.
- Each supervisor coordinates multiple workers, which may use ReAct or Plan‑and‑Execute.
- The Orchestrator collects all results and makes a final decision.

### Advantages

- **Scalability**: New agents can be added without disrupting existing ones.
- **Specialisation**: Each level can focus on its own responsibilities.
- **Modularity**: Easy to update or replace a sub‑system.

### Disadvantages

- **Complexity**: More moving parts; harder to debug.
- **Communication overhead**: Messages travel up and down the hierarchy.
- **Potential for bottlenecks**: The top‑level orchestrator can become a single point of failure.

---

# Combining Patterns in Practice

In real‑world banking agents, you rarely use a single pattern in isolation. A typical architecture might combine:

- **Hierarchical** structure at the top
- **Plan‑and‑Execute** for managing workflows
- **ReAct** for each worker that needs to interact with dynamic data
- **Reflection** to validate outputs before they are sent to customers
- **Tool‑Calling** as a fundamental ability for all agents

Example: A loan origination system has an Orchestrator (Hierarchical). The Orchestrator uses Plan‑and‑Execute to sequence steps. The Credit Assessment worker uses ReAct to gather data from multiple sources (credit bureaus, internal databases, etc.) and reason about risk. The final decision is then run through a Reflection check to ensure compliance with regulatory policies.

---

# Best Practices for Applying Design Patterns

✅ **Understand the problem domain** before choosing a pattern—different patterns excel in different contexts.

✅ **Start simple**—use the simplest pattern that meets your requirements; you can always add complexity later.

✅ **Combine patterns wisely**—layering patterns can provide powerful capabilities but also increase complexity.

✅ **Limit iterations**—set maximum loops for ReAct to prevent infinite loops and excessive token usage.

✅ **Provide clear tool definitions**—for tool‑calling agents, ensure each tool has a clear name, description, and parameter schema.

✅ **Design for failure**—include fallbacks, timeouts, and retries in execution steps.

✅ **Add observability**—log all thoughts, actions, and observations for debugging and compliance.

✅ **Test with edge cases**—patterns may behave unpredictably with unusual inputs.

✅ **Keep the reasoning chain concise**—encourage the agent to be succinct to reduce token usage.

✅ **Regularly review and update**—patterns may need to evolve as the domain changes.

---

# Common Mistakes

❌ **Using ReAct when a simple tool‑call would suffice** – Overcomplicating simple tasks.

❌ **Not providing enough context in observations** – Agents need rich feedback to reason effectively.

❌ **Ignoring token usage** – ReAct chains can consume large amounts of tokens; monitor costs.

❌ **Hardcoding actions** – Agents should be flexible; avoid fixed action sequences unless using Plan‑and‑Execute.

❌ **Forgetting to handle exceptions** – APIs may fail, data may be missing; plan for these.

❌ **Over‑engineering the hierarchy** – Too many levels of agents can reduce performance.

❌ **Neglecting safety checks** – Ensure agents do not take harmful actions; implement guardrails.

---

# Interview Questions

1. What is an agent design pattern and why is it important?

2. Explain the ReAct pattern and give a banking example.

3. How does Plan‑and‑Execute differ from ReAct? When would you choose one over the other?

4. Describe the Hierarchical pattern and its benefits in banking.

5. What is the Reflection pattern and how can it improve agent outputs?

6. How do you decide which pattern to use for a given banking use case?

7. Can you combine multiple patterns? Give an example.

8. What are the main risks of using ReAct in production, and how can you mitigate them?

9. How do you handle errors in a Plan‑and‑Execute workflow?

10. What is the Swarm pattern and when might it be useful in banking?

---

# Practice Exercises

1. Design a ReAct agent for a customer service scenario where the customer asks about recent transactions and wants to dispute a charge.

2. Create a Plan‑and‑Execute workflow for opening a new savings account, including document collection, identity verification, and initial deposit.

3. Build a hierarchical agent for a fraud detection system: define the top‑level orchestrator, mid‑level supervisors, and workers. Describe their interactions.

4. Implement a Reflection pattern for a loan approval agent: draft a decision, critique it based on regulatory rules, and revise it.

5. Choose a banking process (e.g., credit card application) and identify which patterns would be most suitable. Justify your choices.

---

# Key Takeaways

- Agent design patterns provide reusable templates for structuring agent logic, improving efficiency, maintainability, and reliability.
- Key patterns include Reflection, Tool‑Calling, Chain‑of‑Thought, ReAct, Plan‑and‑Execute, Hierarchical, and Swarm.
- ReAct interleaves reasoning and action, making it suitable for dynamic, information‑gathering tasks.
- Plan‑and‑Execute separates planning from execution, ideal for well‑structured workflows.
- Hierarchical patterns enable specialisation and scalability by organising agents into levels.
- Patterns are often combined to address complex banking requirements.
- Choosing the right pattern requires understanding the task's nature, latency, cost, and explainability needs.

---

# Chapter Summary

In this chapter, you learned:

- The concept and importance of agent design patterns
- Detailed explanations of seven major patterns: Reflection, Tool‑Calling, Chain‑of‑Thought, ReAct, Plan‑and‑Execute, Hierarchical, and Swarm
- How to choose the appropriate pattern for banking use cases
- Banking examples for each pattern, including fraud investigation, loan processing, and customer onboarding
- How patterns can be combined to build sophisticated multi‑agent systems
- Best practices, common mistakes, and practical considerations like token usage and error handling

You now have a toolkit of reusable patterns that you can apply to design robust, efficient, and maintainable agents for banking applications. In the next chapter, we will delve into Responsible AI—ensuring that your agents are fair, transparent, and compliant with ethical and regulatory standards.