# Chapter 10 — Scheduling Tasks and Automation

> **Linux Administration • B.Tech Year III • Practical chapter**  
> **Theme:** schedule predictable work safely, understand execution context, and verify outcomes.

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain why Linux administrators schedule recurring and one-time tasks.
2. Distinguish recurring scheduling with `cron` from one-time scheduling with `at` (where installed and enabled).
3. Read the five time fields in a typical user crontab entry.
4. Inspect a user's scheduled tasks and understand common environment differences.
5. Design and test a harmless scheduled job using safe paths and clear output.

## 1. Why schedule tasks?

Administrators automate repetitive work such as generating reports, rotating application output, checking disk usage, or running a data import at a predictable time. Scheduling can improve consistency, but a scheduled command still runs with the permissions and environment of its execution account. It does **not** automatically become an administrator.

Examples of tasks that may be scheduled after review:

- create a daily report from a test dataset;
- check whether a log file has grown beyond an agreed threshold;
- run a maintenance script in a lab environment;
- produce a status summary for a service owner.

Avoid scheduling destructive commands until the purpose, target, backup, rollback, and responsible owner are clear.

![Linux task scheduling architecture](/images/tutorials/linuxadmin/ch10-linux-task-scheduling-architecture.png)

*Figure 10.1 — A scheduler invokes a job within a defined user and environment context.*

## 2. Two common scheduling tools

### `cron` and `crontab`

`cron` is commonly used for recurring tasks. A user's crontab contains schedule entries and commands to run. The exact implementation and supported extensions can differ across Linux distributions.

Inspect your own crontab:

```bash
crontab -l
```

If no crontab exists, the command may report that there is none. This is not necessarily an error. Do not edit another user's schedule or system-wide cron files without explicit authorization.

To learn available options:

```bash
crontab -h
man crontab
man 5 crontab
```

Some versions do not support `crontab -h` as a help option; use the manual page or distribution documentation when needed.

### `at`

`at` is designed for a one-time job at a specified time, where the package and service are installed and enabled. It may be unavailable in Webminal, containers, or restricted student environments.

Inspect availability without changing system configuration:

```bash
command -v at
command -v atq
```

Do not enable services or install packages on shared systems unless your instructor or administrator has authorized the change.

## 3. Reading a cron expression

A typical user crontab line has five time fields followed by the command:

```text
minute hour day-of-month month day-of-week command
```

For example:

```cron
30 8 * * 1-5 /home/student/bin/report.sh
```

This example means 08:30 on weekdays (Monday through Friday) on many common cron implementations. It is illustrative; do not assume that the named file exists on your machine.

![Cron schedule fields](/images/tutorials/linuxadmin/ch10-cron-schedule-fields.png)

*Figure 10.2 — The five schedule fields in a typical cron entry.*

### Common field values

| Field | Typical values | Meaning |
|---|---|---|
| Minute | `0–59` | Minute of the hour |
| Hour | `0–23` | Hour of the day |
| Day of month | `1–31` | Calendar day |
| Month | `1–12` or names | Month |
| Day of week | Commonly `0–7` or names | Weekday; exact conventions can vary |

Common symbols:

| Symbol | Meaning | Example |
|---|---|---|
| `*` | Every permitted value | `*` in the month field |
| `,` | List of values | `1,3,5` |
| `-` | Range | `1-5` |
| `/` | Step interval | `*/15` in the minute field |

Be careful when both the day-of-month and day-of-week fields are restricted: cron implementations can differ in how they interpret the combination. Check the manual page for your environment rather than relying on a memorized rule.

## 4. Inspect and reason before scheduling

Start with read-only inspection:

```bash
whoami
pwd
date
crontab -l
```

These commands show the current account, working directory, system time, and the current user's schedule (if any).

Before adding a job, answer these questions:

- What is the job's purpose, and who owns the result?
- Which account will run it?
- Does the command use absolute paths for scripts and files?
- What input does it read, and where will output go?
- What happens if the job fails or runs twice?
- Can the job overlap with a previous run?
- How will the result be checked, and how will the job be disabled?

## 5. Scheduled jobs have a different environment

A command that works in an interactive terminal may fail when scheduled. A cron job may have a smaller environment, a different working directory, no interactive prompt, and a different `PATH`.

Good practices:

- Prefer absolute paths for executables, scripts, and files.
- Do not rely on aliases or shell startup files.
- Avoid commands that wait for interactive input.
- Define required environment variables deliberately and protect secrets.
- Send output to an agreed log or reporting destination.
- Check exit status and error output.
- Make the job safe to repeat where possible.

Do not put passwords, API keys, or other secrets directly into crontab entries or scripts that may be readable by other users.

## 6. Example: a harmless report job

For practice, create a script that reports the date and the current account. Keep it in a directory you own and use a test output file.

Example script content:

```bash
#!/usr/bin/env bash
printf 'Report time: '
date
printf 'Running account: '
whoami
```

Save it as `report.sh` in a directory you control. Before scheduling it, run it manually and confirm that the output is correct. On a Linux machine where you have permission to execute your own script, use the file permissions and execution method appropriate to your environment; if the shell blocks execution, ask the instructor rather than changing shared-system permissions.

An illustrative crontab line might be:

```cron
*/15 * * * * /home/student/bin/report.sh >> /home/student/report.log 2>&1
```

This would run every 15 minutes on common cron implementations. **Do not install this recurring line without instructor approval.** For a class exercise, inspect the syntax and explain where output and errors would go; use a one-off supervised test if scheduling is not required.

## 7. Safe scheduling workflow

![Safe scheduling workflow](/images/tutorials/linuxadmin/ch10-safe-scheduling-workflow.png)

*Figure 10.3 — A repeatable process for designing and maintaining scheduled work.*

1. **Define:** record the purpose, owner, timing, expected result, and impact.
2. **Prepare:** use a known script, absolute paths, predictable inputs, and an explicit output destination.
3. **Validate:** check the time fields, account permissions, dependencies, and likely run duration.
4. **Test:** run manually with harmless sample data before enabling a schedule.
5. **Monitor:** inspect output, errors, exit status, and whether the job overlaps or repeats unexpectedly.
6. **Maintain:** document the schedule and a safe way to disable or remove it.

## 8. Command reference

| Command | Brief description | Typical use |
|---|---|---|
| `date` | Display current date and time | Check time context |
| `whoami` | Display current username | Confirm execution account |
| `pwd` | Display current directory | Understand path context |
| `crontab -l` | List current user's crontab | Inspect existing schedule |
| `crontab -e` | Edit current user's crontab | Use only when authorized |
| `command -v at` | Check whether `at` is available | Inspect one-time scheduler tool |
| `command -v atq` | Check whether `atq` is available | Inspect queue tool availability |
| `man 5 crontab` | Read crontab format documentation | Verify field semantics |
| `tail -n 20 FILE` | Inspect the last lines of a known output file | Review a test log |
| `grep PATTERN FILE` | Search a known text file | Find errors in a test log |

Use `tail` and `grep` only with files you are permitted to read. Do not assume that system log paths are accessible to student accounts.

## 9. Hands-on labs

> **Safety boundary:** Start with inspection and manual testing. Use your own WSL2/Ubuntu environment or an instructor-approved VM. Webminal may not provide a running cron daemon or `at` service. Do not edit system-wide schedules, install packages, or enable services on shared systems.

### Lab A — Inspect your scheduling environment (5–10 minutes)

1. Run `whoami`, `pwd`, and `date`.
2. Run `crontab -l` and record whether a crontab exists.
3. Run `command -v at` and `command -v atq`.
4. Read the available crontab documentation.
5. Explain why the absence of `at` or a current crontab does not necessarily mean the system is broken.

**Evidence to submit:** command list, short output summary, and one sentence distinguishing recurring from one-time scheduling.

### Lab B — Decode cron entries (10 minutes)

For each example below, explain the schedule in plain English. These are syntax exercises; do not install them as real jobs.

```cron
0 7 * * * /path/to/daily-report.sh
*/10 * * * * /path/to/check-status.sh
30 8 * * 1-5 /path/to/weekday-report.sh
0 0 1 * * /path/to/monthly-summary.sh
```

For each line, identify the five time fields, the command, and one operational risk to check before enabling it.

### Lab C — Design a harmless job (10–15 minutes)

1. Write a small report script using `date` and `whoami`.
2. Run it manually in your own environment.
3. Choose an output file in a directory you own.
4. Draft (but do not install) a crontab line that would run the report.
5. State how you would check success and safely disable the job.

If an instructor-approved local VM supports a practical cron demonstration, the instructor may supervise installing and removing a temporary test entry. Do not install recurring jobs on shared Webminal accounts.

### Lab D — Failure scenario (5 minutes)

A scheduled report works when run manually but fails overnight. List at least four possible causes and a safe diagnostic step for each. Consider `PATH`, working directory, file permissions, missing input, output location, and a non-interactive environment.

## 10. Troubleshooting guide

| Symptom | Possible cause | Safe next step |
|---|---|---|
| `crontab -l` reports no crontab | No schedule exists for this user | Record this result; create one only if the lab requires and authorizes it. |
| Command works manually but not on schedule | Different `PATH`, working directory, or environment | Use absolute paths and test the script in a controlled environment. |
| No output file appears | Wrong destination, missing directory, or insufficient permission | Check the intended path and account permissions. |
| Output is empty or incomplete | Script error, missing input, or early exit | Run manually with test data and inspect error output. |
| Job runs twice or overlaps | Runtime exceeds interval or schedule duplicates | Review runtime and cadence; make repeat behavior safe. |
| `at` is unavailable | Package/service not present or environment restricted | Use the approved environment; do not enable services without authorization. |
| Schedule appears to run at the wrong time | Time zone, clock, daylight-saving behavior, or cron semantics | Check system time and local documentation. |

## 11. Knowledge check — MCQs

**1. Which tool is commonly used for recurring scheduled tasks?**

A. `cron` / `crontab`  
B. `df`  
C. `scp`  
D. `uname`

**2. Which tool is designed for a one-time job when available?**

A. `at`  
B. `grep`  
C. `free`  
D. `ip`

**3. In a typical cron entry, how many time fields appear before the command?**

A. Two  
B. Three  
C. Five  
D. Seven

**4. Why can a command work manually but fail under cron?**

A. Cron always runs as root  
B. The scheduled environment may differ from the interactive shell  
C. Cron ignores all file paths  
D. Scheduled jobs cannot write output

**5. What is a good practice for scheduled scripts?**

A. Depend on interactive prompts  
B. Use unclear relative paths  
C. Use absolute paths and check output/errors  
D. Put passwords directly in the crontab

**6. What should you do before enabling a recurring job?**

A. Test it manually and verify purpose, permissions, output, and failure behavior  
B. Run it against production data immediately  
C. Disable logging  
D. Assume it will run only once

### Answer key

1. **A** — Cron is commonly used for recurring schedules.
2. **A** — `at` is used for one-time jobs where available.
3. **C** — A typical cron entry has five time fields.
4. **B** — Scheduled jobs may have a different environment and working directory.
5. **C** — Explicit paths and observable output make jobs easier to operate safely.
6. **A** — Validate and test before enabling recurring automation.

## 12. Quick revision

- Use `cron` for recurring work and `at` for one-time work where supported.
- A typical crontab entry has five time fields followed by a command.
- Scheduled jobs run as a particular account with a particular environment.
- Prefer absolute paths, harmless tests, clear output, and error handling.
- Check overlap, permissions, output, and a safe disable procedure.
- Do not put secrets in crontab entries or run unreviewed destructive jobs.

## 13. Further reading

- Local documentation: `man crontab` and `man 5 crontab`.
- `at` and `atq` manual pages where installed.
- Your Linux distribution's official documentation for cron implementation, environment, and service management.

## Next chapter

**Chapter 11 — System Logs, Journals, and Troubleshooting:** log locations, `journalctl`, filtering evidence, service diagnosis, and responsible handling of log data.
