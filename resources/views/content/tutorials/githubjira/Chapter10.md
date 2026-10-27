# Chapter 10: Jira Work Items, Hierarchy and Acceptance Criteria

> **Practical focus:** Make requirements small, testable and ready for delivery.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Create well-structured work items.
- Write testable acceptance criteria.
- Break broad outcomes into actionable tasks.

## 1. Why this topic matters

Clear work items explain what is needed, why it matters and how completion will be verified. Exact hierarchy labels vary by Jira setup.

![From initiative to tasks](/images/tutorials/githubjira/githubjira-work-item-hierarchy.png)

## 2. Core concepts

### Common work-item types

An epic often groups a larger outcome; a story expresses user value; a task describes work; a bug reports unexpected behaviour. The exact hierarchy and issue types depend on project configuration.

### Write acceptance criteria

Criteria should be observable and testable. Avoid statements such as “works well.” Prefer clear expected behaviour and relevant edge cases. Use examples or Given/When/Then format when helpful.

![Definition of acceptance](/images/tutorials/githubjira/githubjira-acceptance-criteria.png)

## 3. Practical model

Teams may use story points, time estimates or another planning approach. Estimates are planning aids, not guarantees. Prioritise by value, urgency, risk and dependencies according to team practice.

![A ready work item](/images/tutorials/githubjira/githubjira-ready-work.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. Clear work items explain what is needed, why it matters and how completion will be verified. Exact hierarchy labels vary by Jira setup.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Create one epic and two stories or equivalent work items.
2. For each story, write acceptance criteria that can be tested without guessing.
3. Add an owner, priority, dependencies and estimate where those fields are available.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `Create work item` | Use the Jira create action available to your role |
| `Link work items` | Connect related, blocked-by or parent/child work where supported |
| `Edit fields` | Update description, assignee, priority and estimate as permitted |
| `Activity/history` | Verify what changed after editing |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. What makes acceptance criteria useful?**

<details><summary>Show answer</summary>They are specific and testable</details>

**2. Why break an epic into smaller items?**

<details><summary>Show answer</summary>To make work actionable and progress visible</details>

**3. Are estimates guarantees?**

<details><summary>Show answer</summary>No, they support planning</details>

## Key takeaways

- Clear work items explain what is needed, why it matters and how completion will be verified. Exact hierarchy labels vary by Jira setup.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 11 — Agile and Scrum Planning in Jira**
