# Chapter 09 — Remote Access and Secure File Transfer

> **Linux Administration • B.Tech Year III • Practical chapter**  
> **Theme:** use SSH safely, understand trust, and move files without exposing credentials.

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain the purpose of Secure Shell (SSH) and its encrypted client–server connection.
2. Distinguish server host-key verification from user authentication and account authorization.
3. Recognize the role of public and private keys in key-based authentication.
4. Use basic `ssh`, `scp`, and `sftp` syntax on an instructor-approved lab system.
5. Identify unsafe practices such as bypassing host-key warnings, sharing private keys, or copying files to an unverified destination.

## 1. Why remote access matters

Linux systems are often administered remotely: a developer may inspect a test server, an operator may transfer a configuration file, or an administrator may investigate a service without sitting at the server console. **SSH (Secure Shell)** provides an encrypted channel for remote login and related operations.

Encryption protects the channel in transit, but it does not make every action safe by itself. The client must verify the server identity, the user must authenticate appropriately, and the account must have authorization for the requested action.

![Linux remote access architecture](/images/tutorials/linuxadmin/ch09-linux-remote-access-architecture.png)

*Figure 9.1 — Client, trust boundary, encrypted channel, and approved server.*

### Three different security questions

| Question | What it means | Example |
|---|---|---|
| **Server identity** | Am I connecting to the intended server? | Verify the SSH host key. |
| **User authentication** | Can I prove which account I am? | Approved password or public-key authentication. |
| **Authorization** | What is this account allowed to do? | Read a permitted directory but not modify system files. |

Do not confuse these controls. A successful login does not automatically grant permission to perform every administrative task.

## 2. SSH connection architecture

An SSH session commonly involves:

- **Client:** the computer from which the user connects, running `ssh`, `scp`, or `sftp`.
- **Server:** an approved remote machine running an SSH server service, commonly `sshd`.
- **Encrypted channel:** protects session data while it travels across the network.
- **Host-key record:** helps the client recognize the server on later connections.
- **Account policy:** controls authentication methods and what the account may access.

The remote SSH server may not be installed or enabled in a local WSL2 or Webminal environment. Do not assume that `ssh localhost` will work. First inspect the client and use only a lab server that your instructor has approved.

## 3. Inspect the SSH client

Run these commands in your own Linux terminal, WSL2 Ubuntu, virtual machine, or supported lab shell.

```bash
ssh -V
command -v ssh
ssh -h
```

- `ssh -V` prints the installed client version.
- `command -v ssh` locates the executable when available.
- `ssh -h` displays usage information on many OpenSSH builds; if the local build responds differently, consult its manual page.

To read documentation:

```bash
man ssh
man scp
man sftp
```

If `man` pages are unavailable in Webminal, use the built-in help where available or the official OpenSSH documentation linked in the resources section. Do not install packages or change system configuration unless your lab instructions authorize it.

## 4. Basic SSH syntax

General form:

```bash
ssh username@hostname
```

Example with placeholders (replace them only with instructor-provided values):

```bash
ssh student@lab-server.example.edu
```

The example hostname is illustrative, not a real lab target. Do not attempt to access a system without permission.

Common options:

| Option | Purpose | Example |
|---|---|---|
| `-p PORT` | Connect to a specified SSH port | `ssh -p 2222 student@approved-host` |
| `-i FILE` | Select a private-key file | `ssh -i ~/.ssh/lab_key student@approved-host` |
| `-v` | Show verbose connection diagnostics | `ssh -v student@approved-host` |
| `-o OPTION=VALUE` | Set a connection option for this invocation | Use only when the instructor explains the option |
| `-V` | Display client version | `ssh -V` |

Verbose output can include usernames, hostnames, paths, and connection details. Review it before sharing logs publicly.

## 5. Host-key verification: confirm the server identity

On first connection, SSH may ask whether to trust the server's host key. The key fingerprint should be checked against a value supplied through a trusted channel by the lab instructor or system administrator. Accepting a key without checking it can make it easier to connect to an impostor.

SSH commonly stores known host keys in:

```text
~/.ssh/known_hosts
```

Important habits:

- Confirm the hostname and fingerprint through a trusted source.
- Treat an unexpected host-key change as a **stop-and-investigate** event.
- Do not use `StrictHostKeyChecking=no` as a quick fix.
- Do not delete a known-host entry merely to suppress a warning; first establish why the key changed and follow the approved recovery procedure.
- A host key identifies the server; it is not the same as the user's login key.

![SSH key-based authentication flow](/images/tutorials/linuxadmin/ch09-ssh-key-authentication-flow.png)

*Figure 9.2 — Public-key authentication and the separate server host-key check.*

## 6. Public-key authentication

A key pair contains two related but different files:

- **Private key:** stays with the user on the client device. Never send it to the server or share it with classmates.
- **Public key:** can be installed on an approved server account by an authorized administrator.

A simplified key-based login flow is:

1. Create a key pair on the client, following the organization's or instructor's guidance.
2. Protect the private key and use a passphrase where appropriate.
3. Have the public key installed on the approved remote account through an authorized process.
4. Verify the server's host key before relying on the connection.
5. Connect and confirm that the account has only the access it needs.

If your instructor has authorized key-generation practice on your own machine, first inspect the tool's options:

```bash
ssh-keygen -h
```

Some OpenSSH builds interpret `-h` differently or display usage in another way. Do not overwrite an existing key. If you proceed with key creation, choose a new, clearly named lab key file and follow the prompts carefully. Do not paste private-key contents into chat, tickets, source control, or shared folders.

### SSH configuration

Per-user client settings can be stored in:

```text
~/.ssh/config
```

A configuration entry can make approved hosts easier to address, but it must not weaken host verification or conceal which system is being accessed. For example, an instructor may provide a host alias, username, port, and key-file path for a dedicated classroom server. Copy only the approved settings and check their meaning before use.

## 7. Secure file transfer with `scp` and `sftp`

### `scp` — copy a file

General form:

```bash
scp LOCAL_FILE username@hostname:REMOTE_PATH
scp username@hostname:REMOTE_FILE LOCAL_PATH
```

Use an instructor-approved destination and a disposable test file. Before copying, verify the remote hostname, account, and path. After copying, confirm that the file reached the intended location.

### `sftp` — interactive file transfer

Connect to an approved server:

```bash
sftp username@approved-host
```

Useful commands at the `sftp>` prompt include:

| SFTP command | Purpose |
|---|---|
| `pwd` | Show the remote working directory |
| `lpwd` | Show the local working directory |
| `ls` | List remote directory contents |
| `lls` | List local directory contents |
| `get FILE` | Download a permitted remote file |
| `put FILE` | Upload a local file to the current remote directory |
| `help` | Show supported commands |
| `bye` | Close the SFTP session |

SFTP commands and supported options can vary by client. Use `help` in the actual session and follow the instructor's path and file-size limits.

## 8. Safe remote-access workflow

![Safe SSH transfer workflow](/images/tutorials/linuxadmin/ch09-safe-ssh-transfer-workflow.png)

*Figure 9.3 — A repeatable checklist for remote login and file transfer.*

Use this sequence every time:

1. **Confirm the target:** check the approved hostname, account, and purpose.
2. **Verify server identity:** validate the host key or fingerprint using a trusted source.
3. **Authenticate:** use the approved authentication method; never share private keys.
4. **Limit the action:** use least privilege and run only commands needed for the task.
5. **Transfer and verify:** check source, destination, file name, and outcome.
6. **Close the session:** exit cleanly and do not leave credentials or sensitive files behind.

Stop if the hostname, fingerprint, permission, or destination is unexpected. Ask the instructor or administrator rather than bypassing a security check.

## 9. Command reference

| Command | Brief description | Typical use |
|---|---|---|
| `ssh -V` | Display SSH client version | Check client availability |
| `ssh user@host` | Open a remote shell | Approved remote login |
| `ssh -p PORT user@host` | Connect on a specified port | Instructor-provided lab port |
| `ssh -i KEY user@host` | Select a private key | Use a designated, protected lab key |
| `ssh -v user@host` | Show connection diagnostics | Troubleshoot with care |
| `scp FILE user@host:PATH` | Copy local file to remote host | Approved upload |
| `scp user@host:FILE PATH` | Copy remote file locally | Approved download |
| `sftp user@host` | Start interactive file transfer | Transfer permitted files |
| `man ssh` | Read SSH manual | Learn options and behavior |
| `man scp` | Read SCP manual | Learn copy syntax |
| `man sftp` | Read SFTP manual | Learn interactive commands |

## 10. Hands-on labs

> **Safety boundary:** Use your own WSL2/Ubuntu machine, a dedicated class VM, or an instructor-provided target only. Do not scan or log in to public hosts. No root access is required for the introductory activities in this chapter.

### Lab A — Client inspection (5–10 minutes)

1. Open your Linux terminal.
2. Run `ssh -V`.
3. Run `command -v ssh`.
4. Read the available help or manual page.
5. Record the client version and whether the tool is available.

**Evidence to submit:** a short note with the command, output summary, and one sentence describing the role of an SSH client.

### Lab B — Understand trust and authentication (10 minutes)

In pairs, draw a three-column table in your notes:

| Server identity | User authentication | Authorization |
|---|---|---|
| What is verified? | What is proved? | What is permitted? |

Add one example to each column. Explain why accepting a host key and authenticating a user are different checks.

### Lab C — Practice transfer syntax safely (10–15 minutes)

Without connecting to an unapproved host:

1. Read the manual pages for `scp` and `sftp`.
2. Rewrite the placeholder examples using labels such as `LOCAL_FILE`, `STUDENT_USER`, `APPROVED_HOST`, and `REMOTE_PATH`.
3. Mark which parts are local and which are remote.
4. Describe two checks you would complete before executing the command.
5. If a dedicated class server is provided, transfer only a small, non-sensitive test file under the instructor's supervision.

**Do not execute placeholder commands literally.** Replace every placeholder with the exact approved lab values first.

### Lab D — Security scenario (5 minutes)

A teammate reports: “SSH says the host identification has changed. I deleted the warning and connected again.”

Write a response that explains:
- why the warning matters;
- which trusted person or channel should be used to verify the new fingerprint;
- why bypassing the check is unsafe; and
- what should happen before connecting again.

## 11. Troubleshooting guide

| Symptom | Possible cause | Safe next step |
|---|---|---|
| `ssh: command not found` | Client is unavailable in this environment | Use an approved environment or ask the instructor; do not install packages without authorization. |
| Connection timed out | Wrong hostname/port, network path issue, or server unavailable | Recheck the supplied target and port; ask the lab administrator. |
| Connection refused | SSH service may not be listening on that target/port | Confirm server details with the administrator; do not enable a service without permission. |
| Permission denied | Wrong account, unsupported authentication, or account policy | Check the approved username and method; never share secrets. |
| Host key changed warning | Server rebuilt, key legitimately rotated, or possible impersonation | Stop and verify the fingerprint out of band before reconnecting. |
| File not found | Local or remote path is incorrect | Check local/remote working directories and exact file names. |
| Permission denied during transfer | Account lacks access to the target path | Use an approved directory or request authorized access; do not try to bypass permissions. |

## 12. Knowledge check — MCQs

**1. What does SSH primarily provide?**

A. Automatic software updates  
B. An encrypted channel for remote access  
C. A replacement for all file permissions  
D. A guarantee that every remote command is safe

**2. What should you do when the server host key changes unexpectedly?**

A. Disable host-key checking  
B. Accept the new key immediately  
C. Stop and verify the fingerprint through a trusted channel  
D. Share your private key with the administrator

**3. Which key must remain private on the client?**

A. The server's public host key  
B. The user's private key  
C. The user's public key  
D. A checksum

**4. Which tool provides an interactive secure file-transfer session?**

A. `sftp`  
B. `df`  
C. `ps`  
D. `uname`

**5. Which statement about authentication and authorization is correct?**

A. They mean exactly the same thing  
B. Authentication proves identity; authorization controls allowed actions  
C. Authorization verifies the server fingerprint  
D. Host-key verification grants administrator privileges

**6. What is the safest first step before using `scp` on a remote server?**

A. Disable verification to avoid delays  
B. Confirm the approved target, identity, account, and destination path  
C. Copy the private key to the server  
D. Use the root account by default

### Answer key

1. **B** — SSH provides an encrypted channel for remote access.
2. **C** — Unexpected host-key changes must be investigated.
3. **B** — The private key must remain protected on the client.
4. **A** — SFTP provides interactive file transfer.
5. **B** — Authentication establishes identity; authorization defines permitted actions.
6. **B** — Confirm the target and destination before transferring data.

## 13. Quick revision

- SSH supports encrypted remote login and related operations.
- Server host-key verification, user authentication, and authorization solve different problems.
- Keep private keys private and use approved authentication methods.
- Use `scp` for file copying and `sftp` for interactive transfers.
- Never bypass unexpected host-key warnings or access systems without permission.
- Verify the target and destination before every transfer.

## 14. Further reading

- OpenSSH manual pages: `ssh(1)`, `ssh_config(5)`, `scp(1)`, and `sftp(1)` available through `man` on systems with the documentation installed.
- OpenBSD manual pages: https://man.openbsd.org/ssh
- OpenBSD SCP manual: https://man.openbsd.org/scp
- OpenBSD SFTP manual: https://man.openbsd.org/sftp

## Next chapter

**Chapter 10 — Scheduling Tasks and Automation:** cron, `at` where available, scheduled jobs, environment considerations, and safe automation practices.
