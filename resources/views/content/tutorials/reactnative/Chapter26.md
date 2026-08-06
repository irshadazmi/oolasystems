# Chapter 26: Debugging & Troubleshooting

---

In previous chapters, we built several ExpenseApp features using:

- Navigation
- Context API
- AsyncStorage
- APIs
- Notifications
- Device APIs
- Forms & Validation
- TypeScript
- Expo Router

As applications grow larger, bugs and unexpected behavior become inevitable.

Even experienced developers spend a significant amount of time debugging applications.

The important skill is not avoiding all bugs — it is learning how to:

✅ Identify issues

✅ Analyze root causes

✅ Fix problems systematically

In ExpenseApp, debugging helps you:

- Fix UI issues
- Resolve API problems
- Diagnose crashes
- Debug navigation issues
- Understand state problems
- Improve performance

In this chapter, we will learn practical debugging techniques used in real-world React Native applications.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand debugging fundamentals
- Use React DevTools
- Use console logs effectively
- Understand Flipper basics
- Inspect API/network calls
- Analyze error messages
- Debug async operations
- Identify common React Native pitfalls
- Build systematic troubleshooting skills

---

# 🧠 What is Debugging?

Debugging is the process of:

✅ Identifying issues

✅ Understanding root causes

✅ Fixing problems efficiently

---

# 🔹 Important Mindset

Good debugging is systematic.

Avoid:

❌ Random guessing

❌ Changing multiple things at once

Instead:

✅ Reproduce issue

✅ Isolate problem

✅ Fix step-by-step

---

# 🔹 Debugging Flow

```text id="debug001"
Bug Appears
      ↓
Reproduce Issue
      ↓
Inspect Logs & Errors
      ↓
Identify Root Cause
      ↓
Fix Problem
      ↓
Verify Solution
```

---

# 🔹 Real ExpenseApp Examples

Common debugging situations:

- Login not working
- Transactions not updating
- API returning wrong data
- Navigation not opening screen
- Theme not updating
- Form validation failing

---

# 🛠️ Using React DevTools

---

# 🔹 What is React DevTools?

React DevTools helps inspect:

✅ Components

✅ Props

✅ State

✅ Context values

✅ Re-renders

---

# 🔹 Why Useful?

Instead of guessing application state:

❌ Blind debugging

we can inspect real component data directly.

---

# 🔹 What You Can Inspect

Examples in ExpenseApp:

✅ Transaction list state

✅ Logged-in user

✅ Theme context

✅ Form values

---

# 🔹 Example Scenario

Problem:

```text id="debug002"
Total amount incorrect
```

Debugging steps:

1. Inspect transaction state
2. Verify props passed to component
3. Check reduce() calculation

---

# 🔹 React DevTools Use Cases

| Problem         | What to Inspect   |
| --------------- | ----------------- |
| Wrong UI        | Component props   |
| Missing data    | State values      |
| Re-render issue | Component updates |
| Theme issue     | Context values    |

---

# 🧾 Using Console Logs Properly

---

# 🔹 Why console.log() Matters

`console.log()` is the simplest and fastest debugging tool.

---

# 🔹 Basic Example

```ts id="log001"
console.log("Transactions:", transactions);
```

---

# 🔹 Debugging State Changes

```ts id="log002"
useEffect(() => {
    console.log("Updated transactions:", transactions);
}, [transactions]);
```

---

# 🔹 Why Helpful?

This helps track:

✅ State updates

✅ Async data loading

✅ Unexpected changes

---

# 🔹 Use Descriptive Logs

❌ Bad:

```ts id="log003"
console.log(data);
```

---

# ✅ Better:

```ts id="log004"
console.log("Fetched API data:", data);
```

---

# 🔹 console.table()

Useful for arrays and objects.

---

# 🔹 Example

```ts id="log005"
console.table(transactions);
```

---

# 🔹 Why Useful?

Better visualization for:

✅ Transactions

✅ API responses

✅ Arrays of objects

---

# 🔹 Avoid Excessive Logs

Too many logs create noise.

Best practice:

✅ Log only meaningful information

---

# 🔹 Remove Logs in Production

Production apps should avoid unnecessary logs for:

✅ Performance

✅ Security

✅ Cleaner debugging

---

# 🌐 Debugging API Calls

Most real-world bugs involve APIs.

---

# 🔹 Common API Problems

❌ Wrong endpoint

❌ Invalid response

❌ Authentication failure

❌ Network timeout

❌ Incorrect payload

---

# 🔹 Axios Example

```ts id="api001"
const response = await axios.get("/transactions");

console.log(response.data);
```

---

# 🔹 What to Verify

Always check:

✅ URL

✅ Request body

✅ Response data

✅ Status codes

---

# 🔹 ExpenseApp Example

Problem:

```text id="api002"
Transactions not showing
```

Debug steps:

1. Check API response
2. Verify response structure
3. Check state update
4. Verify FlatList data

---

# 🔹 Error Handling Example

```ts id="api003"
try {
    const response = await axios.get("/transactions");

    console.log(response.data);
} catch (error) {
    console.log(error);
}
```

---

# 🧪 Flipper Basics

---

# 🔹 What is Flipper?

Flipper is a debugging platform for React Native applications.

---

# 🔹 Features

Flipper provides:

✅ Network inspector

✅ Layout inspector

✅ Logs viewer

✅ Performance tools

---

# 🔹 Setup

1. Install Flipper desktop app
2. Start React Native app
3. Connect emulator/device

---

# 🔹 ExpenseApp Use Cases

Flipper helps debug:

✅ API requests

✅ Layout problems

✅ Performance issues

✅ AsyncStorage data

---

# 🔹 Flipper Network Tab

The network tab shows:

✅ API requests

✅ Headers

✅ Response body

✅ Status codes

---

# ⚠️ Understanding Error Messages

Error messages are extremely important.

Never ignore them.

---

# 🔹 Common Error Types

| Error Type    | Example            |
| ------------- | ------------------ |
| Syntax Error  | Missing bracket    |
| Runtime Error | Undefined property |
| Network Error | API failed         |
| Type Error    | Wrong data type    |

---

# 🔹 Example Error

```text id="err001"
TypeError:
Cannot read property 'map' of undefined
```

---

# 🔹 Root Cause

```ts id="err002"
transactions.map(...)
```

`transactions` is undefined.

---

# 🔹 Fix

```ts id="err003"
transactions?.map(...)
```

---

# 🔹 Why Optional Chaining Helps

Optional chaining prevents:

❌ Application crashes

when values are undefined.

---

# 🔹 Read Error Messages Carefully

Error messages usually tell:

✅ File

✅ Line number

✅ Problem type

---

# 🔍 Debugging Async Issues

Async operations are common bug sources.

---

# 🔹 Common Problems

❌ Missing await

❌ Incorrect loading states

❌ Race conditions

❌ Unhandled Promise rejection

---

# 🔹 Example Problem

```ts id="async001"
const data = fetchTransactions();
```

Missing:

```ts id="async002"
await;
```

---

# 🔹 Correct Version

```ts id="async003"
const data = await fetchTransactions();
```

---

# 🔹 Loading State Debugging

```tsx id="async004"
if (loading) {
    return <Text>Loading...</Text>;
}
```

---

# 🔹 Why Important?

Without proper loading states:

❌ UI may render incomplete data

---

# 🚨 Common React Native Pitfalls

---

# 🔹 Undefined State

❌ Problem:

```ts id="pit001"
transactions.map(...)
```

---

# ✅ Better:

```ts id="pit002"
transactions?.map(...)
```

---

# 🔹 Infinite Re-renders

❌ Problem:

```tsx id="pit003"
useEffect(() => {
    setCount(count + 1);
});
```

---

# 🔹 Why Happens?

Missing dependency array.

---

# ✅ Fix

```tsx id="pit004"
useEffect(() => {
    setCount(count + 1);
}, []);
```

---

# 🔹 Incorrect FlatList Keys

❌ Problem:

```tsx id="pit005"
keyExtractor={(item) => item.id}
```

---

# ✅ Better:

```tsx id="pit006"
keyExtractor={(item) =>
    item.id.toString()
}
```

---

# 🔹 Wrong Prop Types

❌ Problem:

```tsx id="pit007"
<ExpenseItem amount="200" />
```

---

# ✅ Better:

```tsx id="pit008"
<ExpenseItem amount={200} />
```

---

# 🔹 Navigation Errors

❌ Wrong route name:

```tsx id="pit009"
router.push("/transaction");
```

---

# ✅ Correct:

```tsx id="pit010"
router.push("/(transaction)");
```

---

# 🧪 ExpenseApp Debugging Scenario

---

# 🔹 Problem

Transaction total not updating.

---

# 🔹 Debugging Process

Step 1:

Check state.

```ts id="dbg001"
console.log(transactions);
```

---

Step 2:

Verify calculation.

```ts id="dbg002"
transactions.reduce(...)
```

---

Step 3:

Check dependencies.

```tsx id="dbg003"
useEffect(() => {}, [transactions]);
```

---

# 🔹 Result

Incorrect dependency identified and fixed.

---

# ⚡ Performance Debugging

Sometimes applications work correctly but feel slow.

---

# 🔹 Symptoms

❌ Laggy scrolling

❌ Delayed taps

❌ Slow rendering

---

# 🔹 Tools

Use:

✅ React DevTools Profiler

✅ Flipper Performance Plugin

---

# 🔹 Common Fixes

✅ Use React.memo

✅ Optimize FlatList

✅ Reduce re-renders

---

# 🔹 Metro Bundler Errors

React Native often shows Metro errors.

---

# 🔹 Common Fix

Restart Metro:

```bash id="metro001"
npx expo start -c
```

---

# 🔹 Why Helpful?

Clears cache and resolves many unexpected issues.

---

# 🔹 Recommended Debugging Workflow

```text id="workflow001"
Read Error
    ↓
Reproduce Bug
    ↓
Add Logs
    ↓
Inspect State
    ↓
Inspect Network Calls
    ↓
Fix Root Cause
    ↓
Verify Solution
```

---

# ✅ Best Practices

✅ Read error messages carefully
✅ Debug systematically
✅ Use logs strategically
✅ Use DevTools and Flipper
✅ Keep components small
✅ Handle async operations properly

---

# ⚠️ Common Mistakes

❌ Ignoring error messages
❌ Guessing instead of analyzing
❌ Overusing console logs
❌ Not checking API responses
❌ Debugging multiple issues simultaneously

---

# 🧪 Practice Exercises

1. Debug failed login API
2. Debug transaction list rendering
3. Add loading state debugging
4. Inspect Theme Context values
5. Debug FlatList performance
6. Debug navigation route issue
7. Use Flipper to inspect API requests

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned debugging fundamentals
✅ Used React DevTools effectively
✅ Used console logs properly
✅ Explored Flipper basics
✅ Inspected network/API calls
✅ Analyzed error messages
✅ Debugged async operations
✅ Identified common React Native pitfalls
✅ Built systematic troubleshooting skills
