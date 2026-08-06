# Chapter 8: Advanced JavaScript for React Native

---

# 🚀 Introduction

In previous chapters, we learned JavaScript fundamentals such as:

- Variables
- Functions
- Conditions
- Loops
- Arrays
- Objects

In this chapter, we move to more advanced JavaScript concepts that are heavily used in modern React Native applications.

Modern React Native development relies on:

- ES6+ syntax
- Functional programming concepts
- Immutable data handling
- Array methods
- Clean and reusable functions

These concepts are frequently used while building:

- Screens
- Forms
- APIs
- Navigation
- State management
- Expense calculations
- Dashboard summaries

in ExpenseApp.

This chapter focuses specifically on the modern JavaScript concepts commonly used in React Native development.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand modern ES6+ syntax
- Use `let` and `const` properly
- Understand why `var` should be avoided
- Write cleaner code using arrow functions
- Work with objects and arrays efficiently
- Use destructuring and template literals
- Use spread and rest operators
- Apply array methods effectively
- Understand immutability
- Write predictable pure functions

---

# 🔹 let vs const

Modern JavaScript uses `let` and `const` instead of `var`.

---

# ❌ Why Avoid `var`?

Before ES6, JavaScript used `var` for declaring variables.

However, `var` has several problems and can lead to confusing bugs in large applications.

Modern React Native applications should use:

- `const`
- `let`

instead of `var`.

---

# ⚠️ Problem 1: Function Scope Instead of Block Scope

`var` is function scoped, not block scoped.

This means variables declared inside blocks like:

- `if`
- `for`
- `while`

still affect values outside the block.

---

# 🧪 Example

```ts
var amount = 100;

if (true) {
  var amount = 500;
}

console.log(amount);
```

👉 Output:

```text
500
```

---

# ❌ What Happened?

The variable inside the `if` block overwrote the original variable.

This happens because:

```text
var ignores block scope
```

The same variable is shared across the entire function.

This can cause:

- Unexpected overwriting
- Difficult debugging
- Hidden bugs
- Accidental data modification

---

# ✅ let Fixes This Problem

`let` is block scoped.

```ts
let amount = 100;

if (true) {
  let amount = 500;
}

console.log(amount);
```

👉 Output:

```text
100
```

Now the inner variable exists only inside the `if` block.

---

# ⚠️ Problem 2: Variable Hoisting Confusion

Variables declared using `var` are hoisted to the top of the function.

This can create unexpected behavior.

---

# 🧪 Example

```ts
console.log(total);

var total = 500;
```

👉 Output:

```text
undefined
```

---

# ❌ Why Does This Happen?

JavaScript internally behaves like this:

```ts
var total;

console.log(total);

total = 500;
```

This behavior can confuse beginners and create difficult bugs.

---

# ✅ let and const Are Safer

```ts
console.log(total);

let total = 500;
```

👉 This produces an error immediately.

This helps developers detect mistakes faster.

---

# ⚠️ Problem 3: Issues Inside Loops

`var` can behave unexpectedly inside loops because the same variable gets reused.

---

# 🧪 Example

```ts
for (var i = 0; i < 3; i++) {
  setTimeout(() => {
    console.log(i);
  }, 100);
}
```

👉 Output:

```text
3
3
3
```

---

# ❌ Why?

Because all callbacks share the same `i` variable.

By the time `setTimeout` runs:

```text
i = 3
```

---

# ✅ let Fixes This Automatically

```ts
for (let i = 0; i < 3; i++) {
  setTimeout(() => {
    console.log(i);
  }, 100);
}
```

👉 Output:

```text
0
1
2
```

Each loop iteration gets its own variable.

---

# 📊 var vs let vs const

| Keyword | Scope    | Reassignment | Recommended               |
| ------- | -------- | ------------ | ------------------------- |
| `var`   | Function | Yes          | ❌ Avoid                  |
| `let`   | Block    | Yes          | ✅ Use when value changes |
| `const` | Block    | No           | ✅ Preferred              |

---

# ✅ const (Preferred)

Used when a value should not be reassigned.

```ts
const amount = 500;
```

---

# ✅ Benefits of const

- Prevents accidental reassignment
- Makes code safer
- Improves readability
- Encourages predictable code

---

# 🧪 Example

```ts
const category = "Food";
```

---

# ✅ let

Used when value changes later.

```ts
let total = 0;

total = total + 100;
```

---

# 📋 Common Use Cases of let

- Counters
- Loops
- Accumulations
- Search inputs
- Form state updates

---

# ✅ Best Practice

👉 Prefer `const` by default
👉 Use `let` only when needed
👉 Avoid `var` completely

---

# 🔹 Arrow Functions

Arrow functions provide a shorter and cleaner syntax.

They are widely used in React Native.

---

# 🧪 Traditional Function

```ts
function add(a: number, b: number) {
  return a + b;
}
```

---

# 🧪 Arrow Function

```ts
const add = (a: number, b: number) => a + b;
```

---

# ✅ Benefits

- Cleaner syntax
- Easier to read
- Avoids `this` binding issues
- Preferred in React

---

# 🔹 Multi-line Arrow Function

```ts
const calculateTotal = (expenses: any[]) => {
  return expenses.reduce((sum, item) => sum + item.amount, 0);
};
```

---

# 🧪 ExpenseApp Example

```ts
const calculateTotal = (expenses: any[]) =>
  expenses.reduce((sum, item) => sum + item.amount, 0);
```

👉 Calculates total transaction amount.

---

# 🔹 Destructuring

Destructuring allows extracting values from objects and arrays easily.

It improves readability and reduces repetitive code.

---

# 📦 Object Destructuring

---

# ❌ Without Destructuring

```ts
const expense = {
  title: "Food",
  amount: 200,
};

console.log(expense.title);

console.log(expense.amount);
```

---

# ✅ With Destructuring

```ts
const expense = {
  title: "Food",
  amount: 200,
};

const { title, amount } = expense;

console.log(title);

console.log(amount);
```

---

# ✅ Benefits

- Cleaner code
- Easier property access
- Less repetition

---

# 📚 Array Destructuring

```ts
const amounts = [100, 200];

const [first, second] = amounts;
```

---

# 📋 Use Cases

- Extracting API responses
- Working with arrays
- Handling hook return values

---

# ⚛️ React Example

```tsx
function ExpenseItem({
  description,
  amount,
}: {
  description: string;
  amount: number;
}) {
  return (
    <Text>
      {description}: ₹{amount}
    </Text>
  );
}
```

👉 Props are destructured directly inside function parameters.

---

# 🔹 Template Literals

Template literals make string creation cleaner and more readable.

---

# ❌ Old Way

```ts
const text = title + ": ₹" + amount;
```

---

# ✅ Modern Way

```ts
const title = "Food";

const amount = 200;

const text = `${title}: ₹${amount}`;
```

---

# ✅ Benefits

- Easier variable interpolation
- Cleaner syntax
- Better readability

---

# 🔹 Spread Operator (`...`)

Used to copy or merge arrays and objects.

Very important in React state management.

---

# 📦 Array Copy

```ts
const numbers = [1, 2, 3];

const copy = [...numbers];
```

---

# ➕ Adding New Items

```ts
const expenses = [{ id: 1, amount: 200 }];

const updatedExpenses = [...expenses, { id: 2, amount: 300 }];
```

---

# ❓ Why Important in React?

React requires immutable updates.

---

# ❌ Wrong (Mutation)

```ts
expenses.push({
  id: 3,
  amount: 500,
});
```

👉 Directly modifies original array.

---

# ✅ Correct (Immutable)

```ts
const newExpenses = [...expenses, { id: 3, amount: 500 }];
```

👉 Creates a new array.

---

# 🔹 Rest Operator (`...`)

Used to collect multiple values into an array.

---

# 🧪 Example

```ts
const sum = (...numbers: number[]) =>
  numbers.reduce((total, n) => total + n, 0);
```

---

# 🧪 Usage

```ts
sum(10, 20, 30);
```

👉 Output:

```text
60
```

---

# 🔹 Array Methods

Modern JavaScript provides powerful array methods heavily used in React Native.

---

# map()

Transforms each item into another value.

---

# 🧪 Example

```ts
const numbers = [1, 2, 3];

const doubled = numbers.map((n) => n * 2);
```

---

# 📤 Output

```ts
[2, 4, 6];
```

---

# ⚛️ ExpenseApp Example

```tsx
{
  expenses.map((expense, index) => (
    <ExpenseDetail
      key={index}
      description={expense.description}
      amount={expense.amount}
    />
  ));
}
```

👉 Converts transaction data into UI components.

---

# filter()

Returns items matching a condition.

---

# 🧪 Example

```ts
const expenses = [{ amount: 200 }, { amount: 800 }];

const filtered = expenses.filter((item) => item.amount > 500);
```

---

# 📋 Use Cases

- Category filtering
- Search results
- Dashboard reports

---

# find()

Returns the first matching item.

---

# 🧪 Example

```ts
const expense = expenses.find((item) => item.id === 1);
```

---

# 📋 Use Cases

- Finding transaction by ID
- Editing records
- Detail screens

---

# reduce()

Combines all items into a single value.

---

# 🧪 Example

```ts
const total = expenses.reduce((sum, item) => sum + item.amount, 0);
```

## 🔹 How `reduce` Works

- `numbers` is an array of numbers (thanks to the rest parameter `...numbers`).
- `reduce` iterates through the array.
- `sum` starts at the **initial value** you provide (`0` here).
- On each iteration, `n` is the current number, and you add it to `total`.

---

# 📋 ExpenseApp Use Cases

- Dashboard totals
- Monthly summaries
- Expense analytics

---

# 🔹 Immutability

Immutability means not modifying original data directly.

React depends on immutable updates for detecting changes efficiently.

---

# ❌ Direct Mutation

```ts
expenses.push({
  id: 4,
  amount: 600,
});
```

---

# ✅ Immutable Update

```ts
const updatedExpenses = [...expenses, { id: 4, amount: 600 }];
```

---

# 🔹 Updating Objects Safely

```ts
const updated = expenses.map((expense) =>
  expense.description === "Grocery"
    ? {
        ...item,
        amount: 1000,
      }
    : item,
);
```

---

# ❓ Why Important?

- Predictable updates
- Better performance
- Easier debugging

---

# 🔹 Pure Functions

Pure functions are predictable functions.

---

# 📋 Characteristics

A pure function:

- Does not modify external data
- Returns same output for same input
- Has no side effects

---

# ✅ Pure Function Example

```ts
const add = (a: number, b: number) => a + b;
```

---

# ❌ Impure Function

```ts
let total = 0;

const addExpense = (amount: number) => {
  total += amount;
};
```

👉 Depends on external variable.

---

# ✅ Better Version

```ts
const addExpense = (total: number, amount: number) => total + amount;
```

---

# ❓ Why Pure Functions Matter

Pure functions:

- Are easier to test
- Are reusable
- Produce predictable behavior

---

# 🧪 Real ExpenseApp Example

```ts
type Expense = {
  id: number;
  title: string;
  amount: number;
};

const expenses: Expense[] = [
  {
    id: 1,
    title: "Food",
    amount: 200,
  },

  {
    id: 2,
    title: "Travel",
    amount: 300,
  },
];

// Total

const total = expenses.reduce((sum, item) => sum + item.amount, 0);

// Add new expense

const updatedExpenses = [
  ...expenses,

  {
    id: 3,
    title: "Shopping",
    amount: 500,
  },
];

// Filter

const filteredExpenses = expenses.filter((item) => item.amount > 200);
```

---

# 🔹 Common Mistakes

---

# ❌ Mutating State Directly

```ts
expenses.push(newExpense);
```

---

# ✅ Correct

```ts
setExpenses([...expenses, newExpense]);
```

---

# ❌ Using var

```ts
var amount = 100;
```

---

# ✅ Correct

```ts
const amount = 100;
```

---

# ✅ Best Practices

- Prefer `const` over `let`
- Avoid `var`
- Use arrow functions
- Use immutable updates
- Prefer array methods over loops
- Write pure functions
- Keep code readable and predictable

---

# ⚠️ Common Mistakes

- Mutating arrays directly using `push()`
- Using `var` instead of `const` or `let`
- Forgetting to return values inside arrow functions
- Modifying objects directly instead of using spread operator

---

# 🧪 Practice Exercises

1. Create an array of expenses and calculate total amount using `reduce()`
2. Filter all expenses greater than ₹500 using `filter()`
3. Convert a traditional function into an arrow function
4. Create a new array using spread operator and add one more expense item
5. Replace `var` with `let` and `const` in sample examples

---

# 📘 Chapter Summary

In this chapter, you:

- Learned modern ES6+ syntax
- Understood `let`, `const`, and why `var` should be avoided
- Used arrow functions effectively
- Applied destructuring
- Used template literals
- Worked with spread and rest operators
- Used array methods (`map`, `filter`, `find`, `reduce`)
- Understood immutability
- Wrote pure functions
- Applied modern JavaScript best practices
