# Chapter 11: Agile and Scrum Planning in Jira

> **Practical focus:** Plan a sprint around a goal and a realistic amount of work.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Explain backlog, sprint goal and sprint planning.
- Select ready work based on capacity.
- Use review and retrospective for continuous improvement.

## 1. Why this topic matters

Scrum uses a product backlog, sprint planning, a sprint goal, daily coordination, review and retrospective. Jira can support this workflow when configured for Scrum.

![The Scrum cycle](/images/tutorials/githubjira/githubjira-scrum-cycle.png)

## 2. Core concepts

### Backlog and sprint goal

The backlog is an ordered set of potential work. Sprint planning selects work that supports a sprint goal and fits team capacity. Do not treat the sprint as a list of unrelated tasks.

### Readiness and capacity

Before selecting an item, check that its purpose and acceptance criteria are clear and dependencies are understood. Account for availability and uncertainty instead of filling every hour with planned work.

![A realistic sprint plan](/images/tutorials/githubjira/githubjira-sprint-planning.png)

## 3. Practical model

Daily coordination helps reveal progress and blockers. Sprint review inspects the outcome; retrospective identifies process improvements. Use available Jira reports as signals, not as substitutes for team conversation.

![Shared Scrum responsibilities](/images/tutorials/githubjira/githubjira-scrum-roles.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. Scrum uses a product backlog, sprint planning, a sprint goal, daily coordination, review and retrospective. Jira can support this workflow when configured for Scrum.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Prioritise a small backlog and write a sprint goal.
2. Select a realistic set of ready items and record the reasoning.
3. Simulate a mid-sprint blocker, update the affected work item and describe how the team should respond.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `Backlog view` | Prioritise and prepare work items |
| `Sprint planning` | Select items and record a goal where supported |
| `Board status` | Update progress as work changes |
| `Burndown / reports` | Inspect progress when enabled in the project |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. What should guide sprint selection?**

<details><summary>Show answer</summary>A sprint goal and realistic team capacity</details>

**2. Why check readiness before planning?**

<details><summary>Show answer</summary>To reduce ambiguity and unmanaged dependencies</details>

**3. What is a retrospective for?**

<details><summary>Show answer</summary>Learning and improving how the team works</details>

## Key takeaways

- Scrum uses a product backlog, sprint planning, a sprint goal, daily coordination, review and retrospective. Jira can support this workflow when configured for Scrum.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 12 — Kanban, Workflow and Flow Metrics**
