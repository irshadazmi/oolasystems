# Chapter 15 — Backup, Recovery, and Operational Troubleshooting

> **Course:** Linux Administration  
> **Audience:** B.Tech Year III  
> **Lab environments:** Webminal, WSL2 Ubuntu, or a Linux virtual machine  
> **Approach:** Safe, practical exercises using files created in a student's own working directory

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain the difference between a backup, synchronization, and an archive.
2. Describe full and incremental backup strategies and why separate failure domains matter.
3. Explain **Recovery Point Objective (RPO)** and **Recovery Time Objective (RTO)**.
4. Create and inspect a simple `tar` archive of practice files.
5. validate an archive with a checksum and test a restore into a separate directory.
6. Follow a structured, evidence-based troubleshooting and incident-triage workflow.
7. Document recovery steps and identify improvements after a simulated incident.

## 1. Why backup and recovery matter

A system is not resilient simply because files exist on a disk. Files can be deleted accidentally, corrupted, overwritten, encrypted by malware, or made unavailable by hardware failure. A backup is useful only if it is available, sufficiently recent, and can be restored successfully.

A practical backup plan answers four questions:

- **What** must be protected?
- **How often** should it be backed up?
- **Where** will the backup be stored, including protection from the same failure?
- **How will recovery be tested?**

### Backup and recovery architecture

![Backup and recovery architecture showing source data, backup creation, protected storage, validation, and recovery testing](/images/tutorials/linuxadmin/ch15-backup-recovery-architecture.png)

### Backup, synchronization, and archiving

| Concept | Purpose | Important limitation |
|---|---|---|
| Backup | Preserve a recoverable copy of data from an earlier point in time | Must be protected and restore-tested |
| Synchronization | Keep two locations aligned | Deletion or corruption may also synchronize |
| Archive | Package files and directories together, often with metadata | An archive is not automatically a safe backup |
| Snapshot | Capture a point-in-time view supported by a filesystem or platform | May share the same storage or failure domain |

**Key principle:** synchronization is useful, but it is not a substitute for independent, versioned backups.

## 2. Backup strategies

### Full backup

A full backup copies all selected data each time. It is straightforward to understand and restore, but can require more storage and time.

### Incremental backup

An incremental backup stores changes since the most recent backup in the chain. It can save storage and time, but recovery may require the full backup plus each required incremental backup.

### Choosing a strategy

The right approach depends on data volume, change rate, storage capacity, recovery objectives, and available tooling. For this introductory lab, students create a small archive manually rather than configuring a production backup service.

### Protect against a shared failure

Keeping the only backup beside the original files is risky. If the same disk, account, or machine fails, both copies may be lost. Production designs should consider separate storage, access controls, encryption, retention, and—where appropriate—an offline or otherwise isolated copy.

## 3. RPO and RTO

- **Recovery Point Objective (RPO):** the maximum acceptable amount of data loss measured in time. If the latest usable backup is from 02:00 and the incident occurs at 06:00, up to four hours of changes may be missing.
- **Recovery Time Objective (RTO):** the target time to restore a service or process after disruption. It includes more than copying files; validation and communication also take time.

![Recovery planning diagram comparing RPO, RTO, business priorities, planning, and exercises](/images/tutorials/linuxadmin/ch15-rpo-rto-recovery-planning.png)

### Mini exercise: select objectives

For each scenario, propose an RPO and RTO, and explain the business reason:

1. A student's practice folder.
2. A college admissions portal during application week.
3. A non-critical internal report generated once a month.

There is no single correct answer without business requirements. Explain the trade-off between cost, data loss, and downtime.

## 4. Practical lab A — create sample data

Use a practice directory in your own home directory. Do not run these exercises against system folders or real project data.

```bash
mkdir -p ~/linuxadmin-ch15/source
cd ~/linuxadmin-ch15

printf 'Linux Administration backup lab\n' > source/README.txt
printf 'Student practice file\n' > source/notes.txt
mkdir -p source/config
printf 'mode=practice\n' > source/config/lab.conf

find source -type f -print
```

**Observe:** `find` lists the sample files that will be included in the archive.

If `mkdir` reports that the directory already exists, inspect its contents before continuing. Do not delete existing work to make the example run.

## 5. Practical lab B — create and inspect a tar archive

Create the backup archive outside the source directory so it does not include itself:

```bash
tar -czf ch15-backup.tar.gz -C ~/linuxadmin-ch15 source
```

List the archive contents without extracting it:

```bash
tar -tzf ch15-backup.tar.gz
```

Inspect the archive file:

```bash
ls -lh ch15-backup.tar.gz
file ch15-backup.tar.gz
```

**What the options mean**

| Option | Meaning |
|---|---|
| `-c` | Create an archive |
| `-z` | Compress with gzip |
| `-f` | Use the filename that follows |
| `-t` | List archive contents |
| `-x` | Extract an archive |
| `-v` | Show file names while processing |

The `-C` option changes to the specified directory before using the following source path. It helps keep archive paths predictable.

## 6. Practical lab C — checksum and integrity check

A checksum helps detect whether a file has changed. It does **not** prove that the archive contains every required file, that the backup is stored safely, or that an application can recover from it.

```bash
sha256sum ch15-backup.tar.gz
sha256sum ch15-backup.tar.gz > ch15-backup.sha256
sha256sum -c ch15-backup.sha256
```

Expected final status: `ch15-backup.tar.gz: OK`.

Keep the checksum file with the archive for this exercise. In a real environment, store integrity evidence separately enough that an attacker or storage failure cannot silently alter both.

If `sha256sum` is unavailable in a particular lab environment, record the limitation and use an available trusted checksum utility only if the instructor approves it.

## 7. Practical lab D — restore to a new directory

A backup is not proven until a restore has been tested. Restore to a separate target directory; do not overwrite the source files.

```bash
mkdir -p ~/linuxadmin-ch15/restore-test
tar -xzf ~/linuxadmin-ch15/ch15-backup.tar.gz \
  -C ~/linuxadmin-ch15/restore-test
```

Inspect the restored files:

```bash
find ~/linuxadmin-ch15/restore-test -type f -print
cat ~/linuxadmin-ch15/restore-test/source/README.txt
cat ~/linuxadmin-ch15/restore-test/source/config/lab.conf
```

Compare source and restored file listings. For this small exercise, compare file contents as well. In production, recovery validation may also include ownership, permissions, application checks, database consistency, and service health.

**Safety:** extract only archives you trust. Before extracting an unfamiliar archive, list its contents with `tar -tzf` and inspect paths. Do not use a privileged account for this lab.

## 8. Recovery checklist

Before an incident:

- Identify critical data and system dependencies.
- Define backup frequency, retention, owners, RPO, and RTO.
- Protect backups from unauthorized access and from the same failure as the source.
- Monitor backup jobs and preserve relevant logs.
- Test restoration periodically and document the results.

During recovery:

1. Confirm scope and business impact.
2. Preserve evidence and avoid unnecessary changes.
3. Identify a known-good backup and validate its integrity.
4. Restore to a controlled location or approved recovery environment.
5. Verify files, data consistency, and service behavior.
6. Communicate status and record actions taken.

After recovery:

- Record the timeline, cause, and impact.
- Identify why existing controls did not prevent or quickly detect the problem.
- Assign owners and deadlines for corrective actions.
- Update and retest the recovery procedure.

## 9. Operational troubleshooting: evidence before action

![Incident triage workflow from detecting and scoping an issue to impact assessment, evidence preservation, hypothesis testing, and verified recovery](/images/tutorials/linuxadmin/ch15-incident-triage-workflow.png)

A useful troubleshooting sequence is:

1. **Define the symptom:** describe what is failing and what still works.
2. **Scope the impact:** identify affected users, systems, and data.
3. **Build a timeline:** record when the issue began and what changed.
4. **Collect evidence:** capture exact error messages and relevant logs.
5. **Form a hypothesis:** state a likely cause that can be tested.
6. **Run a safe check:** start with read-only inspection where possible.
7. **Change one thing at a time:** use approved, reversible actions.
8. **Verify recovery:** test the original symptom and related functions.
9. **Document and learn:** record findings, resolution, and prevention.

### Useful read-only checks

These commands may be useful depending on the problem and the lab platform:

```bash
date
whoami
pwd
df -h
free -h
uptime
ps aux | head
```

For logs, `journalctl` may be available on systemd-based Linux systems. Webminal may restrict access to system logs and service management; that is an environment limitation, not a reason to bypass controls.

Do not restart services, remove files, change permissions, or edit system configuration merely to experiment. Use a disposable VM or an instructor-approved environment for system-level recovery exercises.

## 10. Incident-triage worksheet

Use the following headings in your lab notebook:

| Field | Record |
|---|---|
| Incident ID | A short label, such as `LAB-15-01` |
| Symptom | What is observed? |
| Scope and impact | Who or what is affected? |
| Start time | When was it first observed? |
| Recent changes | What changed shortly before the incident? |
| Evidence | Exact messages, command output, timestamps |
| Hypothesis | What might explain the evidence? |
| Safe test | How can the hypothesis be tested? |
| Action | What was changed, by whom, and when? |
| Verification | What proves recovery? |
| Follow-up | What should be improved? |

### Pair exercise: recover a missing practice file

1. Create a file inside `source/` and make a new archive.
2. Confirm that the file appears in the archive listing.
3. Restore into `restore-test/`.
4. Verify the file contents.
5. Write a short incident note explaining how you would respond if the source copy were accidentally deleted.

This is a simulation. Do not delete the source file as part of the required exercise.

## 11. Common mistakes and troubleshooting

| Problem | Likely explanation | Safe next step |
|---|---|---|
| `tar` says a file cannot be found | Current directory or archive path is incorrect | Run `pwd` and `ls`; use the explicit paths shown in the lab |
| Archive does not list expected files | Wrong source path or files created elsewhere | Inspect the source directory and repeat archive creation with the correct path |
| Checksum reports `FAILED` | Archive changed, checksum file mismatch, or file corruption | Stop and investigate; do not treat the backup as trusted |
| Restore output is in an unexpected location | `-C` target or archive paths were misunderstood | List archive contents and inspect the restore directory |
| Backup exists but recovery fails | Backup may be incomplete, corrupt, or not tested | Identify a known-good copy and review the recovery procedure |
| `journalctl` or service tools are unavailable | The environment is restricted or does not use systemd | Record the limitation and use instructor-provided evidence or a suitable VM |

## 12. Knowledge check — MCQs

**1. What is the main purpose of a backup?**

A. To keep two folders synchronized at all times  
B. To provide a recoverable copy of data  
C. To increase CPU performance  
D. To replace all access controls  

**2. What does RPO describe?**

A. Maximum acceptable data-loss interval  
B. Time needed to install Linux  
C. Number of users on a server  
D. Time required to reboot a computer  

**3. What does RTO describe?**

A. The age of a Linux distribution  
B. The number of backup files  
C. The target time to restore a service or process  
D. The size of an archive  

**4. Which command lists the contents of a gzip-compressed tar archive?**

A. `tar -xzf archive.tar.gz`  
B. `tar -tzf archive.tar.gz`  
C. `tar -czf archive.tar.gz`  
D. `ls -R /`  

**5. What does a successful `sha256sum -c` check establish?**

A. The backup is stored off-site  
B. The application is fully operational  
C. The checksum matches the checked file  
D. Every required file was backed up  

**6. Why should a restore test use a separate directory in this lab?**

A. To avoid accidentally overwriting source files  
B. To make the archive larger  
C. To disable compression  
D. To bypass file permissions  

### Answer key

1. **B** — a backup provides a recoverable copy.
2. **A** — RPO concerns the acceptable data-loss interval.
3. **C** — RTO concerns the target recovery time.
4. **B** — `-t` lists, `-z` handles gzip, and `-f` specifies the archive file.
5. **C** — a checksum check confirms the file matches the recorded checksum, not that recovery will succeed.
6. **A** — restoring separately protects the source files during practice.

## 13. Submission checklist

Submit a short lab report containing:

- The commands used to create and list the archive.
- The checksum verification result.
- The restored file listing and one verified file's contents.
- Your proposed RPO and RTO for one scenario, with justification.
- The completed incident-triage worksheet for the simulated missing-file scenario.
- Two lessons learned about safe recovery.

## 14. Chapter summary

- Backups, synchronization, archives, and snapshots serve different purposes.
- Backups should be protected against shared failures and tested through restoration.
- RPO concerns acceptable data loss; RTO concerns acceptable recovery time.
- `tar` can create and inspect an archive, while checksums help detect file changes.
- A disciplined incident response uses evidence, safe tests, controlled changes, verification, and documentation.

**Next step:** review the course's Linux Administration learning outcomes and practise the recovery checklist in an instructor-approved lab.
