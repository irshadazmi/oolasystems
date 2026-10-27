# Chapter 16 — 3 Hours Hands Dirty with Cybersecurity

**Practical consolidation guide | Cybersecurity & Practices**

> **Purpose:** Quickly revise the most important concepts from Chapters 1–15, then spend most of the session doing practical work. Use this as a single-glance lab sheet. It is not a replacement for the detailed chapters.

## Quick-fire revision: concepts to recall

Use these prompts for a rapid oral or written recap. Keep answers short; then apply the concepts in the labs.

| Topic | Quick-fire question / reminder |
|---|---|
| Security foundations | What do confidentiality, integrity, and availability protect? |
| Threats and risk | Distinguish a threat, a vulnerability, and a risk. Risk is commonly assessed using likelihood and impact. |
| Passwords and MFA | Why is a unique password plus MFA stronger than a password alone? |
| Phishing | Check sender, domain, unexpected urgency, attachments, and requests for credentials or payment. |
| Networking | What are the roles of IP addresses, ports, DNS, HTTP, and HTTPS? |
| Linux identity | Which user are you running as, and which groups apply to that user? |
| Least privilege | Give each account only the permissions needed for its tasks. |
| Logs and evidence | Separate observed facts from assumptions; preserve timestamps and context. |
| Incident response | Report, triage, contain through approved procedures, preserve evidence, recover, and review. |
| Web security | Authentication answers “who are you?”; authorisation answers “what are you allowed to do?” |
| Input validation | Validate on the server; use allow-lists and sensible length/type/range checks. |
| SQL injection | Use parameterised queries; do not build SQL by concatenating untrusted input. |
| Endpoint security | Keep systems updated, use built-in protection, and verify backups and recovery. |
| Cloud IAM and secrets | Use named identities, least privilege, managed secret storage, rotation, and audit logs. |
| Secure delivery | Review dependencies, scan code and secrets, protect build pipelines, and define release gates. |
| Governance | Assign each significant risk an owner, treatment, due date, and review metric. |

## UNIX/Linux lab command reference

Use a permitted Linux terminal, such as your own Ubuntu/WSL2 environment or an instructor-approved training terminal. The commands below are primarily for observation and safe file practice. Examples using `jspm_team` or `/home/projects/jspm` are illustrative names only.

| # | Name / Command | Brief Description | Most Common Options | Simple Examples |
|---:|---|---|---|---|
| 1 | `whoami` | Print the effective username. | No common options needed. | `whoami` |
| 2 | `id` | Show user ID, primary group, and supplementary groups. | `-u` user ID; `-g` primary group ID; `-G` group IDs; `-n` names. | `id` · `id suresh` · `id -nG` |
| 3 | `pwd` | Print the current working directory. | `-L` logical path; `-P` physical path. | `pwd` |
| 4 | `echo "$SHELL"` | Display the `SHELL` environment variable. | Shell built-in; options vary by shell. | `echo "$SHELL"` |
| 5 | `ls` | List directory contents. | `-l` long format; `-a` hidden files; `-la` both; `-d` directory itself. | `ls -la` · `ls -ld /home/projects/jspm` |
| 6 | `getent group` | Query group information from system databases. | Supply a database and optional key; no common flag required. | `getent group` · `getent group jspm_team` |
| 7 | `groups` | Show groups associated with a user. | Optional username. | `groups` · `groups suresh` |
| 8 | `cat` | Display a text file. | `-n` number lines; `-A` show line endings and special characters. | `cat notes.txt` · `cat -n notes.txt` |
| 9 | `less` | View a file page by page. | `-N` show line numbers. Press `q` to quit. | `less notes.txt` · `less -N notes.txt` |
| 10 | `head` | Display the first lines of a file. | `-n N` number of lines. | `head -n 10 notes.txt` |
| 11 | `tail` | Display the last lines of a file. | `-n N` number of lines; `-f` follow updates (use only when appropriate). | `tail -n 20 sample.log` |
| 12 | `grep` | Search text for a pattern. | `-i` ignore case; `-n` line numbers; `-r` recursive; `-E` extended patterns. | `grep -n "error" sample.log` |
| 13 | `find` | Search for files/directories by criteria. | `-name` name pattern; `-type f` files; `-type d` directories. | `find . -type f -name "*.txt"` |
| 14 | `mkdir` | Create a directory. | `-p` create parent directories as needed. | `mkdir lab-notes` · `mkdir -p practice/week1` |
| 15 | `touch` | Create an empty file or update timestamps. | No common options needed for basic use. | `touch notes.txt` |
| 16 | `cp` | Copy files/directories. | `-i` ask before overwrite; `-r` copy directories. | `cp -i notes.txt notes-copy.txt` |
| 17 | `mv` | Move or rename files. | `-i` ask before overwrite. | `mv notes-copy.txt archive.txt` |
| 18 | `rm` | Remove files. **Destructive: verify the path first.** | `-i` prompt before each removal; avoid recursive removal in beginner labs. | `rm -i practice-copy.txt` |
| 19 | `rmdir` | Remove an empty directory. | No common options needed. | `rmdir empty-folder` |
| 20 | `file` | Identify a file's type. | No common options needed for basic use. | `file notes.txt` |
| 21 | `wc` | Count lines, words, and bytes. | `-l` lines; `-w` words; `-c` bytes. | `wc -l sample.log` |
| 22 | `sort` | Sort lines of text. | `-r` reverse; `-n` numeric sort. | `sort names.txt` · `sort -n scores.txt` |
| 23 | `uniq` | Report or filter adjacent repeated lines. | `-c` count occurrences; input usually sorted first. | `sort names.txt \| uniq -c` |
| 24 | `cut` | Extract fields or character positions. | `-d` delimiter; `-f` fields. | `cut -d: -f1 /etc/passwd` |
| 25 | `history` | Show commands recorded by the shell. | Options vary by shell. | `history` |
| 26 | `man` | Open a command's manual page. | `-k` search manual descriptions. | `man ls` · `man -k permissions` |
| 27 | `command --help` | Display brief usage information where supported. | `--help` is common but not universal. | `ls --help` · `grep --help` |
| 28 | `uname` | Display system/kernel information. | `-a` all available information; `-r` kernel release. | `uname -r` · `uname -a` |
| 29 | `uptime` | Show uptime and load averages. | No common options needed for basic use. | `uptime` |
| 30 | `df` | Report filesystem disk space. | `-h` human-readable sizes. | `df -h` |
| 31 | `du` | Estimate file/directory space use. | `-h` human-readable; `-s` summary. | `du -sh lab-notes` |
| 32 | `free` | Display memory usage. | `-h` human-readable. | `free -h` |
| 33 | `ps` | Display process information. | `aux` is a common BSD-style combination. | `ps aux` |
| 34 | `grep` with a pipe | Filter output from another command. | Combine with grep options above. | `ps aux \| grep -i firefox` |
| 35 | `date` | Display current date/time. | `-u` UTC; formatting options vary. | `date` · `date -u` |
| 36 | `ip addr` | Display network interface addresses. | `show` is commonly used as a subcommand. | `ip addr show` |
| 37 | `ip route` | Display routing table. | `show` is commonly used as a subcommand. | `ip route show` |
| 38 | `getent hosts` | Look up host information through configured name services. | Supply a hostname. | `getent hosts example.com` |
| 39 | `curl -I` | Request response headers from a URL. | `-I` headers only; use only with authorised targets. | `curl -I https://example.com` |
| 40 | `sha256sum` | Calculate a SHA-256 checksum for a file. | `-c` verify checksums from a file. | `sha256sum sample.txt` |

### Command safety notes

- Commands and options can vary by Linux distribution, shell, permissions, and installed tools.
- `id suresh` only works if that account exists and the environment permits the lookup.
- Do not create or modify system groups during this revision unless the instructor explicitly authorises it and provides an administrative environment. Group-management commands such as `groupadd` require administrative privileges.
- Avoid `sudo`, `chmod`, and `chown` in restricted shared terminals if the environment does not support administrative operations. Do not attempt to repair the terminal's `sudo` configuration.
- For `curl`, use the example only for a permitted target; never run scans or send crafted requests to public systems.
- `rm` permanently removes files in many environments. Practise only with a disposable file you created yourself.

## Hands-on Lab A — identity, directories, files, and search

**Goal:** Practise common UNIX commands and capture evidence of what each one does.

### A1. Establish your environment

Run the following and write down what each output tells you:

```bash
whoami
id
groups
pwd
echo "$SHELL"
uname -r
uptime
```

### A2. Create a disposable practice workspace

```bash
mkdir -p cyber-lab/week1
cd cyber-lab/week1
pwd
touch notes.txt
echo "Security practice: evidence matters." > notes.txt
cat notes.txt
cp notes.txt notes-copy.txt
ls -la
file notes.txt
wc -w notes.txt
```

### A3. Search and inspect

```bash
printf "INFO login\nWARNING retry\nERROR denied\n" > sample.log
cat -n sample.log
grep -n "ERROR" sample.log
head -n 2 sample.log
tail -n 2 sample.log
sort sample.log
```

Answer:
1. Which command showed your effective username?
2. Which command displayed your groups?
3. What does `ls -la` show that plain `ls` may not?
4. What did `grep` find in `sample.log`?
5. Why should an investigator preserve the original log before analysis?

### A4. Inspect system resources

```bash
df -h
free -h
ps aux | head
```

Explain the difference between disk space, memory, and running processes.

## Hands-on Lab B — permissions and least privilege

**Goal:** Read permission information without changing system permissions.

1. Run `ls -l` in your practice folder.
2. Identify the file owner, group, and permission characters.
3. Explain the difference between read, write, and execute permission for a file and for a directory.
4. Run `id` and compare your current identity with the owner/group shown by `ls -l`.
5. Describe one reason a web application should not run with unnecessary administrative privileges.

Do not use `chmod` or `chown` for this exercise. Focus on reading and explaining the permissions shown by the environment.

## Hands-on Lab C — network and packet observation

**Goal:** Connect network concepts to evidence.

1. Run `ip addr show` and identify an interface and its address.
2. Run `ip route show` and explain what a default route is.
3. Run `getent hosts example.com` and record the returned address if name resolution is available.
4. If Wireshark is available, open an instructor-supplied capture file and try these display filters:

| Task | Filter |
|---|---|
| DNS | `dns` |
| TCP | `tcp` |
| HTTP in the lab capture | `http` |
| TLS handshake | `tls.handshake` |

5. Record two observations: timestamp, protocol, source/destination, and a cautious interpretation.

Do not capture other people's traffic. Use only supplied or explicitly authorised captures.

## Hands-on Lab D — web security review

**Goal:** Identify a risk and propose a secure fix using a designated training lab or instructor-provided example.

Use only an assigned OWASP Juice Shop instance or a designated PortSwigger Web Security Academy lab. If no training target is available, use the questions below as a design review.

- [ ] Is access control enforced on the server for every protected object/action?
- [ ] Are authentication failures and suspicious sign-ins handled and logged appropriately?
- [ ] Are session cookies protected with appropriate attributes, such as `Secure`, `HttpOnly`, and `SameSite` where applicable?
- [ ] Is user input validated on the server?
- [ ] Are database queries parameterised instead of built by concatenating user input?
- [ ] Are errors prevented from exposing secrets, stack traces, or internal configuration?
- [ ] Are dependencies and software components reviewed for known vulnerabilities?
- [ ] Are logs useful for detection without storing passwords, tokens, or unnecessary personal data?

### Safe parameterised-query example

```python
cursor.execute(
    "SELECT id, name FROM students WHERE email = %s",
    (email,)
)
```

Placeholder syntax varies by database driver. The principle is to pass input values separately from the SQL statement structure.

Complete one finding:

| Field | Notes |
|---|---|
| Evidence observed | |
| Potential impact | |
| Root cause | |
| Recommended fix | |
| How to retest safely | |

## Hands-on Lab E — incident triage and evidence

**Scenario:** A fictional student account has several failed sign-ins, one successful sign-in from an unfamiliar location, and an unexpected export of records.

1. List the events in chronological order.
2. Separate facts from assumptions.
3. Assess severity using likely impact and scope.
4. List safe first actions: report through the approved channel, protect the account using authorised procedures, and preserve relevant logs.
5. Record the evidence source, timestamp, collector, and any integrity check required by the lab.
6. Write a three-sentence incident update: what is known, what action is underway, and when the next update is due.

Do not delete logs, attempt unauthorised access, or contact a suspected attacker.

## Hands-on Lab F — cloud, secrets, and secure delivery

**Goal:** Review a fictional application deployment.

Scenario: a developer committed an API key to source control; all developers share an administrator account; dependencies are not reviewed; and backups have not been restore-tested.

| Risk | Practical control |
|---|---|
| Exposed API key | Revoke/rotate it, check usage logs, remove it from active code, and address repository history under policy. |
| Shared administrator account | Use named identities, role-based access, and least privilege. |
| Unreviewed dependencies | Maintain dependency records and use available vulnerability scanning. |
| Secrets embedded in builds | Inject secrets from an approved secret store at deployment; do not bake them into source or images. |
| Untested backups | Schedule and record a safe restore test. |
| Weak release process | Add code review, automated checks, approval, monitoring, and rollback planning. |

Choose the two most serious risks and explain why you prioritised them.

## Hands-on Lab G — build a risk register

Choose one finding from the previous labs.

| ID | Asset / process | Risk statement | Likelihood (1–5) | Impact (1–5) | Score | Treatment | Owner / due date |
|---|---|---|---:|---:|---:|---|---|
| R-01 | Example: student portal | A compromised account may expose records because access controls are insufficient. | 3 | 5 | 15 | Review MFA and server-side authorisation; monitor suspicious access. | Assign a real owner and date for the exercise. |

The row is illustrative only; it is not an assessment of any real institution. Calculate `Risk score = Likelihood × Impact`, prioritise the issue, and name one metric that could show whether the treatment is working.

Possible metrics: MFA coverage, critical patch compliance, successful backup restore-test rate, time to detect an incident, or overdue high-risk findings.

## Final quick-fire review

Answer in one or two sentences each.

1. What is the difference between a threat, vulnerability, and risk?
2. Why does least privilege still matter when MFA is enabled?
3. Why are parameterised SQL queries safer than string concatenation?
4. What should happen first when an API key is exposed?
5. Why must evidence be distinguished from assumptions?
6. Give one metric that can show whether a security control is working.

### Instructor answer cues

1. A threat can cause harm; a vulnerability is a weakness; risk combines likelihood and impact.
2. MFA protects sign-in, while least privilege limits the damage possible after account compromise.
3. Parameterisation separates input data from SQL structure.
4. Revoke/rotate the key, investigate its use, then remove it from active code and handle repository history according to policy.
5. Evidence is an observed/recorded fact; an assumption is an interpretation that needs validation.
6. Examples include MFA coverage, patch compliance, restore-test success, or time to detect/contain.

## Lab completion checklist

- [ ] UNIX/Linux command reference reviewed and commands practised
- [ ] Identity, groups, files, search, and resource commands explained
- [ ] Permission notation and least privilege reviewed
- [ ] Network/packet observations recorded
- [ ] One web-security finding and safe remediation documented
- [ ] Incident timeline and evidence notes completed
- [ ] Cloud secret and secure-delivery risks reviewed
- [ ] Risk register entry prioritised with treatment and owner

**Key takeaway:** Identify assets and risks, apply proportionate controls, observe evidence, respond through approved procedures, and verify that improvements work.

---
*Cybersecurity & Practices · Practical Consolidation Guide*
