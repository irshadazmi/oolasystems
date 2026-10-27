# Chapter 15: Security Governance, Risk Management, and Continuous Improvement

Security is not only a collection of tools. Organisations need clear responsibilities, risk-based decisions, policies that can be followed, controls that are tested, and a process for correcting gaps. Governance connects business objectives with security architecture and day-to-day operations. Risk management helps teams decide what matters most, while assurance and metrics help establish whether controls are working.

This final chapter brings together the course themes—identity, secure configuration, web security, network analysis, cloud, software delivery, incident response, and recovery—into a practical operating model.

> **Learning safety:** Use fictional scenarios and sample records. Do not expose real security findings, credentials, personal data, or internal architecture in public documents. Follow your institution's and employer's policies when collecting evidence or discussing incidents.

## Learning objectives

By the end of this chapter, you should be able to:

- Explain the relationship between security governance, risk management, architecture, and operations.
- Write a clear risk statement and maintain a simple risk register.
- Map risks to preventive, detective, and corrective controls.
- Define security control owners, evidence, and review cadence.
- Select useful security measures and explain their limitations.
- Propose a continuous-improvement plan based on findings, incidents, and control testing.

## 1. Industry scenario: security tools exist, but ownership is unclear

A fictional education platform has MFA, endpoint protection, cloud logs, backups, and automated dependency scanning. Yet a review discovers that privileged access is rarely reviewed, some patches are overdue, backup restoration has not been tested recently, and scanner findings do not have clear owners.

The problem is not necessarily the absence of tools. It is the gap between controls and governance: no one is accountable for some decisions, evidence is incomplete, exceptions have no expiry, and success is measured by tool deployment rather than outcomes.

Security governance establishes who decides, who implements, who verifies, and how unresolved risks are escalated.

![Security governance architecture](/images/tutorials/cybersecurity/ch15-security-governance-architecture.png)

## 2. Governance, risk, and architecture

These ideas work together:

- **Governance** defines direction, responsibilities, policy, risk tolerance, and oversight.
- **Risk management** identifies what could go wrong, estimates likelihood and impact, chooses treatment, and reviews remaining risk.
- **Security architecture** translates requirements into trust boundaries, identity and access controls, data protection, monitoring, and recovery design.
- **Operations** run the controls, respond to alerts, patch systems, manage access, and preserve evidence.
- **Assurance** checks whether controls are implemented and effective, records exceptions, and tracks corrective action.

A policy that says “privileged access must be reviewed” is not sufficient on its own. The organisation also needs a named owner, a defined scope and frequency, evidence that the review occurred, and a process for removing inappropriate access.

## 3. A practical risk-management workflow

![Risk management register workflow](/images/tutorials/cybersecurity/ch15-risk-management-register-workflow.png)

A simple risk workflow is:

1. **Identify:** name the asset or service, threat, vulnerability or weakness, and possible consequence.
2. **Analyse:** estimate likelihood and impact using the organisation's agreed scale and available evidence.
3. **Evaluate:** compare the risk with agreed criteria and decide whether further treatment is needed.
4. **Treat:** mitigate, avoid, transfer/share where appropriate, or explicitly accept the risk through the authorised process.
5. **Review:** assign an owner, due date, residual-risk statement, and next review date.

### Write a useful risk statement

Use a structured statement:

> Because of **[cause or weakness]**, **[event]** may affect **[asset or business process]**, resulting in **[impact]**.

Example: “Because privileged access is not reviewed regularly, an obsolete account may retain access to student records, increasing the risk of unauthorised disclosure or modification.”

A risk statement should describe a plausible cause, event, and consequence. Avoid vague entries such as “security is poor” or “hackers may attack.”

## 4. Build a risk register

A risk register helps a team track decisions and actions over time.

| ID | Risk statement | Likelihood | Impact | Existing controls | Treatment / action | Owner | Due / review date |
|---|---|---|---|---|---|---|---|
| R-01 | Obsolete privileged access may allow unauthorised changes | Medium | High | MFA; audit logs | Review access, remove stale grants, test process | Identity owner | Set by team |
| R-02 | Overdue patches may expose a service to known weaknesses | Medium | High | Asset inventory; patch tool | Prioritise exposed assets and verify updates | Platform owner | Set by team |
| R-03 | Backups may not restore within required time | Medium | High | Scheduled backups | Conduct restore test and record result | Service owner | Set by team |
| R-04 | Secret exposure may permit unintended API access | Low/Medium | High | Repository controls | Scan, rotate exposed credentials, narrow permissions | Application owner | Set by team |

These are teaching examples, not assessments of a real organisation. Teams should determine likelihood, impact, and deadlines using their own evidence and criteria.

## 5. Map risks to control types

A control should address a defined risk and have a clear owner and expected outcome.

| Control type | Purpose | Course-related examples |
|---|---|---|
| Preventive | Reduce the chance that an unwanted event occurs | MFA, least privilege, secure configuration, input validation, patching |
| Detective | Identify events or conditions that need attention | Authentication logs, endpoint alerts, network analysis, dependency scanning |
| Corrective / recovery | Limit consequences or restore a safe state | Credential rotation, remediation, tested backups, incident-response procedures |
| Governance / assurance | Make responsibilities and control performance visible | Risk register, access review, exception approval, control testing |

Many controls support more than one purpose. For example, central logging helps detection, but it is only effective when events are useful, protected, retained, reviewed, and connected to an escalation process.

## 6. Control assurance: verify that security works

![Security control assurance loop](/images/tutorials/cybersecurity/ch15-security-control-assurance-loop.png)

For each important control, define:

- **Objective:** what risk should the control reduce?
- **Owner:** who is accountable for operating and reviewing it?
- **Scope:** which systems, accounts, data, and environments are covered?
- **Evidence:** what record demonstrates that the control ran?
- **Test:** how will the team verify that it is effective?
- **Exception:** how are failures or exclusions recorded and approved?
- **Improvement:** who will correct gaps, by when, and how will the fix be retested?

### Useful measures

| Measure | Example definition | What to watch for |
|---|---|---|
| Patch compliance | In-scope assets updated within the defined deadline / total in-scope assets | Excluded devices and unsupported systems should remain visible |
| Privileged-access review | Required reviews completed on time / reviews scheduled | Completion alone does not prove inappropriate access was removed |
| Backup restore success | Successful restore tests / restore tests scheduled | Test representative systems and verify restored data |
| Vulnerability remediation | Findings closed within target / findings due | Validate fixes and avoid closing findings without evidence |
| Incident triage time | Time between report/alert and initial triage | Faster is not better if triage quality or documentation is lost |
| Corrective-action closure | Actions verified complete / actions due | Require evidence and retesting, not just a status change |

Metrics need a defined denominator, scope, time period, and owner. Use them to improve decisions, not to conceal exceptions or optimise a number at the expense of real security.

## 7. Exception and risk-acceptance management

Not every risk can be fixed immediately. A controlled exception should include:

1. The specific requirement or control that cannot currently be met.
2. The reason for the exception and the evidence supporting it.
3. The risk and potential impact.
4. Compensating controls that reduce exposure while the gap remains.
5. An authorised approver and named risk owner.
6. An expiry or review date.
7. A remediation plan and verification criteria.

Risk acceptance should follow the organisation's authority and escalation rules. An exception is not a permanent substitute for remediation, and an expired exception should be reviewed rather than silently carried forward.

## 8. Practical capstone: design a security improvement plan

**Scenario:** A fictional student portal has a public web frontend, an API, a database, staff and student accounts, cloud hosting, a CI/CD pipeline, endpoint devices, and daily backups.

The review has found these issues:

- Some privileged accounts have not been reviewed.
- The API has inconsistent access checks on individual records.
- A dependency scanner reports an unresolved high-priority finding.
- One cloud secret has an unclear owner and rotation date.
- Security logs exist but alert ownership is not documented.
- Backups run, but restore testing is overdue.

### Student tasks

1. Draw a high-level architecture with user identities, web/API layers, database, cloud services, CI/CD, logs, and backups.
2. Identify at least six risks and write each as cause, event, and consequence.
3. Prioritise the risks using a stated likelihood/impact scale and justify your choices.
4. Map each risk to preventive, detective, and corrective controls where appropriate.
5. Create a risk register with owners, target dates, evidence, and review dates.
6. Define three measures that would show whether the improvement plan is working.
7. Identify one risk that needs immediate escalation and explain why.
8. Present a 30-day improvement plan with milestones, dependencies, and verification steps.

### Suggested deliverable

| Priority | Action | Risk addressed | Owner | Evidence of completion | Review |
|---|---|---|---|---|---|
| 1 | Review privileged access and remove unjustified grants | Unauthorised administrative activity | Identity owner | Approved review and access-change records | Set by team |
| 2 | Validate and fix record-level API authorisation | Unauthorised record access | Application owner | Tests for permitted and denied access | Set by team |
| 3 | Triage dependency finding and verify remediation | Known software weakness | Engineering owner | Advisory review, updated dependency, test results | Set by team |
| 4 | Assign and rotate cloud secret if required | Uncontrolled credential exposure | Cloud owner | Secret inventory and rotation evidence | Set by team |
| 5 | Define log-alert ownership and escalation | Delayed detection | Security/operations owner | Alert routing test and runbook | Set by team |
| 6 | Conduct and document a restore test | Recovery failure | Service owner | Restore results and integrity verification | Set by team |

This is a design exercise. Do not access or change a real production system without explicit approval.

## 9. Continuous improvement loop

A sustainable security programme learns from multiple inputs:

- Incident reviews and near misses.
- Vulnerability and configuration findings.
- Access reviews and audit results.
- Patch and backup verification.
- Threat-model and architecture changes.
- User reports and approved exercises.
- Changes in systems, suppliers, data, and business priorities.

Convert each significant finding into a tracked action with an owner, target date, expected outcome, and verification step. Revisit the risk register when systems or assumptions change. Close the loop by confirming that the corrective action reduced the intended risk.

## 10. Key takeaways

- Governance assigns responsibility and creates a process for risk-based decisions.
- A risk register should include a clear risk statement, treatment, owner, dates, and residual risk.
- Preventive, detective, and corrective controls work together.
- Security architecture should be connected to operational ownership and evidence.
- Metrics are useful only when their scope, definitions, limitations, and exceptions are clear.
- Risk acceptance must be authorised, justified, time-bound or periodically reviewed, and tracked.
- Continuous improvement turns incidents and findings into verified changes.

## 11. Knowledge check

1. What is the purpose of security governance?
   - A. Buy more tools without assigning owners
   - B. Establish direction, accountability, risk decisions, and oversight
   - C. Replace technical controls
   - D. Avoid documenting exceptions

2. Which is the clearest risk statement?
   - A. “Security is bad”
   - B. “Because privileged access is not reviewed, obsolete accounts may retain access to sensitive records”
   - C. “Use more tools”
   - D. “There may be problems someday”

3. Which is a detective control?
   - A. Reviewing authentication logs and investigating alerts
   - B. Restricting database permissions
   - C. Restoring a tested backup
   - D. Removing an obsolete account

4. What should a risk register include?
   - A. Only a list of tools
   - B. Risk description, treatment, owner, due/review dates, and relevant evidence
   - C. Public copies of credentials
   - D. Unverified status labels only

5. What is a good control metric practice?
   - A. Hide excluded assets
   - B. Define scope and denominator, retain evidence, and review limitations
   - C. Measure only the number of tools installed
   - D. Close findings without retesting

6. Which is appropriate for a risk exception?
   - A. No owner or expiry
   - B. Authorised approval, rationale, compensating controls, review date, and remediation plan
   - C. Automatic permanent acceptance
   - D. Delete the risk entry

**Answer key:** 1-B, 2-B, 3-A, 4-B, 5-B, 6-B.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: govern risk, verify controls, and continuously improve security outcomes.*
