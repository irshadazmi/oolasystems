# Chapter 07: GitHub Issues, Labels and Milestones

> **Practical focus:** Turn bugs and ideas into clear, actionable work.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Create actionable issues.
- Use labels, assignees and milestones consistently.
- Improve issue quality through triage.

## 1. Why this topic matters

An issue should make the problem or request understandable, reproducible and actionable. Labels, assignees and milestones help organise work.

![Issue lifecycle](/images/tutorials/githubjira/githubjira-issue-lifecycle.png)

## 2. Core concepts

### Write a useful issue

Describe the context, expected behaviour, actual behaviour, reproducible steps and relevant environment. Include screenshots or logs only when appropriate and remove secrets and personal data.

### Triage and labels

Labels can communicate type, priority, area or status. Assignees identify responsibility; milestones group work toward a target. Agree on a small consistent vocabulary so labels remain useful.

![An actionable bug report](/images/tutorials/githubjira/githubjira-good-bug-report.png)

## 3. Practical model

Templates can prompt contributors for required information and reduce back-and-forth. Use a template that fits the project and avoid collecting sensitive data unnecessarily.

![Issue triage board](/images/tutorials/githubjira/githubjira-triage-board.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. An issue should make the problem or request understandable, reproducible and actionable. Labels, assignees and milestones help organise work.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Create one feature request and one bug issue in a practice repository.
2. Add suitable labels, an assignee and a milestone where available.
3. Improve a vague bug report by adding reproduction steps and expected versus actual behaviour.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `gh issue list` | List issues when GitHub CLI is installed and authenticated |
| `gh issue view <number>` | View an issue using GitHub CLI |
| `gh issue create` | Create an issue interactively where supported |
| `git status` | Check local changes before linking development work |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. What information helps reproduce a bug?**

<details><summary>Show answer</summary>Steps, environment, expected and actual results</details>

**2. What does an assignee communicate?**

<details><summary>Show answer</summary>Who is responsible for follow-up</details>

**3. Why use labels consistently?**

<details><summary>Show answer</summary>To classify and filter work reliably</details>

## Key takeaways

- An issue should make the problem or request understandable, reproducible and actionable. Labels, assignees and milestones help organise work.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 8 — GitHub Projects and Lightweight Planning**
