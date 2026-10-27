# Chapter 12: Cloud Security, IAM, API Keys, and Secrets

Cloud services can be provisioned quickly, but speed does not remove the need for security design. Identity and access management (IAM), secure network boundaries, workload configuration, data protection, secret handling, and monitoring must be planned together. This chapter uses a vendor-neutral approach so students can apply the same reasoning across AWS, Azure, GCP, and other cloud platforms.

> **Lab safety:** Use diagrams, instructor-provided sample policies, or a sandbox account explicitly approved for teaching. Do not create paid resources without permission, publish cloud credentials, test another tenant, or modify production IAM. Never paste real API keys, access tokens, passwords, or private customer data into a classroom document or public repository.

## Learning objectives

By the end of this chapter, you should be able to:

- Explain the shared-responsibility model for cloud security.
- Sketch a cloud reference architecture with identity, network, workload, data, and monitoring controls.
- Distinguish authentication from authorisation and apply least privilege to human and workload identities.
- Identify common API-key and secret-management failures.
- Recommend safe storage, rotation, revocation, and auditing of secrets.
- Review a sample cloud/API design and document risks, controls, and open questions.

## 1. Industry scenario: a cloud API key appears in a repository

A development team builds a student-services API hosted in the cloud. A developer commits a configuration file containing a long-lived API key to a source repository. The API uses a broad cloud role, logs are spread across several services, and nobody is certain who can revoke the key.

The security response must address the immediate exposure and the underlying design. Removing the string from the latest source file is not enough if it remains in version history or has already been copied. The team should follow its incident process, revoke or rotate the credential, examine relevant audit activity, update dependent workloads safely, and prevent the same pattern from recurring.

## 2. Shared responsibility in cloud security

Cloud providers secure the underlying infrastructure according to their service model. Customers remain responsible for many decisions, such as identity configuration, data classification, access policies, application code, secret handling, and logging. The exact division varies between infrastructure, platform, and software services, and between providers.

| Security area | Typical customer responsibility |
|---|---|
| Identity and access | Configure users, roles, MFA, permissions, and access reviews |
| Data | Classify data, choose access rules, and configure encryption and retention |
| Application | Validate requests, enforce authorisation, patch dependencies, and handle errors safely |
| Cloud configuration | Set network exposure, service permissions, logging, and resource policies |
| Secrets | Store credentials securely, restrict access, rotate and revoke them |
| Monitoring and response | Enable relevant logs, define alert ownership, and practise incident handling |

Do not assume that a managed service automatically makes every application or data configuration secure. Confirm the responsibilities for the exact service and deployment model.

## 3. Cloud security reference architecture

A secure design uses multiple layers. Users and administrators authenticate through an identity layer; API gateways or edge controls provide a defined entry point; workloads use narrowly scoped permissions; data stores and secrets are not exposed unnecessarily; and central monitoring supports detection and investigation.

![Cloud security reference architecture](/images/tutorials/cybersecurity/ch12-cloud-security-reference-architecture.png)

### Architecture review questions

- **Identity:** Are administrator accounts separate from everyday accounts? Is MFA required for privileged access?
- **Network:** Which services must be public? Can databases and internal services remain private?
- **Workloads:** Are service identities used instead of shared human credentials? Are images and dependencies maintained?
- **Data:** Is access limited to the required records and operations? Are encryption and retention requirements defined?
- **Secrets:** Are keys held in a suitable secret store rather than source code or client applications?
- **Visibility:** Are security-relevant events logged, protected, monitored, and assigned to an owner?
- **Recovery:** Are backup, restore, and incident procedures documented and tested?

## 4. IAM: authentication is not authorisation

**Authentication** establishes which user or workload is making a request. **Authorisation** decides whether that identity may perform a particular action on a particular resource under the applicable conditions. A valid login or API key should not grant unrestricted access.

![IAM authentication and authorisation flow](/images/tutorials/cybersecurity/ch12-iam-authentication-authorization-flow.png)

### Least-privilege design

1. Give each human or workload a distinct identity where feasible.
2. Grant only the actions and resources required for the task.
3. Avoid broad wildcard permissions unless explicitly justified and controlled.
4. Separate production administration from normal development and routine use.
5. Use time-limited or just-in-time privileged access where the platform supports it.
6. Review unused permissions and remove obsolete identities.
7. Log sensitive access and changes to IAM policies.

### Example: review a fictional policy

A service only needs to read a specific set of student profile records. Its policy grants read, write, and delete access across every database in the account.

**Review task:** identify the excess permissions, define the minimum actions and resource scope, and name the evidence needed to validate the revised policy. Do not apply the example policy to a real cloud account.

## 5. API keys and secrets: common failure patterns

A secret is information used to authenticate or authorise access, such as an API key, database password, signing key, or access token. Secret-handling failures often occur when a value is placed in a source file, mobile app, build log, issue tracker, or public repository.

| Risky pattern | Safer design |
|---|---|
| Hard-coded key in source code | Use a managed secret store or approved secret-injection mechanism |
| Secret committed to version control | Prevent commits with scanning and revoke/rotate exposed credentials |
| One key shared across services | Use separate identities or credentials scoped to each workload |
| Long-lived, broad-access key | Prefer short-lived credentials and minimum required permissions where supported |
| Secret embedded in a mobile app | Treat client-side values as extractable; enforce access on the server |
| No rotation or ownership process | Assign an owner, rotation plan, expiry where feasible, and revocation procedure |
| Credentials printed in logs | Redact sensitive values and review logging practices |

A secret manager helps store and control secrets, but it does not remove the need to restrict who can retrieve them, monitor access, or rotate exposed credentials.

## 6. Secret-management lifecycle

A controlled lifecycle covers creation, storage, use, rotation, and revocation. Use platform-supported mechanisms and document which workload needs which secret and why.

![Secrets management lifecycle](/images/tutorials/cybersecurity/ch12-secrets-management-lifecycle.png)

### If a secret is exposed

1. **Notify the authorised owner or incident-response contact** and follow the organisation's process.
2. **Revoke or rotate the credential** as appropriate. Do not rely only on deleting the visible text.
3. **Review relevant audit logs** to determine whether the credential was used and what resources it could reach.
4. **Update dependent services safely** and verify that legitimate operations still work.
5. **Remove exposed copies where feasible** from source, build artefacts, logs, and repository history using an approved process.
6. **Reduce recurrence risk** with secret scanning, scoped identities, short-lived credentials where supported, and clear ownership.

Do not paste a real exposed secret into the incident report. Refer to a protected credential identifier or secret-store record instead.

## 7. API security design: protect the service, not just the key

A key can identify a client or authorise a limited integration, but it should not replace robust application security. Design the API to:

- Authenticate callers using an appropriate mechanism for the client and risk.
- Authorise every sensitive operation on the server, including access to individual records.
- Validate input and use parameterised database queries.
- Apply rate limits and quotas appropriate to the service.
- Use TLS for data in transit and avoid exposing secrets in URLs.
- Return safe errors without revealing tokens, stack traces, internal configuration, or sensitive data.
- Record security-relevant events without logging credentials or unnecessary personal data.
- Version and retire integrations through a documented process.

For browser and mobile clients, assume that any value shipped to the client can be inspected. Put privileged operations behind a server-side API and enforce access at the server.

## 8. Practical exercise: review a sample cloud/API design

**Scenario:** A fictional student-services API has a public web frontend, an API service, a database, an object-storage bucket for documents, and a third-party notification service.

The design has these reported properties:

- The database accepts connections from any source.
- The API uses one administrator credential for all operations.
- A third-party API key is stored in the repository.
- Logs record requests, but sensitive actions are not clearly distinguished.
- No owner is assigned to review access or rotate credentials.

### Student tasks

1. Draw the request path from the client through the API to the database and external service.
2. Mark each trust boundary and identify which components should be public or private.
3. List at least five risks and rate likelihood and impact using a simple low/medium/high scale.
4. Recommend controls for network exposure, workload identity, data access, secret storage, and audit logging.
5. Explain how you would respond to the exposed key without revealing it in your report.
6. Identify one control that prevents misuse, one that detects it, and one that supports recovery.
7. Write two assumptions that need confirmation before the design can be approved.

### Suggested deliverable

| Component | Risk | Proposed control | Evidence needed | Owner |
|---|---|---|---|---|
| Database | Unnecessary network exposure | Restrict network paths to approved workloads | Network rules and connectivity test |
| API identity | Excessive permissions | Narrow service role and resource scope | Policy review and authorised test |
| Third-party integration | Exposed key | Revoke/rotate and use secret management | Rotation record and access logs |
| Logs | Weak investigation capability | Record relevant events with safe redaction | Sample event and alert ownership |
| Document storage | Unclear data access | Explicit access policy and least privilege | Policy review and access test |

These are design-review exercises. Do not deploy or test changes in a real environment without approval.

## 9. Key takeaways

- Cloud security is shared between provider and customer; exact responsibilities depend on the service model.
- IAM should verify identities and separately enforce permission for each action and resource.
- Least privilege applies to human users, service identities, database access, and third-party integrations.
- API keys and other secrets should not be hard-coded, committed, logged, or embedded in client applications as trusted credentials.
- Exposed secrets require revocation or rotation, scope review, and a safe update of dependent services.
- A secure cloud architecture combines identity, network boundaries, hardened workloads, data protection, and monitoring.
- Logs, access reviews, incident ownership, and tested recovery are part of the design—not optional additions.

## 10. Knowledge check

1. What does the cloud shared-responsibility model mean?
   - A. The provider is responsible for every customer setting
   - B. Provider and customer responsibilities vary by service and configuration
   - C. Customers do not need to manage identities
   - D. Logging is never a customer concern

2. What is the difference between authentication and authorisation?
   - A. Authentication identifies the caller; authorisation decides what actions are allowed
   - B. They mean exactly the same thing
   - C. Authorisation encrypts all network traffic
   - D. Authentication defines backup retention

3. Where should a server-side API secret normally be stored?
   - A. In a public repository
   - B. In a mobile app bundle
   - C. In an approved secret-management mechanism with restricted access
   - D. In a URL query string

4. A key is accidentally committed to a repository. What is the safest first principle?
   - A. Delete the latest file and assume the key is safe
   - B. Follow the incident process, revoke or rotate the credential, and investigate its use
   - C. Post the key in a team chat for review
   - D. Ignore it if the repository is private

5. Why is a mobile app API key not a reliable place to enforce privileged access?
   - A. Mobile apps cannot use HTTPS
   - B. Values shipped to clients can be extracted; server-side authorisation is still needed
   - C. All APIs must be public
   - D. Keys cannot identify clients

6. Which is an example of least privilege?
   - A. One administrator key shared by all services
   - B. A service role limited to reading the specific resources it needs
   - C. Every user can delete backups
   - D. All network sources can access the database

**Answer key:** 1-B, 2-A, 3-C, 4-B, 5-B, 6-B.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: define trust boundaries, scope permissions, protect secrets, and make security observable.*
