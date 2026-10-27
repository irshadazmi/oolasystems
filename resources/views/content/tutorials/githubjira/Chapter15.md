# Chapter 15: Team Delivery, Reporting and Operational Practice

> **Practical focus:** Keep work visible, reviewable and ready for handover.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Prepare evidence-based status updates.
- Review issue hygiene and delivery risks.
- Write a clear operational handover.

## 1. Why this topic matters

Healthy delivery combines good issue hygiene, small reviewed changes, reliable status updates and clear evidence of completion.

![A coordinated team delivery loop](/images/tutorials/githubjira/githubjira-team-delivery.png)

## 2. Core concepts

### Issue hygiene

Keep titles specific, owners current, acceptance criteria testable and status accurate. Close or archive stale items according to team policy rather than leaving misleading board data.

### Reporting with evidence

A useful update says what was completed, what remains, what is blocked, why it is blocked, and what action is needed. Link to work items, pull requests and checks where appropriate.

![A useful status update](/images/tutorials/githubjira/githubjira-status-report.png)

## 3. Practical model

A handover should capture context, changes made, validation performed, known risks and the next owner or action. Never include credentials or confidential data in routine ticket comments.

![A reliable handover](/images/tutorials/githubjira/githubjira-handover.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. Healthy delivery combines good issue hygiene, small reviewed changes, reliable status updates and clear evidence of completion.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Review a sample board and identify stale, blocked and unassigned items.
2. Prepare a short status report with completed work, current risk, blocker, owner and next action.
3. Write a handover note for a merged feature with links to the work item and pull request, test evidence and known limitations.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `git status` | Check local work state |
| `git log --oneline -5` | Summarise recent commits |
| `git show --stat` | Inspect a commit's changed-file summary |
| `Issue / PR links` | Provide traceable evidence in the report |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. What should a status update include when work is blocked?**

<details><summary>Show answer</summary>The blocker, impact, owner and requested next action</details>

**2. Why keep ticket status accurate?**

<details><summary>Show answer</summary>To support reliable coordination and reporting</details>

**3. What should never be placed in a handover note?**

<details><summary>Show answer</summary>Passwords, private keys or access tokens</details>

## Key takeaways

- Healthy delivery combines good issue hygiene, small reviewed changes, reliable status updates and clear evidence of completion.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 16 — Three-Hour Hands-On Consolidation Lab**
