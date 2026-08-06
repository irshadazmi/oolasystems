# Chapter 13: Global State Management with Context API & AsyncStorage

---

In previous chapters, we managed data using `useState` inside individual components.

This worked well for smaller screens and isolated features.

However, as applications grow, multiple screens often need access to the same data.

For example, in ExpenseApp:

- Home screen needs expense list
- Add Expense screen needs to add new expenses
- Summary screen needs total expenses

Passing data manually through many components becomes difficult.

In this chapter, we solve this problem using:

✅ **Context API** for global state management
✅ **AsyncStorage** for local data persistence

With this, ExpenseApp will be able to:

- Share data across screens
- Maintain centralized application state
- Persist expenses even after app restart

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand global state management
- Learn prop drilling problems
- Use React Context API
- Implement Provider/Consumer pattern
- Create reusable context hooks
- Persist data using AsyncStorage
- Load data during app startup
- Use JSON serialization properly
- Structure scalable React Native applications

---

# 🔹 The Problem with Local Component State

So far, we used `useState` inside individual components.

Example:

```tsx
const [expenses, setExpenses] = useState([]);
```

This works well for simple screens.

However, in real applications:

- Many screens need same data
- Components become deeply nested
- Props must be passed through multiple layers

Example:

```text
HomeScreen
   ↓
ExpenseList
   ↓
ExpenseItem
```

Passing props through many levels is called:

👉 **Prop Drilling**

This makes applications:

- Harder to maintain
- More complex
- Difficult to scale

---

# 🔹 Why Context API?

Context API helps share data globally across the application without manually passing props.

It acts like a centralized store accessible from any screen.

---

## Context API is Useful For

- Expense data
- Authentication
- Theme settings
- User profile data
- Language settings

---

# 🔹 How Context Works

```text
ExpenseProvider
       │
       ├── HomeScreen
       │       └── ExpenseItem
       │
       └── AddExpenseScreen
```

👉 All child components inside the Provider can access shared data.

---

# 🔹 Context API Basics

React Context consists of:

| Part                | Responsibility                |
| ------------------- | ----------------------------- |
| Context             | Creates shared data container |
| Provider            | Supplies data to components   |
| Consumer/useContext | Accesses shared data          |

---

# 🔹 Create Expense Context

📁 `src/contexts/ExpenseContext.tsx`

```tsx
import { createContext } from "react";

export type Expense = {
  id: number;
  description: string;
  amount: number;
};

export type ExpenseContextType = {
  expenses: Expense[];
  addExpense: (expense: Expense) => void;
};

export const ExpenseContext = createContext<ExpenseContextType | null>(null);
```

---

## Explanation

👉 `createContext()` creates global shared state

👉 `Expense` defines expense structure

👉 `ExpenseContextType` defines context shape

👉 `null` is initial default value

---

# 🔹 Create Expense Provider

The Provider stores and manages global application state.

📁 `src/contexts/ExpenseProvider.tsx`

```tsx
import React, { useEffect, useState } from "react";

import AsyncStorage from "@react-native-async-storage/async-storage";

import { Expense, ExpenseContext } from "./ExpenseContext";

export function ExpenseProvider({ children }: { children: React.ReactNode }) {
  const [expenses, setExpenses] = useState<Expense[]>([]);

  useEffect(() => {
    loadStoredExpenses();
  }, []);

  const loadStoredExpenses = async () => {
    try {
      const data = await AsyncStorage.getItem("expenses");

      if (data) {
        setExpenses(JSON.parse(data));
      }
    } catch (error) {
      console.log("Error loading expenses:", error);
    }
  };

  const addExpense = async (expense: Expense) => {
    const updatedExpenses = [...expenses, expense];

    setExpenses(updatedExpenses);

    try {
      await AsyncStorage.setItem("expenses", JSON.stringify(updatedExpenses));
    } catch (error) {
      console.log("Error saving expenses:", error);
    }
  };

  return (
    <ExpenseContext.Provider
      value={{
        expenses,
        addExpense,
      }}
    >
      {children}
    </ExpenseContext.Provider>
  );
}
```

---

# 🔹 Responsibilities of Provider

The Provider is responsible for:

✅ Managing global state
✅ Updating application data
✅ Loading persisted data
✅ Saving updated data
✅ Providing state to child components

---

# 🔹 Wrap Application with Provider

📁 `src/app/_layout.tsx`

```tsx
import { Stack } from "expo-router";

import { ExpenseProvider } from "../contexts/ExpenseProvider";

export default function RootLayout() {
  return (
    <ExpenseProvider>
      <Stack />
    </ExpenseProvider>
  );
}
```

---

## Why Wrap the App?

Wrapping the app makes context accessible throughout the entire application.

All screens inside `<ExpenseProvider>` can access shared expense data.

---

# 🔹 Access Context using useContext

Components can access global data using `useContext`.

📁 `src/hooks/useExpenseContext.ts`

```tsx
import { useContext } from "react";

import { ExpenseContext } from "../contexts/ExpenseContext";

export default function useExpenseContext() {
  const context = useContext(ExpenseContext);

  if (!context) {
    throw new Error("useExpenseContext must be used inside ExpenseProvider");
  }

  return context;
}
```

---

# 🔹 Why Create Custom Hook?

Benefits:

✅ Cleaner components
✅ Reusable logic
✅ Safer context access
✅ Better maintainability

---

# 🔹 Display Expenses using Context

📁 `src/app/index.tsx`

```tsx
import React from "react";

import { FlatList, SafeAreaView, Text, View } from "react-native";

import useExpenseContext from "../hooks/useExpenseContext";

export default function HomeScreen() {
  const { expenses } = useExpenseContext();

  return (
    <SafeAreaView style={{ flex: 1 }}>
      <FlatList
        data={expenses}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <View
            style={{
              padding: 15,
              borderBottomWidth: 1,
            }}
          >
            <Text>{item.description}</Text>

            <Text>₹{item.amount}</Text>
          </View>
        )}
      />
    </SafeAreaView>
  );
}
```

---

# 🔹 Add Expense using Context

📁 `src/app/add-expense.tsx`

```tsx
import React, { useState } from "react";

import { Pressable, SafeAreaView, Text, TextInput, View } from "react-native";

import useExpenseContext from "../hooks/useExpenseContext";

export default function AddExpenseScreen() {
  const { addExpense } = useExpenseContext();

  const [description, setDescription] = useState("");

  const [amount, setAmount] = useState("");

  const handleSave = () => {
    addExpense({
      id: Date.now(),
      description,
      amount: Number(amount),
    });

    setDescription("");
    setAmount("");
  };

  return (
    <SafeAreaView style={{ flex: 1 }}>
      <View style={{ padding: 20 }}>
        <Text>Description</Text>

        <TextInput
          value={description}
          onChangeText={setDescription}
          placeholder="Enter description"
          style={{
            borderWidth: 1,
            padding: 10,
            marginBottom: 20,
          }}
        />

        <Text>Amount (₹)</Text>

        <TextInput
          value={amount}
          onChangeText={setAmount}
          placeholder="Enter amount"
          keyboardType="numeric"
          style={{
            borderWidth: 1,
            padding: 10,
            marginBottom: 20,
          }}
        />

        <Pressable
          onPress={handleSave}
          style={{
            backgroundColor: "#333",
            padding: 15,
          }}
        >
          <Text
            style={{
              color: "#fff",
              textAlign: "center",
            }}
          >
            Save Expense
          </Text>
        </Pressable>
      </View>
    </SafeAreaView>
  );
}
```

---

# 🔹 Persistence Flow

```text
Add Expense
     ↓
Update Context State
     ↓
Save to AsyncStorage
     ↓
App Restart
     ↓
Load Stored Data
     ↓
Restore UI
```

---

# 💾 AsyncStorage

AsyncStorage stores data locally on the device.

It is useful for:

- Expense persistence
- Login sessions
- Offline storage
- User preferences

---

# 🔹 Install AsyncStorage

```bash
npx expo install @react-native-async-storage/async-storage
```

---

# 🔹 JSON Serialization

AsyncStorage only supports string values.

Therefore:

| Operation       | Method             |
| --------------- | ------------------ |
| Object → String | `JSON.stringify()` |
| String → Object | `JSON.parse()`     |

---

## Convert Object to String

```tsx
JSON.stringify(expenses);
```

---

## Convert String to Object

```tsx
JSON.parse(data);
```

---

# 🔹 Loading Data on App Startup

When the app starts:

1. Provider initializes
2. `useEffect()` runs
3. AsyncStorage loads saved data
4. State updates automatically
5. UI re-renders with stored expenses

---

# 🔹 Recommended Folder Structure

```text
src
│
├── app
│   ├── _layout.tsx
│   ├── index.tsx
│   └── add-expense.tsx
│
├── contexts
│   ├── ExpenseContext.tsx
│   └── ExpenseProvider.tsx
│
├── hooks
│   └── useExpenseContext.ts
│
├── components
│   └── ExpenseItem.tsx
│
└── styles
    └── styles.ts
```

---

# 🔹 AsyncStorage Limitations

AsyncStorage is useful for smaller local data.

However, it is NOT ideal for:

- Large databases
- Complex querying
- Sensitive encrypted data
- Very high-performance storage

Advanced applications may use:

- SQLite
- Realm
- Firebase
- Supabase

---

# ✅ Best Practices

✅ Keep contexts focused
✅ Use TypeScript types
✅ Create custom hooks for context access
✅ Handle AsyncStorage errors properly
✅ Use functional state updates
✅ Persist important data only
✅ Separate UI from business logic
✅ Keep components clean and reusable

---

# ⚠️ Common Mistakes

❌ Forgetting to wrap app with Provider
❌ Using context outside Provider
❌ Forgetting `await` with AsyncStorage
❌ Forgetting `JSON.stringify()`
❌ Mutating state directly
❌ Creating one huge global context
❌ Storing large datasets unnecessarily

---

# 🧪 Practice Exercises

1. Add Delete Expense functionality
2. Add Edit Expense feature
3. Add Clear All Expenses button
4. Display total expense count
5. Create separate `AuthContext`
6. Add loading indicator while restoring data
7. Create reusable storage utility functions

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned why global state management is important
✅ Understood prop drilling problems
✅ Used Context API for shared state
✅ Implemented Provider/Consumer architecture
✅ Created reusable custom hooks
✅ Persisted data using AsyncStorage
✅ Loaded data during app startup
✅ Used JSON serialization correctly
✅ Structured scalable React Native applications
