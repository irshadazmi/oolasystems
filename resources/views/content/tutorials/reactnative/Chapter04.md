# Chapter 4: State, Props & Component Architecture

---

# 🚀 Introduction

In this chapter, we move from **static UI** to building **dynamic and interactive React Native applications**.

So far, our ExpenseApp only displayed user interface components.
Now we will make the application respond to user input using:

- State
- Props
- Controlled Inputs
- Reusable Components
- Component Architecture
- Parent → Child Communication
- One-Way Data Flow

We will continue enhancing the **ExpenseApp** created in previous chapters.

For simplicity, we will NOT introduce:

- Navigation
- FlatList
- APIs
- Async Storage

These topics will be covered in upcoming chapters.

This chapter forms the foundation for all modern React Native application development.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand State and Props
- Use the `useState` Hook
- Create Controlled Inputs
- Understand One-Way Data Flow
- Build reusable components
- Understand Component Architecture
- Pass data from Parent → Child
- Learn Functional vs Class Components
- Organize applications using reusable UI components
- Build a small interactive ExpenseApp

---

# ⚛️ Understanding State

State is data managed inside a component that can change over time.

State helps create dynamic and interactive applications.

---

# 📋 Common Uses of State

State is commonly used for:

- Form inputs
- Search fields
- Toggle buttons
- Counters
- API responses
- Dynamic UI updates

---

# ⚡ Important Behavior

Whenever state changes:

✅ React Native automatically re-renders the UI.

This is one of the most powerful features of React.

---

# 🧪 Simple State Example

State helps React Native remember changing values.

```tsx
import React, { useState } from "react";

import { Pressable, Text, View } from "react-native";

export default function Index() {
  const [count, setCount] = useState(0);

  return (
    <View>
      <Text>Counter: {count}</Text>

      <Pressable onPress={() => setCount(count + 1)}>
        <Text>Increase</Text>
      </Pressable>
    </View>
  );
}
```

## Replace your existing 'app/index.tsx' code with above code.

# 🔍 Understanding the State Example

| Code                  | Purpose                 |
| --------------------- | ----------------------- |
| `count`               | Current state value     |
| `setCount`            | Updates the state       |
| `useState(0)`         | Initial state value     |
| `setCount(count + 1)` | Increases counter value |

Whenever the button is pressed:

1. State updates
2. UI re-renders automatically
3. Updated value appears on screen

---

# 📱 Extending the ExpenseApp Example

Now let us extend the **Add Transaction** screen created in Chapter03.

📁 `app/index.tsx`

```tsx
import React, { useState } from "react";

import { Text, TextInput, View } from "react-native";

import { styles } from "../styles/styles";

export default function Index() {
  const [amount, setAmount] = useState("");

  return (
    <View style={styles.container}>
      <Text style={styles.label}>Amount</Text>

      <TextInput
        style={styles.textInput}
        placeholder="Enter amount"
        keyboardType="numeric"
        value={amount}
        onChangeText={setAmount}
      />

      <Text style={styles.label}>You entered amount: {amount} </Text>
    </View>
  );
}
```

---

# ✅ At This Stage

- User input is captured using State
- State values update automatically
- The form becomes interactive
- UI re-renders whenever state changes

---

# 🎛️ Understanding Controlled Inputs

Controlled Inputs are form fields whose values are managed using React Native state.

This means:

- State stores the input value
- `TextInput` displays the state value
- `onChangeText` updates the state whenever the user types

This creates synchronization between:

```text
User Input ↔ State ↔ UI
```

---

# 🧪 Controlled Input Example

```tsx
<TextInput value={amount} onChangeText={setAmount} />
```

---

# 📦 Understanding Props

Props (Properties) are used to pass data from:

```text
Parent Component → Child Component
```

Props help components communicate with each other.

---

# 🔹 Important Characteristics of Props

Props are:

- Read-only
- Passed from parent components
- Used for reusable UI
- Used for component communication

---

# 🧪 Simple Props Example

Props allow parent components to send data to child components.

---

## 📁 Child Component (app/expense-detail.tsx)

```tsx
import { Text, View } from "react-native";
import { styles } from "../styles/styles";

export default function ExpenseDetail({
  description,
  amount,
}: {
  description: string;
  amount: number;
}) {
  return (
    <View style={styles.container}>
      <Text style={styles.label}>{description}</Text>
      <Text style={styles.label}>Amount: ₹{amount.toFixed(2)}</Text>
    </View>
  );
}
```

---

## 📁 Parent Component (app/index.tsx)

```tsx
import React from "react";
import { SafeAreaView } from "react-native";
import ExpenseDetail from "./expense-detail";

export default function Index() {
  return (
    <SafeAreaView>
      <ExpenseDetail description="Grocery Shopping" amount={100.0} />
    </SafeAreaView>
  );
}
```

---

# 🔍 How Props Work

Here:

- `Index` is the Parent Component
- `ExpenseDetail` is the Child Component
- `description="Grocery Shopping"` and 'amount={100.0}' are passed as Props

The child component receives and displays the value.

---

# ⚖️ State vs Props

| Feature    | State                   | Props                   |
| ---------- | ----------------------- | ----------------------- |
| Definition | Internal component data | Data passed from parent |
| Ownership  | Current component       | Parent component        |
| Mutable    | Yes                     | No                      |
| Purpose    | Dynamic UI              | Component communication |
| Updated By | Component itself        | Parent component        |
| Scope      | Local                   | Shared                  |

---

# 🔄 One-Way Data Flow

React Native follows a concept called:

```text
One-Way Data Flow
```

Data always flows in one direction.

```text
Parent Component
       ↓
      Props
       ↓
Child Component
```

---

# ✅ Benefits of One-Way Data Flow

This architecture makes applications:

- Predictable
- Easier to debug
- Easier to maintain
- Easier to understand

---

# 🧱 Understanding Components

React Native applications are built using components.

A component is an independent and reusable UI block.

Examples:

- Header
- Expense Form
- Expense Detail
- Login Screen
- Dashboard Card

Large applications are built by combining many reusable components.

This approach improves:

- Maintainability
- Reusability
- Readability
- Scalability

---

# 🏗️ Understanding Component Architecture

Professional React Native applications are rarely built using a single file.

Instead, applications are divided into:

- Screens
- Reusable Components
- Types
- Styles
- Utility Functions

This separation makes applications easier to maintain, test, and scale.

---

# 📱 ExpenseApp Component Architecture

The following diagram shows how different components in ExpenseApp are organized and communicate with each other.

It also illustrates:

- Parent → Child relationships
- One-Way Data Flow
- Reusable Components
- Shared Styles and Types
- Recommended folder organization

![React Native Component Hierarchy](/images/tutorials/reactnative/component-architecture.png)

---

# 📁 Recommended Project Structure

```text
src/
│
├── app/
│   ├── index.tsx
│   └── (transaction)/
│       ├── add.tsx
│       └── detail.tsx
│
├── components/
│   └── page-title.tsx
│
├── styles/
│   └── styles.ts
│
└── types/
    └── expense.ts
```

---

# ♻️ Creating Reusable Components

Reusable components help avoid duplicate code.

Instead of repeatedly writing the same UI, we create reusable components that can be used across multiple screens.

Common reusable components include:

- Page Header
- Custom Button
- Input Field
- Expense Card
- Loader
- Modal Dialog

This makes applications cleaner and easier to maintain.

---

# 📁 Create Reusable PageTitle Component

Create:

```text
app/components/page-title.tsx
```

---

# 🧪 Reusable Component Example

```tsx
import React from "react";

import { Text, View } from "react-native";

import { styles } from "@/src/styles/styles";

export default function PageTitle({ title }: { title: string }) {
  return (
    <View>
      <Text style={styles.title}>{title}</Text>
    </View>
  );
}
```

---

# 📁 Create Expense Type

Create:

```text
src/types/expense.ts
```

---

```tsx
export interface Expense {
  description: string;

  amount: number;
}
```

---

# 📁 Create ExpenseAdd Component

Create:

```text
app/(transaction)/add.tsx
```

Move the rendering portion of `app/index.tsx` into this component and use PageTitle component.

```tsx
import React, { useState } from "react";

import { Image, Pressable, Text, TextInput, View } from "react-native";

import { styles } from "@/src/styles/styles";

import PageTitle from "../components/page-title";

export default function ExpenseAdd() {
  const [description, setDescription] = useState("");

  const [amount, setAmount] = useState("");

  const handleAddTransaction = () => {
    console.log("Description:", description);

    console.log("Amount:", amount);
  };

  return (
    <View style={styles.container}>
      <PageTitle title="Add Transaction" />

      <View style={styles.imageContainer}>
        <Image
          style={styles.image}
          source={require("../../assets/images/expense-logo.png")}
        />
      </View>

      <Text style={styles.label}>Description</Text>

      <TextInput
        style={styles.textInput}
        placeholder="Enter description"
        value={description}
        onChangeText={setDescription}
      />

      <Text style={styles.label}>Amount</Text>

      <TextInput
        style={styles.textInput}
        placeholder="Enter amount"
        keyboardType="numeric"
        value={amount}
        onChangeText={setAmount}
      />

      <Pressable style={styles.button} onPress={handleAddTransaction}>
        <Text style={styles.buttonText}>Add Transaction</Text>
      </Pressable>
    </View>
  );
}
```

---

# 🔍 Understanding ExpenseAdd Component

In this component:

| Feature        | Purpose                  |
| -------------- | ------------------------ |
| `useState`     | Stores form values       |
| `TextInput`    | Captures user input      |
| `onChangeText` | Updates state            |
| `Pressable`    | Handles button click     |
| `PageTitle`    | Reusable title component |

This is our first interactive React Native form.

---

# 📁 Create A Separate ExpenseDetail Component

Create a separate ExpenseDetail component under app/(transaction):

```text
app/(transaction)/detail.tsx
```

---

```tsx
import React from "react";

import { Text, View } from "react-native";

import { Expense } from "@/src/types/expense";

import { styles } from "@/src/styles/styles";

export default function ExpenseDetail({ expense }: { expense: Expense }) {
  return (
    <View style={styles.container}>
      <Text style={styles.label}>{expense.description}</Text>

      <Text style={styles.label}>Amount: ₹{expense.amount.toFixed(2)}</Text>
    </View>
  );
}
```

---

# 🔍 Understanding ExpenseDetail Component

This component receives data using Props.

```tsx
expense={{
    description: "Food",
    amount: 200,
}}
```

The parent component sends expense data to the child component.

The child component displays:

- Expense description
- Expense amount

This demonstrates:

```text
Parent → Child Communication
```

using Props.

---

# 🔢 Why Convert Amount to Number?

`TextInput` always returns string values.

```tsx
amount: Number(amount);
```

converts:

```text
"500" → 500
```

This ensures the amount is stored as a numeric value.

---

# 📁 Update index.tsx

Now we pass values (Props) from:

```text
Parent Component → Child Component
```

📁 `app/index.tsx`

```tsx
import React from "react";

import { SafeAreaView } from "react-native";

import ExpenseDetail from "./(transaction)/detail";

export default function Index() {
  return (
    <SafeAreaView style={{ flex: 1 }}>
      <ExpenseDetail
        expense={{
          description: "Sample Transaction",
          amount: 99.99,
        }}
      />
    </SafeAreaView>
  );
}
```

---

# ⚛️ Functional vs Class Components

React supports two types of components:

1. Functional Components
2. Class Components

---

# ✅ Functional Components (Modern Approach)

Functional components are simple JavaScript functions that return JSX.

They are the modern and recommended approach for React Native applications.

---

# 🌟 Advantages of Functional Components

- Easier to write
- Easier to understand
- Less boilerplate code
- Better readability
- Supports Hooks (`useState`, `useEffect`)
- Widely used in modern applications

---

# 🧪 Functional Component Example

```tsx
import { Text, View } from "react-native";

export default function App() {
  return (
    <View>
      <Text>Expense App</Text>
    </View>
  );
}
```

---

# 🏛️ Class Components (Older Approach)

Before Hooks were introduced, React applications commonly used class components.

Class components use:

- ES6 classes
- `this.state`
- Lifecycle methods

Today, they are mostly found in older applications.

---

# 🧪 Class Component Example

```tsx
import React, { Component } from "react";

import { Text, View } from "react-native";

export default class App extends Component {
  render() {
    return (
      <View>
        <Text>Expense App</Text>
      </View>
    );
  }
}
```

---

# ⚖️ Functional vs Class Components

| Feature     | Functional Component | Class Component   |
| ----------- | -------------------- | ----------------- |
| Syntax      | Simple function      | ES6 class         |
| State       | `useState` Hook      | `this.state`      |
| Lifecycle   | `useEffect`          | Lifecycle methods |
| Code Size   | Smaller              | Larger            |
| Readability | Easier               | More complex      |
| Usage       | Recommended          | Legacy            |

---

# ♻️ Why Reusable Components Matter

Professional React Native applications are built using reusable UI blocks.

Instead of duplicating code across screens, developers create reusable components such as:

- Headers
- Buttons
- Cards
- Input fields
- Modals
- Navigation bars

This architecture helps applications scale efficiently.

In our ExpenseApp:

- `ExpenseAdd`
- `ExpenseDetail`
- `PageTitle`

are reusable components.

Later chapters will introduce:

- Bottom Tab Navigation
- Drawer Navigation
- Shared Form Components
- API Services
- Custom Hooks

---

# ✅ Best Practices

- Keep state in parent components when multiple components need shared data
- Create reusable components for repeated UI
- Use meaningful prop and state names
- Define TypeScript types separately
- Keep components small and focused
- Organize styles in shared files

---

# ⚠️ Common Beginner Mistakes

| Mistake                        | Correct Approach              |
| ------------------------------ | ----------------------------- |
| Forgetting `useState` import   | Import from React             |
| Using string instead of number | Convert using `Number()`      |
| Modifying props directly       | Props are read-only           |
| Large monolithic components    | Split into smaller components |
| Missing types                  | Define interfaces/types       |

---

# 🧪 Practice Exercises

1. Add a new `category` field to the Expense type
2. Add a “Clear Form” button inside `ExpenseAdd`
3. Display a message when no expense is available
4. Show expense amount with two decimal places
5. Create a reusable button component

---

# 📘 Chapter Summary

In this chapter, you:

- Learned Functional vs Class Components
- Understood State and Props
- Used the `useState` Hook
- Created controlled inputs
- Passed data using Props
- Understood One-Way Data Flow
- Created reusable components
- Learned Component Architecture
- Organized applications using reusable UI
- Built a small interactive ExpenseApp
