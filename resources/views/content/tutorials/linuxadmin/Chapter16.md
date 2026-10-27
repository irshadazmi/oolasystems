# Chapter 16 — 3 Hours Hands Dirty with Linux Administration

**Practical consolidation guide | Linux Administration**

> **Purpose:** Quickly revise the most important concepts from Chapters 1–15, then spend most of the session doing practical work. Use this as a single-glance lab sheet, not a replacement for the detailed chapters.

## Quick-fire revision: concepts to recall

Keep answers short, then demonstrate each idea in the terminal.

| Topic | Quick-fire question / reminder |
|---|---|
| Linux ecosystem | How do the kernel, shell, utilities, and applications fit together? |
| Identity | Which account is active, and which groups apply to it? |
| Paths and navigation | What is the difference between an absolute path and a relative path? |
| Help | When would you use `man`, `--help`, or shell history? |
| Files and text | How can you list, inspect, search, count, and sort text safely? |
| Permissions | How do owner, group, and other permission bits work? Read them before changing anything. |
| Processes | How do you inspect running processes and recognise a process from its output? |
| Resources | What do disk usage, memory, uptime, and load tell you? |
| Packages and updates | Why use trusted repositories and review updates? |
| Storage | How are filesystems, mount points, and directory paths related? |
| Networking | What do interface addresses, routes, DNS, and ports tell you? |
| Remote access | Why verify SSH host keys and prefer key-based authentication where appropriate? |
| Scheduling | What are cron jobs used for, and why should scheduled commands use reliable paths? |
| Logs | Why record timestamps and exact errors before attempting a fix? |
| Shell scripting | How do variables, quoting, exit status, conditions, and loops help automate repeatable work? |
| Services | How are a process and a managed service different? |
| Security | How do updates, least privilege, reduced attack surface, and careful evidence handling help? |
| Backup and recovery | Why must a backup be restore-tested? What do RPO and RTO mean? |

![A safe practical workflow connecting identity, exploration, observation, protection, and verification](/images/tutorials/linuxadmin/ch16-linux-admin-practical-workflow.png)

![Connected map of identity and access, files and storage, system health, connectivity, and resilience](/images/tutorials/linuxadmin/ch16-linux-operations-map.png)

## Linux administration command reference

Use a permitted Linux terminal, such as your own Ubuntu/WSL2 environment, a virtual machine, or an instructor-approved training terminal. Some commands and options may not be available in restricted web terminals. Commands that require administrative privileges are marked accordingly; do not run them unless explicitly authorised.

| # | Name / Command | Brief Description | Most Common Options | Simple Examples |
|---:|---|---|---|---|
| 1 | `whoami` | Print the effective username. | No common options needed. | `whoami` |
| 2 | `id` | Show user ID and group memberships. | `-u` user ID; `-g` primary group ID; `-G` group IDs; `-n` names. | `id` · `id -nG` |
| 3 | `groups` | Show groups associated with a user. | Optional username. | `groups` |
| 4 | `pwd` | Print the current working directory. | `-L` logical path; `-P` physical path. | `pwd` |
| 5 | `echo "$SHELL"` | Display the `SHELL` environment variable. | Shell built-in; options vary. | `echo "$SHELL"` |
| 6 | `uname` | Display system/kernel information. | `-a` all available; `-r` kernel release. | `uname -r` · `uname -a` |
| 7 | `date` | Display current date/time. | `-u` UTC; formatting options vary. | `date` · `date -u` |
| 8 | `history` | Show shell command history. | Options vary by shell. | `history` |
| 9 | `man` | Open a command manual. | `-k` search descriptions. | `man ls` · `man -k files` |
| 10 | `command --help` | Show brief usage where supported. | `--help` is common but not universal. | `ls --help` |
| 11 | `ls` | List directory contents. | `-l` long; `-a` hidden; `-la` both; `-d` directory itself. | `ls -la` |
| 12 | `mkdir` | Create directories. | `-p` create parent directories. | `mkdir -p ~/linuxadmin-lab/work` |
| 13 | `touch` | Create an empty file or update timestamps. | No common options for basic use. | `touch notes.txt` |
| 14 | `cat` | Display a text file. | `-n` number lines. | `cat -n notes.txt` |
| 15 | `less` | View a file page by page. | `-N` show line numbers; `q` quits. | `less -N notes.txt` |
| 16 | `head` | Display the first lines. | `-n N` line count. | `head -n 5 sample.log` |
| 17 | `tail` | Display the last lines. | `-n N` line count; `-f` follow updates. | `tail -n 10 sample.log` |
| 18 | `grep` | Search text for a pattern. | `-i` ignore case; `-n` line numbers; `-r` recursive; `-E` extended patterns. | `grep -in "error" sample.log` |
| 19 | `find` | Search for files/directories. | `-name`; `-type f`; `-type d`. | `find . -type f -name "*.txt"` |
| 20 | `cp` | Copy files/directories. | `-i` prompt before overwrite; `-r` directories. | `cp -i notes.txt notes-copy.txt` |
| 21 | `mv` | Move or rename files. | `-i` prompt before overwrite. | `mv notes-copy.txt notes-old.txt` |
| 22 | `rm` | Remove files. **Destructive.** | `-i` prompt; avoid recursive removal in this lab. | `rm -i disposable.txt` |
| 23 | `rmdir` | Remove an empty directory. | No common options needed. | `rmdir empty-folder` |
| 24 | `file` | Identify file type. | No common options for basic use. | `file notes.txt` |
| 25 | `wc` | Count lines, words, and bytes. | `-l` lines; `-w` words; `-c` bytes. | `wc -l sample.log` |
| 26 | `sort` | Sort lines of text. | `-r` reverse; `-n` numeric. | `sort names.txt` |
| 27 | `uniq` | Filter adjacent repeated lines. | `-c` count; usually sort input first. | `sort names.txt \| uniq -c` |
| 28 | `cut` | Extract fields or character positions. | `-d` delimiter; `-f` fields. | `cut -d: -f1 /etc/passwd` |
| 29 | `ps` | Display process information. | `aux` common BSD-style combination. | `ps aux` |
| 30 | `grep` with a pipe | Filter another command's output. | Combine with grep options. | `ps aux \| grep -i python` |
| 31 | `uptime` | Show uptime and load averages. | No common options for basic use. | `uptime` |
| 32 | `free` | Display memory usage. | `-h` human-readable. | `free -h` |
| 33 | `df` | Report filesystem disk space. | `-h` human-readable. | `df -h` |
| 34 | `du` | Estimate file/directory space use. | `-h` human-readable; `-s` summary. | `du -sh ~/linuxadmin-lab` |
| 35 | `ip addr` | Display network interfaces and addresses. | `show` subcommand. | `ip addr show` |
| 36 | `ip route` | Display the routing table. | `show` subcommand. | `ip route show` |
| 37 | `getent hosts` | Look up host information through configured name services. | Supply a hostname. | `getent hosts example.com` |
| 38 | `curl -I` | Request response headers from a URL. | `-I` headers only; use authorised targets. | `curl -I https://example.com` |
| 39 | `tar` | Create, list, or extract archives. | `-c` create; `-t` list; `-x` extract; `-z` gzip; `-f` archive filename. | `tar -czf backup.tar.gz source` |
| 40 | `sha256sum` | Calculate or verify SHA-256 checksums. | `-c` verify from a checksum file. | `sha256sum notes.txt` |
| 41 | `getent group` | Query group information. | Database and optional key. | `getent group` |
| 42 | `ssh` | Connect to a remote host securely. | `-p` port; `-i` identity file. | `ssh user@approved-host` |
| 43 | `scp` | Copy files over SSH. | `-P` port; `-r` directories. | `scp notes.txt user@approved-host:~/` |
| 44 | `crontab -l` | List the current user's scheduled cron jobs. | `-l` list; `-e` edit. | `crontab -l` |
| 45 | `journalctl` | Inspect systemd journal logs. | `-b` current boot; `-n N` recent lines. | `journalctl -n 30` |
| 46 | `systemctl` | Inspect/manage systemd units. | `status`, `is-active`, `list-units`; system changes may require admin rights. | `systemctl status ssh` |
| 47 | `bash` | Run the Bash shell or a script. | `-n` syntax check; `-x` trace execution. | `bash -n script.sh` |
| 48 | `sleep` | Pause for a specified interval. | Numeric duration. | `sleep 2` |
| 49 | `printf` | Print formatted text predictably. | Format string and arguments. | `printf 'Status: %s\n' 'OK'` |
| 50 | `sha256sum -c` | Check files against recorded checksums. | `-c` reads checksum records. | `sha256sum -c backup.sha256` |

### Command safety notes

- Commands and options vary by distribution, shell, permissions, and installed tools.
- Read paths carefully before moving or removing anything. For this lab, create and remove only disposable files you made yourself.
- Avoid `sudo`, `chmod`, `chown`, user/group modification, and service changes in restricted shared terminals. Do not attempt to repair a restricted terminal's administrative configuration.
- Use `ssh` and `scp` only with hosts and accounts you are authorised to access. Verify host keys; never paste private keys or passwords into shared notes.
- `journalctl` and `systemctl` may be unavailable in Webminal or non-systemd environments. Record the limitation and continue with available read-only checks.
- For scheduled jobs, use absolute paths and test commands manually before scheduling them.
- For backup exercises, list archive contents before extracting and restore into a separate directory.

## Hands-on Lab A — identity, navigation, files, and text

**Goal:** Establish your environment, create a safe workspace, and practise the core command set.

```bash
whoami
id
groups
pwd
echo "$SHELL"
uname -r
date
uptime

mkdir -p ~/linuxadmin-lab/source
cd ~/linuxadmin-lab
printf 'Linux Administration practice\n' > source/README.txt
printf 'INFO startup\nWARNING retry\nERROR sample failure\n' > source/sample.log
mkdir -p source/config
printf 'mode=practice\n' > source/config/lab.conf

ls -la
find source -type f -print
cat -n source/README.txt
grep -n "ERROR" source/sample.log
head -n 2 source/sample.log
tail -n 2 source/sample.log
wc -l source/sample.log
sort source/sample.log
file source/README.txt
```

**Check yourself**

1. Which command showed your effective username?
2. Which commands showed your current path and groups?
3. What is the difference between `head` and `tail`?
4. Why is `grep` useful when inspecting logs?
5. What does `find source -type f` exclude?

## Hands-on Lab B — permissions, storage, and system health

**Goal:** Read permissions and resource information without changing system settings.

```bash
cd ~/linuxadmin-lab
ls -l source
ls -ld source source/config
id
df -h
du -sh ~/linuxadmin-lab
free -h
ps aux | head
```

Record:
- The owner, group, and permission characters shown for one file.
- The filesystem with the most relevant available-space information for your environment.
- One observation from memory and process output.
- Why permission changes should be deliberate and least-privileged.

Do not run `chmod` or `chown` in this exercise.

## Hands-on Lab C — networking and remote access concepts

**Goal:** Inspect local network configuration and understand safe remote access.

```bash
ip addr show
ip route show
getent hosts example.com
curl -I https://example.com
```

If a command is unavailable or network access is restricted, record that fact rather than trying to bypass the restriction.

Answer:
1. Which interface appears to have an address?
2. What does the default route represent?
3. What role does DNS play?
4. What does `curl -I` request?
5. Before connecting with SSH, what should you verify about the host key and destination?

Do not attempt remote access unless an approved host and account have been provided.

## Hands-on Lab D — archive, checksum, and restore

**Goal:** Create a backup of the practice files, validate it, and restore to a separate location.

```bash
cd ~/linuxadmin-lab
tar -czf practice-backup.tar.gz source
tar -tzf practice-backup.tar.gz
sha256sum practice-backup.tar.gz > practice-backup.sha256
sha256sum -c practice-backup.sha256

mkdir -p restore-test
tar -xzf practice-backup.tar.gz -C restore-test
find restore-test -type f -print
cat restore-test/source/README.txt
```

Record the checksum result and one file-content verification.

**Quick-fire:** Explain the difference between a backup and synchronization. What do RPO and RTO mean? Why is a restore test necessary?

## Hands-on Lab E — process, logs, and incident triage

**Goal:** Use evidence before recommending action.

Run available read-only checks:

```bash
date
uptime
ps aux | head
df -h
free -h
```

If available in your environment, inspect recent system journal messages:

```bash
journalctl -n 30
```

**Scenario:** A fictional service user reports that an application is unavailable after a recent update.

Write a short triage note with:

| Field | Your notes |
|---|---|
| Observed symptom | |
| Scope and impact | |
| Start time / timeline | |
| Exact evidence collected | |
| Possible cause (hypothesis) | |
| Safe next check | |
| Verification required | |

Do not restart services or modify system files unless the instructor provides an approved disposable environment.

## Hands-on Lab F — shell scripting and scheduling

**Goal:** Create a small repeatable report script and inspect scheduling without changing system configuration.

Create a script:

```bash
cd ~/linuxadmin-lab
cat > system-report.sh <<'EOF'
#!/usr/bin/env bash
printf 'Linux Administration quick report\n'
printf 'Date: '
date
printf 'User: '
whoami
printf '\nWorking directory: '
pwd
printf '\nDisk summary:\n'
df -h
printf '\nMemory summary:\n'
free -h
EOF
bash -n system-report.sh
bash system-report.sh
```

Inspect the script and its output:

```bash
cat -n system-report.sh
```

Optional: list existing user cron entries without editing them:

```bash
crontab -l
```

A “no crontab” message or a missing command can be normal in a restricted environment. Do not create a scheduled job unless there is time, an approved environment, and a clear need. Explain why scheduled scripts should use predictable paths and handle failures.

## Hands-on Lab G — package, service, and security review

**Goal:** Connect operational concepts to safe administrative decisions.

Answer in your lab notes; use read-only commands only where available.

1. Why should software be installed from trusted repositories?
2. What evidence would you collect before investigating a failed service?
3. What is the difference between a process and a service?
4. Why should logs avoid passwords, tokens, and unnecessary personal data?
5. What is the purpose of least privilege?
6. Why should backups be stored separately from the source where feasible?
7. What should be checked after a security update?
8. Why should recovery instructions be tested rather than merely documented?

Optional read-only checks in a suitable systemd-based VM:

```bash
systemctl is-active ssh
systemctl --no-pager status ssh
journalctl -n 30
```

The service may have a different name or may not be installed. Do not enable, restart, install, or alter services as part of this review.

## Quick-fire practical challenge

Complete these without copying the full command sequence from above:

1. Print your username, groups, and current directory.
2. Create a nested practice directory and three text files.
3. Find all `.txt` files below the practice directory.
4. Search a sample log for the word `ERROR`.
5. Display disk and memory summaries.
6. Inspect one file's owner and permission notation.
7. Create an archive of the sample directory and list its contents.
8. Verify the archive checksum.
9. Restore the archive to a new directory and verify one file.
10. Write a short incident note that separates facts from assumptions.

## Final quick-fire review

Answer in one or two sentences each.

1. What is the difference between an absolute and a relative path?
2. What is the purpose of pipes (`|`)?
3. What do `df -h` and `du -sh` measure differently?
4. Why should you inspect an archive before extracting it?
5. What does a checksum verify—and what does it not verify?
6. Why are logs and timestamps important during troubleshooting?
7. Why should SSH host keys be verified?
8. What is the difference between RPO and RTO?
9. Why should scripts quote variable expansions such as `"$HOME"`?
10. Why is “one controlled change, then verify” safer than making many changes at once?

### Answer cues

1. Absolute paths start from the root; relative paths are interpreted from the current directory.
2. A pipe passes one command's output to another command as input.
3. `df` reports filesystem capacity/availability; `du` estimates space used by selected files/directories.
4. It helps detect unexpected paths and avoid extracting an untrusted archive blindly.
5. It checks that file content matches a recorded checksum; it does not prove completeness, safe storage, or successful recovery.
6. They establish a timeline and help correlate events with symptoms.
7. It helps detect unexpected host identity changes and reduces the risk of connecting to an impostor.
8. RPO concerns acceptable data loss; RTO concerns target recovery time.
9. Quoting generally preserves spaces and prevents unintended word splitting and pathname expansion.
10. It makes cause and effect easier to understand and reduces unintended impact.

## Lab completion checklist

- [ ] Command reference reviewed and practised
- [ ] Identity, navigation, file, and text commands completed
- [ ] Permissions and system-resource observations recorded
- [ ] Network outputs or environment limitations recorded
- [ ] Backup archive created and listed
- [ ] Checksum verified and restore tested separately
- [ ] Shell script syntax-checked and run
- [ ] Incident-triage note completed
- [ ] Security, service, package, and recovery questions answered

**Key takeaway:** Observe first, make changes deliberately, protect data, verify outcomes, and document evidence. A good Linux administrator does not merely run commands—the administrator understands their effects and confirms the result.

---

*Linux Administration · Practical Consolidation Guide*
