# Chapter 12: React Hooks, Side Effects & Data Flow

---

# Recommended New Learning Flow

1. Why Hooks?
2. useState refresher
3. Managing Expense List
4. Updating State Correctly
5. useEffect introduction
6. Dependency arrays
7. Derived values (totals)
8. Fetching/loading data
9. Cleanup functions
10. Rules of Hooks
11. Custom hooks
12. One-way data flow
13. Parent-child communication
14. Common mistakes
15. Best practices
16. Exercises

---

# Important Improvements You Should Add

## 1. Add “Why Hooks?” Section

Before directly starting `useState`.

```md
# Why React Hooks?

Before Hooks, React developers mainly used Class Components for managing state and lifecycle methods.

Hooks allow Functional Components to:

- Manage state
- Handle side effects
- Share reusable logic
- Write cleaner and smaller code

Hooks made React development simpler and more powerful.

In modern React Native applications, Hooks are the standard approach.
```

---

# 2. Align useState Example with ExpenseApp

Instead of generic counter example first, start directly with ExpenseApp context.

Replace this:

```tsx
const [count, setCount] = useState(0);
```

With:

```tsx
const [description, setDescription] = useState("");
const [amount, setAmount] = useState("");
```

Because previous chapters already established this flow.

Then later introduce counter as secondary example if needed.

---

# 3. Add Proper TypeScript Types

Current examples miss TypeScript typing consistency.

Add:

```tsx
type Expense = {
  id: number;
  description: string;
  amount: number;
};
```

Then:

```tsx
const [expenses, setExpenses] = useState<Expense[]>([]);
```

This aligns with earlier chapters.

---

# 4. Improve State Update Example

Current:

```tsx
setExpenses([...expenses, expense]);
```

Better teaching version:

```tsx
setExpenses((prevExpenses) => [...prevExpenses, newExpense]);
```

Then explain WHY:

```md
👉 Functional updates always use the latest state
👉 Prevents stale state issues
👉 Recommended when new state depends on previous state
```

---

# 5. Add Full ExpenseApp Example

This is missing currently.

You should add a complete working example like this:

```tsx
import React, { useState } from "react";
import { SafeAreaView, Text, TextInput, Pressable, View } from "react-native";

type Expense = {
  id: number;
  description: string;
  amount: number;
};

export default function App() {
  const [description, setDescription] = useState("");
  const [amount, setAmount] = useState("");
  const [expenses, setExpenses] = useState<Expense[]>([]);

  const handleAddExpense = () => {
    const newExpense = {
      id: Date.now(),
      description,
      amount: Number(amount),
    };

    setExpenses((prevExpenses) => [...prevExpenses, newExpense]);

    setDescription("");
    setAmount("");
  };

  return (
    <SafeAreaView>
      <TextInput
        value={description}
        onChangeText={setDescription}
        placeholder="Description"
      />

      <TextInput
        value={amount}
        onChangeText={setAmount}
        placeholder="Amount"
        keyboardType="numeric"
      />

      <Pressable onPress={handleAddExpense}>
        <Text>Add Expense</Text>
      </Pressable>

      {expenses.map((item) => (
        <View key={item.id}>
          <Text>{item.description}</Text>
          <Text>₹{item.amount}</Text>
        </View>
      ))}
    </SafeAreaView>
  );
}
```

This keeps continuity with earlier chapters.

---

# 6. Add “Derived State” Explanation

Very important educational concept.

```md
# Derived State

Sometimes values are calculated from existing state instead of stored separately.

Example:

- Total expense amount
- Expense count
- Average expense

These values are called derived state.
```

Then show:

```tsx
const totalAmount = expenses.reduce((sum, item) => sum + item.amount, 0);
```

Then explain:

```md
👉 Avoid storing derived values separately unless necessary
👉 Reduces bugs and duplicate state
```

This is a VERY important React concept.

---

# 7. Improve useEffect Section

Current explanation is too short.

Add lifecycle explanation:

```md
useEffect replaces lifecycle methods from Class Components:

- componentDidMount
- componentDidUpdate
- componentWillUnmount
```

---

# 8. Add Loading State Example

Excellent real-world concept.

```tsx
const [loading, setLoading] = useState(true);

useEffect(() => {
  const fetchExpenses = async () => {
    setLoading(true);

    const data = [
      {
        id: 1,
        description: "Food",
        amount: 250,
      },
    ];

    setExpenses(data);
    setLoading(false);
  };

  fetchExpenses();
}, []);
```

Then:

```tsx
if (loading) {
  return <Text>Loading expenses...</Text>;
}
```

Very practical.

---

# 9. Add “Rules of Hooks”

Very important and currently missing.

```md
# Rules of Hooks

Hooks must:

✅ Be called at the top level
✅ Be called inside React components
✅ Be called in same order every render

Hooks should NOT:

❌ Be called inside loops
❌ Be called inside conditions
❌ Be called inside nested functions
```

---

# 10. Improve Custom Hook Example

Current custom hook is too simple.

Better:

📁 `src/hooks/useExpenses.ts`

```tsx
import { useState } from "react";

type Expense = {
  id: number;
  description: string;
  amount: number;
};

export default function useExpenses() {
  const [expenses, setExpenses] = useState<Expense[]>([]);

  const addExpense = (description: string, amount: number) => {
    const newExpense = {
      id: Date.now(),
      description,
      amount,
    };

    setExpenses((prev) => [...prev, newExpense]);
  };

  const totalAmount = expenses.reduce((sum, item) => sum + item.amount, 0);

  return {
    expenses,
    addExpense,
    totalAmount,
  };
}
```

This demonstrates reusable business logic properly.

---

# 11. Add Parent → Child → Parent Communication

Current chapter only shows downward flow.

Add callback props:

```tsx
function Parent() {
  const handleSave = () => {
    console.log("Saved");
  };

  return <Child onSave={handleSave} />;
}

function Child({ onSave }) {
  return (
    <Pressable onPress={onSave}>
      <Text>Save</Text>
    </Pressable>
  );
}
```

Then explain:

```md
👉 Data flows downward
👉 Events flow upward through callback functions
```

Very important architecture concept.

---

# 12. Add Common useEffect Mistakes

This section will help beginners a LOT.

```md
# Common useEffect Mistakes

❌ Missing dependency array
→ Causes unnecessary re-renders

❌ Updating state inside effect incorrectly
→ May create infinite loops

❌ Putting every variable in dependency array blindly
→ Can cause unexpected executions
```

Then show bad example:

```tsx
useEffect(() => {
  setCount(count + 1);
}, [count]);
```

Explain infinite loop clearly.

---

# 13. Add Folder Structure

```text
src/
 ├── app/
 │    └── index.tsx
 ├── components/
 │    └── ExpenseItem.tsx
 ├── hooks/
 │    └── useExpenses.ts
 └── styles/
      └── styles.ts
```

Improves beginner clarity.

---

# 14. Add Practice Exercises

Very valuable for training workshops.

```md
# Practice Exercises

1. Add Delete Expense functionality
2. Show total expense count
3. Add loading indicator
4. Create custom hook for totals
5. Add category field
6. Show highest expense
```

---

# 15. Improve Final Summary

Current summary is too short.

Recommended:

```md
# Chapter Summary

In this chapter, you:

✅ Learned why Hooks are important
✅ Used `useState` for dynamic UI
✅ Managed arrays and objects in state
✅ Understood immutable updates
✅ Learned `useEffect` and side effects
✅ Used dependency arrays correctly
✅ Calculated derived values
✅ Learned cleanup functions
✅ Created reusable custom hooks
✅ Understood one-way data flow
✅ Passed callbacks between components
✅ Followed React Hook best practices
```
