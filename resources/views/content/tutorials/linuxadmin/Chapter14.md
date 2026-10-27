# Chapter 14 — Linux Security and Hardening Basics

> **Linux Administration • B.Tech Year III • Practical chapter**  
> **Theme:** reduce unnecessary exposure, use least privilege, and verify security controls without disrupting systems.

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain defense in depth, least privilege, and attack surface reduction.
2. Identify basic host-hardening areas: accounts, software updates, services, permissions, and logs.
3. Perform read-only security checks on an approved Linux environment.
4. Explain why configuration changes should be authorized, tested, and reversible.
5. Document findings clearly without exposing credentials or sensitive system information.

## 1. What is Linux hardening?

**Hardening** is the process of reducing a system's exposure to threats by applying appropriate configuration, access, update, monitoring, and recovery controls. It is not a one-time command or a guarantee that a system cannot be compromised. A secure configuration depends on the system's role, the data it handles, operational requirements, and the organization's policy.

Common hardening objectives include:

- remove or disable unneeded services after impact review;
- keep supported software and security updates current;
- use named accounts and least-privilege access;
- restrict access to sensitive files and administrative capabilities;
- protect remote access and network-facing services;
- collect and review useful logs;
- maintain backups and a tested recovery process.

![Linux defense in depth](/images/tutorials/linuxadmin/ch14-linux-defense-in-depth.png)

*Figure 14.1 — Multiple layers of control help prevent, detect, and recover from security problems.*

## 2. Defense in depth

Defense in depth means using complementary controls so that one failed control does not leave the entire system unprotected.

| Layer | Example controls | Questions to ask |
|---|---|---|
| Application | Secure configuration, input validation, supported versions | Is the application configured for its intended role? |
| Identity | Named accounts, strong authentication, least privilege | Who can access the system, and why? |
| Host | Updates, permissions, minimal services | Is the host running only what it needs? |
| Network | Limit exposed services and permitted traffic | Which endpoints must be reachable, and from where? |
| Monitoring and recovery | Logs, review, backups, incident process | Can suspicious activity be detected and recovery performed? |

No one layer replaces the others. For example, a firewall does not correct an unsafe application configuration, and logs do not prevent every incident. Controls should fit the system's purpose and risk.

## 3. Least privilege and account hygiene

Least privilege means giving each user, process, or service only the access required for its approved task. Avoid using a privileged account for ordinary work, sharing accounts, or granting broad access merely to make an error disappear.

![Least-privilege access model](/images/tutorials/linuxadmin/ch14-least-privilege-access-model.png)

*Figure 14.2 — Access should be justified, scoped, approved, and reviewed.*

Useful read-only checks include:

```bash
whoami
id
groups
```

These show the current username, identity and group information, and group memberships. In a controlled lab, inspect only the accounts you are authorized to review.

Security practices:

- use named accounts so actions can be attributed;
- review group membership against the person's role;
- use approved administrative elevation only when needed;
- remove or revise access when responsibilities change;
- protect credentials and never place passwords or private keys in scripts or shared notes.

Do not modify users, groups, or permissions on shared learning systems unless the instructor has explicitly authorized the change.

## 4. Software updates and supported packages

Updates can fix known vulnerabilities and improve reliability. Before applying updates to an operational system, check the support status, approved repositories, dependency changes, application compatibility, maintenance window, and recovery plan.

On Debian/Ubuntu systems, package-query commands may include:

```bash
apt list --upgradable
```

Availability and output vary by distribution and configuration. This command is an inspection example; do not run package installation or upgrade commands on shared or production systems without authorization.

Good update hygiene includes:

- use supported software and trusted repositories;
- review update scope and release notes;
- test changes in a non-production environment when possible;
- preserve a recovery path;
- verify application and service behavior after an approved update.

## 5. Reduce the attack surface

The **attack surface** is the set of ways a system can be reached or influenced. Unneeded services, outdated software, overly broad accounts, exposed ports, and unnecessary features can increase it.

On an approved Linux environment, read-only discovery commands may include:

```bash
ps -ef | head
ss -lntup
```

`ps` gives a process view; `ss` can show listening TCP and UDP sockets. Process details may be restricted. A listening socket does not automatically mean a vulnerability exists, but it is a reason to verify whether the endpoint is expected and appropriately protected.

Before disabling a service, confirm its purpose and dependencies. A service that appears unnecessary may support a critical local function. Do not expose a service to the network or disable a security control as a classroom experiment.

## 6. File access and sensitive data

Linux permissions help control which users can read, write, or execute files. Security review should consider the intended owner, group, access level, and sensitivity of the data. Broad permissions can expose credentials, application configuration, logs, or private user information.

Inspect files you are authorized to access:

```bash
ls -l
```

The output displays permission notation, ownership, and file names for the current directory. It does not by itself show every access control that might apply, such as ACLs, mount options, or application-level authorization.

Safe practices:

- avoid storing secrets in public source repositories or world-readable files;
- do not copy sensitive logs or configuration into public channels;
- use approved secret-management mechanisms where available;
- request access through the proper process rather than changing permissions to bypass a denial;
- follow the organization's data retention and handling rules.

## 7. Network exposure and remote access

Every network-facing service should have a clear purpose, owner, expected clients, and appropriate authentication and authorization. The fact that a service is listening does not mean it should be reachable from every network.

For remote access, follow the principles from **Chapter 09 — Remote Access and Secure File Transfer**:

- verify the server identity;
- use approved authentication;
- keep private keys protected;
- limit account privileges;
- investigate unexpected host-key warnings;
- avoid exposing administrative interfaces to untrusted networks.

For classroom practice, inspect supplied examples or a local lab VM. Do not scan public systems or change firewall rules without explicit authorization.

## 8. Logs, monitoring, and recovery

Security monitoring can help detect unusual logins, repeated authentication failures, unexpected service changes, or application errors. Logs may contain personal information and secrets, so read only what is necessary and redact sensitive details before sharing excerpts.

A hardening plan should also address recovery:

- identify what must be backed up;
- protect backups from unauthorized modification;
- establish retention and access controls;
- periodically test restoration in an approved environment;
- document who is responsible for recovery and incident escalation.

A backup that has never been restored in a test may not be sufficient evidence of recoverability.

## 9. Safe hardening and verification workflow

![Safe Linux hardening workflow](/images/tutorials/linuxadmin/ch14-safe-linux-hardening-workflow.png)

*Figure 14.3 — Discover, assess, apply controlled changes, verify, and document.*

1. **Discover:** identify the system's role, users, services, packages, and relevant configuration.
2. **Assess:** prioritize findings by likelihood, impact, and business need.
3. **Harden:** apply approved changes in a controlled order, preferably in a test environment first.
4. **Verify:** repeat checks and confirm that intended functionality still works.
5. **Document:** record evidence, exceptions, approvals, and recovery steps.

Change one thing at a time when feasible. Keep a record of the original state and a rollback path. Do not blindly copy a hardening checklist designed for another distribution or workload.

## 10. Read-only security check reference

| Command | Brief description | Notes |
|---|---|---|
| `whoami` | Show current username | Confirms current identity |
| `id` | Show UID, GID, and groups | Useful for access-context review |
| `groups` | Show group memberships | Review only your own account unless authorized |
| `ps -ef` | List processes | Use to understand running programs |
| `ss -lntup` | Show listening TCP/UDP sockets | Process details may require extra privileges |
| `ls -l` | Show permissions and ownership in a directory | Inspect only permitted paths |
| `apt list --upgradable` | List upgrade candidates on apt-based systems | Availability varies; does not apply updates |
| `journalctl -p warning -n 50` | Show recent journal entries at warning priority or higher on supported systems | Access and options vary |

These checks do not constitute a full security audit. They provide starting evidence for a defined review scope.

## 11. Hands-on labs

> **Safety boundary:** Use your own WSL2/Ubuntu VM, a disposable lab VM, or instructor-provided sample output. Prefer read-only inspection. Do not change accounts, permissions, firewall rules, services, or system packages on shared or production systems.

### Lab A — Identity and access context (5–10 minutes)

1. Run `whoami`, `id`, and `groups`.
2. Explain the difference between a username, UID, primary group, and supplementary groups.
3. Identify one reason why unnecessary group membership may increase risk.
4. Do not modify any account or group.

**Evidence to submit:** a short summary of the output without sharing personal or sensitive identifiers.

### Lab B — Process and listening-socket review (10 minutes)

1. Run `ps -ef | head`.
2. If available, run `ss -lntup`.
3. Choose one process or listening socket from the output.
4. State its apparent purpose only if supported by evidence; otherwise label the purpose as unknown.
5. List the owner or documentation source you would consult before changing it.

### Lab C — Draft a hardening checklist (10–15 minutes)

For a fictional student web server, prepare a checklist covering:

- supported software and update process;
- named accounts and least privilege;
- expected services and listening ports;
- protection of configuration and secrets;
- logging and review;
- backup and restore testing.

For each item, include the evidence you would collect and one verification step. Do not make changes to a real system.

### Lab D — Risk prioritization (5 minutes)

Rank these fictional findings by urgency and justify your reasoning:

- an outdated internet-facing service with a known security fix;
- an unused local package with no known exposure;
- a shared administrative account used by multiple operators;
- missing documentation for a tested backup process.

Consider likelihood, impact, exposure, and available mitigations. Your ranking should explain assumptions rather than claim a universal answer.

## 12. Troubleshooting and common mistakes

| Situation | Why it matters | Safe response |
|---|---|---|
| A command returns permission denied | Access may be intentionally restricted | Request approved access; do not bypass controls |
| An unknown port is listening | Its purpose and exposure are unclear | Identify the owner and expected use before acting |
| A checklist suggests disabling a service | The service may have dependencies | Confirm role and impact; test and plan rollback |
| Updates are available | Updates may affect compatibility or uptime | Review scope, test, schedule, and verify |
| A log contains a token or password | Sharing it may expose an account or service | Redact the secret and follow incident procedures if exposed |
| A permission appears too broad | The intended access requirement may be unclear | Confirm owner and use case before proposing a change |

## 13. Knowledge check — MCQs

**1. What is the purpose of defense in depth?**

A. Depend on one strong control only  
B. Combine complementary controls across layers  
C. Disable logging  
D. Give all users administrator access

**2. What does least privilege mean?**

A. Everyone receives the same access  
B. Users and processes receive only the access required for their task  
C. Permissions should never be reviewed  
D. All services run as root

**3. What does `ss -lntup` help inspect on supported systems?**

A. Listening TCP/UDP sockets  
B. User passwords  
C. Cron schedules  
D. Disk partitions

**4. What should happen before disabling an unfamiliar service?**

A. Disable it immediately  
B. Confirm its purpose, dependencies, impact, and recovery plan  
C. Delete its logs  
D. Expose it to the internet for testing

**5. Which is a good update practice?**

A. Install all updates on production without review  
B. Use trusted sources, assess impact, and verify after an approved update  
C. Ignore unsupported software  
D. Disable update notifications permanently

**6. What is the safest approach when a security check is denied by permissions?**

A. Change ownership of the system file  
B. Bypass the restriction  
C. Request authorized access or use an approved sample  
D. Disable the control

### Answer key

1. **B** — Multiple layers reduce reliance on a single control.
2. **B** — Least privilege limits access to what is required.
3. **A** — `ss` can display listening TCP/UDP sockets.
4. **B** — Understand dependencies and impact before a change.
5. **B** — Updates should be trusted, assessed, and verified.
6. **C** — Respect access controls and use approved evidence.

## 14. Quick revision

- Hardening reduces risk by minimizing exposure and applying layered controls.
- Least privilege, trusted updates, secure file access, and service minimization are core practices.
- Use read-only checks to gather evidence before proposing a change.
- Assess business impact and dependencies before changing a service or firewall.
- Protect logs, credentials, and configuration data.
- Verify changes and preserve a recovery path.

## 15. Further reading

- Local manual pages: `man id`, `man ps`, `man ss`, `man ls`, and `man journalctl`.
- Your Linux distribution's official security and hardening documentation.
- Your organization's approved security baseline, patching process, and incident-response procedure.

## Next chapter

**Chapter 15 — Backup, Recovery, and Operational Troubleshooting:** backup strategies, restore validation, incident prioritization, and a structured troubleshooting method.
