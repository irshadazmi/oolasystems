# Chapter 11: Endpoint Protection, Patching, and Backups

Endpoint security is an operational discipline—not just an antivirus installation. Laptops, desktops, servers, and mobile devices need secure configuration, timely updates, appropriate endpoint protection, restricted privileges, monitoring, and a tested recovery path. This chapter connects those controls into a practical design that students can explain and review.

> **Lab safety:** Use your own laptop or an instructor-approved virtual machine. Do not disable antivirus, firewall, endpoint detection, or organisational controls. Do not run malware samples or destructive commands. Exercises use checklists and read-only inspection; follow local policy before installing updates or changing settings.

## Learning objectives

By the end of this chapter, you should be able to:

- Explain the purpose and limitations of endpoint protection tools.
- Design a layered endpoint defence that includes prevention, detection, response, and recovery.
- Inspect basic update status using approved operating-system interfaces.
- Describe a risk-based patch-management workflow.
- Explain backup isolation, retention, encryption, restore testing, RPO, and RTO.
- Produce a workstation hardening and recovery-readiness checklist.

## 1. Industry scenario: a laptop may be compromised

A college employee reports a suspicious sign-in notification and unusual system behaviour. The laptop also missed several updates, and its last successful backup is unclear. The IT team must reduce risk without destroying evidence or interrupting essential work unnecessarily.

A mature response does not begin by randomly deleting files or disabling security tools. The team follows policy, records what was observed, contacts the authorised support/security owner, and uses established containment and recovery procedures. The organisation also asks why patching and backup checks did not identify the gaps earlier.

![Endpoint defence architecture](/images/tutorials/cybersecurity/ch11-endpoint-defence-architecture.png)

## 2. Endpoint protection: capabilities and limitations

Endpoint protection may combine antivirus or anti-malware detection, behaviour monitoring, host firewall controls, device control, application control, and endpoint detection and response (EDR). Exact capabilities depend on the product, licence, configuration, and operating system.

| Control | Purpose | Important limitation |
|---|---|---|
| Antivirus / anti-malware | Detects known or suspicious files and behaviours | Detection is not perfect; signatures and engines need updates |
| Behaviour monitoring / EDR | Helps detect suspicious activity and supports investigation | Requires appropriate configuration, telemetry, alert handling, and trained responders |
| Host firewall | Restricts network traffic to and from a device | Rules must be maintained; it does not fix insecure applications |
| Disk encryption | Helps protect data if a device is lost or stolen | Does not stop an authorised, logged-in user or malware from accessing unlocked data |
| Application control | Limits which software can execute | Requires maintenance and a process for legitimate exceptions |
| Central logging | Supports investigation and correlation | Logs need protection, retention, monitoring, and a response process |

No single endpoint product replaces patching, least privilege, user awareness, secure application design, backups, or incident response.

## 3. Design a layered endpoint defence

A practical design has four connected functions:

1. **Prevent:** supported operating systems, secure defaults, timely patches, unique user accounts, least privilege, host firewall, and approved software.
2. **Detect:** endpoint alerts, authentication events, system logs, and a process for reviewing unusual activity.
3. **Respond:** defined escalation, authorised containment, evidence preservation, communication, and documented decision-making.
4. **Recover:** known-good backups, tested restoration, credential rotation when required, and post-incident review.

The controls should fit the organisation's risk, device type, user needs, and support capability. An endpoint that handles payroll or student records may need stronger access controls and monitoring than a kiosk with no sensitive local data.

## 4. Patch management is a controlled process

Patches can fix security vulnerabilities, reliability defects, and compatibility problems. Delayed patching leaves known weaknesses exposed; untested or poorly coordinated updates can also disrupt business services. A patch-management process balances urgency with safe deployment.

![Patch management risk workflow](/images/tutorials/cybersecurity/ch11-patch-management-risk-workflow.png)

### Recommended workflow

| Stage | Action | Evidence to record |
|---|---|---|
| Inventory | Identify devices, operating systems, applications, owners, and support status | Asset inventory and last-seen date |
| Assess | Review vendor advisories, severity, exposure, exploit activity where known, and business impact | Risk rationale and source advisory |
| Prioritise | Define which updates require urgent action and set a deadline | Priority, owner, target date |
| Test and deploy | Pilot where feasible, use an approved change window, and prepare a rollback or recovery plan | Change record and deployment result |
| Verify | Confirm installed versions or compliance status and monitor for regressions | Verification result and exceptions |
| Review exceptions | Record unsupported devices or deferred updates with compensating controls and an expiry date | Named risk owner and review date |

Do not rank patch work by a severity number alone. Internet exposure, exploit evidence, asset importance, available mitigations, and operational impact can change the priority. Follow the organisation's established vulnerability and change-management policies.

## 5. Practical exercise: workstation hardening review

Use your own device or an instructor-approved VM. Inspect settings through the operating system's normal interface. Do not disable controls or change managed-device settings.

### Checklist

| Check | What to look for | Record |
|---|---|---|
| Operating-system support | Is the OS still supported and receiving security updates? | OS/version and support status |
| Update status | Are security updates pending or requiring a restart? | Status and date checked |
| Endpoint protection | Is the approved protection tool enabled and reporting healthy status? | Tool/status—do not disable it |
| Firewall | Is the host firewall enabled under the expected profile? | Status only |
| Disk encryption | Is encryption enabled where required by policy? | Enabled/not enabled/unknown |
| User privileges | Is everyday work performed with a standard account where feasible? | Standard/admin and justification |
| Screen lock | Does the device lock after an appropriate idle period? | Observed setting |
| Software inventory | Are unnecessary or unsupported applications present? | Candidate for authorised review |
| Backups | Is there a recent successful backup and a known restore process? | Last backup status and owner |
| Incident reporting | Does the user know where to report a suspected compromise? | Contact/process location |

**Deliverable:** Submit a short table with status (`OK`, `Needs review`, or `Unknown`), evidence, risk, recommended action, and owner. Do not publish device serial numbers, personal files, usernames, or other sensitive details.

## 6. Backups and recovery architecture

Backups reduce the impact of accidental deletion, hardware failure, ransomware, and some operational mistakes. However, a backup can be unavailable, corrupted, too old, or compromised along with production systems. Recovery capability must be designed and tested.

![Backup and recovery architecture](/images/tutorials/cybersecurity/ch11-backup-recovery-architecture.png)

### Design principles

- **Separate access:** production administrators should not automatically have unrestricted rights to delete every backup.
- **Protect copies:** use appropriate encryption, access controls, retention, and tamper-resistant or offline copies where feasible.
- **Define scope:** identify databases, files, configurations, keys, and dependencies required to restore the service.
- **Monitor jobs:** failed or incomplete backups should generate an actionable alert and have an owner.
- **Test restoration:** restore into a controlled environment and verify data integrity and application functionality.
- **Document dependencies:** record recovery order, access requirements, responsible roles, and communication steps.

### RPO and RTO

- **Recovery Point Objective (RPO):** the maximum tolerable amount of data loss measured in time. For example, an RPO of four hours means the business is aiming to recover to a point no more than four hours before the disruption.
- **Recovery Time Objective (RTO):** the target time within which a service should be restored after disruption.

These targets are business requirements, not values that should be guessed by a technician. The design must show that the backup frequency, storage, staffing, and restoration process can meet the agreed targets.

## 7. Industry exercise: design recovery for a student portal

**Scenario:** A fictional student portal stores attendance and examination records. The portal team has daily database backups, but no one has recently tested a restore. A compromised administrator account could potentially reach both production and backup storage.

In teams, propose a design that addresses:

1. Separate permissions for production administration and backup deletion.
2. A backup schedule that is consistent with an agreed RPO.
3. A restoration procedure and target consistent with an agreed RTO.
4. A safe, isolated restore test and an integrity check for restored records.
5. Monitoring for failed backup jobs and unusual deletion activity.
6. Named owners for approving recovery, communicating status, and documenting results.

**Discussion prompt:** Which controls reduce the chance of data loss, which help detect a problem, and which reduce recovery time? Explain why having a successful backup job is not the same as proving recovery will work.

## 8. Incident handling: do not improvise

If a device may be compromised:

- Follow the organisation's incident-reporting procedure and contact the authorised responder.
- Do not delete suspicious files, wipe the device, or reinstall the operating system before the response owner decides how to preserve evidence.
- Avoid entering additional passwords or accessing sensitive services from a potentially compromised device until advised.
- Containment actions such as disconnecting a device should follow policy and the incident lead's direction, especially where critical services or evidence may be affected.
- Record timestamps, observed symptoms, alerts, and actions taken. Share evidence only with authorised recipients.
- After recovery, review the initial cause, patch and configuration gaps, identity controls, monitoring, and backup readiness.

For this student exercise, discuss the response plan rather than simulating malware or attempting destructive actions.

## 9. Key takeaways

- Endpoint security is a layered architecture: prevent, detect, respond, and recover.
- Protection tools have limits and need secure configuration, updates, monitoring, and response ownership.
- Patch management requires inventory, risk-based prioritisation, controlled deployment, verification, and exception tracking.
- Backups must be protected from unauthorised access and deletion, monitored, and tested through restoration.
- RPO defines tolerable data-loss time; RTO defines the target service-restoration time.
- Evidence preservation and approved incident procedures are safer than improvising on a suspected compromised device.

## 10. Knowledge check

1. What is the strongest description of endpoint protection?
   - A. A replacement for patching and backups
   - B. One layer in a broader security design
   - C. A guarantee that malware cannot execute
   - D. A reason to disable the host firewall

2. What should a team do after deploying a patch?
   - A. Assume all devices installed it successfully
   - B. Verify installation/compliance and monitor for regressions
   - C. Delete the asset inventory
   - D. Disable logging

3. Why should patch priority consider more than a severity score?
   - A. Exposure, exploit evidence, asset value, and operational context also matter
   - B. Severity scores are never useful
   - C. Updates are optional for internet-facing devices
   - D. All devices have identical risk

4. What does RPO describe?
   - A. The time allowed to restore service
   - B. The maximum tolerable data-loss interval
   - C. The number of administrators
   - D. The time required to install antivirus

5. Which practice best demonstrates backup readiness?
   - A. A backup job reported success once
   - B. A restore has been tested and the restored data and service verified
   - C. Backup files are stored with unrestricted production access
   - D. No one knows who owns recovery

6. What is a prudent response to a suspected compromised endpoint?
   - A. Immediately delete files and clear logs
   - B. Follow the incident process, contact the authorised responder, and preserve evidence
   - C. Disable all protection tools
   - D. Publish the capture and logs publicly

**Answer key:** 1-B, 2-B, 3-A, 4-B, 5-B, 6-B.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: reduce exposure, verify controls, and prove recovery.*
