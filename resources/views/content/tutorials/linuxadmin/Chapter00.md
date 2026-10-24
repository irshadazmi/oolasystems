# Tutorial: Practical Linux Administration for Developers & Future System Administrators

Welcome to this hands-on tutorial for learning **Linux Administration** through practical, industry-oriented exercises. Across 15 one-hour lectures, we will build the skills needed to inspect, operate, secure, and troubleshoot a Linux environment using **Ubuntu, the command line, system utilities, and Bash**.

The tutorial is designed for **B.Tech students**. It connects Linux concepts to real tasks performed by developers, system administrators, cloud engineers, DevOps teams, and production support engineers.

Our examples will use a safe Linux lab. You can use **Ubuntu on WSL 2**, an Ubuntu virtual machine, an existing Linux system you are authorised to use, or an instructor-approved browser terminal where suitable. Some administration tasks require a full Linux VM or appropriate privileges; the tutorial will identify those requirements before each lab.

---

## About this Tutorial

The goal is to learn Linux by practising common operational tasks rather than memorising commands in isolation. Each chapter builds on skills introduced earlier and follows the 15-lecture **Linux Administration** syllabus.

Across the tutorial, you will practise how to:

- Explore Linux distributions, the kernel, the shell, and the filesystem.
- Navigate directories, find help, and use command-line tools confidently.
- Inspect and filter text and log files with pipes and redirection.
- Understand users, groups, permissions, ownership, and least privilege.
- Inspect packages, processes, system resources, services, and logs.
- Diagnose basic network and connectivity problems.
- Understand SSH and key-based remote administration.
- Inspect filesystems, mounts, and disk usage.
- Write a basic Bash script and schedule routine work.
- Apply introductory hardening, backup, and troubleshooting practices.

The examples use Ubuntu where possible. Commands and service-management details can differ between distributions, Linux environments, and permission levels; each lab will call out relevant limitations.

---

## What You Will Learn

This tutorial progresses from Linux fundamentals to practical system operations and a final troubleshooting capstone.

### 🐧 Linux Foundations and Command-Line Skills

- Linux ecosystem, distributions, kernel, shell, and common use cases
- Lab setup using WSL 2, a virtual machine, or an approved alternative
- Command-line essentials, paths, help, and directory navigation
- Files, text processing, pipes, redirection, and log searching

---

### 👥 Users, Groups, and Access Control

- User and group concepts
- Administrative privileges and the purpose of `sudo`
- File permissions and ownership
- `chmod`, `chown`, and default permissions with `umask`
- Least privilege and safe access-control practices

---

### 📦 Packages, Processes, and Services

- Package managers, repositories, and updates
- Process inspection and resource monitoring
- CPU, memory, and disk usage
- Services, `systemd`, service status, and service logs
- A systematic approach to diagnosing service failures

---

### 🌐 Networking and Remote Administration

- IP addresses, hostnames, DNS, and connectivity checks
- Common command-line networking tools
- SSH and secure remote access
- SSH keys and host verification
- Safe troubleshooting without disabling security controls blindly

---

### 💽 Storage, Logs, and Troubleshooting

- Filesystems, mount points, and disk utilisation
- System and service logs
- Evidence-based troubleshooting methodology
- Identifying likely causes before changing a system
- Recording findings and verifying the result of a change

---

### ⚙️ Bash Automation, Hardening, and Operations

- Bash scripts for repeatable administrative tasks
- Scheduling and basic automation
- Server-hardening and firewall fundamentals
- Backup and file-restoration concepts
- Runbooks, operational checks, and a practical capstone assessment

---

## Learning Approach

Each chapter is designed for a one-hour session and combines concise explanations with practical work. Depending on the topic, chapters may include:

- Concept explanations and architecture diagrams
- Realistic operational scenarios
- Commands with explanations and expected observations
- Step-by-step hands-on labs
- Safety notes and troubleshooting guidance
- Knowledge-check questions
- Practice exercises and review questions

We follow one principle throughout:

**Learn by doing. Inspect first, make a controlled change, and verify the outcome.**

You should understand what a command does before running it. Do not copy commands that delete files, alter permissions, modify system configuration, or change networking unless you understand the effect and are working in the designated lab environment.

---

## The 15-Lecture Learning Path

| Lecture | Topic | Practical focus |
|---:|---|---|
| 1 | Linux ecosystem, distributions, kernel, shell, and lab setup | Launch a Linux environment and inspect it |
| 2 | Command-line essentials, paths, help, and navigation | Practise commands and navigate directories |
| 3 | Files, text processing, pipes, and redirection | Search and filter sample log files |
| 4 | Users, groups, `sudo`, and access control | Explore user and group administration in a suitable lab |
| 5 | Permissions, ownership, `chmod`, `chown`, and `umask` | Configure a shared project directory in a lab |
| 6 | Packages, repositories, and updates | Inspect package information and install an approved package |
| 7 | Processes, CPU, memory, and disk monitoring | Inspect processes and resource usage |
| 8 | Services, `systemd`, and service logs | Inspect and troubleshoot a service where supported |
| 9 | Networking, IP addresses, DNS, and connectivity | Diagnose a simulated connectivity problem |
| 10 | SSH, keys, and remote administration | Generate an SSH key and examine host verification |
| 11 | Storage, filesystems, mounts, and disk usage | Inspect mount points and disk utilisation |
| 12 | System logs and troubleshooting methodology | Diagnose a supplied service-failure scenario |
| 13 | Bash scripting, scheduling, and automation | Write a disk-usage reporting script |
| 14 | Server hardening, firewall basics, and backups | Apply safe controls and test file restoration |
| 15 | Operations capstone, runbook, and assessment | Demonstrate a configured environment and troubleshoot a problem |

A few activities may need an Ubuntu VM or an instructor-managed environment because WSL 2 and browser terminals do not expose every system-administration feature in the same way as a full Linux server.

---

## Our Practice Environment

We will use a small, repeatable lab directory for exercises that create files or sample data. For example, you can keep course work under:

```bash
mkdir -p ~/linux-lab
cd ~/linux-lab
pwd
```

The `mkdir -p` command creates the directory if it does not already exist. `cd` moves into it, and `pwd` prints the current working directory.

### Recommended options

- **Ubuntu on WSL 2:** a convenient choice for students using a compatible Windows laptop.
- **Ubuntu virtual machine:** useful for tasks that need a more complete isolated Linux system.
- **Existing Linux system:** suitable when you have permission to use it for the course.
- **Browser terminal:** useful for selected command-line exercises; availability of `sudo`, services, networking, and storage features may be limited.

Use the environment specified by the instructor for each exercise. Do not use a production server, a shared university server, or another person's machine for experiments.

---

## A Typical Operational Scenario

Imagine that a web application hosted on a Linux server becomes slow or unavailable. An administrator should gather evidence before making changes.

```text
User reports a problem
        ↓
Inspect the service and recent logs
        ↓
Check CPU, memory, disk, and connectivity
        ↓
Form and test a likely explanation
        ↓
Make an authorised, limited change if needed
        ↓
Verify recovery and document the result
```

This approach is relevant to web applications, APIs, databases, cloud virtual machines, container hosts, and CI/CD infrastructure. The goal is not to guess or restart everything; it is to identify the failing layer and act safely.

---

## Safe Lab Guidelines

- Work only in your own lab environment or one explicitly approved by the instructor.
- Start with inspection commands before making changes.
- Use `sudo` only when it is required, authorised, and understood.
- Never expose passwords, private SSH keys, access tokens, or personal data in screenshots or shared files.
- Do not disable a firewall or security feature simply to make a lab command work.
- Avoid destructive commands and system-wide changes unless the exercise explicitly calls for them in an isolated lab.
- For cloud resources, confirm the account, cost limits, and instructor approval before creating anything that could incur charges.
- Record the command used, the observed result, and any conclusion you draw.

---

## Who Should Use This Tutorial?

This tutorial is intended for B.Tech students and beginners who want practical Linux skills for:

- Software development and application deployment
- Cloud computing and DevOps foundations
- Technical support and production operations
- System administration and infrastructure troubleshooting
- Understanding the Linux environments used by servers and automation tools

No prior system-administration experience is assumed. Basic familiarity with using a computer and typing commands will help.

---

## How to Use the Chapters

1. Read the concept and scenario before starting the lab.
2. Open the Linux environment required for that chapter.
3. Type commands yourself and inspect their output.
4. Complete the exercise and record your observations.
5. Attempt the knowledge-check questions without looking at the notes.
6. Keep your lab files organised so you can reuse them in later lectures.

When a command behaves differently on your system, note the exact command, environment, and error message. Differences are useful evidence for troubleshooting.

---

## Key Takeaways

- Linux administration is about understanding and operating a system safely—not just memorising commands.
- The shell provides a practical interface to Linux utilities and administrative tools.
- System administrators inspect evidence, test hypotheses, and verify changes.
- Users, permissions, services, networking, storage, logs, and automation are connected parts of reliable operations.
- Hands-on practice should take place in a controlled environment with least privilege and clear safety boundaries.
- By the end of the 15 lectures, you will have practised a foundation of Linux operations and completed a troubleshooting-oriented capstone.

---

## Next Chapter

👉 **Chapter 1: Linux Ecosystem, Distributions, Kernel, Shell, and Lab Setup**
