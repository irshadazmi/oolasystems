# Chapter 12 — Shell Scripting Fundamentals

> **Linux Administration • B.Tech Year III • Practical chapter**  
> **Theme:** turn repeatable command sequences into readable, testable, and safe scripts.

## Learning outcomes

By the end of this chapter, students should be able to:

1. Explain how Bash reads and executes a shell script.
2. Create a small script with a shebang, comments, variables, and output.
3. Use quoting to preserve values containing spaces and special characters.
4. Apply conditions, loops, and exit status to control script behavior.
5. Test scripts safely with sample data and explain why permissions and input validation matter.

## 1. What is shell scripting?

A shell is a command interpreter. A **shell script** is a text file containing commands that the shell reads and executes in sequence. Scripts can combine existing Linux tools with variables, conditions, loops, and functions to automate repetitive work.

Examples of appropriate beginner tasks include printing a status report, checking whether a directory exists, processing a small list of sample names, or summarizing a test file. Start with scripts that read information or write to a directory you own. Avoid destructive actions while learning.

![Bash script execution architecture](/images/tutorials/linuxadmin/ch12-bash-script-execution-architecture.png)

*Figure 12.1 — The shell interprets script text, runs commands, and produces output and an exit status.*

## 2. Create and run a first script

Create a file named `hello.sh` in a directory you own using an editor available in your environment. Enter:

```bash
#!/usr/bin/env bash
# A small introductory script
printf 'Hello from Linux shell scripting!\n'
printf 'Current user: '
whoami
printf 'Current directory: '
pwd
```

The first line is called the **shebang**. It indicates which interpreter should run the script when the operating system launches it directly. `printf` prints formatted text; `whoami` and `pwd` report the current account and working directory.

You can run a script by explicitly passing it to Bash:

```bash
bash hello.sh
```

This method does not require the file to have its executable bit set, provided the file is readable and Bash is available. It is useful for a beginner lab in a restricted shell. If you later use `./hello.sh`, the file must be executable and the filesystem must permit execution. Follow the instructor's environment-specific instructions rather than changing permissions on shared systems.

## 3. Variables and quoting

Variables store values for reuse. Assignments have no spaces around the equals sign:

```bash
student_name="Amina Khan"
course="Linux Administration"
printf 'Student: %s\n' "$student_name"
printf 'Course: %s\n' "$course"
```

Use double quotes around variable expansions when the value should remain one argument, especially if it may contain spaces or wildcard characters.

Compare:

```bash
folder_name="Lab Files"
printf '%s\n' "$folder_name"
```

Single quotes preserve their contents literally, while double quotes allow variable expansion. Unquoted expansions can be split into multiple words and may expand wildcard characters. Quoting is a simple and important safety habit.

### Common quoting rules

| Pattern | Typical behavior |
|---|---|
| `"$name"` | Expands a variable while preserving the result as one word |
| `'$name'` | Prints the literal characters `$name` |
| `"Text: $name"` | Expands the variable within a string |
| `$(command)` | Substitutes command output |
| `\$` inside double quotes | Represents a literal dollar sign |

## 4. Reading input and validating it

A script can ask the user for input:

```bash
#!/usr/bin/env bash
printf 'Enter your lab name: '
read -r lab_name
printf 'Lab selected: %s\n' "$lab_name"
```

`read -r` avoids treating backslashes as escape characters. In automated or scheduled scripts, interactive input is usually inappropriate because no person may be available to answer the prompt.

Validate input before using it in a command or file path. Do not assume a value is safe simply because it was typed by a user. For this chapter, print or inspect values rather than using them to delete, overwrite, or change system files.

## 5. Conditions and control flow

Conditions allow a script to choose between actions. The `if` statement can test a file or directory, compare values, or evaluate a command's exit status.

```bash
#!/usr/bin/env bash
target="hello.sh"

if [ -f "$target" ]; then
    printf 'Found file: %s\n' "$target"
else
    printf 'File not found: %s\n' "$target"
fi
```

The `-f` test is true when the path refers to a regular file. The quoted variable expansion protects the path if it contains spaces.

![Bash control flow](/images/tutorials/linuxadmin/ch12-bash-conditions-loops-flow.png)

*Figure 12.2 — Conditions choose a path; loops repeat controlled steps.*

### Common tests

| Test | Meaning |
|---|---|
| `[ -f "$path" ]` | Path is a regular file |
| `[ -d "$path" ]` | Path is a directory |
| `[ -r "$path" ]` | Path is readable by the current account |
| `[ -n "$value" ]` | String is not empty |
| `[ "$a" = "$b" ]` | Strings are equal |

Use the test form consistently and quote variables. If your distribution supports Bash's `[[ ... ]]` syntax, it offers additional features, but portable examples in this chapter use `[ ... ]`.

## 6. Loops: repeat a controlled task

A `for` loop can process a known list:

```bash
#!/usr/bin/env bash
for item in alpha beta gamma
do
    printf 'Processing sample: %s\n' "$item"
done
```

This example prints three labels and changes no files. It is a safe way to observe iteration.

A loop should have a clear list or termination condition. Be cautious with loops that operate on files, users, or remote systems. Test the logic using a short list before expanding its scope.

## 7. Exit status and error handling

Linux commands normally return an exit status: `0` commonly means success, while a non-zero value indicates a problem or another condition. A script can inspect a command's status:

```bash
#!/usr/bin/env bash
if grep -q "Linux" sample.txt; then
    printf 'The word was found.\n'
else
    printf 'The word was not found, or the search could not succeed.\n'
fi
```

Create `sample.txt` with harmless practice text before running this example. `grep -q` suppresses matching lines and returns a status that can be tested by `if`. In a more advanced script, distinguish “no match” from an actual read or execution error when that difference matters.

Useful habits:

- Print a clear error message when an expected input is missing.
- Check the result of important commands.
- Avoid hiding all errors by discarding standard error.
- Do not assume a script succeeded just because it printed a friendly message.
- Use a final exit status that reflects the result of the work.

## 8. Functions and reuse

Functions group related commands under a meaningful name:

```bash
show_context() {
    printf 'User: '
    whoami
    printf 'Directory: '
    pwd
}

show_context
```

A function helps avoid duplicating a sequence of commands. Use names that describe the action and keep each function focused. For larger scripts, separate input validation, processing, and reporting into small functions that can be reviewed independently.

## 9. Safe shell scripting lifecycle

![Safe shell scripting lifecycle](/images/tutorials/linuxadmin/ch12-safe-shell-scripting-lifecycle.png)

*Figure 12.3 — A lifecycle for writing and testing scripts responsibly.*

1. **Plan:** define the purpose, inputs, expected output, and failure cases.
2. **Write:** use meaningful variable names, quotes, comments, and small functions.
3. **Test:** run against harmless sample data and include edge cases such as spaces or empty input.
4. **Review:** verify paths, permissions, external commands, and error handling.
5. **Observe:** inspect output and exit status; confirm what changed.
6. **Maintain:** document usage and revise the script when its assumptions change.

Do not run unfamiliar scripts with elevated privileges. Read the script before executing it, particularly if it downloads content, changes permissions, deletes files, or modifies system configuration.

## 10. Command reference

| Command / syntax | Brief description | Example |
|---|---|---|
| `bash FILE` | Run a script through Bash | `bash hello.sh` |
| `printf` | Print formatted output | `printf 'User: %s\n' "$name"` |
| `read -r VAR` | Read a line into a variable | `read -r lab_name` |
| `whoami` | Print current username | `whoami` |
| `pwd` | Print working directory | `pwd` |
| `[ -f "$path" ]` | Test for a regular file | `if [ -f "$target" ]; then ... fi` |
| `for item in LIST` | Iterate through a known list | `for item in alpha beta; do ...; done` |
| `$(command)` | Substitute command output | `today=$(date +%F)` |
| `grep -q PATTERN FILE` | Test whether a pattern is found | `grep -q "Linux" sample.txt` |
| `echo $?` | Display the previous command's exit status | `echo $?` |

The value shown by `echo $?` is the status of the immediately preceding command, so inspect it before running another command. In scripts, it is usually clearer to test the command directly with `if`.

## 11. Hands-on labs

> **Safety boundary:** Use your own WSL2/Ubuntu environment, an instructor-approved VM, or Webminal if the required shell features are supported. Keep files in a directory you own. Do not run examples that delete files, modify accounts, change system configuration, or require elevated privileges.

### Lab A — First script (5–10 minutes)

1. Create `hello.sh` in your practice directory.
2. Enter the first script from Section 2.
3. Run it using `bash hello.sh`.
4. Explain the purpose of the shebang, comment, `printf`, `whoami`, and `pwd`.
5. Record the output.

### Lab B — Variables and quoting (10 minutes)

1. Create a variable containing a value with a space, such as `Lab One`.
2. Print it using `printf '%s\n' "$variable"`.
3. Print the literal text `'$variable'` using single quotes.
4. Explain the difference between the two results.
5. Try an empty string and document what your script prints.

### Lab C — File check and loop (10–15 minutes)

1. Write a script that checks whether `sample.txt` exists in the current directory.
2. If it exists, print a message; otherwise, print a helpful not-found message.
3. Add a loop over three harmless labels.
4. Run the script with and without `sample.txt`.
5. Explain why quoting `"$target"` is a good habit.

### Lab D — Exit-status observation (5 minutes)

Run a harmless command that succeeds, then inspect its status with `echo $?`. Next, run a harmless command that fails in your environment (for example, test for a deliberately nonexistent file) and inspect the status immediately. Explain why the exit status must be checked before another command replaces it.

## 12. Troubleshooting guide

| Symptom | Possible cause | Safe next step |
|---|---|---|
| `bash: FILE: No such file or directory` | Wrong current directory or filename | Run `pwd` and list your own practice files. |
| `command not found` | Typo or unavailable command | Check spelling and use `command -v COMMAND`. |
| Variable prints empty | Variable not assigned, misspelled, or out of scope | Review the assignment and variable name. |
| Path with spaces is split | Variable expansion is unquoted | Use `"$variable"` when one argument is intended. |
| `if` condition behaves unexpectedly | Incorrect test syntax or assumptions | Test the condition separately and quote variables. |
| Script reports success despite a failure | Exit status not checked or error suppressed | Check important commands and handle failure explicitly. |
| `./script.sh` says permission denied | File is not executable or execution is restricted | For this beginner lab, run `bash script.sh`; ask the instructor before changing permissions in shared environments. |

## 13. Knowledge check — MCQs

**1. What is a shell script?**

A. A text file containing commands for a shell to interpret  
B. A Linux filesystem  
C. A network port  
D. A package repository

**2. What does the shebang `#!/usr/bin/env bash` indicate?**

A. The script should be interpreted using Bash found through `env`  
B. The script must always run as root  
C. The script is encrypted  
D. The script cannot use variables

**3. Why is `"$name"` commonly preferred over `$name`?**

A. It deletes spaces  
B. It preserves the expanded value as one argument in common command contexts  
C. It makes the variable read-only  
D. It automatically validates input

**4. What does exit status `0` commonly indicate?**

A. Success  
B. A missing file in every case  
C. The user is root  
D. The command was never run

**5. What is the purpose of an `if` statement?**

A. To select behavior based on a condition or command status  
B. To install packages  
C. To change the system clock  
D. To encrypt a disk

**6. Which is the safest approach when learning a new script?**

A. Run it with elevated privileges immediately  
B. Run it against production data  
C. Read it, use harmless sample data, and check its output and status  
D. Ignore all error messages

### Answer key

1. **A** — A shell script contains commands interpreted by a shell.
2. **A** — The shebang selects the interpreter lookup through `env`.
3. **B** — Quoting helps preserve a value as a single argument.
4. **A** — Zero commonly indicates success.
5. **A** — Conditions allow the script to branch.
6. **C** — Read, test, and verify before broader use.

## 14. Quick revision

- Bash executes commands in a script in sequence and reports output and status.
- Use meaningful variables, comments, and quotes.
- Conditions and loops control branching and repetition.
- Check exit status and report failures clearly.
- Test with harmless sample data before automating a task.
- Read unfamiliar scripts before executing them; never assume automation makes an operation safe.

## 15. Further reading

- Local manual pages: `man bash`, `help printf`, `help read`, and `man grep`.
- GNU Bash Reference Manual: https://www.gnu.org/software/bash/manual/
- Your Linux distribution's official documentation for shell scripting and command-line tools.

## Next chapter

**Chapter 13 — Services and Server Operations:** service lifecycle, systemd units, listening ports, service status, and safe operational checks.
