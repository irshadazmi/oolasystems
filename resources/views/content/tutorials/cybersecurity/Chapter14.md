# Chapter 14: Incident Response, Evidence Handling, and Communication

Security incidents are stressful because information is incomplete and decisions may have consequences for people, services, and evidence. A repeatable incident-response process helps teams determine what is known, reduce harm, preserve useful records, restore services safely, and learn from the event. Good response depends on clear roles, approved procedures, accurate timestamps, careful communication, and respect for legal, privacy, and organisational requirements.

> **Safety and authority:** This chapter is for defensive learning. Use fictional scenarios and instructor-provided evidence. Do not access another person's account, copy private data, delete logs, wipe devices, or isolate production systems unless you are explicitly authorised and following the approved incident process.

## Learning objectives

By the end of this chapter, you should be able to:

- Describe a basic incident-response lifecycle.
- Distinguish an alert, a suspicious event, and a confirmed incident.
- Triage a report using impact, scope, confidence, and urgency.
- Explain safe evidence handling and the importance of timestamps and context.
- Draft a concise incident update that separates known facts from assumptions.
- Recommend containment, recovery, and lessons-learned actions without exceeding authority.

## 1. Industry scenario: suspicious activity on a student portal

The campus IT team receives three reports close together: a user sees an unfamiliar sign-in notification, the monitoring dashboard reports repeated failed logins, and a support agent notices an unusual change to a student record. At first, the team does not know whether the reports are connected.

A disciplined response avoids jumping to conclusions. The team records the reports and times, validates the alerts, identifies potentially affected accounts and services, and follows the incident playbook. The designated incident lead coordinates authorised actions, protects evidence, and communicates updates through approved channels.

![Incident response lifecycle](/images/tutorials/cybersecurity/ch14-incident-response-lifecycle.png)

## 2. Event, alert, and incident: understand the difference

- **Event:** an observable occurrence, such as a login, a process starting, or a file being changed.
- **Alert:** a notification produced by a tool or a person because an event or pattern may need attention.
- **Suspicious activity:** behaviour that merits investigation but may have a legitimate explanation.
- **Security incident:** an event or set of events that meets the organisation's criteria for actual or likely harm to confidentiality, integrity, availability, or policy compliance.

Not every alert is a confirmed incident. Conversely, a quiet dashboard does not prove that no incident occurred. Use the organisation's criteria, evidence, and escalation process.

## 3. Incident-response lifecycle

A practical lifecycle contains connected phases:

1. **Prepare:** define roles, escalation contacts, playbooks, logging, backups, and exercises before an incident occurs.
2. **Detect and analyse:** collect reports, validate signals, establish scope, assess impact, and record uncertainty.
3. **Contain:** use approved actions to limit further impact while preserving necessary evidence.
4. **Eradicate:** address the underlying cause, such as compromised credentials, unsafe configuration, or vulnerable software.
5. **Recover:** restore service in a controlled way and verify expected behaviour and monitoring.
6. **Learn:** document root causes and contributing factors, track corrective actions, and improve controls.

Real incidents may require revisiting earlier phases as new information appears. The lifecycle is a guide, not a reason to delay urgent escalation.

## 4. Triage: impact, scope, confidence, and urgency

![Incident triage decision flow](/images/tutorials/cybersecurity/ch14-incident-triage-decision-flow.png)

A triage record should answer:

| Question | What to record |
|---|---|
| What was reported or detected? | Exact observation, alert identifier, or user report |
| When did it happen? | Timestamp and time zone where available |
| Which assets or identities may be affected? | Known accounts, devices, services, and data categories |
| What is the potential impact? | Confidentiality, integrity, availability, safety, and business impact |
| How confident are we? | Confirmed facts, plausible hypotheses, and unknowns |
| Is activity continuing or spreading? | Evidence for current activity; avoid unsupported assumptions |
| Who must be notified? | Incident lead, security team, service owner, or other approved contacts |
| What is the next authorised action? | A specific check, escalation, or approved containment step |

Prioritisation should consider both impact and urgency. A suspected compromise of a privileged account or a service holding sensitive records may require faster escalation than a low-impact, isolated anomaly. Follow the organisation's severity model rather than inventing a universal score.

## 5. Containment decisions: proportionate and authorised

Containment can reduce ongoing harm, but it can also disrupt service or destroy volatile evidence if done carelessly. Actions depend on the incident, asset criticality, available evidence, and response authority.

Examples of possible actions—only when approved by the incident lead or policy—include:

- Temporarily disabling or restricting a compromised account.
- Revoking or rotating an exposed credential.
- Blocking a known malicious indicator at an approved control point.
- Isolating an affected endpoint using the organisation's established procedure.
- Restricting a vulnerable service while a fix is prepared.

Before acting, consider the scope, business impact, dependencies, evidence needs, rollback path, and who has authority to approve the change. Students should describe the decision and its rationale rather than performing disruptive actions.

## 6. Evidence handling: preserve trust and context

Evidence can include alert records, system and application logs, timestamps, approved packet captures, screenshots, change records, and user reports. It must be relevant to the investigation and handled according to policy.

![Evidence handling and communication](/images/tutorials/cybersecurity/ch14-evidence-handling-and-communication.png)

### Evidence-handling principles

- **Relevance:** collect only what is needed for the authorised investigation.
- **Context:** preserve the source, time range, time zone, system identity where appropriate, and the question being investigated.
- **Integrity:** use approved storage and integrity mechanisms where required; avoid unnecessary modification of original evidence.
- **Access control:** restrict evidence to authorised people and protect sensitive or personal data.
- **Traceability:** record who collected, accessed, transferred, or analysed the evidence when required by procedure.
- **Retention:** follow the organisation's retention, privacy, and legal requirements.
- **Limitations:** record gaps, clock differences, missing logs, and other factors that reduce confidence.

A screenshot alone may omit important context. A log line may be misleading without the system clock, related events, or an understanding of how the log was generated. Correlate multiple sources where available and state the limitations.

## 7. Communication during an incident

Incident communication should be accurate, brief, timely, and audience-appropriate. Do not speculate, assign blame, or disclose credentials and sensitive personal data.

A useful update includes:

- **Status:** suspected, under investigation, confirmed, contained, or recovering—using the organisation's definitions.
- **Known facts:** what has been observed and when.
- **Potential impact:** what may be affected and what remains unknown.
- **Actions taken:** authorised steps completed, without exposing sensitive details.
- **Next step:** the next check or decision and who owns it.
- **Next update:** the expected time or trigger for the next communication, if known.

### Example incident update

> **Status:** Under investigation.  
> **Known facts:** Monitoring recorded repeated failed sign-ins for a test account at approximately 10:15 IST. No unauthorised access has been confirmed from the available evidence.  
> **Actions:** The alert has been assigned to the authorised security contact, and related authentication logs are being reviewed.  
> **Unknowns:** The source and intent of the attempts are not yet established.  
> **Next step:** Correlate sign-in records with approved identity-provider logs and update the incident record.

This is a fictional example. In a real incident, use the approved reporting channel and the actual evidence.

## 8. Practical lab: tabletop incident exercise

**Scenario:** The instructor provides a fictional timeline:

- 09:42 — several failed sign-ins are recorded for one account.
- 09:47 — the account successfully signs in from a location not previously associated with the test scenario.
- 09:51 — a sensitive profile field is changed.
- 09:55 — a user reports that the profile information looks incorrect.

### Student tasks

1. Put the events in chronological order and identify which facts are directly supported.
2. List at least three hypotheses, including a legitimate explanation and a possible compromise.
3. Identify the additional evidence that would help distinguish those hypotheses.
4. Classify the potential confidentiality, integrity, and availability impact.
5. Recommend the first escalation and containment decisions, specifying who must authorise them.
6. Write a short incident update that clearly marks what is known, unknown, and being checked.
7. Identify evidence that must be protected and explain why access should be restricted.
8. Propose two recovery-verification checks and three lessons-learned actions.

### Deliverable: incident record

| Field | Student entry |
|---|---|
| Incident reference | Fictional identifier supplied by instructor |
| Reporter and time | Use the scenario details |
| Summary | One or two factual sentences |
| Affected scope | Known assets, accounts, and data categories |
| Evidence | Source, timestamp, and relevant observation |
| Impact and confidence | Known impact, possible impact, and uncertainty |
| Actions and approvals | What was done or recommended and by whom |
| Next steps | Owner and follow-up |
| Closure and lessons | Verification results and tracked improvements |

Do not include real passwords, API keys, session tokens, unnecessary personal information, or actual student records in the exercise report.

## 9. Recovery and lessons learned

Recovery is more than bringing a service online. The team should verify that the underlying cause has been addressed, affected credentials and permissions are safe, restored data is correct, monitoring is functioning, and business owners accept the service's return.

A post-incident review should ask:

- What happened, and what evidence supports the timeline?
- Which controls worked as intended?
- Which gaps allowed the incident or delayed detection?
- Were roles, escalation, and communication clear?
- Were recovery objectives met?
- Which corrective actions have owners and target dates?
- How will the organisation verify that each improvement is effective?

Focus on improving systems and processes rather than assigning blame. Track actions to completion and update playbooks, architecture, training, or monitoring as needed.

## 10. Key takeaways

- An alert is a signal to evaluate; it is not automatically proof of an incident.
- Triage should consider impact, scope, confidence, urgency, and the approved severity model.
- Containment and recovery actions must be authorised, proportionate, and documented.
- Evidence needs context, integrity, restricted access, and traceability.
- Incident communication should separate confirmed facts, hypotheses, unknowns, and next steps.
- Recovery must be verified, and lessons learned should become owned, trackable improvements.

## 11. Knowledge check

1. What is the best description of an alert?
   - A. Proof that an attack succeeded
   - B. A signal that may require investigation
   - C. A replacement for evidence
   - D. A reason to delete logs

2. Which is a sensible first step after receiving a suspicious report?
   - A. Wipe the device immediately
   - B. Record the report, validate available evidence, and follow escalation procedure
   - C. Publish the logs online
   - D. Disable all monitoring

3. Why should containment actions be authorised?
   - A. They can affect service, evidence, and other systems
   - B. They never affect business operations
   - C. It is always safe to disable any account
   - D. Authorisation removes the need for documentation

4. Which item improves evidence traceability?
   - A. Removing timestamps
   - B. Recording source, collection time, and authorised handling
   - C. Sharing evidence through public chat
   - D. Editing the original record without documentation

5. What should an incident update communicate?
   - A. Speculation presented as fact
   - B. Known facts, unknowns, actions, and next steps
   - C. Credentials and secret tokens
   - D. Personal opinions about blame

6. What is a useful purpose of a post-incident review?
   - A. Hide control failures
   - B. Turn findings into owned and verifiable improvements
   - C. Delete all records
   - D. Avoid changing procedures

**Answer key:** 1-B, 2-B, 3-A, 4-B, 5-B, 6-B.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: respond methodically, preserve evidence, communicate clearly, and improve the system.*
