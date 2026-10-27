# Chapter 11 — System Logs, Journals, and Troubleshooting

> **Linux Administration • B.Tech Year III • Practical chapter**  
> **Theme:** use logs as evidence, narrow the problem, and verify each troubleshooting step.

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain why Linux systems collect logs and how logs support troubleshooting and auditing.
2. Distinguish the systemd journal from traditional text log files.
3. Use basic `journalctl`, `less`, `tail`, and `grep` commands to inspect permitted log data.
4. Filter events by service, boot, and time window where supported.
5. Correlate log entries with a reported symptom while protecting sensitive information.

## 1. Why logs matter

Linux logs record events from the kernel, services, applications, authentication components, and other system facilities. They can help answer questions such as:

- When did a service start failing?
- Did the system report a resource or device problem?
- Was a login attempt successful or rejected?
- Did an application report an error before a user-facing failure?

Logs provide **evidence**, not an automatic explanation. A single warning may be harmless or unrelated to the symptom. Good troubleshooting checks the time, context, repetition, and relationship between events before drawing a conclusion.

![Linux logging and journal architecture](/images/tutorials/linuxadmin/ch11-linux-logging-journal-architecture.png)

*Figure 11.1 — Events flow from system components into available logging facilities and are then investigated by an operator.*

## 2. Where Linux logs may be found

Two common approaches are the systemd journal and plain-text log files. Availability and configuration depend on the distribution, services, and permissions.

![Journal versus text logs](/images/tutorials/linuxadmin/ch11-journal-vs-text-logs.png)

*Figure 11.2 — Two common log inspection paths.*

### Systemd journal

On systems using systemd, `journalctl` reads journal records. The journal may include structured metadata, service messages, and boot-related events.

Check whether the command is available:

```bash
command -v journalctl
```

Useful examples:

```bash
journalctl
journalctl -b
journalctl -n 50
journalctl --since "1 hour ago"
```

- `journalctl` displays journal entries that the current account is allowed to read.
- `-b` filters to the current boot.
- `-n 50` requests the most recent 50 entries.
- `--since` limits results to a time boundary on supported versions.

The journal may be large, and access to some records may be restricted. Start with a narrow time window relevant to the incident.

### Traditional text log files

Many Linux distributions also store text logs under `/var/log`. The exact files and layout vary. Common tools for permitted text files include:

```bash
less FILE
tail -n 20 FILE
grep -i "error" FILE
```

Replace `FILE` with a log file you are authorized to read. Do not assume every file is present or readable in a student environment. Do not attempt to bypass permissions.

## 3. Filter journal entries by service

On a system using systemd, `journalctl -u` can filter records for a unit such as a service. For example, if your instructor has identified a service you are allowed to inspect:

```bash
journalctl -u SERVICE_NAME
journalctl -u SERVICE_NAME -b
journalctl -u SERVICE_NAME --since "30 minutes ago"
```

`SERVICE_NAME` is a placeholder, not a literal service name. Replace it only with a service supplied for your lab. If a service name is unknown, ask the administrator or inspect approved documentation rather than guessing.

Other useful options on many systemd systems include:

| Option | Purpose |
|---|---|
| `-b` | Show records for a boot |
| `-n N` | Show the most recent N records |
| `-u UNIT` | Filter by a unit |
| `--since TIME` | Set a start time |
| `--until TIME` | Set an end time |
| `-p PRIORITY` | Filter by priority level |
| `-f` | Follow new records as they arrive |

Check `man journalctl` on the target system because supported options and accepted time formats can vary.

## 4. Read timestamps and context

When investigating a symptom:

1. Record when the problem was first observed.
2. Confirm the system's time and relevant time zone.
3. Select a time window around the symptom, not just the latest log lines.
4. Look for related entries before and after the error.
5. Compare the relevant service, application, and system messages if available.
6. Record what the evidence supports and what remains uncertain.

A timestamp from one source may be presented differently from another. Be careful when correlating logs from multiple hosts or services.

## 5. A practical investigation workflow

![Evidence-based log investigation workflow](/images/tutorials/linuxadmin/ch11-evidence-based-log-investigation.png)

*Figure 11.3 — Define scope, filter evidence, correlate events, and verify the result.*

Use this workflow:

- **Define scope:** identify the symptom, host, service, account, and approximate start time.
- **Set the time window:** narrow the search to the relevant period.
- **Filter evidence:** use the appropriate journal or text-log tools.
- **Correlate:** compare related events and look for repeated patterns.
- **Verify:** test a specific hypothesis using an authorized, low-risk action.
- **Document:** record the observation, action, outcome, and any remaining uncertainty.

Avoid making multiple changes at once; it becomes harder to know which change affected the result.

## 6. Useful command reference

| Command | Brief description | Example |
|---|---|---|
| `date` | Show current date and time | `date` |
| `journalctl -b` | Read current-boot journal entries | `journalctl -b` |
| `journalctl -n 50` | Show recent journal entries | `journalctl -n 50` |
| `journalctl --since "1 hour ago"` | Filter by start time | `journalctl --since "1 hour ago"` |
| `journalctl -u UNIT` | Filter by unit | `journalctl -u SERVICE_NAME` |
| `journalctl -p warning` | Filter by priority on supported systems | `journalctl -p warning` |
| `less FILE` | Read a text file page by page | `less /path/to/known.log` |
| `tail -n 20 FILE` | Show final lines of a file | `tail -n 20 /path/to/known.log` |
| `grep -i "error" FILE` | Search case-insensitively | `grep -i "error" /path/to/known.log` |
| `grep -n "PATTERN" FILE` | Show matching line numbers | `grep -n "timeout" /path/to/known.log` |

All paths and service names shown as placeholders must be replaced with valid, approved values. Log access may be limited by the user's permissions.

## 7. Responsible handling of log data

Logs may contain usernames, hostnames, IP addresses, request paths, email addresses, session identifiers, or other sensitive information.

- Read only records needed for the task and permitted by policy.
- Do not post raw logs publicly or upload them to unapproved services.
- Redact tokens, passwords, session identifiers, and personal information before sharing a diagnostic excerpt.
- Preserve timestamps and enough surrounding context to support the diagnosis.
- Follow organizational retention and incident-reporting procedures.
- Do not delete or alter logs to hide an action or remove inconvenient evidence.

## 8. Hands-on labs

> **Safety boundary:** Use only your own WSL2/Ubuntu environment, an instructor-approved VM, or log samples supplied for class. Some Webminal environments do not run systemd, do not expose `journalctl`, or restrict access to system logs. Missing commands or permission errors are valid observations; do not bypass them.

### Lab A — Inspect logging tools (5–10 minutes)

1. Run `command -v journalctl`.
2. Run `date`.
3. If available, run `journalctl -n 20`.
4. If permitted, run `journalctl -b`.
5. Record whether the commands are available and whether output is restricted.

**Evidence to submit:** the command, a brief output summary, and one sentence explaining why log access may differ between environments.

### Lab B — Filter and summarize a time window (10 minutes)

On a system where `journalctl` is available and records are readable:

1. Inspect a small number of recent entries.
2. Use `--since "1 hour ago"` to narrow the window.
3. If your instructor provides an approved unit name, use `-u SERVICE_NAME`.
4. Identify one event with a timestamp, source, and message.
5. State whether it directly explains a symptom or needs further evidence.

If no journal is available, use a sample text log provided by your instructor and practice with `less`, `tail`, and `grep`.

### Lab C — Build a mini incident timeline (10–15 minutes)

Using a provided sample log or permitted local records:

1. Identify the reported symptom and its approximate start time.
2. Select three relevant entries.
3. Put them in timestamp order.
4. For each entry, record source, message, and why it may matter.
5. Write a short conclusion that separates facts from hypotheses.
6. List the next low-risk check you would perform.

Do not include personal data, credentials, or sensitive host information in your submission.

### Lab D — Redact a diagnostic excerpt (5 minutes)

Your instructor gives you a log excerpt that includes a username, an IP address, and a token-like string. Prepare a shareable version by replacing sensitive values with labels such as `[USER]`, `[IP ADDRESS]`, and `[REDACTED TOKEN]`. Preserve timestamps and the non-sensitive error context.

## 9. Troubleshooting guide

| Symptom | Possible cause | Safe next step |
|---|---|---|
| `journalctl: command not found` | systemd tools are absent in the environment | Confirm the environment and use an instructor-provided text log if appropriate. |
| No journal entries are shown | No records in the selected range, limited journal storage, or access restrictions | Check the time window and ask the administrator about permitted access. |
| Permission denied | The current account cannot read the requested records | Request authorized access; do not attempt to bypass permissions. |
| Service filter returns no results | Wrong unit name, no events in the selected range, or unit not managed by systemd | Verify the supplied unit name and time window. |
| Timestamps appear inconsistent | Time-zone or clock differences across systems | Record the time zone and compare timestamps carefully. |
| A log contains many errors | Repeated symptom, noisy component, or unrelated events | Narrow the time window and correlate with the actual symptom. |

## 10. Knowledge check — MCQs

**1. What is the best way to treat log entries during troubleshooting?**

A. Every error proves the root cause  
B. Logs are evidence that must be interpreted in context  
C. Delete old errors before investigating  
D. Ignore timestamps

**2. Which command commonly reads the systemd journal?**

A. `journalctl`  
B. `crontab`  
C. `scp`  
D. `lsblk`

**3. What does `journalctl -b` commonly select?**

A. Only binary files  
B. Records from the current boot  
C. All users' passwords  
D. The oldest log file

**4. What should you do if access to a log is denied?**

A. Bypass the restriction  
B. Request authorized access or use an approved sample  
C. Change ownership of the log  
D. Disable auditing

**5. Why is a narrow time window useful?**

A. It automatically proves root cause  
B. It reduces unrelated events and helps correlate evidence  
C. It changes the system clock  
D. It removes sensitive information

**6. Before sharing logs outside the team, what should you do?**

A. Include every record  
B. Remove timestamps  
C. Redact secrets and sensitive personal or system data  
D. Upload the raw file to any available site

### Answer key

1. **B** — Log messages need context and corroboration.
2. **A** — `journalctl` is the common systemd journal interface.
3. **B** — `-b` commonly selects the current boot.
4. **B** — Respect access controls and use authorized data.
5. **B** — A relevant time window helps reduce noise and compare events.
6. **C** — Redact sensitive data while preserving diagnostic context.

## 11. Quick revision

- Linux logs help investigate service, application, kernel, and authentication events.
- `journalctl` reads systemd journal records; text logs can be inspected with tools such as `less`, `tail`, and `grep`.
- Availability, file locations, and permissions vary by distribution and environment.
- Narrow the time window, correlate multiple sources, and verify a hypothesis before acting.
- Protect log data and redact secrets before sharing diagnostic excerpts.
- Document observations and outcomes so another operator can follow the reasoning.

## 12. Further reading

- Local manual pages: `man journalctl`, `man less`, `man tail`, and `man grep`.
- Your Linux distribution's official documentation for system logging, journal storage, and log access controls.

## Next chapter

**Chapter 12 — Shell Scripting Fundamentals:** variables, quoting, conditions, loops, exit status, and safe automation with Bash.
