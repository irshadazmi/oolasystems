# Chapter 08: GitHub Projects and Lightweight Planning

> **Practical focus:** Visualise work, ownership, priority and progress.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Create a lightweight project board.
- Use status, owner and priority fields appropriately.
- Identify blockers and keep work status accurate.

## 1. Why this topic matters

A project board makes work visible, but a board is useful only when its fields and status meanings are clear and maintained.

![A lightweight project board](/images/tutorials/githubjira/githubjira-project-board.png)

## 2. Core concepts

### Board design

Use a small number of statuses with definitions everyone understands. A status should represent the work's actual state, not a desired state.

### Fields and views

Status, owner, priority, target date and milestone can support different questions. Use views that help the team decide what to do next; avoid adding fields no one maintains.

![Useful project fields](/images/tutorials/githubjira/githubjira-project-fields.png)

## 3. Practical model

Large work items hide risk. Break work into smaller deliverables, make blockers visible and avoid moving items to Done until acceptance criteria are met.

![Limit work in progress](/images/tutorials/githubjira/githubjira-work-in-progress.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. A project board makes work visible, but a board is useful only when its fields and status meanings are clear and maintained.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Create a project board for a fictional Student Task Tracker.
2. Add at least six work items, assign owners and set status and priority.
3. Move one item through the workflow and write a short update explaining what changed and what remains blocked.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `gh project list` | List projects if GitHub CLI and permissions support it |
| `gh issue list` | Review open work items |
| `gh issue view <number>` | Inspect a work item's details |
| `git status` | Check whether code work is ready to share |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. Why keep status definitions clear?**

<details><summary>Show answer</summary>To make progress meaningful and consistent</details>

**2. What does work in progress represent?**

<details><summary>Show answer</summary>Items currently being worked on</details>

**3. When should an item be marked Done?**

<details><summary>Show answer</summary>When agreed completion criteria are met</details>

## Key takeaways

- A project board makes work visible, but a board is useful only when its fields and status meanings are clear and maintained.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 9 — Jira Fundamentals and Project Navigation**
