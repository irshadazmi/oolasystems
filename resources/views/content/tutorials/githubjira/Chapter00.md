# Chapter 00: GitHub and Jira: A Practical Tutorial

> **Practical focus:** From source control to coordinated team delivery.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Explain the roles of Git, GitHub and Jira.
- Describe a basic plan-to-code workflow.
- Set up a safe practice scenario and protect credentials.

## 1. Why this topic matters

GitHub and Jira support different but connected parts of software delivery: Git records changes, GitHub hosts collaboration around code, and Jira organises work and progress.

![The delivery workflow](/images/tutorials/githubjira/githubjira-delivery-overview.png)

## 2. Core concepts

### Why these tools matter

Teams need a reliable record of code changes and a shared view of work. Git provides version history; GitHub adds repository hosting, pull requests and code collaboration; Jira helps teams plan, assign and track work.

### Core vocabulary

A repository stores project files and Git history. A commit records a snapshot of changes. A branch isolates a line of work. A pull request proposes changes for review. A Jira work item records a task, bug, story or other unit of work.

![Who does what?](/images/tutorials/githubjira/githubjira-tool-map.png)

## 3. Practical model

Use small changes, descriptive commits, clear work items, review before merging, and evidence-based status updates. Never place passwords, API tokens, private keys or real personal data in a repository or ticket.

![A safe learning path](/images/tutorials/githubjira/githubjira-learning-path.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. GitHub and Jira support different but connected parts of software delivery: Git records changes, GitHub hosts collaboration around code, and Jira organises work and progress.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Open GitHub and Jira (or the approved equivalents) and inspect their main navigation.
2. Choose a fictional Student Task Tracker project. Write three features and one bug as plain-language work items.
3. Identify where code, review discussion and work status would live; record one sentence per tool.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `git --version` | Check whether Git is installed |
| `git config --list` | Inspect configured Git settings; redact personal details before sharing |
| `git help` | Open Git's help overview |
| `pwd` | Print the current directory |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. Which tool records local version history?**

<details><summary>Show answer</summary>Git</details>

**2. What is the primary role of GitHub in this course?**

<details><summary>Show answer</summary>Repository hosting and code collaboration</details>

**3. What does Jira primarily help a team manage?**

<details><summary>Show answer</summary>Work items, workflow and progress</details>

## Key takeaways

- GitHub and Jira support different but connected parts of software delivery: Git records changes, GitHub hosts collaboration around code, and Jira organises work and progress.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 1 — Git, GitHub and Jira: Roles, Concepts and Team Workflow**
