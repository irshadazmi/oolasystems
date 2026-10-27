# Chapter 01: Git, GitHub and Jira: Roles and Workflow

> **Practical focus:** Understand the tool boundaries before using them.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Distinguish Git, GitHub and Jira.
- Trace a work item from requirement to reviewed code.
- Explain why links between planning and implementation matter.

## 1. Why this topic matters

Git is the version-control engine; GitHub is a collaboration platform built around Git repositories; Jira is a work-planning and tracking system.

![Git, GitHub and Jira](/images/tutorials/githubjira/githubjira-tool-boundaries.png)

## 2. Core concepts

### Git versus GitHub

Git runs locally and stores repository history. GitHub hosts remote repositories and supports pull requests, issues, reviews, project planning and automation. Git can be used without GitHub; GitHub collaboration commonly relies on Git.

### Jira's role

Jira represents the team's work: requirements, bugs, tasks, owners, priorities and workflow status. Its exact labels and capabilities depend on project configuration and plan.

![From requirement to code](/images/tutorials/githubjira/githubjira-work-item-to-code.png)

## 3. Practical model

A work item can be linked to a branch, commits and a pull request. This relationship helps a reviewer understand why a change exists and helps a team verify whether the work is complete.

![A continuous team loop](/images/tutorials/githubjira/githubjira-team-loop.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. Git is the version-control engine; GitHub is a collaboration platform built around Git repositories; Jira is a work-planning and tracking system.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. For a fictional feature, write a Jira-style story with a user need and acceptance criteria.
2. Name a Git branch for the feature and a clear commit message.
3. Sketch the sequence from story to pull request and identify where review feedback is recorded.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `git --version` | Check Git availability |
| `git status` | Inspect repository state |
| `git log --oneline` | View concise commit history |
| `git branch` | List local branches |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. Can Git work without GitHub?**

<details><summary>Show answer</summary>Yes, Git is a local version-control tool</details>

**2. Where should task ownership and status be tracked?**

<details><summary>Show answer</summary>In the team's Jira workflow</details>

**3. Why link a pull request to a work item?**

<details><summary>Show answer</summary>To provide context and traceability</details>

## Key takeaways

- Git is the version-control engine; GitHub is a collaboration platform built around Git repositories; Jira is a work-planning and tracking system.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 2 — Git Setup, Configuration and Essential Commands**
