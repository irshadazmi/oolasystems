# Chapter 09 — Practical Web Security Using OWASP Juice Shop

**Course:** Cybersecurity & Practices  
**Audience:** B.Tech Year III · JSPM University  
**Focus:** Guided web-security investigation in an authorised, isolated training environment

## 1. Learning objectives

By the end of this chapter, you should be able to:

- Explain why intentionally vulnerable applications are useful for security education.
- Investigate a beginner-level challenge in OWASP Juice Shop without testing real systems.
- Record observations and evidence in a clear, reproducible way.
- Connect a finding to its potential impact and a suitable defensive control.
- Explain why a successful demonstration is not, by itself, proof that an entire application is insecure.

## 2. Industry scenario: review before release

A development team is preparing a student-services portal for release. A reviewer is asked to check whether users can access only the information and actions permitted for their role. The reviewer uses a deliberately vulnerable training application to practise the workflow, then records the lesson and recommended controls.

The aim is not to attack a live service. It is to learn a repeatable process: **observe → collect evidence → assess impact → recommend a control → retest**.

![OWASP Juice Shop safe lab workflow](/images/tutorials/cybersecurity/ch09-juice-shop-safe-lab.png)

## 3. What is OWASP Juice Shop?

OWASP Juice Shop is an intentionally insecure web application designed for security training and demonstrations. It contains examples of common web-application weaknesses and supports guided learning. Because it is intentionally vulnerable, it should be run only in a controlled training environment.

Use the official project and documentation:

- [OWASP Juice Shop project](https://owasp.org/www-project-juice-shop/)
- [Juice Shop documentation and setup](https://pwning.owasp-juice.shop/)
- [OWASP Web Security Testing Guide](https://owasp.org/www-project-web-security-testing-guide/)

## 4. Safety rules before starting

1. Use an instructor-provided instance or a local/isolated lab configured for the class.
2. Follow the instructor's setup instructions and the platform's terms.
3. Do not scan, probe, or attempt challenges against public websites, university systems, or other people's applications.
4. Use only dummy accounts and sample data supplied for the lab.
5. Do not record real passwords, tokens, personal data, or secrets in screenshots or notes.
6. Stop if the target or environment is unclear. Confirm the authorised target before continuing.

## 5. A structured investigation method

### Step 1 — Identify the target

Write down the lab name and the exact local or instructor-provided address. Confirm that it is the intended training environment. Do not substitute a real website.

### Step 2 — Understand the expected behaviour

Open the relevant challenge description. In your own words, record what the application is expected to permit and what it should prevent. Avoid assuming that a challenge title alone explains the underlying cause.

### Step 3 — Observe safely

Use the normal browser interface and follow the challenge instructions. Change one input or action at a time. Note the starting state, the action taken, and the visible result. Do not use destructive actions or access data that is outside the challenge's scope.

### Step 4 — Record evidence

A useful evidence note contains:

| Field | What to record |
|---|---|
| Finding ID | A short identifier, such as `JS-01` |
| Lab / challenge | The training challenge name |
| Expected behaviour | What a correctly protected application should do |
| Observed behaviour | What actually happened |
| Evidence | A short note or sanitised screenshot |
| Potential impact | What data, action, or service could be affected |
| Recommended control | A specific prevention or detection measure |
| Retest | How to confirm the control works |

Keep evidence concise, reproducible, and free of real secrets or personal data.

### Step 5 — Recommend a control

Choose a control that addresses the underlying weakness, rather than only hiding the visible symptom. Depending on the finding, this may involve server-side authorization, safe query parameterization, robust input handling, secure configuration, session controls, logging, or automated security tests.

### Step 6 — Retest

Describe how a developer or tester would verify the fix in the authorised lab. A good retest checks both the original failing case and a legitimate use case, so that the fix does not simply break normal functionality.

## 6. Practical exercise — one finding, end to end

**Time:** 20–25 minutes  
**Tools:** OWASP Juice Shop in an instructor-approved isolated environment; browser; notes template  
**Deliverable:** One short security finding

1. Open the authorised training environment.
2. Choose a beginner challenge recommended by the instructor.
3. Read its description and state the security concept you think it illustrates.
4. Observe normal behaviour, then follow the challenge instructions.
5. Record expected behaviour, observed behaviour, and safe evidence.
6. Explain the potential impact in one or two sentences.
7. Recommend one specific control and describe a retest.
8. Submit the finding for review; do not test any unrelated target.

### Finding template

```text
Finding ID:
Lab / challenge:
Security concept:
Expected behaviour:
Observed behaviour:
Evidence (sanitised):
Potential impact:
Recommended control:
Retest plan:
```

## 7. Example: turning an observation into a useful report

**Illustrative example only:** A training challenge demonstrates that a server-side action is not sufficiently restricted to the intended role.

- **Observation:** The lab permits an action that should require a different permission.
- **Potential impact:** In a real application, a user might perform an unauthorised action or access information outside their role.
- **Recommended control:** Enforce authorization on the server for every sensitive operation; do not rely only on hiding buttons in the user interface.
- **Retest:** Repeat the authorised test with a permitted role and a restricted role. Confirm that the permitted action still works and the restricted action is denied.

The example is a reporting pattern, not a claim about a specific Juice Shop challenge or deployment.

## 8. Common mistakes to avoid

- Testing a real website instead of the assigned lab.
- Treating a challenge title as proof of root cause.
- Reporting a screenshot without explaining expected versus observed behaviour.
- Recommending only client-side checks for a server-side security requirement.
- Including tokens, credentials, or personal information in evidence.
- Claiming that one successful challenge proves an entire application is vulnerable or secure.
- Failing to retest the fix with both valid and restricted use cases.

## 9. Key takeaways

- Practice only in a clearly authorised, isolated environment.
- Use a repeatable workflow: observe, document, assess impact, mitigate, and retest.
- Evidence should be minimal, reproducible, and sanitised.
- Security findings should explain the risk and recommend a control that addresses the cause.
- OWASP Juice Shop is a learning environment; lessons must be validated against the design and implementation of the system being reviewed.

## 10. Knowledge check

**1. Why is OWASP Juice Shop suitable for a classroom lab?**

- A. It guarantees that every real website has the same weaknesses
- B. It is intentionally insecure and designed for security training
- C. It grants permission to test any public website
- D. It removes the need for safe lab setup

**2. What should you confirm before testing?**

- A. That the target is an authorised training environment
- B. That the website has a login page
- C. That you can reach other systems from it
- D. That you have collected real user data

**3. Which is the strongest evidence note?**

- A. “The website is bad”
- B. A screenshot with visible passwords
- C. Expected behaviour, observed behaviour, sanitised evidence, impact, and control
- D. A challenge title without observations

**4. Why is hiding a button in the browser not enough to enforce authorization?**

- A. Buttons cannot be styled
- B. Users may interact with server endpoints without using that button
- C. Browsers do not support security
- D. It automatically encrypts the database

**5. What should a retest check?**

- A. Only that the page looks different
- B. Only that the application returns a response
- C. That the restricted action is denied and legitimate use still works
- D. That logs have been deleted

**6. Where should you practise the assigned challenge?**

- A. Any public site with a similar feature
- B. A university production portal
- C. An instructor-approved, isolated training environment
- D. A random IP address

**Answer key:** 1-B, 2-A, 3-C, 4-B, 5-C, 6-C.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: stay authorised, collect evidence carefully, and explain the defence.*
