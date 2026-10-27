# Chapter 09: Jira Fundamentals and Project Navigation

> **Practical focus:** Understand projects, work items, boards and permissions.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Navigate Jira projects and work items.
- Understand boards, workflows and permissions.
- Inspect work-item history and context.

## 1. Why this topic matters

Jira provides configurable work tracking. Project types, available features and terminology may vary by Jira product, configuration and plan.

![Jira workspace map](/images/tutorials/githubjira/githubjira-jira-workspace.png)

## 2. Core concepts

### Jira building blocks

A project groups work in a team or product context. Work items represent tasks, bugs, stories or other tracked units. Boards show selected work in a workflow view, while reports summarise activity and progress.

### Project types and configuration

Some Jira environments use different project experiences, workflows and administration controls. Follow the course instance and avoid assuming that every account has permission to create projects or change global settings.

![Access and responsibility](/images/tutorials/githubjira/githubjira-jira-permissions.png)

## 3. Practical model

Only users with appropriate permissions can perform particular actions. Use your own account, do not share credentials, and ask a project administrator when a required setting is unavailable.

![A practical navigation loop](/images/tutorials/githubjira/githubjira-jira-navigation.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. Jira provides configurable work tracking. Project types, available features and terminology may vary by Jira product, configuration and plan.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Open the approved Jira environment and inspect the project list or assigned project.
2. Open a work item and identify its key, summary, status, assignee and description.
3. Record the current workflow statuses and determine which actions your account is allowed to perform.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `Jira search` | Use the UI search or configured query language to find work items |
| `Work item key` | Use the issue key shown in the project to identify a work item |
| `Activity/history panel` | Inspect recorded changes when available |
| `Project settings` | View only settings your role is authorised to access |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. What does a Jira project provide?**

<details><summary>Show answer</summary>A context for grouping and managing work</details>

**2. Why might a user not see an administration option?**

<details><summary>Show answer</summary>Their role or permissions may not allow it</details>

**3. What does a board display?**

<details><summary>Show answer</summary>Selected work items arranged by workflow or planning view</details>

## Key takeaways

- Jira provides configurable work tracking. Project types, available features and terminology may vary by Jira product, configuration and plan.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 10 — Jira Work Items, Hierarchy and Acceptance Criteria**
