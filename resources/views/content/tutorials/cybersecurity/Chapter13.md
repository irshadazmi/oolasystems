# Chapter 13: Secure Software Delivery and Dependency Risks

Secure software delivery integrates security into requirements, architecture, coding, testing, release, and operations. Modern applications rely on open-source libraries, build tools, container images, CI/CD platforms, service identities, and deployment artefacts. A weakness in any of these inputs can affect the final product—even when the application code itself appears correct.

This chapter focuses on practical security architecture and engineering controls that help teams reduce risk throughout the software development life cycle (SDLC).

> **Lab safety:** Use a sample repository or an instructor-approved project. Do not scan repositories or systems without permission, publish credentials, execute untrusted packages, or attempt to compromise a CI/CD service. Treat scanner findings as leads to review, not proof that an exploit exists.

## Learning objectives

By the end of this chapter, you should be able to:

- Explain why security must be built into the SDLC rather than added only before release.
- Draw a secure delivery architecture with code review, automated checks, controlled build, release gates, and monitoring.
- Describe common dependency and software supply-chain risks.
- Explain the roles and limitations of static analysis, dependency scanning, secret scanning, and software testing.
- Recommend controls for CI/CD credentials, build runners, artefact integrity, and release approval.
- Conduct a small, safe review of a sample repository and produce a prioritised remediation report.

## 1. Industry scenario: a vulnerable library reaches production

A team deploys a student-services application. A library used by the application is later reported to have a serious vulnerability. The team does not know which release introduced the dependency, which services use it, whether the deployed artefact matches the approved build, or who can deploy directly to production.

This is not only a coding problem. It is a delivery-system problem: dependency inventory, version control, build provenance, release approval, and operational ownership are all needed to respond quickly.

## 2. Secure SDLC architecture

Security activities should appear throughout the lifecycle. During planning, teams identify assets and abuse cases. During design, they define trust boundaries and secure defaults. During implementation, they review code and dependencies. Before release, they verify controls and decide how to handle findings. During operations, they monitor, patch, and learn from incidents.

![Secure SDLC architecture](/images/tutorials/cybersecurity/ch13-secure-sdlc-architecture.png)

### Security activities by stage

| Stage | Example security activities | Evidence |
|---|---|---|
| Plan | Identify sensitive data, users, trust boundaries, abuse cases, and requirements | Threat model and security requirements |
| Design | Define authentication, authorisation, data flows, failure behaviour, and secure defaults | Architecture decision and design review |
| Build | Code review, static analysis, secret scanning, dependency inventory | Review approvals and scan results |
| Verify | Unit/integration tests, security tests, configuration review, dependency checks | Test results and tracked findings |
| Release | Approve artefacts, restrict deployment permissions, confirm rollback plan | Release record and artefact identity |
| Operate | Monitor events, patch components, review alerts, improve controls | Logs, incident records, remediation evidence |

## 3. What automated security checks can and cannot do

| Control | What it helps identify | Limitations |
|---|---|---|
| Static Application Security Testing (SAST) | Potential insecure patterns in source code | Can miss runtime/context issues and produce false positives |
| Software Composition Analysis (SCA) | Known vulnerabilities and licensing or inventory concerns in dependencies | Depends on inventory quality and advisory data; not every finding is exploitable in context |
| Secret scanning | Credential-like strings in code and repository history | May miss transformed, generated, or unsupported secret formats |
| Dynamic Application Security Testing (DAST) | Some behaviours and vulnerabilities in a running application | Coverage depends on reachable paths, test setup, and authentication |
| Unit and integration tests | Expected behaviour and regression protection | Only cover scenarios the team has designed and run |
| Manual review / threat modelling | Design flaws, trust-boundary issues, and context | Requires time, expertise, and clear scope |

Use tools as part of a process that assigns findings, validates context, prioritises risk, and verifies fixes. A clean scan is not a guarantee that software is secure.

## 4. CI/CD pipeline architecture

A continuous integration and continuous delivery/deployment pipeline should be treated as part of the production security boundary. Anyone who can alter build definitions, access deployment credentials, or publish an artefact may be able to affect what reaches users.

![Secure CI/CD pipeline](/images/tutorials/cybersecurity/ch13-secure-cicd-pipeline.png)

### Recommended controls

- Protect important branches and require review for security-sensitive changes.
- Run tests, secret scanning, and dependency checks automatically where feasible.
- Pin or lock dependency versions and use trusted registries and approved sources.
- Keep build runners isolated and regularly maintained; avoid unnecessary privileges.
- Use short-lived or narrowly scoped pipeline identities where supported.
- Keep production credentials out of source code and ordinary build logs.
- Restrict who can approve and execute production deployments.
- Preserve artefact identity, build logs, approvals, and deployment records.
- Define how findings are triaged and how exceptions are approved, owned, and expired.

## 5. Software supply-chain risk

The software supply chain includes source code, third-party dependencies, package registries, build tools, CI/CD workflows, secrets, container images, artefacts, and release channels. An attacker or accidental error at one stage can compromise downstream software.

![Software supply-chain threat model](/images/tutorials/cybersecurity/ch13-software-supply-chain-threat-model.png)

### Example risks and controls

| Risk | Possible impact | Design control |
|---|---|---|
| Vulnerable or abandoned dependency | Exploitation, data exposure, service disruption | Inventory dependencies, monitor advisories, update and verify |
| Typosquatted or untrusted package | Malicious code executes during build or runtime | Use trusted registries, verify package identity, review new dependencies |
| Dependency versions are not reproducible | Different builds include unexpected code | Use lockfiles, pinned versions, controlled update procedures |
| Build runner is overprivileged | Build compromise can affect production | Isolate runners and scope credentials and network access |
| Secret leaks into repository or logs | Unauthorised access to systems or data | Secret scanning, redaction, revocation, and secure secret injection |
| Artefact is replaced after approval | Unreviewed code reaches production | Verify artefact identity and integrity; control promotion |
| Unreviewed pipeline changes | Attackers can alter build or deployment behaviour | Protect pipeline definitions and require review |

## 6. Practical lab: review a sample repository safely

**Required:** an instructor-provided sample repository or a small project you own. Work locally or in the approved classroom environment. Do not execute an unfamiliar package just because a scanner recommends it.

### Task A — Establish the baseline

1. Record the repository name and commit or version under review.
2. Identify the language, package manager, dependency manifest, and lockfile if present.
3. Locate the documented build and test commands; do not run scripts you do not understand.
4. Check whether a `.env` file or other local configuration could contain secrets. Do not open or copy real credentials into your report.

### Task B — Review the dependency posture

1. Inspect the manifest and lockfile to understand declared dependencies and version constraints.
2. Use an approved dependency scanner or instructor-provided scan report if available.
3. For each finding, record package name, affected version, advisory reference, severity, and whether the package is used in the relevant execution path—if known.
4. Do not assume a finding is exploitable solely because it is listed. Record uncertainty and request review where necessary.
5. Propose a supported update or mitigation and identify the tests required to validate it.

### Task C — Review the delivery controls

Answer these questions using the sample repository or a provided pipeline diagram:

- Are important changes reviewed before merging?
- Are dependencies locked or otherwise controlled for reproducible builds?
- Are secrets kept out of source code and logs?
- Are build and deployment identities limited to their required permissions?
- Are test and scan results retained and assigned to an owner?
- Is the production artefact traceable to an approved source revision and build?
- Is there a documented rollback or recovery plan?

### Task D — Produce a finding record

| Field | What to enter |
|---|---|
| Finding | Concise description of the issue |
| Evidence | File, configuration, scan result, or review observation—without secrets |
| Risk | Likelihood and impact, with rationale |
| Affected scope | Components, versions, builds, or environments known to be affected |
| Recommendation | Specific, proportionate change |
| Owner and due date | Person/team responsible and target date |
| Verification | Test, scan, review, or deployment evidence that confirms the fix |

## 7. Release gates and risk decisions

A release gate is a decision point, not merely a green tick from a tool. Teams should define which findings block a release, who may approve an exception, what compensating controls are required, and when an exception expires.

A useful decision considers:

- Severity and likely impact.
- Whether the affected component is present and reachable in the deployed context.
- Exposure and known exploitation information, where available.
- Existing mitigations and the confidence in those mitigations.
- The risk of delaying the release versus deploying with the finding.
- The owner, expiry date, and verification plan for any exception.

Do not hide findings to make a pipeline pass. Record the decision and preserve evidence so it can be reviewed later.

## 8. Industry exercise: design a safer release process

**Scenario:** A web application is built by a shared CI/CD runner. Developers can change pipeline files, a long-lived cloud key is stored as a build variable accessible to many projects, and the release process does not verify the artefact after build.

In pairs or small groups, draw a revised pipeline and propose controls for:

1. Code review and protection of pipeline definitions.
2. Dependency inventory, lockfiles, and vulnerability triage.
3. Secret scanning and secure credential injection.
4. Build isolation and least-privilege identities.
5. Release approval, artefact integrity, and traceability.
6. Monitoring, rollback, and incident response if a dependency is compromised.

**Deliverable:** one architecture diagram and a prioritised list of five improvements. For each improvement, identify the risk addressed and the evidence that would show the control is working.

## 9. Key takeaways

- Secure delivery spans planning, design, implementation, verification, release, and operations.
- CI/CD infrastructure and credentials are part of the security boundary.
- Dependency scanning, SAST, DAST, secret scanning, and tests are complementary—not interchangeable.
- Software supply-chain security requires controlled inputs, trustworthy builds, restricted credentials, and traceable artefacts.
- Scanner findings need validation, prioritisation, ownership, and verified remediation.
- Release exceptions should be explicit, justified, time-bound, and auditable.

## 10. Knowledge check

1. When should security be considered in the SDLC?
   - A. Only after deployment
   - B. Throughout planning, design, build, verification, release, and operations
   - C. Only when a scanner finds a critical issue
   - D. Only during incident response

2. What is a key purpose of dependency scanning?
   - A. Guarantee that every dependency is safe
   - B. Identify known issues and inventory risks in included dependencies
   - C. Replace code review
   - D. Encrypt all build logs

3. Why are CI/CD credentials security-sensitive?
   - A. They cannot affect production
   - B. They may permit changes to builds, artefacts, or deployments
   - C. They are always public by design
   - D. They replace release approvals

4. What should a team do with a scanner finding?
   - A. Hide it if the pipeline fails
   - B. Validate context, prioritise, assign an owner, and verify remediation
   - C. Assume it is always exploitable
   - D. Publish any related secrets for review

5. Which control helps reduce the risk of an artefact being replaced after approval?
   - A. Shared administrator credentials
   - B. Traceable artefact identity and integrity verification
   - C. Disabling logs
   - D. Unpinned dependencies

6. What makes a release exception well governed?
   - A. No record and no expiry
   - B. A named approver, rationale, owner, compensating controls, and expiry/review date
   - C. A verbal approval only
   - D. Automatic acceptance of all findings

**Answer key:** 1-B, 2-B, 3-B, 4-B, 5-B, 6-B.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: secure the code, dependencies, build system, release, and operational feedback loop.*
