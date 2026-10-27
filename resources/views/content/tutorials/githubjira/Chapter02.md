# Chapter 02: Git Setup, Configuration and Essential Commands

> **Practical focus:** Prepare a safe local workspace and understand Git's basic vocabulary.

---

## Learning objectives

By the end of this chapter, you should be able to:
- Verify Git installation and configure commit identity.
- Explain working tree, staging area, commit and remote.
- Use basic Git inspection commands safely.

## 1. Why this topic matters

Git records repository history through commits. Before collaborating, verify installation and configure the author identity used in commits.

![The Git working cycle](/images/tutorials/githubjira/githubjira-git-lifecycle.png)

## 2. Core concepts

### Install and verify

Use an approved Git installer for your operating system. Verify the installation with `git --version`. Installation steps differ by OS and organisational policy.

### Configure identity

Git commit metadata commonly includes a name and email. Configure a suitable identity with `git config --global user.name` and `git config --global user.email`. Use the identity policy required by your team; do not share private configuration output blindly.

![A safe Git setup](/images/tutorials/githubjira/githubjira-git-setup.png)

## 3. Practical model

The working tree contains current files. The staging area selects changes for the next commit. A commit records a snapshot in repository history. A remote is another repository location used for collaboration.

![Anatomy of a Git command](/images/tutorials/githubjira/githubjira-command-anatomy.png)

## 4. Industry scenario

Scenario: a team is delivering a small feature for a fictional Student Task Tracker. Git records repository history through commits. Before collaborating, verify installation and configure the author identity used in commits.

## 5. Hands-on lab

**Use only your own practice repository and the approved Jira project. Do not use production code, credentials or personal data.**

1. Run `git --version`. If Git is not installed, follow the approved installation guide.
2. Set `user.name` and `user.email` using your course-approved identity, then inspect only those values.
3. Create a practice folder and initialise a repository with `git init`; run `git status`.

### Lab evidence to record

- What you changed or inspected.
- The command or UI action used.
- What you observed and how you verified it.
- Any limitation, blocker or follow-up action.

## 6. Command and action reference

| Command / action | Purpose / safe note |
|---|---|
| `git --version` | Show installed Git version |
| `git config --global user.name "Your Name"` | Set commit author name; replace placeholder |
| `git config --global user.email "you@example.com"` | Set commit author email; replace placeholder |
| `git init` | Create repository metadata in the current directory |
| `git status` | Show current repository state |
| `git help status` | Open help for a command |

> **Safety note:** Command-line examples are illustrative. Replace placeholders with values from your own approved practice environment. Do not paste tokens, passwords, private keys or confidential data into commits, tickets or screenshots.

## 7. Common mistakes and troubleshooting

- **Wrong repository or project:** verify the repository URL, current directory, project name and work-item key before changing anything.
- **Permission denied / action unavailable:** check account access and project or repository permissions; request the appropriate access rather than sharing credentials or bypassing controls.
- **Unexpected Git state:** stop and inspect `git status`, the diff and recent history before trying another command.
- **Missing integration activity:** verify configuration, permissions, repository connection and the team's linking convention; do not assume the integration supports every event.

## 8. Quick-fire knowledge check

**1. What does `git init` do?**

<details><summary>Show answer</summary>Initialises a Git repository</details>

**2. What is the staging area for?**

<details><summary>Show answer</summary>Selecting changes for the next commit</details>

**3. Does `git status` normally modify files?**

<details><summary>Show answer</summary>No, it inspects repository state</details>

## Key takeaways

- Git records repository history through commits. Before collaborating, verify installation and configure the author identity used in commits.
- Keep changes small, status accurate and evidence easy for teammates to inspect.
- Follow approved access, review and security policies.

## Practice extension

Ask a teammate to review your work or inspect a sample project. Identify one improvement to clarity, traceability, test evidence or workflow consistency.

## Next chapter

**Chapter 3 — Repositories, Cloning and Remote Synchronisation**
