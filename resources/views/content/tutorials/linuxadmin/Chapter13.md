# Chapter 13 — Services and Server Operations

> **Linux Administration • B.Tech Year III • Practical chapter**  
> **Theme:** understand service lifecycle, inspect status and logs, and make only authorized operational changes.

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain the difference between a process and a service.
2. Describe the role of a service manager such as `systemd` where available.
3. Inspect service status and recent logs using approved commands.
4. Recognize the purpose of service units, dependencies, and listening sockets.
5. Apply a safe workflow before starting, stopping, enabling, or restarting a service.

## 1. What is a Linux service?

A **process** is a running program. A **service** is a program or capability managed to provide a function, often in the background, such as a web server, scheduled task, database, or logging component. A service may be represented by one or more processes and may expose a network endpoint, but not every service listens on a network port.

On many mainstream Linux distributions, `systemd` is used as the system and service manager. The `systemctl` command is a common interface for inspecting and controlling systemd units. Some learning shells, containers, and lightweight distributions do not use systemd or do not grant access to service management. Check the environment before assuming a command is available.

![Linux service architecture](/images/tutorials/linuxadmin/ch13-linux-service-architecture.png)

*Figure 13.1 — Operator, service manager, unit configuration, and service process.*

## 2. Process versus service

| Concept | Meaning | Example |
|---|---|---|
| Process | A running instance of a program, usually with a PID | A shell or web-server process |
| Service | A managed capability or background workload | A web server managed by a service manager |
| Unit | A systemd resource definition, such as a service or socket unit | `example.service` |
| Daemon | A program that commonly runs in the background | A logging or network daemon |
| Socket / port | A communication endpoint that a program may listen on | A web server's TCP listening socket |

A service can fail even if a process briefly appears in the process list. Conversely, a process may be healthy while a dependent endpoint or application function is unavailable. Use more than one source of evidence.

## 3. Check which tools are available

Start with read-only inspection:

```bash
command -v systemctl
command -v journalctl
ps -ef | head
```

- `command -v` checks whether a command can be found.
- `ps -ef | head` displays a small sample of process information.
- If `systemctl` is unavailable or reports that systemd is not running, use the approved environment's process and log inspection tools instead.

Do not attempt to install or enable a service manager in a restricted learning environment merely to make the exercise work. Record the limitation and ask the instructor which environment to use.

## 4. Inspect a service safely

On a system using systemd, inspect a service whose name and access have been provided by the instructor or administrator:

```bash
systemctl status SERVICE_NAME
```

`SERVICE_NAME` is a placeholder. Replace it only with an approved unit name. The status output may include whether the unit is loaded and active, recent messages, and process details.

Useful read-only commands include:

```bash
systemctl is-active SERVICE_NAME
systemctl is-enabled SERVICE_NAME
systemctl list-units --type=service --state=running
```

The output of `is-enabled` describes enablement configuration, not necessarily whether the service is currently running. A service can be active now but not configured to start automatically at boot, or enabled but currently inactive.

Some operations require administrative privileges. Do not use `sudo` or change system services unless the exercise explicitly authorizes it and explains the expected impact.

## 5. Service lifecycle and dependencies

A service generally has a configuration or unit definition, may depend on other units, starts a process, and produces status and log information. An operator may monitor it or carry out an approved stop/restart when necessary.

![Service lifecycle and dependencies](/images/tutorials/linuxadmin/ch13-service-lifecycle-dependencies.png)

*Figure 13.2 — A simplified service lifecycle, from loading configuration to monitoring and controlled operations.*

Before changing a service, consider:

- Which applications or users depend on it?
- Will a restart interrupt active work?
- Is the service managed by systemd on this machine?
- Is there a documented maintenance window?
- Is there a safe rollback or recovery procedure?
- How will success be verified after the change?

Do not infer that a service is safe to restart simply because its status is “failed” or “inactive.” Understand the context first.

## 6. Read service logs

On a system using systemd, `journalctl` can filter messages by unit:

```bash
journalctl -u SERVICE_NAME -n 50
journalctl -u SERVICE_NAME --since "30 minutes ago"
```

Replace the placeholder with an approved service name. Use a relevant time window around the reported symptom. A single error line is not necessarily the root cause; compare timestamps, repeated events, and application behavior.

For more details about log investigation, see **Chapter 11 — System Logs, Journals, and Troubleshooting**.

## 7. Listening sockets and network endpoints

Some services listen for network connections; others only work locally or respond to scheduled or event-driven tasks. On Linux systems with the `ss` utility, the following command can display listening TCP and UDP sockets:

```bash
ss -lntup
```

Depending on permissions, process names or PIDs may not be visible. Do not probe or expose a service to the network without permission. A listening port alone does not prove that the application is healthy or securely configured.

When a service is expected to provide a network endpoint, verify the expected port and behavior using an approved local or lab test. Never publish a test service on a public interface without explicit authorization and a security review.

## 8. Safe service operations workflow

![Safe service operations workflow](/images/tutorials/linuxadmin/ch13-safe-service-operations-workflow.png)

*Figure 13.3 — Inspect, assess impact, act minimally, and verify the outcome.*

1. **Identify:** confirm the exact system and unit name.
2. **Inspect:** check status, logs, dependencies, and related processes.
3. **Assess:** understand user impact, permissions, and maintenance timing.
4. **Act:** make only the approved change, using the documented procedure.
5. **Verify:** re-check status, logs, and expected behavior.
6. **Document:** record the initial state, action, result, and rollback if needed.

Commands that change state include `start`, `stop`, `restart`, `enable`, and `disable`. These are not interchangeable:

| Action | General purpose |
|---|---|
| `start` | Request that a unit run now |
| `stop` | Request that a unit stop now |
| `restart` | Stop and start a unit again; may interrupt service |
| `enable` | Configure a unit to start automatically in supported systemd setups |
| `disable` | Remove automatic-start enablement in supported setups |
| `reload` | Ask a service to reload configuration if supported; behavior varies |

Use state-changing commands only when the instructor or administrator has authorized the action.

## 9. Command reference

| Command | Brief description | Typical use |
|---|---|---|
| `command -v systemctl` | Check whether systemctl is available | Environment inspection |
| `systemctl status UNIT` | Show unit status and recent messages | Read-only diagnosis |
| `systemctl is-active UNIT` | Check active state | Status check |
| `systemctl is-enabled UNIT` | Check enablement configuration | Boot behavior review |
| `systemctl list-units --type=service --state=running` | List running service units | Service inventory |
| `journalctl -u UNIT -n 50` | Show recent unit logs | Troubleshooting |
| `ps -ef` | List processes | Process inspection |
| `ss -lntup` | Show listening TCP/UDP sockets and, where permitted, process details | Endpoint inspection |
| `systemctl restart UNIT` | Restart a unit | State-changing; authorized maintenance only |

Replace `UNIT` with an approved unit name. Some commands or options may not be available in Webminal or other restricted environments.

## 10. Hands-on labs

> **Safety boundary:** Use your own WSL2/Ubuntu VM or an instructor-approved lab machine. Do not restart, stop, enable, or disable shared system services. The read-only activities below are sufficient for the core lab.

### Lab A — Inspect service-management support (5–10 minutes)

1. Run `command -v systemctl`.
2. Run `command -v journalctl`.
3. Run `ps -ef | head`.
4. If systemd is available, inspect a service name supplied by your instructor using `systemctl status SERVICE_NAME`.
5. Record whether the environment supports service inspection.

**Evidence to submit:** command output summary and a short explanation of why a restricted shell may not expose systemd.

### Lab B — Interpret service state (10 minutes)

Using instructor-provided sample output or a permitted local service:

1. Identify whether the unit is loaded and active.
2. Identify the most recent relevant message.
3. Explain the difference between active state and enabled state.
4. List one follow-up check before declaring the service healthy.

Do not change the service state during this lab.

### Lab C — Connect service status with logs (10–15 minutes)

1. Choose an instructor-approved service or sample log.
2. Record the symptom and approximate time.
3. Inspect the service status and a short log window.
4. List two facts supported by the evidence and one hypothesis that needs testing.
5. Propose a low-risk next step and explain how you would verify it.

### Lab D — Endpoint reasoning (5 minutes)

Review instructor-provided output from `ss -lntup`. Identify one listening socket, its protocol, and (if visible) the owning process. Explain why a listening socket alone does not prove that an application is healthy or safe to expose.

## 11. Troubleshooting guide

| Symptom | Possible cause | Safe next step |
|---|---|---|
| `systemctl: command not found` | systemd tools are unavailable | Use the approved environment and document the limitation. |
| “System has not been booted with systemd” | Current environment is a container, WSL configuration, or another non-systemd setup | Do not try to start systemd without authorization; use supported inspection methods. |
| Unit not found | Incorrect unit name or service not installed | Verify the name with the instructor or system administrator. |
| Service is inactive | It may be stopped, event-driven, or not needed in this environment | Check the service's intended role and logs before taking action. |
| Service is active but application fails | Dependency, configuration, endpoint, or application-level issue | Correlate status, logs, and approved endpoint checks. |
| Logs are inaccessible | Permissions or journal configuration restrict access | Request authorized access or use a provided sample. |
| Port is listening but no response | Application behavior, firewall, routing, or protocol mismatch | Follow the approved troubleshooting scope and verify the expected endpoint. |

## 12. Knowledge check — MCQs

**1. What is a process?**

A. A running instance of a program  
B. A package repository  
C. A cron expression  
D. A filesystem mount point

**2. What is `systemctl` commonly used for on systemd systems?**

A. Managing and inspecting systemd units  
B. Editing every text file  
C. Creating disk partitions  
D. Encrypting all network traffic

**3. What is the difference between active and enabled?**

A. They always mean the same thing  
B. Active describes current state; enabled concerns automatic startup configuration  
C. Enabled means the service is healthy  
D. Active means the service listens on the public internet

**4. Why should a service restart be reviewed before execution?**

A. It can interrupt users or dependent services  
B. It never changes service behavior  
C. It always deletes logs  
D. It cannot affect running processes

**5. What does `journalctl -u UNIT` commonly do?**

A. Filters journal entries by unit  
B. Starts the unit  
C. Opens a network port  
D. Changes the unit's permissions

**6. What is the safest approach in a shared student environment?**

A. Restart system services to experiment  
B. Disable logging to reduce noise  
C. Perform read-only checks unless a state change is explicitly authorized  
D. Expose any listening service publicly

### Answer key

1. **A** — A process is a running program instance.
2. **A** — `systemctl` is the common systemd unit interface.
3. **B** — Active state and boot enablement are distinct.
4. **A** — Restarting can interrupt work or dependencies.
5. **A** — `-u` filters journal entries by unit.
6. **C** — Read-only checks are the safe default in shared environments.

## 13. Quick revision

- A process is a running program; a service is a managed capability or workload.
- `systemctl` and `journalctl` are useful on systems using systemd.
- Service availability and privileges differ across distributions and learning environments.
- Inspect status, logs, dependencies, and impact before changing a service.
- A listening socket does not by itself prove application health or safe exposure.
- Make only authorized changes and verify the outcome.

## 14. Further reading

- Local manual pages: `man systemctl`, `man systemd.service`, `man journalctl`, and `man ss`.
- Your Linux distribution's official documentation for service management and systemd units.

## Next chapter

**Chapter 14 — Linux Security and Hardening Basics:** least privilege, update hygiene, secure configuration, exposure reduction, and practical security checks.
