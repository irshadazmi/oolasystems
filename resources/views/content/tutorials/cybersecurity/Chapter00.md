# Tutorial: Practical Cybersecurity & Practices for Developers and Future Security Professionals

Welcome to this hands-on tutorial for learning **Cybersecurity & Practices** through practical, industry-oriented exercises. Across 15 one-hour lectures, we will build foundational skills to recognise security risks, protect accounts and systems, examine evidence, assess web application weaknesses, and recommend practical mitigations.

The tutorial is designed for **B.Tech students**. It connects cybersecurity concepts to tasks performed by software developers, IT support teams, system administrators, cloud engineers, security analysts, and incident-response teams.

Our activities use safe, controlled learning environments: sample data, instructor-provided packet captures, intentionally vulnerable training applications such as **OWASP Juice Shop**, and approved learning resources. Perform security testing only on systems you own or have explicit permission to test.

---

## About this Tutorial

The goal is to learn cybersecurity by applying concepts to realistic scenarios rather than memorising terminology in isolation. Each chapter builds on earlier skills and follows the 15-lecture **Cybersecurity & Practices** syllabus.

Across the tutorial, you will practise how to:

- Explain the confidentiality, integrity, and availability (CIA) triad.
- Identify assets, threats, vulnerabilities, likelihood, impact, and risk.
- Recognise phishing attempts and improve password, MFA, and account-protection practices.
- Use basic networking tools to inspect IP addresses, ports, DNS, and HTTP/HTTPS behaviour.
- Understand Linux accounts, file permissions, and least privilege.
- Examine sample authentication logs and preserve useful evidence.
- Map application scenarios to common web security risks, including OWASP Top 10 topics.
- Review authentication and session-management workflows.
- Compare unsafe SQL construction with parameterized database queries.
- Practise in an intentionally vulnerable web application in an isolated lab.
- Inspect a supplied network packet capture with Wireshark.
- Prepare endpoint-hardening, patching, backup, and recovery checklists.
- Review cloud IAM, API keys, secrets, and secure software-delivery practices.
- Work through an incident-response tabletop exercise and present evidence-based recommendations.

The examples are introductory and defensive. Tool availability and commands can vary by operating system and lab environment; each activity should identify its prerequisites and limitations.

---

## What You Will Learn

This tutorial progresses from security foundations to practical analysis, prevention, response, and a final mini-project assessment.

### 🔐 Security Foundations and Account Protection

- Cybersecurity foundations, the CIA triad, threats, vulnerabilities, and risk
- Asset–threat–control mapping and basic risk assessment
- Password hygiene, multi-factor authentication (MFA), phishing, and account protection
- Recognising suspicious messages and describing safer user actions

---

### 🌐 Networking and Linux Security Basics

- IP addresses, ports, DNS, HTTP, and HTTPS
- Basic network commands and `curl` for approved connectivity checks
- Linux accounts, permissions, and least privilege
- Reading sample authentication logs and documenting investigation evidence

---

### 🕸️ Web Application Security

- OWASP Top 10 and common web application risks
- Authentication, session management, and secure access
- Input validation, injection, and secure database access
- Comparing unsafe SQL examples with parameterized queries
- Introductory, authorised practice with OWASP Juice Shop in an isolated lab

---

### 🧰 Network, Endpoint, and Cloud Protection

- Inspecting a supplied packet capture using Wireshark
- Endpoint protection, patching, and backup practices
- Cloud security fundamentals, identity and access management (IAM), API keys, and secrets
- Secure software delivery and dependency-risk review

---

### 🚨 Incident Response and Security Assessment

- Incident response, containment, and recovery
- Evidence-based investigation and clear documentation
- Tabletop exercises for practising response decisions
- Mini-project presentations that communicate findings, evidence, risk, and mitigations

---

## Learning Approach

Each chapter is designed for a one-hour session and combines concise explanations with practical work. Depending on the topic, chapters may include:

- Concept explanations and simple diagrams
- Realistic security scenarios
- Step-by-step hands-on labs using free or instructor-approved tools
- Sample logs, packet captures, code snippets, or intentionally vulnerable applications
- Safety notes and troubleshooting guidance
- Knowledge-check questions
- Practice exercises and review questions

We follow one principle throughout:

**Use authorised labs, collect evidence carefully, explain the risk, and recommend a verifiable mitigation.**

Do not test a public website, university system, another student's account, or any third-party service unless you have explicit authorisation and a clearly defined scope. Never collect, expose, or share real passwords, tokens, private keys, or personal data.

---

## The 15-Lecture Learning Path

| Lecture | Topic | Practical focus |
|---:|---|---|
| 1 | Cybersecurity foundations, CIA triad, threats, vulnerabilities and risk | Create an asset–threat–control matrix |
| 2 | Passwords, MFA, phishing and account protection | Analyse phishing examples and security practices |
| 3 | Networking for security: IP, ports, DNS, HTTP/HTTPS | Use basic networking commands and curl |
| 4 | Linux accounts, permissions and least privilege | Create users and inspect file permissions |
| 5 | Logs, evidence and incident investigation | Analyse sample authentication logs |
| 6 | OWASP Top 10 and web application risks | Map scenarios to common vulnerabilities |
| 7 | Authentication, session management and secure access | Review a sample login workflow |
| 8 | Input validation, injection and secure database access | Compare unsafe and parameterized SQL examples |
| 9 | Practical web security using OWASP Juice Shop | Complete a beginner challenge in an isolated lab |
| 10 | Network traffic analysis using Wireshark | Inspect a supplied packet capture |
| 11 | Endpoint protection, patching and backups | Prepare a workstation hardening checklist |
| 12 | Cloud security, IAM, API keys and secrets | Review a sample cloud/API architecture |
| 13 | Secure software delivery and dependency risks | Review a repository security checklist |
| 14 | Incident response, containment and recovery | Conduct an incident-response tabletop exercise |
| 15 | Mini-project presentations and assessment | Present findings, evidence and mitigations |

A few activities may require an instructor-provided environment, sample packet capture, or intentionally vulnerable training application. Do not substitute a real production target for a lab exercise.

---

## Our Practice Environment

Use the environment specified by the instructor for each exercise. Depending on the lecture, you may work with:

- **A local computer or approved Linux environment** for basic commands and file-permission exercises.
- **Sample files** containing fictional authentication events, security scenarios, or application data.
- **Wireshark** with an instructor-provided packet capture for network-traffic analysis.
- **OWASP Juice Shop** or another intentionally vulnerable training application, run locally or through an instructor-approved isolated lab.
- **OWASP Web Security Academy** for guided web-security learning where appropriate.
- **Code snippets and sample repositories** for reviewing SQL queries, authentication flows, and dependency-security checklists.

Install software only from trusted official sources and follow the instructor's setup instructions. Do not scan, attack, or probe systems outside the authorised lab scope.

---

## A Typical Security Scenario

Imagine that a student reports a suspicious login notification, or an application team discovers an unexpected authentication failure. A disciplined security practitioner should establish facts before taking action.

```text
A report or alert is received
        ↓
Identify the affected asset and define the scope
        ↓
Collect relevant logs or other approved evidence
        ↓
Assess the likely threat, impact, and risk
        ↓
Recommend or apply an authorised, limited control
        ↓
Verify the result and document lessons learned
```

This approach is relevant to web applications, endpoints, networks, cloud services, and software delivery. The aim is to make evidence-based decisions—not to guess, overreact, or perform unapproved testing.

---

## Safe Lab Guidelines

- Work only on your own systems, instructor-provided exercises, or targets explicitly authorised for the activity.
- Read the scope and instructions before starting any security lab.
- Use fictional/sample data whenever possible.
- Do not attempt to access another person's account or data.
- Never publish passwords, MFA codes, API keys, access tokens, private keys, or sensitive logs.
- Do not run scans or exploitation tools against public websites or university systems without written permission.
- Keep intentionally vulnerable applications isolated from personal files, accounts, and production networks.
- Do not disable security controls simply to make an exercise work.
- Record the tool, action, observation, potential impact, and recommended mitigation.
- If you discover a possible real vulnerability accidentally, stop testing and report it through the appropriate authorised channel.

---

## Who Should Use This Tutorial?

This tutorial is intended for B.Tech students and beginners who want practical cybersecurity skills relevant to:

- Secure software development and web application testing
- IT support and endpoint protection
- Linux and system administration
- Network security and traffic analysis
- Cloud security and identity/access management
- Security operations and incident-response foundations
- Secure software delivery and dependency-risk awareness

No prior professional cybersecurity experience is assumed. Basic computer literacy and willingness to follow lab instructions carefully will help.

---

## How to Use the Chapters

1. Read the concept and scenario before starting the lab.
2. Check the prerequisites and confirm that the target or data is authorised for use.
3. Follow the steps in the approved environment and record what you observe.
4. Explain the security significance of the evidence—not just the tool output.
5. Recommend a mitigation and describe how you would verify it.
6. Attempt the knowledge-check questions without looking at the notes.
7. Keep lab notes free of passwords, tokens, personal data, and other secrets.

When a tool behaves differently on your system, record the environment, exact command or action, and error message. Treat the output as evidence to investigate, not as proof of a conclusion by itself.

---

## Key Takeaways

- Cybersecurity combines people, processes, and technology; it is not limited to hacking tools.
- Risk assessment connects assets, threats, vulnerabilities, likelihood, impact, and controls.
- Account protection, least privilege, secure coding, patching, backups, and monitoring reduce common risks.
- Logs and packet captures can support investigations when handled carefully and interpreted in context.
- Web, endpoint, network, cloud, and software-delivery security are connected parts of a broader security practice.
- Safe practice requires authorisation, clear scope, isolated labs, careful evidence handling, and verifiable mitigations.
- By the end of the 15 lectures, you will have practised core security workflows and presented findings and mitigations in a mini-project assessment.

---

## Next Chapter

👉 **Chapter 1: Cybersecurity Foundations, CIA Triad, Threats, Vulnerabilities, and Risk**
