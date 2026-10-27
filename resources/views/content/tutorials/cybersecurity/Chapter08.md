# Chapter 08 — Input Validation, Injection, and Secure Database Access

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: treat external input as untrusted, separate data from instructions, and limit the impact of failure.*

---

## Learning objectives

By the end of this chapter, you should be able to:

- Explain why input from forms, URLs, APIs, files, and other systems must be treated as untrusted.
- Distinguish input validation, output encoding, parameterized queries, and authorization.
- Explain how SQL injection can happen when application code combines untrusted input with SQL text.
- Recognize safer database-access patterns using prepared/parameterized statements.
- Recommend layered controls: server-side validation, authorization, least privilege, safe error handling, and testing.
- Review a sample request flow and document risks and mitigations without testing systems without permission.

## 1. Industry scenario: the campus results portal

A college results portal accepts a student name or ID and queries a database. During a code review, an engineer discovers that the application builds SQL by joining a query string with the value supplied by the user.

The problem is not simply that a user entered an unusual value. The design allows input to become part of the SQL instruction itself. Depending on the query and database driver, this can change the intended query logic or expose data the caller should not access.

A safer design uses parameterized queries, validates input against the expected business rules, enforces authorization on the server, and gives the application database account only the permissions it needs.

![Input validation pipeline](/images/tutorials/cybersecurity/ch08-input-validation-pipeline.png)

**Industry principle:** validation asks whether a value is acceptable; parameterization protects the query structure; authorization decides what the user may do. These controls solve different problems and should work together.

## 2. What counts as untrusted input?

Untrusted input is any value that crosses a boundary where the application cannot assume it is correct or safe. Examples include:

- Form fields such as student ID, email address, search text, and date of birth.
- URL path segments, query parameters, and HTTP headers.
- JSON or XML received by an API.
- Uploaded files and imported spreadsheet data.
- Values received from another service, message queue, or database when their integrity is not guaranteed.

A value may be syntactically valid but still not be allowed for the current user or business operation. For example, `student_id = 1042` might be a valid integer, but a student should not be able to retrieve another student's private record merely by changing that ID.

## 3. Input validation: type, range, format and meaning

Validation should occur on the server, close to the operation that uses the value. Client-side validation is useful for feedback and usability, but it can be bypassed.

| Validation check | Question | Example |
|---|---|---|
| Requiredness | Must a value be present? | Student ID cannot be empty |
| Type | Is the value the expected data type? | Page number is an integer |
| Length | Is the value within an allowed size? | Search term has a sensible maximum length |
| Range | Is the value within acceptable limits? | Quantity must be positive and below a defined maximum |
| Format | Does it match the required structure? | Date uses an accepted format |
| Allow-list | Is the value one of the permitted choices? | Sort field is `name`, `date`, or `status` |
| Business rule | Is the action valid in this context? | A result can be published only by an authorized role |

Prefer explicit allow-lists for fields with a small set of legitimate choices. Avoid trying to block every imaginable “bad” character; such block-lists are often incomplete and can reject legitimate data.

Validation does not replace parameterized queries. Even well-validated text should be passed to the database as a parameter rather than concatenated into SQL.

## 4. SQL injection: when data changes query meaning

SQL injection is a vulnerability that can occur when an application constructs a database command by combining SQL syntax with untrusted input. The exact impact depends on the query, database permissions, driver, and application design.

### Unsafe illustrative pattern

```python
# UNSAFE: do not use this pattern
query = "SELECT * FROM users WHERE name='" + username + "'"
cursor.execute(query)
```

Here, `username` becomes part of the SQL text. If input can introduce SQL syntax, the resulting command may not mean what the developer intended.

### Safer illustrative pattern

```python
# SAFER: keep SQL structure and value separate
query = "SELECT * FROM users WHERE name = ?"
cursor.execute(query, (username,))
```

The `?` placeholder shown here is supported by some database drivers (for example, SQLite). Placeholder syntax varies by driver; use the syntax and API documented for your database library. For example, some Python database drivers use `%s` placeholders. Do not manually quote or concatenate the parameter.

![Unsafe and parameterized SQL comparison](/images/tutorials/cybersecurity/ch08-injection-parameterized-sql.png)

### Important limits

- Parameterized queries are the primary control for passing values into SQL statements.
- Parameters usually represent **values**, not SQL identifiers such as table names, column names, or sort directions. Where dynamic identifiers are required, map user choices to a fixed allow-list of known identifiers.
- Stored procedures are not automatically safe if they build dynamic SQL through string concatenation.
- An ORM can help, but unsafe raw-query APIs can still introduce injection.
- Escaping by hand is error-prone and should not be treated as a substitute for parameterization.

## 5. Secure database access is layered

A secure data-access design should not depend on one control.

### A. Validate at the server boundary

Check the type, length, range, format, and business meaning of values. Reject unexpected values clearly and consistently.

### B. Enforce authorization for every sensitive operation

Authentication answers “Who are you?” Authorization answers “What are you allowed to do?” Check permissions on the server for each request that reads, changes, exports, or deletes protected data. Do not rely on hidden buttons or client-side role checks.

### C. Use parameterized queries

Keep supplied values separate from the SQL statement. Use the documented database-driver API and avoid building SQL with string interpolation or concatenation.

### D. Apply least privilege

The application's database identity should have only the permissions needed for its workload. A read-only feature should not need broad write or administrative privileges. Separate duties where appropriate, and do not embed database administrator credentials in application code.

### E. Handle errors safely

Return useful but non-sensitive messages to users. Do not expose SQL text, credentials, connection strings, stack traces, or internal schema details in production responses. Record appropriate diagnostic information in access-controlled logs, avoiding passwords, session tokens, and unnecessary personal data.

### F. Test expected and unexpected cases

Test normal inputs, missing values, wrong types, boundary values, unauthorized access, and safe error behaviour. Use an approved training lab or an application you own or have explicit permission to assess.

![Secure database request path](/images/tutorials/cybersecurity/ch08-secure-database-request-path.png)

## 6. Practical lab — review a sample data-access workflow

**Goal:** identify where validation, authorization, and parameterized database access belong. This is a design-review exercise; no live target or exploit payload is required.

### Step 1 — Trace the request

Draw this simplified path:

`Browser or mobile app → API endpoint → server-side validation → authorization check → parameterized query → database → permitted response`

For each step, write what should be checked and which component is responsible.

### Step 2 — Review the code pattern

Compare the unsafe and safer examples in Section 4. In your notes, answer:

1. Which part of the unsafe example mixes data and SQL instructions?
2. Why is the parameterized example safer?
3. Why is input validation still useful when the query is parameterized?
4. What could go wrong if the application database account has excessive privileges?

### Step 3 — Add business authorization

Consider an endpoint such as `GET /students/1042/results`. The ID may be a valid integer and the query may be parameterized. The server must still decide whether the signed-in user is permitted to view those results.

Record:
- **Identity:** who is making the request?
- **Permission:** what is this role allowed to view?
- **Object-level check:** may this user access this particular student's record?
- **Evidence:** what security-relevant event should be logged without recording secrets?

### Step 4 — Complete a control table

| Risk or failure | Recommended control | Evidence to look for |
|---|---|---|
| SQL built using string concatenation | Parameterized query or safe ORM API | Query code uses placeholders and separate parameters |
| Malformed or oversized input | Server-side type, length, and range validation | Validation rules and tests |
| User changes an ID to access another record | Server-side object-level authorization | Tests for allowed and denied users |
| Database account can administer the database | Least-privilege database role | Grants reviewed against workload |
| Detailed internal errors shown to users | Generic response and protected diagnostic logging | Error-handling tests and log review |
| Sensitive values appear in logs | Redaction and logging policy | No passwords, tokens, or unnecessary personal data |

### Step 5 — Write a short finding

Use this format:

- **Observation:** what was found in the sample design?
- **Risk:** what could happen and to which data or service?
- **Recommendation:** which controls should be applied?
- **Verification:** what safe test or code review would demonstrate the fix?

Do not run injection tests against public websites, university systems, or third-party applications unless you have explicit authorization and a defined scope.

## 7. Common misconceptions

- **“We validate input, so SQL injection is impossible.”** Validation helps enforce expected values, but parameterization is still needed.
- **“The frontend rejects bad input.”** Requests can be sent without using the frontend; enforce rules on the server.
- **“An ORM guarantees safety.”** ORM parameter APIs are useful, but raw SQL and dynamic query construction still require care.
- **“A parameterized query means the user is authorized.”** It protects query structure; authorization is a separate decision.
- **“A generic error means we should not log details.”** Keep user-facing errors safe while retaining carefully controlled diagnostic logs.
- **“The database account needs broad permissions just in case.”** Excessive privileges increase the potential impact of application flaws.

## 8. Key takeaways

- Treat input from users, clients, files, and external systems as untrusted.
- Validate on the server using type, length, range, format, and business rules.
- Use parameterized queries to keep data separate from SQL instructions.
- Use allow-lists for dynamic identifiers that cannot be bound as query parameters.
- Enforce authorization on every sensitive server-side operation, including access to individual records.
- Apply least privilege to database identities and handle errors and logs safely.
- Test with an authorized lab, documented scope, and repeatable evidence.

## 9. Knowledge check

**1. What is the primary purpose of a parameterized query?**

- A. To replace user authentication
- B. To keep supplied values separate from SQL structure
- C. To grant the database account more privileges
- D. To encrypt every database column

**2. Where should security-critical input validation be enforced?**

- A. Only in the browser
- B. Only in a help page
- C. On the server, near the operation that uses the input
- D. Only after a database error occurs

**3. A query uses parameters, but a student can view another student's results by changing an ID. Which control is missing or ineffective?**

- A. Object-level authorization
- B. DNS resolution
- C. File compression
- D. UI styling

**4. Which is the safest way to handle a user-selected sort column?**

- A. Concatenate any supplied column name into SQL
- B. Assume the browser will send only valid values
- C. Map the choice to a fixed allow-list of permitted column identifiers
- D. Give the application full database administrator privileges

**5. Why should the application database account follow least privilege?**

- A. It makes input validation unnecessary
- B. It limits the potential impact if the application is compromised
- C. It prevents every outage
- D. It removes the need for backups

**6. Which statement about error handling is best?**

- A. Show full stack traces and SQL text to all users
- B. Never record any diagnostic evidence
- C. Return safe user-facing messages and keep protected, appropriately redacted diagnostic logs
- D. Put database passwords in logs for troubleshooting

**Answer key:** 1-B, 2-C, 3-A, 4-C, 5-B, 6-C.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: validate carefully, parameterize database queries, authorize every sensitive action, and test only with permission.*
