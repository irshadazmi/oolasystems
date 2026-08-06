# Chapter 16: Advanced JavaScript – Async Patterns

---

In previous chapters, we worked with:

- API calls
- AsyncStorage
- Navigation
- Context API
- Loading and error handling

All these features rely heavily on **asynchronous programming**.

Modern React Native applications constantly perform background operations such as:

- Fetching API data
- Saving local storage
- Handling user input
- Loading screens
- Processing search requests

In this chapter, we will learn advanced asynchronous programming patterns used in real-world React Native applications.

In ExpenseApp, these patterns help us:

- Fetch expenses from APIs
- Search expenses efficiently
- Improve performance
- Avoid unnecessary API calls
- Handle errors gracefully

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand asynchronous programming
- Learn callbacks, promises, and async/await
- Handle asynchronous flows effectively
- Chain async operations
- Handle async errors properly
- Use debouncing and throttling
- Improve React Native performance
- Apply batching techniques
- Build cleaner async architecture

---

# 🔹 What is Asynchronous Programming?

JavaScript is single-threaded.

This means it executes one operation at a time.

However, some operations take time:

- API calls
- File loading
- Timers
- Database operations

Instead of blocking the application, JavaScript handles these tasks asynchronously.

---

# 🔹 Synchronous vs Asynchronous

## Synchronous Example

```ts
console.log("Start");

console.log("Middle");

console.log("End");
```

Output:

```text
Start
Middle
End
```

---

## Asynchronous Example

```ts
console.log("Start");

setTimeout(() => {
    console.log("Async Task");
}, 1000);

console.log("End");
```

Output:

```text
Start
End
Async Task
```

---

# 🔹 Why Async Programming Matters in React Native

Without async programming:

❌ UI freezes
❌ Slow user experience
❌ App becomes unresponsive

With async programming:

✅ Smooth UI
✅ Better performance
✅ Faster interactions

---

# 🔹 Callbacks

---

# 🔹 What is a Callback?

A callback is a function passed into another function.

The callback executes later after a task completes.

---

## Callback Example

```ts
function fetchData(callback: (data: string) => void) {
    setTimeout(() => {
        callback("Expenses Loaded");
    }, 1000);
}

fetchData((data) => {
    console.log(data);
});
```

---

# 🔹 Callback Flow

```text
Function Starts
      ↓
Async Operation Runs
      ↓
Callback Executes Later
```

---

# 🔹 Problem: Callback Hell

Nested callbacks become difficult to read and maintain.

```ts
loginUser(() => {
    fetchExpenses(() => {
        saveExpenses(() => {
            console.log("Completed");
        });
    });
});
```

Problems:

❌ Hard to read
❌ Difficult debugging
❌ Poor maintainability

---

# 🔹 Promises

Promises solve callback hell problems.

---

# 🔹 What is a Promise?

A Promise represents a future value.

It may:

- Succeed
- Fail
- Still be processing

---

# 🔹 Promise States

| State     | Meaning       |
| --------- | ------------- |
| Pending   | Still running |
| Fulfilled | Success       |
| Rejected  | Failed        |

---

# 🔹 Promise Example

```ts
const fetchExpenses = () => {
    return new Promise<string>((resolve) => {
        setTimeout(() => {
            resolve("Expenses Loaded");
        }, 1000);
    });
};

fetchExpenses().then((data) => {
    console.log(data);
});
```

---

# 🔹 Promise Chaining

Promises can be chained together.

```ts
fetchExpenses()
    .then((data) => {
        return data + " Successfully";
    })
    .then((result) => {
        console.log(result);
    })
    .catch((error) => {
        console.log(error);
    });
```

---

# 🔹 Problems with Promise Chains

Large promise chains can still become difficult to read.

This led to:

👉 `async/await`

---

# 🔹 async / await (Modern Approach)

`async/await` provides cleaner asynchronous code.

It looks similar to synchronous code.

---

# 🔹 Basic Example

```ts
const fetchExpenses = async () => {
    const data = await apiCall();

    console.log(data);
};
```

---

# 🔹 With Error Handling

```ts
const loadExpenses = async () => {
    try {
        const data = await apiCall();

        console.log(data);
    } catch (error) {
        console.log(error);
    }
};
```

---

# 🔹 Why async/await is Preferred

Benefits:

✅ Cleaner syntax
✅ Easier debugging
✅ Better readability
✅ Better error handling

👉 Preferred in React Native applications

---

# 🔹 Promise Chaining vs async/await

---

## Promise Chaining

```ts
fetchExpenses().then(processExpenses).then(saveExpenses).catch(handleError);
```

---

## async/await

```ts
try {
    const expenses = await fetchExpenses();

    const processed = await processExpenses(expenses);

    await saveExpenses(processed);
} catch (error) {
    handleError(error);
}
```

---

# 🔹 Error Propagation

Errors inside async operations travel upward until caught.

This is called:

👉 Error Propagation

---

# 🔹 Example

```ts
const fetchExpenses = async () => {
    throw new Error("API Failed");
};

const loadData = async () => {
    try {
        await fetchExpenses();
    } catch (error) {
        console.log(error);
    }
};

loadData();
```

---

# 🔹 Best Practices for Error Handling

✅ Always use try/catch

✅ Show user-friendly messages

✅ Avoid silent failures

✅ Log important errors

---

# 🔹 Debouncing

---

# 🔹 What is Debouncing?

Debouncing delays function execution until the user stops triggering events.

---

# 🔹 ExpenseApp Use Cases

- Search expenses
- Filter categories
- Search transactions

---

# 🔹 Problem Without Debouncing

If user types:

```text
F
Fo
Foo
Food
```

API gets called multiple times unnecessarily.

---

# 🔹 Debounce Example

```ts
let timeout: NodeJS.Timeout;

const debounce = (fn: (...args: any[]) => void, delay: number) => {
    return (...args: any[]) => {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            fn(...args);
        }, delay);
    };
};
```

---

# 🔹 Using Debounce

```ts
const searchExpenses = debounce(async (query: string) => {
    console.log("Searching:", query);
}, 500);
```

---

# 🔹 Debounce Flow

```text
User Typing
      ↓
Previous Timer Cleared
      ↓
Wait for Delay
      ↓
Execute Function
```

---

# 🔹 Throttling

---

# 🔹 What is Throttling?

Throttling limits function execution to once every fixed interval.

---

# 🔹 Use Cases

- Scroll events
- Resize events
- Button tapping
- Gesture handling

---

# 🔹 Throttle Example

```ts
let lastCall = 0;

const throttle = (fn: (...args: any[]) => void, delay: number) => {
    return (...args: any[]) => {
        const now = Date.now();

        if (now - lastCall >= delay) {
            lastCall = now;

            fn(...args);
        }
    };
};
```

---

# 🔹 Debounce vs Throttle

| Feature   | Debounce     | Throttle        |
| --------- | ------------ | --------------- |
| Execution | After delay  | Every interval  |
| Best For  | Search input | Scroll events   |
| Reduces   | API calls    | Frequent events |

---

# 🔹 Batching Updates

React batches multiple state updates together.

This improves rendering performance.

---

# 🔹 Example

```tsx
setCount((prev) => prev + 1);

setCount((prev) => prev + 1);
```

React combines updates into fewer renders.

---

# 🔹 ExpenseApp Example

```tsx
setExpenses((prev) => [...prev, newExpense]);

setTotal((prev) => prev + newExpense.amount);
```

---

# 🔹 Why Batching is Important

Benefits:

✅ Better performance
✅ Fewer renders
✅ Smoother UI

---

# 🧪 ExpenseApp Example – Search with API

```tsx
const searchExpenses = debounce(async (query: string) => {
    try {
        const response = await axios.get(`/expenses?q=${query}`);

        setExpenses(response.data);
    } catch (error) {
        console.log(error);
    }
}, 500);
```

---

# 🔹 Complete Async Flow

```text
User Types Search
        ↓
Debounce Waits
        ↓
API Request Sent
        ↓
Server Responds
        ↓
State Updates
        ↓
UI Re-renders
```

---

# 🔹 Recommended Folder Structure

```text
src
│
├── services
│   └── expenseService.ts
│
├── hooks
│   └── useDebounce.ts
│
├── app
│   └── search.tsx
│
└── components
    └── SearchBar.tsx
```

---

# ⚠️ Common Mistakes

❌ Nested callbacks everywhere
❌ Forgetting `await`
❌ Ignoring async errors
❌ Excessive API calls
❌ Not debouncing search inputs
❌ Updating state too frequently
❌ Mixing UI and async logic

---

# ✅ Best Practices

✅ Prefer async/await over callbacks
✅ Always use try/catch
✅ Use debouncing for search
✅ Use throttling for frequent events
✅ Keep async logic clean
✅ Separate API logic into services
✅ Avoid unnecessary renders

---

# 🧪 Practice Exercises

1. Create reusable debounce utility
2. Create reusable throttle utility
3. Add debounced search to ExpenseApp
4. Add loading state during search
5. Add retry button on API failure
6. Prevent button double-taps using throttle
7. Create custom hook for async loading

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned asynchronous programming fundamentals
✅ Understood callbacks and callback hell
✅ Used promises and promise chaining
✅ Implemented async/await
✅ Handled async errors properly
✅ Used debouncing and throttling
✅ Improved React Native performance
✅ Applied batching techniques
✅ Built cleaner async architecture
